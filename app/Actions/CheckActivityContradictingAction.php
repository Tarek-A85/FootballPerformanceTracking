<?php

namespace App\Actions;

class CheckActivityContradictingAction{
    
    public function execute($date, $time, $ignoredMatchId = null, $ignoredTrainingId = null):bool
    {
        $user = auth()->user();

        $busy = $user->teams()->where(function($query) use($date, $time, $ignoredMatchId, $ignoredTrainingId){
            $query->whereHas('matches', function($match_query) use ($date, $time, $ignoredMatchId){
                $match_query->where('date', $date)->where('time', $time)->where('id', '!=', $ignoredMatchId);
            
            }) ->orWhereHas('training_sessions', function($training) use ($date, $time, $ignoredTrainingId){
                $training->where('date', $date)->where('time', $time, $ignoredTrainingId);
            });

        })->exists();

        return $busy;

    }
}