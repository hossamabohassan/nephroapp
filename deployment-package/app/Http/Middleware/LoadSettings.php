<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\HttpFoundation\Response;

class LoadSettings
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            if (Schema::hasTable('settings')) {
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
                }
                
                if (isset($settings['locale'])) {
                    Config::set('app.locale', $settings['locale']);
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
        } catch (\Exception $e) {
            // Silently fail if there are database issues
        }

        return $next($request);
    }
}
