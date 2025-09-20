<?php
    $pageTitle = 'Manage Users';
    $pageDescription = 'User management and authentication settings';
?>

<?php if (isset($component)) { $__componentOriginal91fdd17964e43374ae18c674f95cdaa3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal91fdd17964e43374ae18c674f95cdaa3 = $attributes; } ?>
<?php $component = App\View\Components\AdminLayout::resolve(['pageTitle' => $pageTitle,'pageDescription' => $pageDescription] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AdminLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>

    <div class="space-y-6">
            <?php if(session('status')): ?>
                <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded">
                    <?php echo e(session('status')); ?>

                </div>
            <?php endif; ?>

            <?php if($errors->any()): ?>
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded">
                    <p class="font-semibold"><?php echo e(__('Please fix the highlighted errors.')); ?></p>
                </div>
            <?php endif; ?>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200 space-y-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900"><?php echo e(__('Authentication Options')); ?></h3>
                    <p class="text-sm text-gray-500"><?php echo e(__('Pick which sign-up methods are available to people visiting the site.')); ?></p>
                </div>

                <form method="POST" action="<?php echo e(route('admin.users.auth-settings.update')); ?>" class="space-y-4">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>

                    <div class="grid gap-4 md:grid-cols-2">
                        <label class="flex items-start gap-3 rounded-md border border-gray-200 px-4 py-3">
                            <input type="checkbox" name="allow_email_registration" value="1" class="mt-1 h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" <?php if($authSettings->allow_email_registration): echo 'checked'; endif; ?>>
                            <span>
                                <span class="block text-sm font-medium text-gray-900"><?php echo e(__('Email sign up')); ?></span>
                                <span class="mt-1 block text-xs text-gray-500"><?php echo e(__('Show the registration form so people can create accounts with email and password.')); ?></span>
                            </span>
                        </label>

                        <label class="flex items-start gap-3 rounded-md border border-gray-200 px-4 py-3">
                            <input type="checkbox" name="allow_google_auth" value="1" class="mt-1 h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" <?php if($authSettings->allow_google_auth): echo 'checked'; endif; ?>>
                            <span>
                                <span class="block text-sm font-medium text-gray-900"><?php echo e(__('Google sign in')); ?></span>
                                <span class="mt-1 block text-xs text-gray-500"><?php echo e(__('Enable �Continue with Google� for quick sign in and registration.')); ?></span>
                            </span>
                        </label>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:border-indigo-700 focus:ring focus:ring-indigo-200 transition">
                            <?php echo e(__('Save settings')); ?>

                        </button>
                    </div>
                </form>
            </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900"><?php echo e(__('User directory')); ?></h3>
                <a href="<?php echo e(route('admin.users.create')); ?>" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 transition">
                    <?php echo e(__('Create user')); ?>

                </a>
            </div>

                <form method="GET" action="<?php echo e(route('admin.users.index')); ?>" class="grid gap-4 md:grid-cols-4">
                    <div class="md:col-span-2">
                        <label for="q" class="block text-sm font-medium text-gray-700"><?php echo e(__('Search')); ?></label>
                        <input id="q" name="q" type="text" value="<?php echo e($filters['q']); ?>" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="<?php echo e(__('Search by name or email')); ?>">
                    </div>
                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700"><?php echo e(__('Role')); ?></label>
                        <select id="role" name="role" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value=""><?php echo e(__('All roles')); ?></option>
                            <option value="admin" <?php if($filters['role'] === 'admin'): echo 'selected'; endif; ?>><?php echo e(__('Admin')); ?></option>
                            <option value="editor" <?php if($filters['role'] === 'editor'): echo 'selected'; endif; ?>><?php echo e(__('Editor')); ?></option>
                            <option value="member" <?php if($filters['role'] === 'member'): echo 'selected'; endif; ?>><?php echo e(__('Member')); ?></option>
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="inline-flex justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <?php echo e(__('Apply')); ?>

                        </button>
                    </div>
                </form>
            </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
            <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><?php echo e(__('Name')); ?></th>
                                <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><?php echo e(__('Email')); ?></th>
                                <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><?php echo e(__('Role')); ?></th>
                                <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><?php echo e(__('Status')); ?></th>
                                <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><?php echo e(__('Last login')); ?></th>
                                <th class="px-3 py-3"></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 text-sm">
                            <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td class="px-3 py-3">
                                        <div class="font-medium text-gray-900"><?php echo e($user->name); ?></div>
                                    </td>
                                    <td class="px-3 py-3 text-gray-500"><?php echo e($user->email); ?></td>
                                    <td class="px-3 py-3 text-gray-500"><?php echo e(ucfirst($user->role)); ?></td>
                                    <td class="px-3 py-3">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo e($user->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-200 text-gray-700'); ?>">
                                            <?php echo e($user->is_active ? __('Active') : __('Inactive')); ?>

                                        </span>
                                    </td>
                                    <td class="px-3 py-3 text-gray-500"><?php echo e(optional($user->last_login_at)->diffForHumans() ?? __('Never')); ?></td>
                                    <td class="px-3 py-3 text-right">
                                        <a href="<?php echo e(route('admin.users.edit', $user)); ?>" class="text-indigo-600 hover:text-indigo-800"><?php echo e(__('Manage')); ?></a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="6" class="px-3 py-6 text-center text-gray-500"><?php echo e(__('No users found.')); ?></td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    <?php echo e($users->links()); ?>

            </div>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal91fdd17964e43374ae18c674f95cdaa3)): ?>
<?php $attributes = $__attributesOriginal91fdd17964e43374ae18c674f95cdaa3; ?>
<?php unset($__attributesOriginal91fdd17964e43374ae18c674f95cdaa3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal91fdd17964e43374ae18c674f95cdaa3)): ?>
<?php $component = $__componentOriginal91fdd17964e43374ae18c674f95cdaa3; ?>
<?php unset($__componentOriginal91fdd17964e43374ae18c674f95cdaa3); ?>
<?php endif; ?>
<?php /**PATH /homepages/38/d4299336130/htdocs/resources/views/admin/users/index.blade.php ENDPATH**/ ?>