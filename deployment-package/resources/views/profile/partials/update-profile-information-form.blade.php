<section>
    <header class="mb-8">
        <div class="flex items-center space-x-3 mb-4">
            <div class="p-3 rounded-xl shadow-lg"
                 style="background: linear-gradient(135deg, #3b82f6 0%, #9333ea 100%);">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-gray-900">
            {{ __('Profile Information') }}
        </h2>
                <p class="text-gray-600 mt-1">
            {{ __("Update your account's profile information and email address.") }}
        </p>
            </div>
        </div>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')


        <div class="space-y-6">
            <div class="group">
                <x-input-label for="name" :value="__('Full Name')" class="text-gray-700 font-semibold" />
                <div class="relative mt-2">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400 group-hover:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <x-text-input id="name" name="name" type="text" class="pl-10 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-xl shadow-sm transition-all duration-200" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                </div>
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

            <div class="group">
                <x-input-label for="email" :value="__('Email Address')" class="text-gray-700 font-semibold" />
                <div class="relative mt-2">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400 group-hover:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <x-text-input id="email" name="email" type="email" class="pl-10 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-xl shadow-sm transition-all duration-200" :value="old('email', $user->email)" required autocomplete="username" />
                </div>
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div class="mt-3 p-4 bg-yellow-50 border border-yellow-200 rounded-xl">
                        <p class="text-sm text-yellow-800">
                        {{ __('Your email address is unverified.') }}
                            <button form="send-verification" class="ml-2 underline text-yellow-600 hover:text-yellow-800 font-medium">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>
                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

            <div class="group">
                <x-input-label for="mobile_number" :value="__('Mobile Number')" class="text-gray-700 font-semibold" />
                <div class="relative mt-2">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400 group-hover:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                    </div>
                    <x-text-input id="mobile_number" name="mobile_number" type="tel" class="pl-10 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-xl shadow-sm transition-all duration-200" :value="old('mobile_number', $user->mobile_number)" autocomplete="tel" placeholder="+1 (555) 123-4567" />
                </div>
                <x-input-error class="mt-2" :messages="$errors->get('mobile_number')" />
                <p class="mt-2 text-sm text-gray-500 flex items-center">
                    <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Optional: Add your mobile number for account security and notifications.
                </p>
            </div>
        </div>

        <!-- Account Information -->
        <div class="bg-gradient-to-r from-gray-50 to-blue-50 rounded-2xl p-6 border border-gray-100">
            <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Account Information
            </h4>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="flex items-center space-x-3">
                    <div class="p-2 bg-blue-100 rounded-lg">
                        <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div>
                        <span class="text-sm text-gray-500">Role</span>
                        <div class="font-semibold text-gray-900">{{ ucfirst($user->role) }}</div>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="p-2 bg-green-100 rounded-lg">
                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <span class="text-sm text-gray-500">Member since</span>
                        <div class="font-semibold text-gray-900">{{ $user->created_at->format('M d, Y') }}</div>
                    </div>
                </div>
                @if($user->provider)
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-purple-100 rounded-lg">
                            <svg class="w-4 h-4 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <span class="text-sm text-gray-500">Connected via</span>
                            <div class="font-semibold text-gray-900">{{ ucfirst($user->provider) }}</div>
                        </div>
                    </div>
                @endif
                @if($user->last_login_at)
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-orange-100 rounded-lg">
                            <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <span class="text-sm text-gray-500">Last login</span>
                            <div class="font-semibold text-gray-900">{{ $user->last_login_at->diffForHumans() }}</div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="flex items-center gap-4 pt-6">
            <button type="submit" class="group relative overflow-hidden text-white px-8 py-3 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105"
                    style="background: linear-gradient(135deg, #3b82f6 0%, #9333ea 100%);">
                <div class="absolute inset-0 bg-white/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-xl"></div>
                <div class="relative flex items-center space-x-2">
                    <svg class="w-5 h-5 group-hover:animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>{{ __('Save Changes') }}</span>
                </div>
            </button>

            @if (session('status') === 'profile-updated')
                <div class="flex items-center space-x-2 text-green-600 font-medium animate-fade-in">
                    <svg class="w-5 h-5 animate-bounce" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span>{{ __('Profile updated successfully!') }}</span>
                </div>
            @endif
        </div>
    </form>
</section>
