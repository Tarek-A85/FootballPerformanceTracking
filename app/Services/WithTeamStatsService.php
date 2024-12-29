<?php

namespace App\Services;

use App\Models\ActivityStatus;
use App\Models\OfficialMatch;
use App\Models\Team;
use App\Models\TrainingSession;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class WithTeamStatsService extends BaseService{

    public function matches_stats(Team $team, array $params)
    {
       
        $matches = OfficialMatch::with('stats', 'opponent')
                                 ->where('home_team_id', $team->id)
                                 ->whereHas('stats');                   

    if(isset($params['from'])){

        $params['from'] = Carbon::parse($params['from'])->format('Y-m-d');

        $params['to'] = Carbon::parse($params['to'])->format('Y-m-d');

      $matches = $matches->whereBetween('date', [$params['from'], $params['to']]);
    }

    $matches = $matches->get();


    $numbers = [];

    if($matches->count()){

    $numbers['matches'] = 0;

    $earliest = now();

   foreach($matches as $match){
    $earliest = min($earliest, $match->date);

    $numbers['matches']++;

    foreach(['shots', 'goals', 'passes', 'assists', 'yellows', 'reds', 'rating'] as $key){
        if(isset($numbers[$key])){
            $numbers[$key] += $match->stats[$key];
        }

        else{
            $numbers[$key] = $match->stats[$key];
        }
    }

   }

    $numbers['rating'] /= $numbers['matches'];

    if(isset($params['from'])){
    $days = Carbon::parse($params['from'])->diffInDays($params['to']);
    }
    else{
        $days = Carbon::parse($earliest)->diffInDays(now());
    }

    $days = max($days, 1);

    $numbers['matches_every_x_days'] = $days / $numbers['matches'];

    $numbers['scoring_avg'] = $numbers['goals'] / $numbers['matches'];

    $numbers['passing_avg'] = $numbers['passes'] / $numbers['matches'];

    $numbers['successfull_scoring_attempts'] = $numbers['goals'] / $numbers['shots'];

}

 return compact('matches', 'numbers');
       
    }

    public function training_stats(Team $team, array $params)
    {
        $trainings = TrainingSession::with('training_type')
                                     ->where('status_id', ActivityStatus::where('name_en', 'finished')->first()->id)
                                     ->where('trainable_type', 'team')
                                     ->where('trainable_id', $team->id);
        
       if(isset($params['from'])){

      $params['from'] = Carbon::parse($params['from'])->format('Y-m-d');
                                
      $params['to'] = Carbon::parse($params['to'])->format('Y-m-d');
                                
     $trainings = $trainings->whereBetween('date', [$params['from'], $params['to']]);
    }

    $trainings = $trainings->get();

    $numbers = [];

    if($trainings->count()){
    $numbers['trainings'] = 0;

    foreach($trainings as $training){
        $numbers['trainings']++;

        $numbers['minutes'] += $training->minutes;

       if(isset($numbers[$training->training_type->name_en]) ){
        $numbers[$training->training_type->name_en]++;
        $numbers[$training->training_type->name_ar]++;
       }
       else{
        $numbers[$training->training_type->name_en] = 1;
        $numbers[$training->training_type->name_ar] = 1;
       }
       
    }
}
   return compact('numbers', 'trainings');
    }
}