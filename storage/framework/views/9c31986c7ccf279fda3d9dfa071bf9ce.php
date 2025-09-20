

<!-- Navigation Tabs -->
<div class="mb-8">
    <nav class="flex space-x-8">
        <a href="<?php echo e(route('profile.edit')); ?>" 
           class="text-gray-500 hover:text-gray-700 px-3 py-2 font-medium text-sm rounded-md">
            Profile Settings
        </a>
        <a href="<?php echo e(route('profile.favorites')); ?>" 
           class="bg-red-100 text-red-800 px-3 py-2 font-medium text-sm rounded-md">
            Favorites (<?php echo e($stats['favorites_count']); ?>)
        </a>
        <a href="<?php echo e(route('profile.completed')); ?>" 
           class="text-gray-500 hover:text-gray-700 px-3 py-2 font-medium text-sm rounded-md">
            Completed (<?php echo e($stats['completed_count']); ?>)
        </a>
    </nav>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">
                            Favorite Topics
                        </dt>
                        <dd class="text-lg font-medium text-gray-900">
                            <?php echo e($stats['favorites_count']); ?>

                        </dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">
                            Completed Topics
                        </dt>
                        <dd class="text-lg font-medium text-gray-900">
                            <?php echo e($stats['completed_count']); ?>

                        </dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Favorites Grid -->
<?php if($favorites->count() > 0): ?>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-6">Your Favorite Topics</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php $__currentLoopData = $favorites; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $topic): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="border border-gray-200 rounded-lg hover:shadow-md transition-shadow duration-200">
                        <div class="p-6">
                            <!-- Category Badge -->
                            <?php if($topic->category): ?>
                                <div class="mb-3">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        <?php echo e($topic->category->name); ?>

                                    </span>
                                </div>
                            <?php endif; ?>

                            <!-- Title -->
                            <h4 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2">
                                <a href="<?php echo e(route('topics.show', $topic)); ?>" class="hover:text-blue-600">
                                    <?php echo e($topic->title); ?>

                                </a>
                            </h4>

                            <!-- Summary -->
                            <?php if($topic->summary): ?>
                                <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                                    <?php echo e($topic->summary); ?>

                                </p>
                            <?php endif; ?>

                            <!-- Footer with Actions -->
                            <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                                <div class="flex items-center text-sm text-gray-500">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <?php echo e($topic->reading_time ?? '5'); ?> min read
                                </div>
                                
                                <div class="flex items-center space-x-2">
                                    <!-- Remove from Favorites -->
                                    <button 
                                        onclick="toggleFavorite(<?php echo e($topic->id); ?>)"
                                        class="text-red-600 hover:text-red-800 transition-colors duration-200"
                                        title="Remove from favorites"
                                    >
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                        </svg>
                                    </button>

                                    <!-- Mark as Completed -->
                                    <button 
                                        onclick="toggleCompleted(<?php echo e($topic->id); ?>)"
                                        class="text-green-600 hover:text-green-800 transition-colors duration-200"
                                        title="Mark as completed"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                <?php echo e($favorites->links()); ?>

            </div>
        </div>
    </div>
<?php else: ?>
    <!-- Empty State -->
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-12 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">No favorites yet</h3>
            <p class="mt-1 text-sm text-gray-500">
                Start by adding some topics to your favorites.
            </p>
            <div class="mt-6">
                <a href="<?php echo e(route('topics.index')); ?>" 
                   class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700">
                    Browse Topics
                </a>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php /**PATH /homepages/38/d4299336130/htdocs/nephroapp/resources/views/profile/partials/favorites-content.blade.php ENDPATH**/ ?>