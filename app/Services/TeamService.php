<?php

namespace App\Services;

use App\Models\Team;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;

class TeamService extends BaseService {

    public function store(array $data): void
    {
       $team = Team::create([
            'name_en' => $data['english_name'],
            'name_ar' => $data['arabic_name'],
            'color' => $data['color'],
            'user_id' => auth()->id()
        ]);

        $this->activity_logger->creation('Team', [
        'user_id' => auth()->id(),
        'ip_address' => request()->ip(),
        'team' => $team
        ]);
    }

    public function show(array $params, Team $team)
    {
        $matches = $trainings = $data = collect([]);
        
        if(!isset($params['type']) || $params['type'] !== 'trainings'){
            $matches = $team->matches()->with('team:id,name_en,name_ar',
                                              'opponent:id,name_en,name_ar',
                                              'status:id,name_en,name_ar',
                                              'tournament:id,name_en,name_ar',
                                              'round:id,name_en,name_ar');

            if(isset($params['from'])){

            $params['from'] = Carbon::parse($params['from'])->format('Y-m-d');

            $params['to'] = Carbon::parse($params['to'])->format('Y-m-d');

             $matches = $matches->whereBetween('date', [$params['from'], $params['to']]);
          
            }
            $data = $matches->get();

            $data->append('type');
        }
        
        if(!isset($params['type']) || $params['type'] !== 'matches'){
            $trainings = $team->training_sessions()->with('training_type:id,name_en,name_ar',
                                                          'status:id,name_en,name_ar');

            if(isset($params['from'])){
                $params['from'] = Carbon::parse($params['from'])->format('Y-m-d');

                $params['to'] = Carbon::parse($params['to'])->format('Y-m-d');
                
                $trainings = $trainings->whereBetween('date', [$params['from'], $params['to']]);
            }

            $trainings = $trainings->get();

            $data = $data->merge($trainings);

        }

       $data = $data->sortByDesc(['date', 'time'])
                    ->groupBy('date');

       return $data;

    }

    public function update(array $data, Team $team): void
    {
        $old_team = $team;

        $team->update([
            'name_en' => $data['english_name'],
            'name_ar' => $data['arabic_name'],
            'color' => $data['color'],
        ]);

        $this->activity_logger->update('Team', [
        'user_id' => auth()->id(),
        'ip_address' => request()->ip(),
        'old_team' => $old_team,
        'new_team' => $team
        ]);
    }

    public function destroy(Team $team): void
    {
        $deleted_team = $team;

        $team->delete();

        $this->activity_logger->destroy('Team', [
            'user_id' => auth()->id(),
            'ip_address' => request()->ip(),
            'deleted_team' => $deleted_team
        ]);

    }
}