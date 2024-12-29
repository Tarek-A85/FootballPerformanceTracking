<?php

namespace App\Services;

use App\Models\Tournament;

class TournamentService extends BaseService{
    
    public function store(array $data): void
    {
        $tournament = Tournament::create([
            'name_en' => $data['english_name'],
            'name_ar' => $data['arabic_name'],
            'user_id' => auth()->id(),
        ]);

        $this->activity_logger->creation('Tournament', [
            'user_id' => auth()->id(),
            'ip' => request()->ip(),
            'tournament' => $tournament
        ]);
    }
}