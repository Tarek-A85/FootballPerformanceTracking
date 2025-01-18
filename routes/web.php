<?php

use App\Http\Controllers\AllStatsController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\MatchStatController;
use App\Http\Controllers\OfficialMatchController;
use App\Http\Controllers\OpponentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\Team\{
    TeamController,
    TeamActivityController
};
use App\Http\Controllers\TournamentController;
use App\Http\Controllers\TrainingSessionController;
use App\Http\Controllers\WithTeamStatsController;
use App\Models\Team;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;



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
    Route::get('create/match/{tournament}', [TournamentController::class, 'create_match'])->name('tournaments.create_match');
    Route::resource('tournaments', TournamentController::class);
    Route::get('matches/show/{match}/{team?}', [OfficialMatchController::class, 'show'])->name('matches.show');
    Route::delete('matches/{match}/{team?}', [OfficialMatchController::class, 'destroy'])->name('matches.destroy');
    Route::resource('matches', OfficialMatchController::class)->except('show', 'destroy');
    Route::get('opponents/create/{team?}', [OpponentController::class, 'create'])->name('opponents.create');
    Route::resource('opponents', OpponentController::class)->except('create');
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

    Route::controller(TeamActivityController::class)->name('team.')->group(function(){
        Route::get('match/{team}', 'create_match')->name('create_match');
        Route::get('training/{team}', 'create_training')->name('create_training');
    });

    Route::controller(AllStatsController::class)->name('stats.')->group(function(){
        Route::get('matches/statistics', 'matches_stats')->name('matches');
        Route::get('training/sessions/statistics', 'trainings_stats')->name('trainings');

    });

    Route::get('test/{team}', [WithTeamStatsController::class, 'matches_stats']);

    Route::middleware('is_admin')->prefix('admin')->group(function(){
        Route::get('/dashboard', function () {
            return view('dashboard');
        })->name('dashboard');
    });
});

});

require __DIR__.'/auth.php';
