<?php

namespace App\Http\Controllers;

use App\Http\Requests\Tournament\ShowTournamentRequest;
use App\Http\Requests\Tournament\StoreTournamentRequest;
use App\Http\Requests\Tournament\UpdateTournamentRequest;
use App\Models\Team;
use App\Models\Tournament;
use App\Services\TournamentService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TournamentController extends Controller
{

    protected $tournament_service;

    public function __construct(TournamentService $tournament_service)
    {
        $this->tournament_service = $tournament_service;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tournaments = $this->tournament_service->index();

        return view('tournament.index', compact('tournaments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Team $team = null): View
    {
        return view('tournament.create', compact('team'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTournamentRequest $request)
    {
        $request->ensure_uniqueness();

        $this->tournament_service->store($request->validated());

        return redirect()->route('tournaments.index')->with('success', __('The :attribute is created successfully', ['attribute' => __('tournament')]));
    }

    /**
     * Display the specified resource.
     */
    public function show(Tournament $tournament, ShowTournamentRequest $request)
    {
        if(!Gate::allows('manage-tournament', $tournament)){
            abort(404);
        }

        $schedule = $this->tournament_service->show($tournament, $request->validated());

        return view('tournament.show', compact('schedule', 'tournament'));
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tournament $tournament)
    {
        if(!Gate::allows('manage-tournament', $tournament)){
            abort(404);
        }

        return view('tournament.edit', compact('tournament'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTournamentRequest $request, Tournament $tournament)
    {
        if(!Gate::allows('manage-tournament', $tournament)){
            abort(404);
        }

        $request->ensure_uniqueness();

        $this->tournament_service->update($request->validated(), $tournament);

        return redirect()->back()->with('success', __('The :attribute is updated successfully', ['attribute' => __('tournament')]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tournament $tournament)
    {
        if(!Gate::allows('manage-tournament', $tournament)){
            abort(404);
        }

        $this->tournament_service->destroy($tournament);

        return redirect()->route('tournaments.index')->with('success', __('The :attribute is deleted successfully', ['attribute' => __('tournament')]));
    }

    /**
     * Create a new match in this tournament
     */
    public function create_match(Tournament $tournament)
    {
        if(!Gate::allows('manage-tournament', $tournament)){
            abort(404);
        }
        
       $data = $this->tournament_service->create_match();

        return view('tournament.create-match', compact('tournament', 'data'));
    }
}
