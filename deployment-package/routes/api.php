<?php

use App\Http\Controllers\Api\TopicController;
use App\Http\Controllers\Api\UserPreferencesController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'active'])
    ->prefix('admin')
    ->name('api.admin.')
    ->group(function () {
        Route::apiResource('topics', TopicController::class)
            ->scoped(['topic' => 'slug']);
    });

// User preferences API routes moved to web.php for session auth
