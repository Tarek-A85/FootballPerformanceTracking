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
        Schema::create('match_stats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('official_match_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('goals');
            $table->unsignedInteger('assists');
            $table->unsignedInteger('passes');
            $table->unsignedInteger('shots');
            $table->unsignedInteger('headers');
            $table->unsignedInteger('yellows');
            $table->unsignedInteger('reds');
            $table->decimal('rating', 3, 1);
            $table->text('report')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('match_stats');
    }
};
