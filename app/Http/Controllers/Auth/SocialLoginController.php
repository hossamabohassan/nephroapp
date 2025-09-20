<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Support\AuthSettings;
use GuzzleHttp\Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

class SocialLoginController extends Controller
{
    public function redirectToGoogle(): RedirectResponse
    {
        if (! AuthSettings::allowsGoogleAuth()) {
            abort(404);
        }

        // Ensure Google auth settings are loaded
        $this->loadGoogleAuthSettings();

        // Create custom HTTP client for local development
        if (app()->environment('local')) {
            $httpClient = new Client([
                'verify' => false, // Disable SSL verification for local development
                'timeout' => 30,
            ]);
            
            return Socialite::driver('google')
                ->stateless()
                ->setHttpClient($httpClient)
                ->redirect();
        } else {
            return Socialite::driver('google')
                ->stateless()
                ->redirect();
        }
    }

    public function handleGoogleCallback(): RedirectResponse
    {
        if (! AuthSettings::allowsGoogleAuth()) {
            abort(404);
        }

        // Ensure Google auth settings are loaded
        $this->loadGoogleAuthSettings();

        try {
            // Create custom HTTP client for local development
            if (app()->environment('local')) {
                $httpClient = new \GuzzleHttp\Client([
                    'verify' => false, // Disable SSL verification for local development
                    'timeout' => 30,
                ]);
                
                $googleUser = Socialite::driver('google')
                    ->stateless()
                    ->setHttpClient($httpClient)
                    ->user();
            } else {
                $googleUser = Socialite::driver('google')->stateless()->user();
            }
        } catch (Throwable $exception) {
            // Log the actual error for debugging
            \Log::error('Google OAuth Error: ' . $exception->getMessage(), [
                'exception' => $exception,
                'google_client_id' => config('services.google.client_id'),
                'google_redirect' => config('services.google.redirect'),
            ]);
            
            return redirect()->route('login')->withErrors([
                'email' => __('Unable to sign in with Google. Please try again.'),
            ]);
        }

        if (! $googleUser->getEmail()) {
            return redirect()->route('login')->withErrors([
                'email' => __('Your Google account does not have an email address we can use.'),
            ]);
        }

        $user = User::query()
            ->where('provider', 'google')
            ->where('provider_id', $googleUser->getId())
            ->first();

        if (! $user) {
            $user = User::query()->where('email', $googleUser->getEmail())->first();

            if ($user) {
                $user->forceFill([
                    'provider' => 'google',
                    'provider_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar() ?: $user->avatar,
                    'email_verified_at' => $user->email_verified_at ?? now(),
                ])->save();
            } else {
                $user = User::create([
                    'name' => $googleUser->getName() ?: $googleUser->getNickname() ?: $googleUser->getEmail(),
                    'email' => $googleUser->getEmail(),
                    'password' => Hash::make(Str::random(40)),
                    'role' => User::ROLE_MEMBER,
                    'is_active' => true,
                    'provider' => 'google',
                    'provider_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                ]);

                $user->forceFill(['email_verified_at' => now()])->save();
            }
        }

        if (! $user->is_active) {
            return redirect()->route('login')->withErrors([
                'email' => __('Your account is inactive. Please contact support.'),
            ]);
        }

        $user->forceFill([
            'last_login_at' => now(),
            'avatar' => $googleUser->getAvatar() ?: $user->avatar,
        ])->save();

        Auth::login($user, true);

        return redirect()->intended(route('dashboard', absolute: false));
    }

    private function loadGoogleAuthSettings(): void
    {
        try {
            $settings = \App\Models\Setting::getAllAsArray();
            
            if (isset($settings['google_client_id'])) {
                config(['services.google.client_id' => $settings['google_client_id']]);
            }
            
            if (isset($settings['google_client_secret'])) {
                config(['services.google.client_secret' => $settings['google_client_secret']]);
            }
            
            if (isset($settings['google_redirect_uri'])) {
                config(['services.google.redirect' => $settings['google_redirect_uri']]);
            }
            
            // Disable SSL verification for local development
            if (app()->environment('local')) {
                config(['services.google.verify' => false]);
            }
        } catch (\Exception $e) {
            // Silently fail if there are database issues
        }
    }
}
