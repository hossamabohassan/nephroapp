@php
    $pageTitle = 'Create User';
    $pageDescription = 'Add a new user to the system';
@endphp

<x-admin-layout :page-title="$pageTitle" :page-description="$pageDescription">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">{{ $pageTitle }}</h1>
            <p class="text-sm text-slate-600">{{ $pageDescription }}</p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="inline-flex items-center px-3 py-2 bg-slate-600 text-white rounded-lg hover:bg-slate-700 transition-colors">
            {{ __('Back to users') }}
        </a>
    </div>

    <div class="space-y-6">
            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded">
                    <p class="font-semibold">{{ __('Please fix the highlighted errors.') }}</p>
                </div>
            @endif

        <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
            <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">{{ __('Name') }}</label>
                        <input id="name" name="name" type="text" value="{{ old('name') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">{{ __('Email') }}</label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="grid gap-6 md:grid-cols-2">
                        <div>
                            <label for="role" class="block text-sm font-medium text-gray-700">{{ __('Role') }}</label>
                            <select id="role" name="role" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="admin" @selected(old('role') === 'admin')>{{ __('Admin') }}</option>
                                <option value="editor" @selected(old('role', 'member') === 'editor')>{{ __('Editor') }}</option>
                                <option value="member" @selected(old('role', 'member') === 'member')>{{ __('Member') }}</option>
                            </select>
                            <x-input-error :messages="$errors->get('role')" class="mt-2" />
                        </div>

                        <div>
                            <label for="is_active" class="block text-sm font-medium text-gray-700">{{ __('Status') }}</label>
                            <select id="is_active" name="is_active" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="1" @selected(old('is_active', '1') == '1')>{{ __('Active') }}</option>
                                <option value="0" @selected(old('is_active') == '0')>{{ __('Inactive') }}</option>
                            </select>
                            <x-input-error :messages="$errors->get('is_active')" class="mt-2" />
                        </div>
                    </div>

                    <div class="grid gap-6 md:grid-cols-2">
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">{{ __('Password') }}</label>
                            <input id="password" name="password" type="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">{{ __('Confirm Password') }}</label>
                            <input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        </div>
                    </div>

                    <div class="flex items-center justify-end">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:border-indigo-700 focus:ring focus:ring-indigo-200 disabled:opacity-25 transition">
                            {{ __('Create User') }}
                        </button>
                    </div>
            </form>
        </div>
    </div>
</x-admin-layout>
