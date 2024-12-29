<?php

namespace App\Http\Controllers;

use App\Http\Requests\Opponent\StoreOpponentRequest;
use App\Models\Opponent;
use App\Services\OpponentService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;


class OpponentController extends Controller
{

    protected $opponent_service;

    public function __construct(OpponentService $opponent_service)
    {
        $this->opponent_service = $opponent_service;
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
        return view('opponent.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOpponentRequest $request)
    {
        $request->ensure_uniqueness();

        $this->opponent_service->store($request->validated());

        return redirect()->route('opponents.index')->with('success', __('The opponent is created successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Opponent $opponent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Opponent $opponent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Opponent $opponent)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Opponent $opponent)
    {
        //
    }
}
