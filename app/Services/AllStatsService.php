<?php


namespace App\Services;

use App\Models\ActivityStatus;
use App\Models\OfficialMatch;
use App\Models\Team;
use App\Models\TrainingSession;
use App\Models\TrainingType;
use Carbon\Carbon;
use PhpParser\Node\Expr\Match_;

class AllStatsService extends BaseService{
    
    public function matches_stats(array $params)
    {

        $matches = OfficialMatch::with('stats', 'opponent', 'team', 'tournament')
                                  ->where('status_id', ActivityStatus::where('name_en', 'finished')->first()->id)
                                  ->whereRelation('team', 'user_id', auth()->id());

        $teams = Team::with('finished_matches.stats', 'finished_matches.opponent',  'finished_matches.tournament')
                     ->where('user_id', auth()->id());
                       
        if(isset($params['from'])){

           $params['from'] = Carbon::parse($params['from'])->format('Y-m-d');

           $params['to'] = Carbon::parse($params['to'])->format('Y-m-d');

           $matches = $matches->whereBetween('date', [$params['from'], $params['to']]);

        }

        $matches = $matches->get();
                
        $teams = collect([]);

        $opponents = collect([]);

        $tournaments = collect([]);

        $opponent_stats = [];

        $tournament_stats = [];

        $team_stats = [];

        $numbers = [];

       
        if($matches->count()){
            $numbers['matches'] = 0;

        $earliest = now();
             
            foreach($matches as $match){

                $earliest = min($earliest, $match->date);

                $numbers['matches']++;

                foreach(['shots', 'goals', 'passes', 'assists', 'yellows', 'reds', 'headers', 'rating'] as $key){
                    if(isset($numbers[$key])){
                        $numbers[$key] += $match->stats[$key];
                    }
            
                    else{
                        $numbers[$key] = $match->stats[$key];
                    }
                }

                //team

                if(isset( $team_stats[$match->team->id]['goals'])){
                    $team_stats[$match->team->id]['goals'] += $match->stats['goals'];
              }

              else{
                  $team_stats[$match->team->id]['goals'] = 0;

                  $team_stats[$match->team->id]['goals'] += $match->stats['goals'];
              }

              if(isset($team_stats[$match->team->id]['assists'])){
                $team_stats[$match->team->id]['assists'] += $match->stats['assists'];
            }

            else{
                $team_stats[$match->team->id]['assists'] = 0;

                $team_stats[$match->team->id]['assists'] += $match->stats['assists'];
            }

            if(isset($team_stats[$match->team->id]['matches'])){
                $team_stats[$match->team->id]['matches'] += 1;
            }

            else{
                $team_stats[$match->team->id]['matches'] = 1;
            }

            $team_stats[$match->team->id]['contribution'] = $team_stats[$match->team->id]['goals'] + $team_stats[$match->team->id]['assists'];

            $teams->put($match->team->id, $team_stats[$match->team->id]);

            //   opponent

                if(isset( $opponent_stats[$match->opponent->id]['goals'])){
                      $opponent_stats[$match->opponent->id]['goals'] += $match->stats['goals'];
                }

                else{
                    $opponent_stats[$match->opponent->id]['goals'] = 0;

                    $opponent_stats[$match->opponent->id]['goals'] += $match->stats['goals'];
                }

                if(isset($opponent_stats[$match->opponent->id]['assists'])){
                    $opponent_stats[$match->opponent->id]['assists'] += $match->stats['assists'];
                }

                else{
                    $opponent_stats[$match->opponent->id]['assists'] = 0;

                    $opponent_stats[$match->opponent->id]['assists'] += $match->stats['assists'];
                }

                if(isset($opponent_stats[$match->opponent->id]['matches'])){
                    $opponent_stats[$match->opponent->id]['matches'] += 1;
                }

                else{
                    $opponent_stats[$match->opponent->id]['matches'] = 1;
                }

                $opponent_stats[$match->opponent->id]['contribution'] = $opponent_stats[$match->opponent->id]['goals'] + $opponent_stats[$match->opponent->id]['assists'];

               $opponents->put($match->opponent->id, $opponent_stats[$match->opponent->id]);


                if(isset( $tournament_stats[$match->tournament->id]['goals'])){
                     $tournament_stats[$match->tournament->id]['goals'] += $match->stats['goals'];
                }

                else{
                    $tournament_stats[$match->tournament->id]['goals'] = 0;

                    $tournament_stats[$match->tournament->id]['goals'] += $match->stats['goals'];
                }

                if(isset( $tournament_stats[$match->tournament->id]['assists'])){
                   $tournament_stats[$match->tournament->id]['assists'] += $match->stats['assists'];
                }

                else{
                    $tournament_stats[$match->tournament->id]['assists'] = 0;

                    $tournament_stats[$match->tournament->id]['assists'] += $match->stats['assists'];
                }

                if(isset( $tournament_stats[$match->tournament->id]['matches'])){
                    $tournament_stats[$match->tournament->id]['matches'] += 1;
                }

                else{
                    $tournament_stats[$match->tournament->id]['matches'] = 1;
                }

                $tournament_stats[$match->tournament->id]['contribution'] = $tournament_stats[$match->tournament->id]['goals'] + $tournament_stats[$match->tournament->id]['assists'];

                $tournaments->put($match->tournament->id, $tournament_stats[$match->tournament->id]);
            }

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
        
         $numbers['headers_avg'] = $numbers['headers'] / $numbers['matches'];

         $numbers['rating'] /= $numbers['matches'];

       $tournaments = $tournaments->sortByDesc(['contribution', 'goals', 'assists'])->take(10);

       $teams = $teams->sortByDesc(['contribution', 'goals', 'assists'])->take(10);

        $opponents = $opponents->sortByDesc(['contribution', 'goals', 'assists'])->take(10);
        }

        return compact('tournaments', 'teams', 'opponents', 'numbers');

        
    }

    public function training_stats(array $params)
    {
       $data = collect([]);

       $trainings = TrainingSession::with('training_type')
                                   ->where('status_id', ActivityStatus::where('name_en', 'finished')->first()->id)
                                    ->where(function($query){
                                        $query->where('trainable_type', 'user')
                                              ->whereHasMorph('trainable', 'user', function($query){
                                                $query->where('id', auth()->id());
                                              });
                                    })
                                   ->orWhere(function($query){
                                    $query->where('trainable_type', 'team')
                                         ->whereHasMorph('trainable', 'team', function($query){
                                       $query->where('user_id', auth()->id());
                                    });
                                   });  
                                          
       
       if(isset($params['from'])){

         $params['from'] = Carbon::parse($params['from'])->format('Y-m-d');
                                 
         $params['to'] = Carbon::parse($params['to'])->format('Y-m-d');
                                 
         $trainings = $trainings->whereBetween('date', [$params['from'], $params['to']]);                   
     }

     $trainings = $trainings->get();

     $numbers = [];

     $teams = collect([]);

    if($trainings->count()){
    $numbers['trainings'] = 0;

    $numbers['user'] = 0;

    $numbers['team'] = 0;

    $numbers['user_minutes'] = 0;

    $numbers['team_minutes'] = 0;

    $trainings->load('trainable');

    foreach($trainings as $training){
        $numbers['trainings']++;

       

        if($training->trainable_type == 'user'){
            $numbers['user']++;

            $numbers['user_minutes'] += $training->minutes;
        }
        else if($training->trainable_type == 'team'){
            $numbers['team']++;

            $numbers['team_minutes'] += $training->minutes;

            if(!isset($numbers[$training->trainable_id]['trainings'])){
                $numbers[$training->trainable_id]['trainings'] = 1;
            }
            else{
                $numbers[$training->trainable_id]['trainings'] ++;
            }

            if(!isset($numbers[$training->trainable_id][$training->training_type_id])){
                $numbers[$training->trainable_id][$training->training_type_id] = 1;
            }
            else{
                $numbers[$training->trainable_id][$training->training_type_id]++;
            }
            
            if(!isset($numbers[$training->trainable_id]['minutes'])){
                $numbers[$training->trainable_id]['minutes'] = $training->minutes;
            }
            else{
                $numbers[$training->trainable_id]['minutes'] += $training->minutes;
            }

            $teams->put($training->trainable_id, $numbers[$training->trainable->id]);
        }

        if(!isset($numbers['minutes'])){
            $numbers['minutes'] = $training->minutes;
        }
        else{
            $numbers['minutes'] += $training->minutes;
        }
       if(isset($numbers['types'][$training->training_type->id]) ){
        $numbers['types'][$training->training_type->id]++;
      
       }
       else{
        $numbers['types'][$training->training_type->id] = 1;

       }
       
    }
    $teams = $teams->sortByDesc(['minutes', 'trainings'])->take(10);
}
  return compact('numbers', 'teams');
    }

}