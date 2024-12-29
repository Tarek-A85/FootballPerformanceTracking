<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute ;

class OfficialMatch extends Model
{
    /** @use HasFactory<\Database\Factories\OfficialMatchFactory> */
    use HasFactory;

    protected $guarded = ['id'];

    public function date(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => Carbon::parse($value)->format('Y-m-d'),
        );
    }

    public function stats()
    {
        return $this->hasOne(MatchStat::class, 'official_match_id');
    }

    public function team()
    {
        return $this->belongsTo(Team::class, 'home_team_id');
    }

    public function opponent()
    {
        return $this->belongsTo(Opponent::class, 'opponent_id');
    }

    public function tournament()
    {
        return $this->belongsTo(Tournament::class, 'tournament_id');
    }

    public function status()
    {
        return $this->belongsTo(ActivityStatus::class, 'status_id');
    }

    public function round()
    {
        return $this->belongsTo(Round::class, 'round_id');
    }

    public function getTypeAttribute()
    {
        return 'match';
    }
}
