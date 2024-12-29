<?php

namespace App\Http\Controllers;

use App\Http\Requests\Tournament\StoreTournamentRequest;
use App\Models\Tournament;
use App\Services\TournamentService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

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
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('tournament.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTournamentRequest $request)
    {
        $request->ensure_uniqueness();

        $this->tournament_service->store($request->validated());

        return redirect()->route('tournaments.index')->with('success', __('The tournament is created successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Tournament $tournament)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tournament $tournament)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tournament $tournament)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tournament $tournament)
    {
        //
    }
}
