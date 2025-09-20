@php
    $pageTitle = 'Edit User: ' . $user->name;
    $pageDescription = 'Update user information and permissions';
@endphp

<x-admin-layout :page-title="$pageTitle" :page-description="$pageDescription">

    <div class="space-y-6">
            @if (session('status'))
                <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded">
                    <p class="font-semibold">{{ __('Please fix the highlighted errors.') }}</p>
                </div>
            @endif

        <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
            <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">{{ __('Name') }}</label>
                        <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">{{ __('Email') }}</label>
                        <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="grid gap-6 md:grid-cols-2">
                        <div>
                            <label for="role" class="block text-sm font-medium text-gray-700">{{ __('Role') }}</label>
                            <select id="role" name="role" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="admin" @selected(old('role', $user->role) === 'admin')>{{ __('Admin') }}</option>
                                <option value="editor" @selected(old('role', $user->role) === 'editor')>{{ __('Editor') }}</option>
                                <option value="member" @selected(old('role', $user->role) === 'member')>{{ __('Member') }}</option>
                            </select>
                            <x-input-error :messages="$errors->get('role')" class="mt-2" />
                        </div>

                        <div>
                            <label for="is_active" class="block text-sm font-medium text-gray-700">{{ __('Status') }}</label>
                            <select id="is_active" name="is_active" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="1" @selected(old('is_active', $user->is_active) == true)>{{ __('Active') }}</option>
                                <option value="0" @selected(old('is_active', $user->is_active) == false)>{{ __('Inactive') }}</option>
                            </select>
                            <x-input-error :messages="$errors->get('is_active')" class="mt-2" />
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-500">
                            {{ __('Last login:') }} {{ optional($user->last_login_at)->format('M d, Y H:i') ?? __('Never') }}
                        </div>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:border-indigo-700 focus:ring focus:ring-indigo-200 disabled:opacity-25 transition">
                            {{ __('Save Changes') }}
                        </button>
                    </div>
            </form>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
            <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('{{ __('Deactivate this user?') }}');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:outline-none focus:border-red-700 focus:ring focus:ring-red-200 disabled:opacity-25 transition">
                        {{ __('Deactivate User') }}
                    </button>
            </form>
        </div>
    </div>
</x-admin-layout>
