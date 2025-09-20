<x-guest-layout>
    @php
        $allowGoogleAuth = \App\Support\AuthSettings::allowsGoogleAuth();
        $allowEmailRegistration = \App\Support\AuthSettings::allowsEmailRegistration();
    @endphp

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    @if ($allowGoogleAuth)
        <div class="mb-6">
            <a href="{{ route('auth.google.redirect') }}" class="inline-flex w-full items-center justify-center gap-3 rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition">
                <svg class="h-5 w-5" viewBox="0 0 533.5 544.3" xmlns="http://www.w3.org/2000/svg">
                    <path fill="#EA4335" d="M533.5 278.4c0-17.4-1.4-34.9-4.3-52H272v98.5h147c-6.4 34.7-26 64.1-55.5 83.7v69.4h89.2c52.2-48.1 80.8-119 80.8-199.6z"/>
                    <path fill="#34A853" d="M272 544.3c74.7 0 137.4-24.7 183.2-67.2l-89.2-69.4c-24.7 16.6-56.3 26.3-94 26.3-72.1 0-133.3-48.7-155.1-114.3H26.2v71.8C72.4 482.5 166.1 544.3 272 544.3z"/>
                    <path fill="#4A90E2" d="M116.9 319.7c-10.4-30.1-10.4-62.4 0-92.5V155.4H26.2c-43.6 86.9-43.6 190.5 0 277.4l90.7-71.1z"/>
                    <path fill="#FBBC05" d="M272 107.7c39.5-.6 77.3 14 105.9 40.8l79.1-79.1C409.4 24.5 343.6-1.2 272 0 166.1 0 72.4 61.8 26.2 167.8l90.7 71.1C138.7 156.4 199.9 107.7 272 107.7z"/>
                </svg>
                <span>{{ __('Continue with Google') }}</span>
            </a>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>

    @if ($allowEmailRegistration)
        <p class="mt-6 text-center text-sm text-gray-600">
            {{ __('Need an account?') }}
            <a href="{{ route('register') }}" class="font-semibold text-indigo-600 hover:text-indigo-500">{{ __('Create one') }}</a>
        </p>
    @endif
</x-guest-layout>
