<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            {{ __('Edit Menu Item') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                <form method="POST" action="{{ route('admin.navigation-menu.update', $menuItem->id) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                            <input type="text" name="title" value="{{ old('title', $menuItem->title) }}" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('title')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Icon (SVG or Emoji)</label>
                            <textarea name="icon" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Paste SVG code or emoji">{{ old('icon', $menuItem->icon) }}</textarea>
                            @error('icon')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Type</label>
                            <select name="type" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="link" {{ old('type', $menuItem->type) == 'link' ? 'selected' : '' }}>Link</option>
                                <option value="dropdown" {{ old('type', $menuItem->type) == 'dropdown' ? 'selected' : '' }}>Dropdown</option>
                                <option value="separator" {{ old('type', $menuItem->type) == 'separator' ? 'selected' : '' }}>Separator</option>
                            </select>
                            @error('type')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Route Name</label>
                            <input type="text" name="route_name" value="{{ old('route_name', $menuItem->route_name) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="e.g., topics.index">
                            @error('route_name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">URL (if no route)</label>
                            <input type="text" name="url" value="{{ old('url', $menuItem->url) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="e.g., /about">
                            @error('url')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Sort Order</label>
                            <input type="number" name="sort_order" value="{{ old('sort_order', $menuItem->sort_order) }}" min="0" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('sort_order')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Target</label>
                            <select name="target" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="_self" {{ old('target', $menuItem->target) == '_self' ? 'selected' : '' }}>Same Window</option>
                                <option value="_blank" {{ old('target', $menuItem->target) == '_blank' ? 'selected' : '' }}>New Window</option>
                            </select>
                            @error('target')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">CSS Class</label>
                            <input type="text" name="css_class" value="{{ old('css_class', $menuItem->css_class) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="e.g., custom-class">
                            @error('css_class')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Permission Level</label>
                            <select name="permission" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="public" {{ old('permission', $menuItem->permission) == 'public' ? 'selected' : '' }}>Public (Everyone)</option>
                                <option value="editor" {{ old('permission', $menuItem->permission) == 'editor' ? 'selected' : '' }}>Editor (Editors & Admins)</option>
                                <option value="admin" {{ old('permission', $menuItem->permission) == 'admin' ? 'selected' : '' }}>Admin (Admins Only)</option>
                            </select>
                            @error('permission')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="flex items-center">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $menuItem->is_active) ? 'checked' : '' }} class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label class="ml-2 block text-sm text-gray-900">Active</label>
                        </div>
                    </div>
                    
                    <div class="flex justify-end space-x-3 mt-6">
                        <a href="{{ route('admin.navigation-menu.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors duration-200">
                            Cancel
                        </a>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200">
                            Update Menu Item
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
