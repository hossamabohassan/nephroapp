<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;

class SettingsServiceProvider extends ServiceProvider
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
        // Only load settings if the database is set up and the settings table exists
        if ($this->app->runningInConsole() && !$this->app->runningUnitTests()) {
            return;
        }

        try {
            if (Schema::hasTable('settings')) {
                $this->loadSettings();
            }
        } catch (\Exception $e) {
            // Silently fail if there are database issues
            // This prevents breaking the app during migrations or fresh installs
        }
    }

    private function loadSettings(): void
    {
        $settings = Setting::getAllAsArray();
        
        // Apply saved settings to Laravel config
        if (isset($settings['app_name'])) {
            Config::set('app.name', $settings['app_name']);
        }
        
        if (isset($settings['app_url'])) {
            Config::set('app.url', $settings['app_url']);
        }
        
        if (isset($settings['timezone'])) {
            Config::set('app.timezone', $settings['timezone']);
            date_default_timezone_set($settings['timezone']);
        }
        
        if (isset($settings['locale'])) {
            Config::set('app.locale', $settings['locale']);
            app()->setLocale($settings['locale']);
        }
        
        // Google Auth Settings
        if (isset($settings['google_client_id'])) {
            Config::set('services.google.client_id', $settings['google_client_id']);
        }
        
        if (isset($settings['google_client_secret'])) {
            Config::set('services.google.client_secret', $settings['google_client_secret']);
        }
        
        if (isset($settings['google_redirect_uri'])) {
            Config::set('services.google.redirect', $settings['google_redirect_uri']);
        }
    }
}
