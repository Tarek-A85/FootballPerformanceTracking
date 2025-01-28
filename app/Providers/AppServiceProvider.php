<?php

namespace App\Providers;

use App\Events\CreationEvent;
use App\Events\ExceededRateLimitEvent;
use App\Listeners\CreationListener;
use App\Listeners\ExceededRateLimitListener;
use App\Models\OfficialMatch;
use App\Models\Opponent;
use App\Models\Team;
use App\Models\Tournament;
use App\Models\TrainingSession;
use App\Models\User;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::preventLazyLoading();

       

        Relation::enforceMorphMap([
            'team' => 'App\Models\Team',
            'user' => 'App\Models\User',
        ]);

        Gate::define('manage-team', function(User $user, Team $team){
            return ($user->id === $team->user_id);
        });

        Gate::define('manage-tournament', function(User $user, Tournament $tournament){
            return ($user->id === $tournament->user_id);
        });

        Gate::define('manage-match', function(User $user, OfficialMatch $match){
            $team = $match->team;

            return ($user->id === $team->id);
        });

        Gate::define('manage-opponent', function(User $user, Opponent $opponent){
            return ($user->id === $opponent->user_id);
        });

        Gate::define('manage-training', function(User $user, TrainingSession $training){
            $trainable = $training->trainable;

            if($training->trainable_type === 'user'){
                return ($user->id === $trainable->id);
            }
            else{
                return ($user->id === $trainable->user_id);
            }
        });
    }
}
