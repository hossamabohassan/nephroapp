
<ul class="space-y-2">
    <li>
        <a href="<?php echo e(route('profile.edit')); ?>" 
           class="flex items-center p-3 rounded-lg <?php echo e(request()->routeIs('profile.edit') ? 'bg-gray-700 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white'); ?> transition-colors duration-200">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
            <span>Profile Settings</span>
        </a>
    </li>
    
    <li>
        <a href="<?php echo e(route('profile.favorites')); ?>" 
           class="flex items-center p-3 rounded-lg <?php echo e(request()->routeIs('profile.favorites') ? 'bg-gray-700 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white'); ?> transition-colors duration-200">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
            </svg>
            <span>Favorites</span>
            <span class="ml-auto bg-red-500 text-white text-xs rounded-full px-2 py-1"><?php echo e($stats['favorites_count']); ?></span>
        </a>
    </li>
    
    <li>
        <a href="<?php echo e(route('profile.completed')); ?>" 
           class="flex items-center p-3 rounded-lg <?php echo e(request()->routeIs('profile.completed') ? 'bg-gray-700 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white'); ?> transition-colors duration-200">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>Completed</span>
            <span class="ml-auto bg-green-500 text-white text-xs rounded-full px-2 py-1"><?php echo e($stats['completed_count']); ?></span>
        </a>
    </li>
    
    <li>
        <a href="<?php echo e(route('topics.index')); ?>" 
           class="flex items-center p-3 rounded-lg text-gray-300 hover:bg-gray-700 hover:text-white transition-colors duration-200">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C20.832 18.477 19.246 18 17.5 18c-1.746 0-3.332.477-4.5 1.253"/>
            </svg>
            <span>Browse Topics</span>
        </a>
    </li>
</ul>

<div class="mt-8 pt-8 border-t border-gray-700">
    <div class="p-3">
        <h4 class="text-sm font-medium text-gray-400 uppercase tracking-wider mb-3">Quick Stats</h4>
        <div class="space-y-2">
            <div class="flex justify-between text-sm">
                <span class="text-gray-300">Favorites:</span>
                <span class="text-white font-medium"><?php echo e($stats['favorites_count']); ?></span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-gray-300">Completed:</span>
                <span class="text-white font-medium"><?php echo e($stats['completed_count']); ?></span>
            </div>
        </div>
    </div>
</div>
<?php /**PATH /homepages/38/d4299336130/htdocs/nephroapp/resources/views/profile/partials/sidebar-nav.blade.php ENDPATH**/ ?>