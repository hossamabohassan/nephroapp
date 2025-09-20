<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="md:col-span-2">
        <label for="title" class="block text-sm font-medium text-slate-700 mb-2">Title</label>
        <input type="text" 
               name="title" 
               id="title" 
               value="{{ old('title', $menuItem->title ?? '') }}"
               class="block w-full px-3 py-2 border border-slate-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('title') border-red-500 @enderror"
               placeholder="e.g., Home, Topics, About"
               required>
        @error('title')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="url" class="block text-sm font-medium text-slate-700 mb-2">URL</label>
        <input type="text" 
               name="url" 
               id="url" 
               value="{{ old('url', $menuItem->url ?? '') }}"
               class="block w-full px-3 py-2 border border-slate-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('url') border-red-500 @enderror"
               placeholder="e.g., /, /topics, /about"
               required>
        @error('url')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="icon" class="block text-sm font-medium text-slate-700 mb-2">Icon</label>
        <select name="icon" 
                id="icon" 
                class="block w-full px-3 py-2 border border-slate-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('icon') border-red-500 @enderror">
            <option value="">Default</option>
            <option value="home" {{ old('icon', $menuItem->icon ?? '') == 'home' ? 'selected' : '' }}>
                🏠 Home
            </option>
            <option value="book" {{ old('icon', $menuItem->icon ?? '') == 'book' ? 'selected' : '' }}>
                📚 Book/Topics
            </option>
            <option value="info" {{ old('icon', $menuItem->icon ?? '') == 'info' ? 'selected' : '' }}>
                ℹ️ Info
            </option>
            <option value="user" {{ old('icon', $menuItem->icon ?? '') == 'user' ? 'selected' : '' }}>
                👤 User/Profile
            </option>
            <option value="settings" {{ old('icon', $menuItem->icon ?? '') == 'settings' ? 'selected' : '' }}>
                ⚙️ Settings
            </option>
            <option value="mail" {{ old('icon', $menuItem->icon ?? '') == 'mail' ? 'selected' : '' }}>
                ✉️ Contact/Mail
            </option>
        </select>
        @error('icon')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="order" class="block text-sm font-medium text-slate-700 mb-2">Order</label>
        <input type="number" 
               name="order" 
               id="order" 
               value="{{ old('order', $menuItem->order ?? 0) }}"
               min="0"
               class="block w-full px-3 py-2 border border-slate-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('order') border-red-500 @enderror"
               required>
        @error('order')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
        <p class="text-slate-500 text-sm mt-1">Lower numbers appear first in the menu</p>
    </div>

    <div>
        <label for="permission" class="block text-sm font-medium text-slate-700 mb-2">Permission Level</label>
        <select name="permission" 
                id="permission" 
                class="block w-full px-3 py-2 border border-slate-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('permission') border-red-500 @enderror"
                required>
            <option value="public" {{ old('permission', $menuItem->permission ?? 'public') == 'public' ? 'selected' : '' }}>
                🌐 Public - Visible to everyone
            </option>
            <option value="editor" {{ old('permission', $menuItem->permission ?? 'public') == 'editor' ? 'selected' : '' }}>
                ✏️ Editor - Visible to editors and admins
            </option>
            <option value="admin" {{ old('permission', $menuItem->permission ?? 'public') == 'admin' ? 'selected' : '' }}>
                👑 Admin - Visible to admins only
            </option>
        </select>
        @error('permission')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
        <p class="text-slate-500 text-sm mt-1">Control who can see this menu item</p>
    </div>

    <div class="md:col-span-2">
        <div class="space-y-4">
            <div class="flex items-center">
                <input type="checkbox" 
                       name="is_active" 
                       id="is_active" 
                       value="1"
                       {{ old('is_active', $menuItem->is_active ?? true) ? 'checked' : '' }}
                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-slate-300 rounded">
                <label for="is_active" class="ml-2 text-sm text-slate-700">
                    Active (show in navigation)
                </label>
            </div>

            <div class="flex items-center">
                <input type="checkbox" 
                       name="opens_in_new_tab" 
                       id="opens_in_new_tab" 
                       value="1"
                       {{ old('opens_in_new_tab', $menuItem->opens_in_new_tab ?? false) ? 'checked' : '' }}
                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-slate-300 rounded">
                <label for="opens_in_new_tab" class="ml-2 text-sm text-slate-700">
                    Open in new tab
                </label>
            </div>
        </div>
    </div>
</div>

<div class="flex justify-end space-x-3 mt-6 pt-6 border-t border-slate-200">
    <a href="{{ route('admin.menu-items.index') }}" 
       class="px-4 py-2 border border-slate-300 rounded-lg text-slate-700 hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors">
        Cancel
    </a>
    <button type="submit" 
            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors">
        {{ isset($menuItem) ? 'Update Menu Item' : 'Create Menu Item' }}
    </button>
</div>
