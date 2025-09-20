<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            {{ __('Create Header Button') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                <form method="POST" action="{{ route('admin.navigation-header-buttons.store') }}">
                    @csrf
                    
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                            <input type="text" name="title" value="{{ old('title') }}" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('title')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Icon (SVG or Emoji)</label>
                            <textarea name="icon" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Paste SVG code or emoji">{{ old('icon') }}</textarea>
                            @error('icon')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Type</label>
                            <select name="type" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="button" {{ old('type') == 'button' ? 'selected' : '' }}>Button</option>
                                <option value="dropdown" {{ old('type') == 'dropdown' ? 'selected' : '' }}>Dropdown</option>
                                <option value="modal" {{ old('type') == 'modal' ? 'selected' : '' }}>Modal</option>
                            </select>
                            @error('type')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Route Name</label>
                            <input type="text" name="route_name" value="{{ old('route_name') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="e.g., profile.edit">
                            @error('route_name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">URL (if no route)</label>
                            <input type="text" name="url" value="{{ old('url') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="e.g., /about">
                            @error('url')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Sort Order</label>
                            <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" min="0" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('sort_order')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Target</label>
                            <select name="target" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="_self" {{ old('target', '_self') == '_self' ? 'selected' : '' }}>Same Window</option>
                                <option value="_blank" {{ old('target') == '_blank' ? 'selected' : '' }}>New Window</option>
                                <option value="modal" {{ old('target') == 'modal' ? 'selected' : '' }}>Modal</option>
                            </select>
                            @error('target')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">CSS Class</label>
                            <input type="text" name="css_class" value="{{ old('css_class') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="e.g., custom-class">
                            @error('css_class')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Badge Text</label>
                                <input type="text" name="badge_text" value="{{ old('badge_text') }}" maxlength="10" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="e.g., 5">
                                @error('badge_text')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Badge Color</label>
                                <select name="badge_color" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="red" {{ old('badge_color', 'red') == 'red' ? 'selected' : '' }}>Red</option>
                                    <option value="blue" {{ old('badge_color') == 'blue' ? 'selected' : '' }}>Blue</option>
                                    <option value="green" {{ old('badge_color') == 'green' ? 'selected' : '' }}>Green</option>
                                    <option value="yellow" {{ old('badge_color') == 'yellow' ? 'selected' : '' }}>Yellow</option>
                                    <option value="purple" {{ old('badge_color') == 'purple' ? 'selected' : '' }}>Purple</option>
                                    <option value="pink" {{ old('badge_color') == 'pink' ? 'selected' : '' }}>Pink</option>
                                    <option value="indigo" {{ old('badge_color') == 'indigo' ? 'selected' : '' }}>Indigo</option>
                                    <option value="gray" {{ old('badge_color') == 'gray' ? 'selected' : '' }}>Gray</option>
                                </select>
                                @error('badge_color')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Permission Level</label>
                            <select name="permission" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="public" {{ old('permission', 'public') == 'public' ? 'selected' : '' }}>Public (Everyone)</option>
                                <option value="editor" {{ old('permission') == 'editor' ? 'selected' : '' }}>Editor (Editors & Admins)</option>
                                <option value="admin" {{ old('permission') == 'admin' ? 'selected' : '' }}>Admin (Admins Only)</option>
                            </select>
                            @error('permission')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="flex items-center space-x-4">
                            <div class="flex items-center">
                                <input type="hidden" name="is_active" value="0">
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label class="ml-2 block text-sm text-gray-900">Active</label>
                            </div>
                            <div class="flex items-center">
                                <input type="hidden" name="show_badge" value="0">
                                <input type="checkbox" name="show_badge" value="1" {{ old('show_badge') ? 'checked' : '' }} class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label class="ml-2 block text-sm text-gray-900">Show Badge</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex justify-end space-x-3 mt-6">
                        <a href="{{ route('admin.navigation-header-buttons.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors duration-200">
                            Cancel
                        </a>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200">
                            Create Header Button
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
