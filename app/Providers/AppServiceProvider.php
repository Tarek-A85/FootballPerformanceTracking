<?php

namespace App\Providers;

use App\Events\CreationEvent;
use App\Events\ExceededRateLimitEvent;
use App\Listeners\CreationListener;
use App\Listeners\ExceededRateLimitListener;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
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
    }
}
