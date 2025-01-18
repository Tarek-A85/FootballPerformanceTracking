<?php

namespace App\Http\Controllers;

use App\Http\Requests\MatchStat\StoreStatRequest;
use App\Http\Requests\MatchStat\UpdateStatRequest;
use App\Models\MatchStat;
use App\Models\OfficialMatch;
use App\Models\Team;
use App\Services\MatchStatService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class MatchStatController extends Controller
{

    protected $match_stat_service;

    public function __construct(MatchStatService $match_stat_service)
    {
        $this->match_stat_service = $match_stat_service;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(OfficialMatch $match)
    {
        if(!Gate::allows('manage-match', $match)){
            abort(404);
        }

        return view('match-stat.create', compact('match'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStatRequest $request, OfficialMatch $match)
    {
        if(!Gate::allows('manage-match', $match)){
            abort(404);
        }

        $request->check_number_of_goals_and_assists();

        $this->match_stat_service->store($request->validated(), $match);

        return redirect()->route('matches.show', $match)->with('success', __('The :attribute is created successfully', ['attribute' => __('Match Statistics')]));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MatchStat $stat)
    {
        if(!Gate::allows('manage-match', $stat->match->id)){
            abort(404);
        }

        return view('match-stat.edit', compact('stat'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStatRequest $request, MatchStat $stat)
    {
        if(!Gate::allows('manage-match', $stat->match->id)){
            abort(404);
        }
        
        $request->check_number_of_goals_and_assists();

        $this->match_stat_service->update($request->validated(), $stat);

        return redirect()->route('matches.show', $stat->match)->with('success', __('The :attribute is updated successfully', ['attribute' => __('Match Statistics')])); 
    }

}
