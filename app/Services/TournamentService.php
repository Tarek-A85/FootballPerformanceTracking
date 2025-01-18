<?php

namespace App\Services;

use App\Models\OfficialMatch;
use App\Models\Round;
use App\Models\Tournament;
use Carbon\Carbon;

class TournamentService extends BaseService{

    public function index()
    {
        $tournaments = Tournament::where('user_id', auth()->id())->get();

        return $tournaments;
    }

    public function show(Tournament $tournament, array $params)
    {
        $matches = OfficialMatch::with('team:id,name_en,name_ar,color',
                                       'opponent:id,name_en,name_ar',
                                       'status:id,name_en,name_ar',
                                       'round:id,name_en,name_ar',
                                       'tournament:id,name_en,name_ar')
                                ->where('tournament_id', $tournament->id);
        
       if(isset($params['from'])){

         $params['from'] = Carbon::parse($params['from'])->format('Y-m-d');
                                            
         $params['to'] = Carbon::parse($params['to'])->format('Y-m-d');
                                            
        $matches = $matches->whereBetween('date', [$params['from'], $params['to']]);                                            
     }
     else{
        $matches = $matches->where('date', now()->toDateString());
     }

     $matches = $matches->get();

     $matches = $matches->sortByDesc(['date', 'time'])
                        ->groupBy('date');
    
    return $matches;
    }
    
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

    public function update(array $data, Tournament $tournament): void
    {
        $tournament->update([
            'name_en' => $data['english_name'],
            'name_ar' => $data['arabic_name'],
        ]);

        $this->activity_logger->update('Tournament', [
            'user_id' => auth()->id(),
            'ip' => request()->ip(),
            'tournament' => $tournament
        ]);
    }

    public function destroy(Tournament $tournament)
    {
        $old_tournament = $tournament;

        $tournament->delete();

        $this->activity_logger->destroy('Tournament', [
            'user_id' => auth()->id(),
            'ip' => request()->ip(),
            'tournament' => $old_tournament
        ]);
    }

    public function create_match()
    {
    $user = auth()->user();

    $teams = $user->teams;

    $opponents = $user->opponents;

    $rounds = Round::get();

    return compact('opponents', 'teams', 'rounds');
 }
}
