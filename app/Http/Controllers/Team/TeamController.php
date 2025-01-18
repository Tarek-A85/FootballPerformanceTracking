<?php

namespace App\Http\Controllers\Team;

use App\Events\CreationEvent;
use App\Http\Requests\team\ShowTeamRequest;
use App\Http\Requests\Team\StoreTeamRequest;
use App\Http\Requests\Team\UpdateTeamRequest;
use App\Models\Team;
use App\Services\Team\TeamService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;

class TeamController extends Controller
{
    protected $team_service;

    public function __construct(TeamService $team_service)
    {
        $this->team_service = $team_service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()//: View
    {
        
        $teams = auth()->user()->teams->append('suitable-background')->loadCount('finished_matches');

        return view('team.index', compact('teams'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('team.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTeamRequest $request)
    {
       $request->ensure_uniqueness();

        $this->team_service->store($request->validated());
       
        return redirect()->route('teams.index')->with('success', __('The :attribute is created successfully', ['attribute' => __('team')]));
    }

    /**
     * Display the specified resource.
     */
    public function show(Team $team, ShowTeamRequest $request)
    {
        if(!Gate::allows('manage-team', $team)){
            abort(404);
        }
        
       $schedule = $this->team_service->show($request->validated(), $team);

        return view('team.show', compact('team', 'schedule'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Team $team)
    {
        if(!Gate::allows('manage-team', $team)){
            abort(404);
        }

        return view('team.edit', compact('team'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTeamRequest $request, Team $team)
    {
        if(!Gate::allows('manage-team', $team)){
            abort(404);
        }

        $request->ensure_uniqueness();

        $this->team_service->update($request->validated(), $team);

        return redirect()->route('teams.edit', $team)->with('success', __('The :attribute is updated successfully', ['attribute' => __('team')]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Team $team)
    {
        if(!Gate::allows('manage-team', $team)){
            abort(404);
        }
        
        $this->team_service->destroy($team);

        return redirect()->route('teams.index')->with('success', __('The :attribute is deleted successfully', ['attribute' => __('team')]));
    }
}
