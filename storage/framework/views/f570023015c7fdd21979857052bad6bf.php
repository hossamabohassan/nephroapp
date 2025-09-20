<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="md:col-span-2">
        <label for="title" class="block text-sm font-medium text-slate-700 mb-2">Title</label>
        <input type="text" 
               name="title" 
               id="title" 
               value="<?php echo e(old('title', $menuItem->title ?? '')); ?>"
               class="block w-full px-3 py-2 border border-slate-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
               placeholder="e.g., Home, Topics, About"
               required>
        <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <div>
        <label for="url" class="block text-sm font-medium text-slate-700 mb-2">URL</label>
        <input type="text" 
               name="url" 
               id="url" 
               value="<?php echo e(old('url', $menuItem->url ?? '')); ?>"
               class="block w-full px-3 py-2 border border-slate-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm <?php $__errorArgs = ['url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
               placeholder="e.g., /, /topics, /about"
               required>
        <?php $__errorArgs = ['url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <div>
        <label for="icon" class="block text-sm font-medium text-slate-700 mb-2">Icon</label>
        <select name="icon" 
                id="icon" 
                class="block w-full px-3 py-2 border border-slate-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm <?php $__errorArgs = ['icon'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
            <option value="">Default</option>
            <option value="home" <?php echo e(old('icon', $menuItem->icon ?? '') == 'home' ? 'selected' : ''); ?>>
                🏠 Home
            </option>
            <option value="book" <?php echo e(old('icon', $menuItem->icon ?? '') == 'book' ? 'selected' : ''); ?>>
                📚 Book/Topics
            </option>
            <option value="info" <?php echo e(old('icon', $menuItem->icon ?? '') == 'info' ? 'selected' : ''); ?>>
                ℹ️ Info
            </option>
            <option value="user" <?php echo e(old('icon', $menuItem->icon ?? '') == 'user' ? 'selected' : ''); ?>>
                👤 User/Profile
            </option>
            <option value="settings" <?php echo e(old('icon', $menuItem->icon ?? '') == 'settings' ? 'selected' : ''); ?>>
                ⚙️ Settings
            </option>
            <option value="mail" <?php echo e(old('icon', $menuItem->icon ?? '') == 'mail' ? 'selected' : ''); ?>>
                ✉️ Contact/Mail
            </option>
        </select>
        <?php $__errorArgs = ['icon'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <div>
        <label for="order" class="block text-sm font-medium text-slate-700 mb-2">Order</label>
        <input type="number" 
               name="order" 
               id="order" 
               value="<?php echo e(old('order', $menuItem->order ?? 0)); ?>"
               min="0"
               class="block w-full px-3 py-2 border border-slate-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm <?php $__errorArgs = ['order'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
               required>
        <?php $__errorArgs = ['order'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        <p class="text-slate-500 text-sm mt-1">Lower numbers appear first in the menu</p>
    </div>

    <div>
        <label for="permission" class="block text-sm font-medium text-slate-700 mb-2">Permission Level</label>
        <select name="permission" 
                id="permission" 
                class="block w-full px-3 py-2 border border-slate-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm <?php $__errorArgs = ['permission'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                required>
            <option value="public" <?php echo e(old('permission', $menuItem->permission ?? 'public') == 'public' ? 'selected' : ''); ?>>
                🌐 Public - Visible to everyone
            </option>
            <option value="editor" <?php echo e(old('permission', $menuItem->permission ?? 'public') == 'editor' ? 'selected' : ''); ?>>
                ✏️ Editor - Visible to editors and admins
            </option>
            <option value="admin" <?php echo e(old('permission', $menuItem->permission ?? 'public') == 'admin' ? 'selected' : ''); ?>>
                👑 Admin - Visible to admins only
            </option>
        </select>
        <?php $__errorArgs = ['permission'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        <p class="text-slate-500 text-sm mt-1">Control who can see this menu item</p>
    </div>

    <div class="md:col-span-2">
        <div class="space-y-4">
            <div class="flex items-center">
                <input type="checkbox" 
                       name="is_active" 
                       id="is_active" 
                       value="1"
                       <?php echo e(old('is_active', $menuItem->is_active ?? true) ? 'checked' : ''); ?>

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
                       <?php echo e(old('opens_in_new_tab', $menuItem->opens_in_new_tab ?? false) ? 'checked' : ''); ?>

                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-slate-300 rounded">
                <label for="opens_in_new_tab" class="ml-2 text-sm text-slate-700">
                    Open in new tab
                </label>
            </div>
        </div>
    </div>
</div>

<div class="flex justify-end space-x-3 mt-6 pt-6 border-t border-slate-200">
    <a href="<?php echo e(route('admin.menu-items.index')); ?>" 
       class="px-4 py-2 border border-slate-300 rounded-lg text-slate-700 hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors">
        Cancel
    </a>
    <button type="submit" 
            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors">
        <?php echo e(isset($menuItem) ? 'Update Menu Item' : 'Create Menu Item'); ?>

    </button>
</div>
<?php /**PATH /homepages/38/d4299336130/htdocs/nephroapp/resources/views/admin/menu-items/form.blade.php ENDPATH**/ ?>