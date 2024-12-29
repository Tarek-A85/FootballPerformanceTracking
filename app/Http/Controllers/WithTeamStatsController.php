<?php

namespace App\Http\Controllers;

use App\Http\Requests\Team\ShowMatchStatsRequest;
use App\Http\Requests\Team\ShowTrainingStatsRequest;
use App\Models\MatchStat;
use App\Models\OfficialMatch;
use App\Models\Opponent;
use App\Models\Team;
use App\Services\WithTeamStatsService;
use Illuminate\Http\Request;

class WithTeamStatsController extends Controller
{
    protected $team_stats_service;

    public function __construct(WithTeamStatsService $team_stats_service)
    {
        $this->team_stats_service = $team_stats_service;
    }

    public function matches_stats(Team $team, ShowMatchStatsRequest $request)
    {
        $data = $this->team_stats_service->matches_stats($team, $request->validated());

        return view('team.match-stats', compact('data', 'team'));
    }

    public function training_stats(Team $team, ShowTrainingStatsRequest $request)
    {
        $data = $this->team_stats_service->training_stats($team, $request->validated());

        return view('team.training-stats', compact('data', 'team'));
    }
}
