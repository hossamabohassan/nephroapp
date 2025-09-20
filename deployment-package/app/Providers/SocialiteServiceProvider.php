<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Socialite\Contracts\Factory;
use GuzzleHttp\Client;

class SocialiteServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Configure HTTP client for local development
        if (app()->environment('local')) {
            $this->app->bind(Client::class, function () {
                return new Client([
                    'verify' => false, // Disable SSL verification for local development
                    'timeout' => 30,
                ]);
            });
        }
    }
}
