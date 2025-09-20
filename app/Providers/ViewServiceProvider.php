<?php

namespace App\Providers;

use App\Models\MenuItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
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
        // Share menu items with admin layout
        View::composer('layouts.admin', function ($view) {
            $user = Auth::user();
            $userRole = $user ? $user->role : 'public';
            
            $menuItems = MenuItem::active()
                ->visibleToUser($userRole)
                ->ordered()
                ->get();
                
            $view->with('adminMenuItems', $menuItems);
        });

        // Share menu items with profile layout and all views
        View::composer(['layouts.app', 'profile.*'], function ($view) {
            $user = Auth::user();
            $userRole = $user ? $user->role : 'public';
            
            $menuItems = MenuItem::active()
                ->visibleToUser($userRole)
                ->ordered()
                ->get();
                
            $view->with('userMenuItems', $menuItems);
        });
    }
}
