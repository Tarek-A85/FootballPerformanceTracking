<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Opponent extends Model
{
    
    protected $fillable = ['name_en', 'name_ar', 'user_id'];

    public function matches()
    {
        return $this->hasMany(OfficialMatch::class, 'opponent_id');
    }

    public function getStatsAttribute(): array
    {
        $this->load('matches.stats');

       $statistics = [];

       $statistics['matches'] = 0;
       foreach($this->matches as $match){
        if($match->status->name_en === 'finished'){
        $statistics['matches'] += 1;

        foreach(['shots', 'goals', 'passes', 'assists', 'yellows', 'reds', 'rating'] as $key){
            if(isset($statistics[$key])){
                $statistics[$key] += $match->stats[$key];
            }
            else{
                $statistics[$key] = $match->stats[$key];
            }
        }
    }
       }

       

       return $statistics;
    }
}
