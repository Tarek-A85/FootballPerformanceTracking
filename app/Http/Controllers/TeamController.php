<?php

namespace App\Http\Controllers;

use App\Events\CreationEvent;
use App\Http\Requests\team\ShowTeamRequest;
use App\Http\Requests\Team\StoreTeamRequest;
use App\Http\Requests\Team\UpdateTeamRequest;
use App\Models\Team;
use App\Services\TeamService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

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
        $teams = auth()->user()->teams->append('suitable-background');

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
       
        return redirect()->route('teams.index')->with('success', __('The team is created successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Team $team, ShowTeamRequest $request)
    {
        
       $schedule = $this->team_service->show($request->validated(), $team);

        return view('team.show', compact('team', 'schedule'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Team $team)
    {
        return view('team.edit', compact('team'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTeamRequest $request, Team $team)
    {
        $request->ensure_uniqueness();

        $this->team_service->update($request->validated(), $team);

        return redirect()->route('teams.edit', $team)->with('success', __('The team is updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Team $team)
    {
        $this->team_service->destroy($team);

        return redirect()->route('teams.index')->with('success', __('The team is deleted successfully'));
    }
}
