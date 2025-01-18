<?php

namespace App\Services;

use App\Models\OfficialMatch;
use App\Models\TrainingSession;
use Carbon\Carbon;

class ScheduleService extends BaseService{

    public function index(array $params)
    {
        $data = collect([]);

    if(!isset($params['type']) || $params['type'] !== 'trainings'){
      $matches = OfficialMatch::with('team:id,name_en,name_ar,color',
                                     'opponent:id,name_en,name_ar',
                                     'status:id,name_en,name_ar',
                                     'tournament:id,name_en,name_ar',
                                     'round:id,name_en,name_ar')
                                ->whereRelation('team', 'user_id', auth()->id());
                        

    if(isset($params['from'])){

        $params['from'] = Carbon::parse($params['from'])->format('Y-m-d');
                
      $params['to'] = Carbon::parse($params['to'])->format('Y-m-d');
                
     $matches = $matches->whereBetween('date', [$params['from'], $params['to']]);
                          
    }
    else{
        $matches = $matches->where('date', now()->toDateString());
    }
    $data = $matches->get();

    $data->append('type');
    }

    if(!isset($params['type']) || $params['type'] !== 'matches'){
      $trainings = TrainingSession::with('training_type:id,name_en,name_ar',
                                         'status:id,name_en,name_ar',
                                         'trainable')
                                       ->Where(function($query){
                                        $query->where('trainable_type', 'team')
                                             ->whereHasMorph('trainable', 'team', function($query){
                                           $query->where('user_id', auth()->id());
                                        });
                                       })
                                       ->orWhere(function($query){
                                        $query->where('trainable_type', 'user')
                                        ->whereHasMorph('trainable', 'user', function($query){
                                            $query->where('id', auth()->id());
                                    });
                                }); 

        $trainings = $trainings->get();

         if(isset($params['from'])){
         $params['from'] = Carbon::parse($params['from'])->format('Y-m-d');
                
         $params['to'] = Carbon::parse($params['to'])->format('Y-m-d');
                                
         $trainings = $trainings->whereBetween('date', [$params['from'], $params['to']]);
    }
    else{
        $trainings = $trainings->where('date', now()->toDateString());

    }

     $data = $data->merge($trainings);
     
}
    $data = $data->sortByDesc(['date', 'time'])
                 ->groupBy('date');

    return $data;
}
}