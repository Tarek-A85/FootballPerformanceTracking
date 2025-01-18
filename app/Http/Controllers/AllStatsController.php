<?php

namespace App\Http\Controllers;

use App\Http\Requests\Statistics\AllStatsRequest;
use App\Services\AllStatsService;
use Illuminate\Http\Request;

class AllStatsController extends Controller
{
    protected $all_stats_service;

    public function __construct(AllStatsService $all_stats_service)
    {
        $this->all_stats_service = $all_stats_service;
    }

    public function matches_stats(AllStatsRequest $request)
    {
        $data = $this->all_stats_service->matches_stats($request->validated());
        
        return view('stats.matches', compact('data'));
    }

    public function trainings_stats(AllStatsRequest $request)
    {
        $data = $this->all_stats_service->training_stats($request->validated());

        return view('stats.trainings', compact('data'));

    }
}
