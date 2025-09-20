<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Gate::define('access-admin', fn (User $user): bool => $user->isEditor());

        Gate::define('manage-topics', fn (User $user): bool => $user->isEditor());

        Gate::define('manage-users', fn (User $user): bool => $user->isAdmin());

        Gate::define('manage-content', fn (User $user): bool => $user->isEditor());

        Gate::define('manage-settings', fn (User $user): bool => $user->isAdmin());

        Gate::define('view-activity', fn (User $user): bool => $user->isEditor());

        Gate::define('manage-permissions', fn (User $user): bool => $user->isAdmin());
    }
}
