<section>
    <header class="mb-8">
        <div class="flex items-center space-x-3 mb-4">
            <div class="p-3 rounded-xl shadow-lg"
                 style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-gray-900">
                    {{ __('Password & Security') }}
                </h2>
                <p class="text-gray-600 mt-1">
                    {{ __('Update your password to keep your account secure.') }}
                </p>
            </div>
        </div>
    </header>

    @if(auth()->user()->provider)
        <!-- Social Login User -->
        <div class="bg-gradient-to-r from-blue-50 to-cyan-50 rounded-2xl p-6 border border-blue-100">
            <div class="flex items-center space-x-4">
                <div class="p-3 bg-gradient-to-r from-blue-500 to-cyan-600 rounded-xl shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-blue-800">Social Login Account</h3>
                    <p class="text-blue-700 mt-1">
                        You're signed in with <span class="font-semibold">{{ ucfirst(auth()->user()->provider) }}</span>. Password changes are managed through your {{ ucfirst(auth()->user()->provider) }} account.
                    </p>
                </div>
            </div>
        </div>
    @else
        <!-- Regular User -->
        <form method="post" action="{{ route('password.update') }}" class="space-y-6">
            @csrf
            @method('put')

            <div class="space-y-6">
                <div class="group">
                    <x-input-label for="update_password_current_password" :value="__('Current Password')" class="text-gray-700 font-semibold" />
                    <div class="relative mt-2">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400 group-hover:text-green-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        <x-text-input id="update_password_current_password" name="current_password" type="password" class="pl-10 block w-full border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-xl shadow-sm transition-all duration-200" autocomplete="current-password" />
                    </div>
                    <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                </div>

                <div class="group">
                    <x-input-label for="update_password_password" :value="__('New Password')" class="text-gray-700 font-semibold" />
                    <div class="relative mt-2">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400 group-hover:text-green-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                            </svg>
                        </div>
                        <x-text-input id="update_password_password" name="password" type="password" class="pl-10 block w-full border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-xl shadow-sm transition-all duration-200" autocomplete="new-password" />
                    </div>
                    <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                    <p class="mt-2 text-sm text-gray-500 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Use at least 8 characters with a mix of letters, numbers, and symbols.
                    </p>
                </div>

                <div class="group">
                    <x-input-label for="update_password_password_confirmation" :value="__('Confirm New Password')" class="text-gray-700 font-semibold" />
                    <div class="relative mt-2">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400 group-hover:text-green-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="pl-10 block w-full border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-xl shadow-sm transition-all duration-200" autocomplete="new-password" />
                    </div>
                    <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                </div>
            </div>

            <div class="flex items-center gap-4 pt-6">
                <button type="submit" class="group relative overflow-hidden text-white px-8 py-3 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105"
                        style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                    <div class="absolute inset-0 bg-white/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-xl"></div>
                    <div class="relative flex items-center space-x-2">
                        <svg class="w-5 h-5 group-hover:animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        <span>{{ __('Update Password') }}</span>
                    </div>
                </button>

                @if (session('status') === 'password-updated')
                    <div class="flex items-center space-x-2 text-green-600 font-medium animate-fade-in">
                        <svg class="w-5 h-5 animate-bounce" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span>{{ __('Password updated successfully!') }}</span>
                    </div>
                @endif
            </div>
        </form>
    @endif

</section>
