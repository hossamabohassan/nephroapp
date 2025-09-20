<?php

use App\Http\Middleware\EnsureUserIsActive;
use App\Http\Middleware\LoadSettings;
use App\Providers\AppServiceProvider;
use App\Providers\AuthServiceProvider;
use App\Providers\SocialiteServiceProvider;
use App\Providers\ViewServiceProvider;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withProviders([
        AppServiceProvider::class,
        AuthServiceProvider::class,
        SocialiteServiceProvider::class,
        ViewServiceProvider::class,
    ])
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'active' => EnsureUserIsActive::class,
        ]);
        
        // Load settings on every request
        $middleware->web(append: [
            LoadSettings::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
