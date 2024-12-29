<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    /** @use HasFactory<\Database\Factories\TournamentFactory> */
    use HasFactory;

    protected $fillable = ['name_en', 'name_ar', 'user_id'];

    public function matches()
    {
        return $this->hasMany(OfficialMatch::class, 'tournament_id');
    }
}
