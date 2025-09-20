<?php

namespace App\Providers;

use App\Models\NavigationMenuItem;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class NavigationMenuServiceProvider extends ServiceProvider
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
        View::composer(['layouts.app', 'topics.*', 'profile.*'], function ($view) {
            $user = auth()->user();
            $userRole = $user ? $user->role : 'public';
            
            $navigationMenuItems = NavigationMenuItem::active()
                ->visibleToUser($userRole)
                ->ordered()
                ->get();
            
            $navigationHeaderButtons = \App\Models\NavigationHeaderButton::active()
                ->visibleToUser($userRole)
                ->ordered()
                ->get();
            
            $view->with([
                'navigationMenuItems' => $navigationMenuItems,
                'navigationHeaderButtons' => $navigationHeaderButtons,
            ]);
        });
    }
}