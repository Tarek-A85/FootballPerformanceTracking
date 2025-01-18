<?php

namespace App\Http\Controllers;

use App\Http\Requests\Opponent\StoreOpponentRequest;
use App\Models\Opponent;
use App\Models\Team;
use App\Services\OpponentService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

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
    public function create(Team $team = null)
    {
        return view('opponent.create', compact('team'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOpponentRequest $request)
    {
        $request->ensure_uniqueness();

        $this->opponent_service->store($request->validated());

        if(is_null($request->validated('team'))){
            return redirect()->route('matches.create')
                             ->with('success',  __('The :attribute is created successfully', ['attribute' => __('opponent')]) );
        }
       
        return redirect()->route('team.create_match', ['team' => $request->validated('team')])
                         ->with('success', __('The :attribute is created successfully', ['attribute' => __('opponent')]));
    }

    /**
     * Display the specified resource.
     */
    public function show(Opponent $opponent)
    {
        if(!Gate::allows('manage-opponent', $opponent)){
            abort(404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Opponent $opponent)
    {
        if(!Gate::allows('manage-opponent', $opponent)){
            abort(404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Opponent $opponent)
    {
        if(!Gate::allows('manage-opponent', $opponent)){
            abort(404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Opponent $opponent)
    {
        if(!Gate::allows('manage-opponent', $opponent)){
            abort(404);
        }
    }
}
