<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['menuItems']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['menuItems']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div class="w-64 bg-white/95 backdrop-blur-lg rounded-2xl shadow-2xl border border-gray-200 p-6 h-fit">
    <div class="mb-6">
        <h3 class="text-lg font-bold text-gray-900 mb-2 flex items-center">
            <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
            Navigation
        </h3>
        <div class="w-full h-1 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full"></div>
    </div>

    <?php if(isset($menuItems) && $menuItems->count() > 0): ?>
        <nav class="space-y-2">
            <?php $__currentLoopData = $menuItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menuItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e($menuItem->url); ?>" 
                   class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-lg <?php echo e(request()->is(ltrim($menuItem->url, '/')) ? 'bg-gradient-to-r from-blue-500 to-purple-600 text-white shadow-lg' : 'text-gray-700 hover:bg-gradient-to-r hover:from-gray-100 hover:to-gray-200'); ?>"
                   <?php if($menuItem->opens_in_new_tab): ?> target="_blank" <?php endif; ?>>
                    
                    <?php if($menuItem->icon === 'home'): ?>
                        <svg class="w-5 h-5 mr-3 <?php echo e(request()->is(ltrim($menuItem->url, '/')) ? 'text-white' : 'text-blue-500 group-hover:text-blue-600'); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                    <?php elseif($menuItem->icon === 'book'): ?>
                        <svg class="w-5 h-5 mr-3 <?php echo e(request()->is(ltrim($menuItem->url, '/')) ? 'text-white' : 'text-green-500 group-hover:text-green-600'); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    <?php elseif($menuItem->icon === 'info'): ?>
                        <svg class="w-5 h-5 mr-3 <?php echo e(request()->is(ltrim($menuItem->url, '/')) ? 'text-white' : 'text-yellow-500 group-hover:text-yellow-600'); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    <?php elseif($menuItem->icon === 'user'): ?>
                        <svg class="w-5 h-5 mr-3 <?php echo e(request()->is(ltrim($menuItem->url, '/')) ? 'text-white' : 'text-purple-500 group-hover:text-purple-600'); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    <?php elseif($menuItem->icon === 'settings'): ?>
                        <svg class="w-5 h-5 mr-3 <?php echo e(request()->is(ltrim($menuItem->url, '/')) ? 'text-white' : 'text-gray-500 group-hover:text-gray-600'); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    <?php elseif($menuItem->icon === 'mail'): ?>
                        <svg class="w-5 h-5 mr-3 <?php echo e(request()->is(ltrim($menuItem->url, '/')) ? 'text-white' : 'text-red-500 group-hover:text-red-600'); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    <?php else: ?>
                        <svg class="w-5 h-5 mr-3 <?php echo e(request()->is(ltrim($menuItem->url, '/')) ? 'text-white' : 'text-gray-500 group-hover:text-gray-600'); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    <?php endif; ?>
                    
                    <span class="flex-1"><?php echo e($menuItem->title); ?></span>
                    
                    <?php if($menuItem->opens_in_new_tab): ?>
                        <svg class="w-4 h-4 <?php echo e(request()->is(ltrim($menuItem->url, '/')) ? 'text-white' : 'text-gray-400'); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                    <?php endif; ?>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </nav>
    <?php else: ?>
        <div class="text-center py-8">
            <svg class="w-12 h-12 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            <p class="text-gray-500 text-sm">No menu items available</p>
            <p class="text-gray-400 text-xs mt-1">Contact admin to add navigation items</p>
        </div>
    <?php endif; ?>

    <!-- Profile Quick Actions -->
    <div class="mt-8 pt-6 border-t border-gray-200">
        <h4 class="text-sm font-semibold text-gray-700 mb-3">Quick Actions</h4>
        <div class="space-y-2">
            <a href="<?php echo e(route('profile.edit')); ?>" 
               class="flex items-center px-3 py-2 text-sm text-gray-600 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                Profile Settings
            </a>
            <a href="<?php echo e(route('profile.favorites')); ?>" 
               class="flex items-center px-3 py-2 text-sm text-gray-600 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                </svg>
                My Favorites
            </a>
            <a href="<?php echo e(route('profile.completed')); ?>" 
               class="flex items-center px-3 py-2 text-sm text-gray-600 hover:text-green-600 hover:bg-green-50 rounded-lg transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Completed Topics
            </a>
        </div>
    </div>
</div>
<?php /**PATH /homepages/38/d4299336130/htdocs/nephroapp/resources/views/components/profile-sidebar.blade.php ENDPATH**/ ?>