<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if (function_exists('mb_internal_encoding')) {
            mb_internal_encoding('UTF-8');
        }

        if (function_exists('mb_regex_encoding')) {
            mb_regex_encoding('UTF-8');
        }
    }
}
