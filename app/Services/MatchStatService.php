<?php


namespace App\Services;

use App\Models\MatchStat;
use App\Models\OfficialMatch;

class MatchStatService extends BaseService{

    public function store(array $data, OfficialMatch $match)
    {
        $match->stats()->create([
            'shots' => $data['shots'],
            'goals' => $data['goals'],
            'passes' => $data['passes'],
            'assists' => $data['assists'],
            'yellows' => $data['yellows'],
            'reds' => $data['reds'],
            'headers' => $data['headers'],
            'rating' => $data['rating'],
            'report' => $data['report'] ?? null,
        ]);

        $this->activity_logger->creation('Match-Stats', [
            'user_id' => auth()->id(),
            'ip' => request()->ip(),
            'match' => $match
        ]);
    }

    public function update(array $data, MatchStat $stat)
    {
        $stat->update([
            'shots' => $data['shots'],
            'goals' => $data['goals'],
            'passes' => $data['passes'],
            'assists' => $data['assists'],
            'yellows' => $data['yellows'],
            'reds' => $data['reds'],
            'headers' => $data['headers'],
            'rating' => $data['rating'],
            'report' => $data['report'] ?? null,
        ]);

        $this->activity_logger->update('Match-Stats', [
            'user_id' => auth()->id(),
            'ip' => request()->ip(),
            'match' => $stat->match
        ]);
    }
}