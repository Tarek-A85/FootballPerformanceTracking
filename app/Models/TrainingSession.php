<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingSession extends Model
{
    /** @use HasFactory<\Database\Factories\TrainingSessionFactory> */
    use HasFactory;

    protected $guarded = ['id'];

    public function date(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => Carbon::parse($value)->format('Y-m-d'),
        );
    }


    public function trainable()
    {
        return $this->morphTo(__FUNCTION__, 'trainable_type', 'trainable_id');
    }

    public function getTypeAttribute()
    {
        return 'training';
    }

    public function training_type()
    {
        return $this->belongsTo(TrainingType::class, 'training_type_id');
    }

    public function status()
    {
        return $this->belongsTo(ActivityStatus::class, 'status_id');
    }
}
