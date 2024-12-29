<?php

use App\Http\Controllers\LocaleController;
use App\Http\Controllers\MatchStatController;
use App\Http\Controllers\OfficialMatchController;
use App\Http\Controllers\OpponentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TournamentController;
use App\Http\Controllers\TrainingSessionController;
use App\Http\Controllers\WithTeamStatsController;
use App\Models\Tournament;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;


Route::view('test', 'test');



Route::get('locale/{lang}', LocaleController::class)->whereIn('lang', config('app.supported_locales'))
                                                    ->name('change_locale');

Route::middleware('check_locale')->group(function(){

                                              
Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('schedule', [ScheduleController::class, 'index'])->name('schedule.index');
    Route::resource('teams', TeamController::class);
    Route::resource('tournaments', TournamentController::class);
    Route::resource('matches', OfficialMatchController::class);
    Route::resource('opponents', OpponentController::class);
    Route::resource('trainings', TrainingSessionController::class);
    Route::controller(WithTeamStatsController::class)->group(function(){
        Route::get('match/stats/{team}', 'matches_stats')->name('team.match_stats');
        Route::get('training/stats/{team}', 'training_stats')->name('team.training_stats');

    });
    Route::controller(MatchStatController::class)->name('stats.')->prefix('stats')->group(function(){
        Route::get('/{match}', 'create')->name('create');
        Route::post('/{match}', 'store')->name('store');
        Route::get('/{stat}/edit', 'edit')->name('edit');
        Route::put('/{stat}/update', 'update')->name('update');
    });
    Route::get('/main/page', function(){
        return view('main-page');
    })->name('main_page');

    Route::get('test/{team}', [WithTeamStatsController::class, 'matches_stats']);

    Route::middleware('is_admin')->prefix('admin')->group(function(){
        Route::get('/dashboard', function () {
            return view('dashboard');
        })->name('dashboard');
    });
});

});

require __DIR__.'/auth.php';
