<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'active']);
        $this->middleware('can:manage-settings');
    }

    public function index(): View
    {
        $settings = Setting::getAllAsArray();
        $authSettings = \App\Support\AuthSettings::get();
        
        return view('admin.settings.index', [
            'settings' => $settings,
            'authSettings' => $authSettings,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'app_name' => 'required|string|max:255',
            'app_url' => 'required|url|max:255',
            'timezone' => 'required|string|max:50',
            'locale' => 'required|string|max:10',
        ]);

        foreach ($validated as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        // Clear settings cache
        Cache::forget('settings');

        return redirect()
            ->route('admin.settings.index')
            ->with('success', 'Settings updated successfully.');
    }

    public function updateGoogleAuth(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'google_client_id' => 'nullable|string|max:255',
            'google_client_secret' => 'nullable|string|max:255',
            'google_redirect_uri' => 'nullable|url|max:255',
            'allow_google_auth' => 'boolean',
        ]);

        // Update Google auth settings in the settings table
        foreach ($validated as $key => $value) {
            if ($key === 'allow_google_auth') {
                // Update the auth settings table
                $authSettings = \App\Support\AuthSettings::get();
                $authSettings->update(['allow_google_auth' => (bool) $value]);
                \App\Support\AuthSettings::refresh();
            } else {
                // Update the general settings table
                Setting::set($key, $value, 'text', 'google_auth');
            }
        }

        // Clear settings cache
        Setting::clearCache();

        return redirect()
            ->route('admin.settings.index')
            ->with('success', 'Google authentication settings updated successfully.');
    }
}
