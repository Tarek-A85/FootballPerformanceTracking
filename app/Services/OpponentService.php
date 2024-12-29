<?php


namespace App\Services;

use App\Models\Opponent;

class OpponentService extends BaseService{

    public function store(array $data): void
    {
        $opponent = Opponent::create([
            'name_en' => $data['english_name'],
            'name_ar' => $data['arabic_name'],
            'user_id' => auth()->id()
        ]);

        $this->activity_logger->creation('Opponent', [
            'user_id' => auth()->id(),
            'ip' => request()->ip(),
            'opponent' => $opponent,
        ]);
    }

}