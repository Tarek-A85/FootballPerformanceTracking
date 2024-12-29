<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('training_sessions', function (Blueprint $table) {
            $table->id();
            $table->morphs('trainable');
            $table->unsignedInteger('minutes');
            $table->date('date');
            $table->time('time');
            $table->foreignId('training_type_id')->constrained('training_types')->cascadeOnDelete();
            $table->foreignId('status_id')->constrained('activity_statuses')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_sessions');
    }
};
