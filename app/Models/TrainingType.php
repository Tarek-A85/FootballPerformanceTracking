<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingType extends Model
{
    /** @use HasFactory<\Database\Factories\TrainingTypeFactory> */
    use HasFactory;

    protected $fillable = ['name_ar', 'name_en'];
}
