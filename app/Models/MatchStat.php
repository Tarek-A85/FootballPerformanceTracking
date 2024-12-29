<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatchStat extends Model
{
    /** @use HasFactory<\Database\Factories\MatchStatFactory> */
    use HasFactory;

    protected $guarded = ['id'];

    public function match()
    {
        return $this->belongsTo(OfficialMatch::class, 'official_match_id');
    }
}
