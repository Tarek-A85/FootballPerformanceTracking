<?php

namespace App\Http\Controllers;

use App\Http\Requests\Match\StoreMatchRequest;
use App\Http\Requests\Match\UpdateMatchRequest;
use App\Models\OfficialMatch;
use App\Models\Team;
use App\Services\OfficalMatchService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class OfficialMatchController extends Controller
{
    protected $match_service;

    public function __construct(OfficalMatchService $match_service)
    {
        $this->match_service = $match_service;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = $this->match_service->create();

        return view('match.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMatchRequest $request)
    {
        $request->ensure_unique_teams();

        $this->match_service->store($request->validated());

        if($request->validated('form_page') === 'schedule_page'){
          
            return redirect()->route('schedule.index', [
                'from' => $request->validated('date'),

                'to' => $request->validated('date')

            ])->with('success', __('The :attribute is created successfully', ['attribute' => __('match')]));
        }
        else if($request->validated('form_page') === 'team_page'){

            return redirect()->route('teams.show', [
                'team' => $request->validated('my_team'),

                'from' => $request->validated('date'),

                'to' => $request->validated('date')
                
            ])->with('success', __('The :attribute is created successfully', ['attribute' => __('match')]));
        }
        else{
            return redirect()->route('tournaments.show', [
                'tournament' => $request->validated('tournament'),

                'from' => $request->validated('date'),

                'to' => $request->validated('date')
                
            ])->with('success', __('The :attribute is created successfully', ['attribute' => __('match')]));
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(OfficialMatch $match, bool $team = false)
    {
        if(!Gate::allows('manage-match', $match)){
            abort(404);
        }

        $match->load('team:id,name_en,name_ar,color',
                     'opponent:id,name_en,name_ar',
                     'tournament:id,name_en,name_ar',
                     'status:id,name_en,name_ar',
                     'round:id,name_en,name_ar');
                                             
        if($match->status->name === 'finished'){
            $match->load('match_stats');
        }

        return view('match.show', compact('match', 'team'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OfficialMatch $match)
    {
        if(!Gate::allows('manage-match', $match)){
            abort(404);
        }

        $data = $this->match_service->edit();

        $date = Carbon::parse($match['date'])->format('d-m-Y');

        return view('match.edit', compact('data', 'match', 'date'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMatchRequest $request, OfficialMatch $match)
    {
        if(!Gate::allows('manage-match', $match)){
            abort(404);
        }
       
        $request->ensure_unique_teams();

        $this->match_service->update($request->validated(), $match);

        return redirect()->route('matches.show', $match)->with('success', __('The :attribute is updated successfully', ['attribute' => __('match')]));
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OfficialMatch $match, bool $team = false)
    {
        if(!Gate::allows('manage-match', $match)){
            abort(404);
        }
        
        $this->match_service->destroy($match);

        if($team){
            return redirect()->route('teams.show', $match->team)
                             ->with('success', __('The :attribute is deleted successfully', ['attribute' => __('match')]));
        }

        return redirect()->route('schedule.index')
                         ->with('success', __('The :attribute is deleted successfully', ['attribute' => __('match')]));

       
    }
}
