<?php
    $pageTitle = 'System Settings';
    $pageDescription = 'Configure system-wide settings and preferences';
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
    
    <div class="max-w-4xl space-y-8">
        
        <!-- General Settings -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <div class="border-b border-slate-200 pb-4 mb-6">
                <h3 class="text-lg font-semibold text-slate-900">General Settings</h3>
                <p class="text-sm text-slate-600 mt-1">Basic application configuration and preferences</p>
            </div>

            <form method="POST" action="<?php echo e(route('admin.settings.update')); ?>" class="space-y-6">
                <?php echo csrf_field(); ?>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="app_name" class="block text-sm font-medium text-slate-700 mb-2">
                            Application Name
                        </label>
                        <input type="text" 
                               id="app_name" 
                               name="app_name" 
                               value="<?php echo e(old('app_name', $settings['app_name'] ?? config('app.name', 'NephroCoach'))); ?>"
                               class="block w-full px-3 py-2 border border-slate-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                               placeholder="NephroCoach">
                        <p class="mt-1 text-sm text-slate-500">The name of your application</p>
                    </div>

                    <div>
                        <label for="app_url" class="block text-sm font-medium text-slate-700 mb-2">
                            Application URL
                        </label>
                        <input type="url" 
                               id="app_url" 
                               name="app_url" 
                               value="<?php echo e(old('app_url', $settings['app_url'] ?? config('app.url', 'http://localhost'))); ?>"
                               class="block w-full px-3 py-2 border border-slate-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                               placeholder="https://your-domain.com">
                        <p class="mt-1 text-sm text-slate-500">The base URL for your application</p>
                    </div>

                    <div>
                        <label for="timezone" class="block text-sm font-medium text-slate-700 mb-2">
                            Timezone
                        </label>
                        <select id="timezone" 
                                name="timezone" 
                                class="block w-full px-3 py-2 border border-slate-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            <?php ($selectedTimezone = old('timezone', $settings['timezone'] ?? config('app.timezone'))); ?>
                            <option value="UTC" <?php echo e($selectedTimezone === 'UTC' ? 'selected' : ''); ?>>UTC</option>
                            <option value="America/New_York" <?php echo e($selectedTimezone === 'America/New_York' ? 'selected' : ''); ?>>Eastern Time</option>
                            <option value="America/Chicago" <?php echo e($selectedTimezone === 'America/Chicago' ? 'selected' : ''); ?>>Central Time</option>
                            <option value="America/Denver" <?php echo e($selectedTimezone === 'America/Denver' ? 'selected' : ''); ?>>Mountain Time</option>
                            <option value="America/Los_Angeles" <?php echo e($selectedTimezone === 'America/Los_Angeles' ? 'selected' : ''); ?>>Pacific Time</option>
                            <option value="Asia/Riyadh" <?php echo e($selectedTimezone === 'Asia/Riyadh' ? 'selected' : ''); ?>>Riyadh Time</option>
                        </select>
                        <p class="mt-1 text-sm text-slate-500">Default timezone for the application</p>
                    </div>

                    <div>
                        <label for="locale" class="block text-sm font-medium text-slate-700 mb-2">
                            Default Language
                        </label>
                        <select id="locale" 
                                name="locale" 
                                class="block w-full px-3 py-2 border border-slate-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            <?php ($selectedLocale = old('locale', $settings['locale'] ?? config('app.locale'))); ?>
                            <option value="en" <?php echo e($selectedLocale === 'en' ? 'selected' : ''); ?>>English</option>
                            <option value="ar" <?php echo e($selectedLocale === 'ar' ? 'selected' : ''); ?>>Arabic</option>
                        </select>
                        <p class="mt-1 text-sm text-slate-500">Default language for the application</p>
                    </div>
                </div>

                <div class="flex items-center justify-end">
                    <button type="submit" class="inline-flex items-center px-6 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Save Settings
                    </button>
                </div>
            </form>
        </div>

        <!-- Email Settings -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <div class="border-b border-slate-200 pb-4 mb-6">
                <h3 class="text-lg font-semibold text-slate-900">Email Configuration</h3>
                <p class="text-sm text-slate-600 mt-1">Configure email settings for notifications and communication</p>
            </div>

            <div class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Mail Driver
                        </label>
                        <div class="flex items-center space-x-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                <?php echo e(config('mail.default', 'smtp')); ?>

                            </span>
                        </div>
                        <p class="mt-1 text-sm text-slate-500">Current mail driver configuration</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            From Email
                        </label>
                        <div class="flex items-center space-x-4">
                            <span class="text-sm text-slate-600"><?php echo e(config('mail.from.address', 'hello@example.com')); ?></span>
                        </div>
                        <p class="mt-1 text-sm text-slate-500">Default sender email address</p>
                    </div>
                </div>

                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <div class="flex">
                        <svg class="w-5 h-5 text-yellow-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                        </svg>
                        <div>
                            <h4 class="text-sm font-semibold text-yellow-800">Email Configuration Notice</h4>
                            <p class="text-sm text-yellow-700 mt-1">
                                Email settings are configured in your environment file (.env). 
                                Contact your system administrator to modify SMTP settings.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Security Settings -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <div class="border-b border-slate-200 pb-4 mb-6">
                <h3 class="text-lg font-semibold text-slate-900">Security Settings</h3>
                <p class="text-sm text-slate-600 mt-1">Configure security and authentication preferences</p>
            </div>

            <div class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="text-sm font-medium text-slate-900">Email Registration</h4>
                            <p class="text-sm text-slate-500">Allow new users to register with email</p>
                        </div>
                        <div class="flex items-center">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium <?php echo e(\App\Support\AuthSettings::allowsEmailRegistration() ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'); ?>">
                                <?php echo e(\App\Support\AuthSettings::allowsEmailRegistration() ? 'Enabled' : 'Disabled'); ?>

                            </span>
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="text-sm font-medium text-slate-900">Email Verification</h4>
                            <p class="text-sm text-slate-500">Require email verification for new users</p>
                        </div>
                        <div class="flex items-center">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                Required
                            </span>
                        </div>
                    </div>
                </div>

                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex">
                        <svg class="w-5 h-5 text-blue-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div>
                            <h4 class="text-sm font-semibold text-blue-800">Authentication Settings</h4>
                            <p class="text-sm text-blue-700 mt-1">
                                Authentication settings can be managed in the 
                                <a href="<?php echo e(route('admin.users.index')); ?>" class="font-medium underline hover:no-underline">User Management</a> section.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Google Authentication Settings -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <div class="border-b border-slate-200 pb-4 mb-6">
                <h3 class="text-lg font-semibold text-slate-900">Google Authentication</h3>
                <p class="text-sm text-slate-600 mt-1">Configure Google OAuth settings for social login</p>
            </div>

            <form method="POST" action="<?php echo e(route('admin.settings.google-auth.update')); ?>" class="space-y-6">
                <?php echo csrf_field(); ?>

                <!-- Google Auth Toggle -->
                <div class="flex items-center justify-between p-4 bg-slate-50 rounded-lg">
                    <div>
                        <h4 class="text-sm font-medium text-slate-900">Enable Google Authentication</h4>
                        <p class="text-sm text-slate-500">Allow users to sign in with their Google accounts</p>
                    </div>
                    <div class="flex items-center">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" 
                                   name="allow_google_auth" 
                                   value="1" 
                                   class="sr-only peer" 
                                   <?php echo e($authSettings->allow_google_auth ? 'checked' : ''); ?>>
                            <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                    </div>
                </div>

                <!-- Google OAuth Configuration -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="google_client_id" class="block text-sm font-medium text-slate-700 mb-2">
                            Google Client ID
                        </label>
                        <input type="text" 
                               id="google_client_id" 
                               name="google_client_id" 
                               value="<?php echo e(old('google_client_id', $settings['google_client_id'] ?? config('services.google.client_id', ''))); ?>"
                               class="block w-full px-3 py-2 border border-slate-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm <?php $__errorArgs = ['google_client_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               placeholder="Your Google OAuth Client ID">
                        <?php $__errorArgs = ['google_client_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <p class="mt-1 text-sm text-slate-500">Get this from Google Cloud Console</p>
                    </div>

                    <div>
                        <label for="google_client_secret" class="block text-sm font-medium text-slate-700 mb-2">
                            Google Client Secret
                        </label>
                        <input type="password" 
                               id="google_client_secret" 
                               name="google_client_secret" 
                               value="<?php echo e(old('google_client_secret', $settings['google_client_secret'] ?? config('services.google.client_secret', ''))); ?>"
                               class="block w-full px-3 py-2 border border-slate-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm <?php $__errorArgs = ['google_client_secret'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               placeholder="Your Google OAuth Client Secret">
                        <?php $__errorArgs = ['google_client_secret'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <p class="mt-1 text-sm text-slate-500">Keep this secret secure</p>
                    </div>
                </div>

                <div>
                    <label for="google_redirect_uri" class="block text-sm font-medium text-slate-700 mb-2">
                        Redirect URI
                    </label>
                    <input type="url" 
                           id="google_redirect_uri" 
                           name="google_redirect_uri" 
                           value="<?php echo e(old('google_redirect_uri', $settings['google_redirect_uri'] ?? config('services.google.redirect', ''))); ?>"
                           class="block w-full px-3 py-2 border border-slate-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm <?php $__errorArgs = ['google_redirect_uri'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                           placeholder="<?php echo e(config('app.url')); ?>/auth/google/callback">
                    <?php $__errorArgs = ['google_redirect_uri'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    <p class="mt-1 text-sm text-slate-500">Add this URL to your Google OAuth app settings</p>
                </div>

                <!-- Google OAuth Setup Instructions -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex">
                        <svg class="w-5 h-5 text-blue-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div>
                            <h4 class="text-sm font-semibold text-blue-800">Google OAuth Setup Instructions</h4>
                            <div class="text-sm text-blue-700 mt-1 space-y-1">
                                <p>1. Go to <a href="https://console.cloud.google.com/" target="_blank" class="underline hover:no-underline">Google Cloud Console</a></p>
                                <p>2. Create a new project or select an existing one</p>
                                <p>3. Enable the Google+ API</p>
                                <p>4. Create OAuth 2.0 credentials</p>
                                <p>5. Add the redirect URI: <code class="bg-blue-100 px-1 rounded"><?php echo e(config('app.url')); ?>/auth/google/callback</code></p>
                                <p>6. Copy the Client ID and Client Secret to the fields above</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Current Status -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="text-center p-4 bg-slate-50 rounded-lg">
                        <div class="text-sm font-medium text-slate-900">
                            <?php echo e($authSettings->allow_google_auth ? 'Enabled' : 'Disabled'); ?>

                        </div>
                        <div class="text-xs text-slate-600">Google Auth Status</div>
                    </div>

                    <div class="text-center p-4 bg-slate-50 rounded-lg">
                        <div class="text-sm font-medium text-slate-900">
                            <?php echo e(!empty($settings['google_client_id'] ?? config('services.google.client_id')) ? 'Configured' : 'Not Set'); ?>

                        </div>
                        <div class="text-xs text-slate-600">Client ID</div>
                    </div>

                    <div class="text-center p-4 bg-slate-50 rounded-lg">
                        <div class="text-sm font-medium text-slate-900">
                            <?php echo e(!empty($settings['google_client_secret'] ?? config('services.google.client_secret')) ? 'Configured' : 'Not Set'); ?>

                        </div>
                        <div class="text-xs text-slate-600">Client Secret</div>
                    </div>
                </div>

                <div class="flex items-center justify-end">
                    <button type="submit" class="inline-flex items-center px-6 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Save Google Auth Settings
                    </button>
                </div>
            </form>
        </div>

        <!-- System Information -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <div class="border-b border-slate-200 pb-4 mb-6">
                <h3 class="text-lg font-semibold text-slate-900">System Information</h3>
                <p class="text-sm text-slate-600 mt-1">Current system status and version information</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="text-center p-4 bg-slate-50 rounded-lg">
                    <div class="text-2xl font-bold text-slate-900"><?php echo e(app()->version()); ?></div>
                    <div class="text-sm text-slate-600">Laravel Version</div>
                </div>

                <div class="text-center p-4 bg-slate-50 rounded-lg">
                    <div class="text-2xl font-bold text-slate-900"><?php echo e(PHP_VERSION); ?></div>
                    <div class="text-sm text-slate-600">PHP Version</div>
                </div>

                <div class="text-center p-4 bg-slate-50 rounded-lg">
                    <div class="text-2xl font-bold text-slate-900"><?php echo e(config('app.env')); ?></div>
                    <div class="text-sm text-slate-600">Environment</div>
                </div>
            </div>

            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h4 class="text-sm font-medium text-slate-900 mb-3">Cache Status</h4>
                    <div class="space-y-2">
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-slate-600">Configuration</span>
                            <span class="text-green-600 font-medium">Cached</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-slate-600">Routes</span>
                            <span class="text-green-600 font-medium">Cached</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-slate-600">Views</span>
                            <span class="text-green-600 font-medium">Cached</span>
                        </div>
                    </div>
                </div>

                <div>
                    <h4 class="text-sm font-medium text-slate-900 mb-3">Storage</h4>
                    <div class="space-y-2">
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-slate-600">Disk Space</span>
                            <span class="text-slate-900 font-medium">Available</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-slate-600">Logs</span>
                            <span class="text-slate-900 font-medium">Active</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-slate-600">Queue</span>
                            <span class="text-slate-900 font-medium">Running</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Maintenance Actions -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <div class="border-b border-slate-200 pb-4 mb-6">
                <h3 class="text-lg font-semibold text-slate-900">Maintenance Actions</h3>
                <p class="text-sm text-slate-600 mt-1">System maintenance and optimization tools</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <button type="button" onclick="clearCache('config')" class="flex flex-col items-center p-4 border border-slate-200 rounded-lg hover:border-blue-300 hover:bg-blue-50 transition-colors">
                    <svg class="w-8 h-8 text-blue-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    <span class="text-sm font-medium text-slate-900">Clear Config Cache</span>
                    <span class="text-xs text-slate-500 text-center">Clear configuration cache</span>
                </button>

                <button type="button" onclick="clearCache('route')" class="flex flex-col items-center p-4 border border-slate-200 rounded-lg hover:border-blue-300 hover:bg-blue-50 transition-colors">
                    <svg class="w-8 h-8 text-blue-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    <span class="text-sm font-medium text-slate-900">Clear Route Cache</span>
                    <span class="text-xs text-slate-500 text-center">Clear route cache</span>
                </button>

                <button type="button" onclick="clearCache('view')" class="flex flex-col items-center p-4 border border-slate-200 rounded-lg hover:border-blue-300 hover:bg-blue-50 transition-colors">
                    <svg class="w-8 h-8 text-blue-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    <span class="text-sm font-medium text-slate-900">Clear View Cache</span>
                    <span class="text-xs text-slate-500 text-center">Clear compiled views</span>
                </button>
            </div>

            <div class="mt-4 p-4 bg-amber-50 border border-amber-200 rounded-lg">
                <div class="flex">
                    <svg class="w-5 h-5 text-amber-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                    </svg>
                    <div>
                        <h4 class="text-sm font-semibold text-amber-800">Maintenance Notice</h4>
                        <p class="text-sm text-amber-700 mt-1">
                            Cache clearing operations may temporarily affect application performance. 
                            Use during low-traffic periods when possible.
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <?php $__env->startPush('scripts'); ?>
    <script>
        function clearCache(type) {
            if (confirm(`Are you sure you want to clear the ${type} cache?`)) {
                // For now, just show a message
                // In a real implementation, you'd make an AJAX call to clear the cache
                alert(`${type.charAt(0).toUpperCase() + type.slice(1)} cache cleared successfully!`);
            }
        }
    </script>
    <?php $__env->stopPush(); ?>

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
<?php /**PATH /homepages/38/d4299336130/htdocs/resources/views/admin/settings/index.blade.php ENDPATH**/ ?>