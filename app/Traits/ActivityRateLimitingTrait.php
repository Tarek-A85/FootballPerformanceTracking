<?php

namespace App\Traits;

use Exception;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Queue\Middleware\ThrottlesExceptions;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use App\Services\ActivityLoggingService;
trait ActivityRateLimitingTrait{


     /**
     * Ensure the login request is not rate limited.
     *
     * 
     */
    public function ensureIsNotRateLimited(string $key, int $attempts, string $input): void
    {
        $throtlle_key = $this->throttleKey($key);

        if (!RateLimiter::tooManyAttempts($throtlle_key, $attempts)) {

           RateLimiter::hit($throtlle_key);

           return;
        }

        $seconds = RateLimiter::availableIn($throtlle_key);

        $logger = app(ActivityLoggingService::class);

        $logger->rateLimitExceeded($key,[
            'user' => auth()->user(),
            'ip' => request()->ip(),
        ]);
  
        throw ValidationException::withMessages([
            $input => __('Too many attempts, Please try again in :seconds seconds', ['seconds' => $seconds])
        ]);

        }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(string $key): string
    {
        return Str::transliterate($key . ' user_id: ' . auth()->id() . '|' . request()->ip());
    }

    
}