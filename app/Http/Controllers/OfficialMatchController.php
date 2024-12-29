<?php

namespace App\Http\Controllers;

use App\Http\Requests\Match\StoreMatchRequest;
use App\Http\Requests\Match\UpdateMatchRequest;
use App\Models\OfficialMatch;
use App\Services\OfficalMatchService;
use Carbon\Carbon;
use Illuminate\Http\Request;

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

        return redirect()->back()->with('success', __('The match is scheduled successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show(OfficialMatch $match)
    {
        $match->load('team:id,name_en,name_ar',
                                    'opponent:id,name_en,name_ar',
                                    'tournament:id,name_en,name_ar',
                                    'status:id,name_en,name_ar',
                                    'round:id,name_en,name_ar');
                                             
        if($match->status->name === 'finished'){
            $match->load('match_stats');
        }

        return view('match.show', compact('match'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OfficialMatch $match)
    {
        $data = $this->match_service->edit();

        $date = Carbon::parse($match['date'])->format('d-m-Y');

        return view('match.edit', compact('data', 'match', 'date'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMatchRequest $request, OfficialMatch $match)
    {
       
        $request->ensure_unique_teams();

        $this->match_service->update($request->validated(), $match);

        return redirect()->route('matches.show', $match)->with('success', __('The match is updated successfully'));
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OfficialMatch $match)
    {
        $this->match_service->destroy($match);

        return redirect()->route('teams.show', $match->team)->with('success', __('The match is deleted successfully'));
    }
}
