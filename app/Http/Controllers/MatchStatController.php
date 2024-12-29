<?php

namespace App\Http\Controllers;

use App\Http\Requests\MatchStat\StoreStatRequest;
use App\Http\Requests\MatchStat\UpdateStatRequest;
use App\Models\MatchStat;
use App\Models\OfficialMatch;
use App\Models\Team;
use App\Services\MatchStatService;
use Illuminate\Http\Request;

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
        return view('match-stat.create', compact('match'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStatRequest $request, OfficialMatch $match)
    {
        $request->check_rate_limiting();

        $this->match_stat_service->store($request->validated(), $match);

        return redirect()->route('matches.show', $match)->with('success', __('Match stats are added successfully'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MatchStat $stat)
    {
        return view('match-stat.edit', compact('stat'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStatRequest $request, MatchStat $stat)
    {
        $request->check_rate_limiting();

        $this->match_stat_service->update($request->validated(), $stat);

        return redirect()->route('matches.show', $stat->match)->with('success', __('Match stats are updated successfully')); 
    }

}
