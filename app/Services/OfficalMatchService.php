<?php

namespace App\Services;

use App\Models\ActivityStatus;
use App\Models\OfficialMatch;
use App\Models\Round;
use App\Models\Team;
use Carbon\Carbon;
use Illuminate\Support\Arr;

class OfficalMatchService extends BaseService {

    public function create(): array
    {
        $user = auth()->user();

        $teams = $user->teams;

        $opponents = $user->opponents;

        $tournaments = $user->tournaments;

        $rounds = Round::get();

        return compact('teams', 'opponents', 'tournaments', 'rounds');
    }

    public function store(array $data): void
    {
        $match = OfficialMatch::create([
            'home_team_id' => $data['my_team'],
            'opponent_id' => $data['opponent_team'],
            'date' => $data['date'],
            'time' => $data['time'],
            'status_id' => ActivityStatus::where('name_en', 'not started')->first()->id,
            'tournament_id' => $data['tournament'],
            'round_id' => $data['round']
        ]);

        $this->activity_logger->creation('Match', [
            'user_id' => auth()->id(),
            'ip' => request()->ip(),
            'match' => $match
        ]);
    }

    public function edit(): array
    {
        $user = auth()->user();

        $teams = $user->teams;

        $opponents = $user->opponents;

        $tournaments = $user->tournaments;

        $statuses = ActivityStatus::get();

        $rounds = Round::get();

        return compact('teams', 'opponents', 'tournaments', 'statuses', 'rounds');
    }

    public function update(array $data, OfficialMatch $match)
    {
        $old_date = $match->date;

        $finished = ActivityStatus::find($data['status'])->name_en === 'finished' ? true : false;

        $match->update([
            'home_team_id' => $data['my_team'],
            'opponent_id' => $data['opponent_team'],
            'date' => $data['date'] ?? $old_date ,
            'time' => $data['time'],
            'status_id' => $data['status'],
            'tournament_id' => $data['tournament'],
            'round_id' => $data['round'],
            'home_team_score' => $finished ? $data['team_score'] : null,
            'opponent_team_score' => $finished ? $data['opponent_score'] : null,
        ]);

        $this->activity_logger->update('Match', [
            'user_id' => auth()->id(),
            'ip' => request()->ip(),
            'match' => $match
        ]);
    }

    public function destroy(OfficialMatch $match)
    {
        $deleted_match = $match;

        $match->delete();

        $this->activity_logger->destroy('Match', [
            'user_id' => auth()->id(),
            'ip' => request()->ip(),
            'match' => $deleted_match
        ]);

    }
}