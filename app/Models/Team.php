<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    /** @use HasFactory<\Database\Factories\TeamFactory> */
    use HasFactory;

    protected $fillable = ['name_en', 'name_ar', 'color', 'user_id'];

    

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function training_sessions()
    {
        return $this->morphMany(TrainingSession::class, 'trainable');
    }

    public function matches()
    {
        return $this->hasMany(OfficialMatch::class, 'home_team_id');
    }

    public function finished_matches()
    {
        return $this->hasMany(OfficialMatch::class, 'home_team_id')->where('status_id', ActivityStatus::where('name_en', 'finished')->first()->id);
    }

    public function getSuitableBackgroundAttribute()
    {
        $hexColor = ltrim($this->color, '#');

        $red = hexdec(substr($hexColor, 0, 2)) / 255;

        $green = hexdec(substr($hexColor, 2, 2)) / 255;

        $blue = hexdec(substr($hexColor, 4, 2)) / 255;

        $brightness = (0.2126 * $red) + (0.7152 * $green) + (0.0722 * $blue);

        return $brightness > 0.8 ? 'black' : 'white';
    }

    // public function getStatsAttribute(): array
    // {
    //     $this->load('matches.stats');

    //    $statistics = [];

    //    $statistics['matches'] = 0;
    //    foreach($this->matches as $match){
    //     $statistics['matches'] += 1;

        // foreach(['shots', 'goals', 'passes', 'assists', 'yellows', 'reds', 'rating'] as $key){
        //     if(isset($statistics[$key])){
        //         $statistics[$key] += $match->stats[$key];
        //     }
        //     else{
        //         $statistics[$key] = $match->stats[$key];
        //     }
        // }
    //    }

    //    return $statistics;
    // }

}
