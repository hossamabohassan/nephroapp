<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <!-- Modern Admin Dashboard Layout -->
    <div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100">
        
        <!-- Top Navigation Bar -->
        <nav class="sticky top-0 z-50 backdrop-blur-xl bg-white/80 border-b border-slate-200/60 shadow-sm">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    
                    <!-- Logo Section -->
                    <div class="flex items-center space-x-4">
                        <a href="<?php echo e(route('topics.index')); ?>" class="flex items-center space-x-3 group">
                            <div class="relative">
                                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 via-purple-500 to-pink-500 rounded-xl flex items-center justify-center shadow-lg">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                    </svg>
                                </div>
                                <div class="absolute -top-1 -right-1 w-4 h-4 bg-green-400 rounded-full border-2 border-white"></div>
                            </div>
                            <div>
                                <h1 class="text-xl font-bold bg-gradient-to-r from-slate-900 to-slate-600 bg-clip-text text-transparent group-hover:from-blue-600 group-hover:to-purple-600 transition-all duration-200">
                                    <?php echo e(config('app.name', 'NephroCoach')); ?>

                                </h1>
                                <p class="text-xs text-slate-500 font-medium"><?php echo e(content('site_tagline', 'Expert Medical Training Platform')); ?></p>
                            </div>
                        </a>
                    </div>

                    <!-- Search Bar (Desktop) -->
                    <div class="hidden md:flex flex-1 max-w-lg mx-8">
                        <div class="relative w-full">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <input 
                                type="search" 
                                id="global-search"
                                class="block w-full pl-10 pr-3 py-2.5 border border-slate-300 rounded-xl leading-5 bg-white placeholder-slate-400 focus:outline-none focus:placeholder-slate-500 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200" 
                                placeholder="<?php echo e(content('topics_search_placeholder', 'Search topics, categories...')); ?>"
                                value="<?php echo e(request('q')); ?>"
                            >
                        </div>
                    </div>

                    <!-- Right Section -->
                    <div class="flex items-center space-x-4">
                        
                        <?php $__currentLoopData = $navigationHeaderButtons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $headerButton): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($headerButton->type === 'button'): ?>
                                <a href="<?php echo e($headerButton->resolved_url); ?>" 
                                   target="<?php echo e($headerButton->target); ?>"
                                   class="relative p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-lg transition-colors duration-200 <?php echo e($headerButton->css_class); ?>"
                                   title="<?php echo e($headerButton->title); ?>">
                                    <?php echo $headerButton->icon_html; ?>

                                    <?php if($headerButton->show_badge): ?>
                                        <span class="absolute top-1 right-1 block h-2 w-2 rounded-full <?php echo e($headerButton->badge_color_class); ?>"></span>
                                    <?php endif; ?>
                                </a>
                            <?php elseif($headerButton->type === 'dropdown'): ?>
                                <div class="relative" x-data="{ open: false }">
                                    <button @click="open = !open" class="relative p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-lg transition-colors duration-200 <?php echo e($headerButton->css_class); ?>" title="<?php echo e($headerButton->title); ?>">
                                        <?php echo $headerButton->icon_html; ?>

                                        <?php if($headerButton->show_badge): ?>
                                            <span class="absolute top-1 right-1 block h-2 w-2 rounded-full <?php echo e($headerButton->badge_color_class); ?>"></span>
                                        <?php endif; ?>
                                    </button>
                                    <!-- Dropdown content would go here -->
                                </div>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        <!-- User Profile Dropdown -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-slate-100 transition-colors duration-200">
                                <div class="relative">
                                    <img class="h-8 w-8 rounded-full ring-2 ring-white shadow-lg" src="https://ui-avatars.com/api/?name=<?php echo e(auth()->user()->name ?? 'User'); ?>&background=6366f1&color=ffffff" alt="Profile">
                                    <div class="absolute -bottom-0.5 -right-0.5 h-3 w-3 bg-green-400 border-2 border-white rounded-full"></div>
                                </div>
                                <div class="hidden md:block text-left">
                                    <p class="text-sm font-medium text-slate-900"><?php echo e(auth()->user()->name ?? 'Admin User'); ?></p>
                                    <p class="text-xs text-slate-500"><?php echo e(auth()->user()->email ?? 'admin@example.com'); ?></p>
                                </div>
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>

                            <!-- Dropdown Menu -->
                            <div x-show="open" 
                                 x-transition:enter="transition ease-out duration-100"
                                 x-transition:enter-start="transform opacity-0 scale-95"
                                 x-transition:enter-end="transform opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="transform opacity-100 scale-100"
                                 x-transition:leave-end="transform opacity-0 scale-95"
                                 @click.outside="open = false"
                                 class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-slate-200 py-1 z-50">
                                
                                <?php $__currentLoopData = $navigationMenuItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menuItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <a href="<?php echo e($menuItem->resolved_url); ?>" 
                                       target="<?php echo e($menuItem->target); ?>"
                                       class="flex items-center px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 <?php echo e($menuItem->css_class); ?>">
                                        <div class="w-4 h-4 mr-3 text-slate-400">
                                            <?php echo $menuItem->icon_html; ?>

                                        </div>
                                        <?php echo e($menuItem->title); ?>

                                    </a>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                
                                <div class="border-t border-slate-100 my-1"></div>
                                
                                <form method="POST" action="<?php echo e(route('logout')); ?>">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="flex items-center w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                        </svg>
                                        Sign out
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Welcome Hero Section -->
        <div class="bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 relative overflow-hidden">
            <div class="absolute inset-0 bg-black/20"></div>
            <div class="absolute inset-0">
                <div class="absolute top-0 left-0 w-72 h-72 bg-white/10 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob"></div>
                <div class="absolute top-0 right-0 w-72 h-72 bg-purple-300/10 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000"></div>
                <div class="absolute -bottom-8 left-20 w-72 h-72 bg-pink-300/10 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-4000"></div>
            </div>
            
            <div class="relative mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h1 class="text-4xl md:text-6xl font-bold text-white mb-6">
                        <?php echo e(content('hero_title', 'Master Clinical Nephrology with Expert-Crafted Scenarios')); ?>

                    </h1>
                    <p class="text-xl text-blue-100 mb-8 max-w-3xl mx-auto leading-relaxed">
                        <?php echo e(content('hero_subtitle', 'Dive deep into real-world nephrology cases with interactive scenarios designed by leading experts. Perfect your clinical reasoning and diagnostic skills.')); ?>

                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <button class="inline-flex items-center px-8 py-4 bg-white text-blue-600 font-semibold rounded-xl hover:bg-blue-50 transform hover:scale-105 transition-all duration-200 shadow-lg">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                            <?php echo e(content('hero_cta_primary', 'Get Started')); ?>

                        </button>
                        <button class="inline-flex items-center px-8 py-4 bg-transparent border-2 border-white text-white font-semibold rounded-xl hover:bg-white hover:text-blue-600 transform hover:scale-105 transition-all duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                            </svg>
                            <?php echo e(content('hero_cta_secondary', 'View Topics')); ?>

                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
            

            <!-- Filters and Tools Section -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-8">

                <!-- Enhanced Filters -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
                    
                    <!-- Search Filter -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2"><?php echo e(content('topics_search_label', 'Search Topics')); ?></label>
                        <div class="relative">
                            <input type="text" 
                                   id="topic-search" 
                                   class="w-full pl-10 pr-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200" 
                                   placeholder="<?php echo e(content('topics_search_filter_placeholder', 'Search by title, content...')); ?>"
                                   value="<?php echo e(request('q')); ?>">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center">
                                <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Category Filter -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2"><?php echo e(content('topics_category_label', 'Category')); ?></label>
                        <select id="category-filter" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                            <option value=""><?php echo e(content('topics_all_categories_option', 'All Categories')); ?></option>
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($category->name); ?>"><?php echo e($category->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <!-- Status Filter -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Status</label>
                        <select id="status-filter" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                            <option value="">All Topics</option>
                            <option value="favorites">⭐ Favorites</option>
                            <option value="completed">✅ Completed</option>
                            <option value="in-progress">🔄 In Progress</option>
                            <option value="not-started">📋 Not Started</option>
                        </select>
                    </div>


                </div>

                <!-- Quick Filter Tags -->
                <div class="flex flex-wrap gap-2 mb-4">
                    <button class="filter-tag active" data-filter="all">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-blue-100 text-blue-800 border border-blue-200">
                            📚 All Topics
                        </span>
                    </button>
                    <button class="filter-tag" data-filter="favorites">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-red-100 text-red-800 border border-red-200">
                            ⭐ My Favorites
                        </span>
                    </button>
                    <button class="filter-tag" data-filter="completed">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-green-100 text-green-800 border border-green-200">
                            ✅ Completed
                        </span>
                    </button>
                    <button class="filter-tag" data-filter="in-progress">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-yellow-100 text-yellow-800 border border-yellow-200">
                            🔄 In Progress
                        </span>
                    </button>
                    <button class="filter-tag" data-filter="recent">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-purple-100 text-purple-800 border border-purple-200">
                            🕒 Recent
                        </span>
                    </button>
                </div>

            </div>

            <!-- Search Results Message -->
            <div id="search-results-message" class="hidden bg-blue-50 border border-blue-200 rounded-xl p-4 mb-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <div>
                            <h3 class="text-sm font-semibold text-blue-900">Search Results</h3>
                            <p class="text-sm text-blue-700" id="search-results-text">Showing results for your search</p>
                        </div>
                    </div>
                    <button id="clear-search-message" class="text-blue-400 hover:text-blue-600 transition-colors duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Topics Grid -->
            <div id="topics-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                <?php $__empty_1 = true; $__currentLoopData = $topics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $topic): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="topic-card bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden hover:shadow-lg transform hover:-translate-y-1 transition-all duration-300" 
                         data-category="<?php echo e($topic->category->name ?? 'Uncategorized'); ?>"
                         data-title="<?php echo e(strtolower($topic->title)); ?>"
                         data-date="<?php echo e($topic->published_at?->format('Y-m-d')); ?>">
                        
                        <!-- Card Header -->
                        <div class="p-6 pb-4">
                            <div class="flex items-center justify-between mb-4">
                                <?php if($topic->category): ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        <?php echo e($topic->category->name); ?>

                                    </span>
                                <?php endif; ?>
                                <?php if(auth()->guard()->check()): ?>
                                <div class="flex items-center space-x-2">
                                    <!-- Favorite Button -->
                                    <button 
                                        class="favorite-btn p-1 transition-all duration-300 ease-in-out"
                                        data-topic-id="<?php echo e($topic->id); ?>"
                                        data-favorited="false"
                                        title="Add to favorites"
                                    >
                                        <svg class="w-5 h-5 favorite-icon heart-outline" viewBox="0 0 24 24">
                                            <defs>
                                                <filter id="outlineShadow" x="-50%" y="-50%" width="200%" height="200%">
                                                    <feDropShadow dx="0" dy="1" stdDeviation="2" flood-color="#64748b" flood-opacity="0.3"/>
                                                </filter>
                                            </defs>
                                            <path fill="none" stroke="#64748b" stroke-width="2" filter="url(#outlineShadow)" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                        </svg>
                                    </button>
                                    <!-- Completed Button -->
                                    <button 
                                        class="completed-btn p-1 transition-all duration-300 ease-in-out"
                                        data-topic-id="<?php echo e($topic->id); ?>"
                                        data-completed="false"
                                        title="Mark as completed"
                                    >
                                        <svg class="w-5 h-5 completed-icon check-outline" viewBox="0 0 24 24">
                                            <defs>
                                                <filter id="checkOutlineShadow" x="-50%" y="-50%" width="200%" height="200%">
                                                    <feDropShadow dx="0" dy="1" stdDeviation="2" flood-color="#64748b" flood-opacity="0.3"/>
                                                </filter>
                                            </defs>
                                            <!-- Background circle outline -->
                                            <circle cx="12" cy="12" r="10" fill="none" stroke="#64748b" stroke-width="2" filter="url(#checkOutlineShadow)"/>
                                            <!-- Elegant checkmark outline -->
                                            <path fill="none" stroke="#64748b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M8 12l2.5 2.5L16 9" filter="url(#checkOutlineShadow)"/>
                                        </svg>
                                    </button>
                                </div>
                                <?php endif; ?>
                            </div>
                            
                            <h3 class="text-lg font-semibold text-slate-900 mb-2">
                                <a href="<?php echo e(route('topics.show', $topic)); ?>" class="hover:text-blue-600 transition-colors duration-200">
                                    <?php echo e($topic->title); ?>

                                </a>
                            </h3>
                            
                        </div>

                        <!-- Card Footer -->
                        <div class="px-6 py-4 bg-slate-50 border-t border-slate-100">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center text-xs text-slate-500">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <?php echo e($topic->published_at?->diffForHumans() ?? 'Draft'); ?>

                                </div>
                                <a href="<?php echo e(route('topics.show', $topic)); ?>" class="inline-flex items-center justify-center w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 text-white rounded-full hover:from-blue-600 hover:to-purple-700 transition-all duration-300 hover:scale-110 shadow-lg hover:shadow-xl" title="View Topic">
                                    <svg class="w-5 h-5 book-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="col-span-full">
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <h3 class="mt-4 text-lg font-medium text-slate-900"><?php echo e(content('topics_no_results_title', 'No topics found')); ?></h3>
                            <p class="mt-2 text-slate-500"><?php echo e(content('topics_no_results_description', 'Get started by creating your first topic.')); ?></p>
                            <button class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                Create Topic
                            </button>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Results Count -->
            <?php if($topics->count() > 0): ?>
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 px-6 py-4">
                    <div class="flex items-center justify-center">
                        <div class="text-sm text-slate-700">
                            Showing <?php echo e($topics->count()); ?> topics
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php $__env->startPush('scripts'); ?>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            
            // Auto-scroll to Topics Grid if there's a search query parameter
            const urlParams = new URLSearchParams(window.location.search);
            const searchQuery = urlParams.get('q');
            if (searchQuery) {
                // Show search results message
                showSearchResultsMessage(`Search results for "${searchQuery}"`);
                
                // Wait for the page to fully load and then scroll to topics grid
                setTimeout(() => {
                    const topicsGrid = document.getElementById('topics-grid');
                    if (topicsGrid) {
                        topicsGrid.scrollIntoView({ 
                            behavior: 'smooth', 
                            block: 'start',
                            inline: 'nearest'
                        });
                    }
                }, 500); // Small delay to ensure page is fully rendered
            }
            
            // Enhanced Search and Filter Functionality
            const searchInput = document.getElementById('topic-search');
            const categoryFilter = document.getElementById('category-filter');
            const statusFilter = document.getElementById('status-filter');
            const topicCards = document.querySelectorAll('.topic-card');
            const filterTags = document.querySelectorAll('.filter-tag');
            
            // Get CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            
            // Initialize all favorite buttons
            initializeFavoriteButtons();
            
            // Initialize all completed buttons
            initializeCompletedButtons();
            
            // Real-time search
            searchInput.addEventListener('input', function() {
                filterTopics();
                
                const searchTerm = this.value.trim();
                if (searchTerm.length > 0) {
                    // Show search results message
                    showSearchResultsMessage(`Search results for "${searchTerm}"`);
                    
                    // Scroll to topics grid when user starts typing
                    setTimeout(() => {
                        const topicsGrid = document.getElementById('topics-grid');
                        if (topicsGrid) {
                            topicsGrid.scrollIntoView({ 
                                behavior: 'smooth', 
                                block: 'start',
                                inline: 'nearest'
                            });
                        }
                    }, 100); // Small delay to allow filtering to complete
                } else {
                    // Hide search results message when search is cleared
                    hideSearchResultsMessage();
                }
            });
            
            // Category filter
            categoryFilter.addEventListener('change', function() {
                filterTopics();
            });
            
            // Status filter
            statusFilter.addEventListener('change', function() {
                filterTopics();
            });
            
            // Quick filter tags
            filterTags.forEach(tag => {
                tag.addEventListener('click', function() {
                    // Remove active class from all tags
                    filterTags.forEach(t => t.classList.remove('active'));
                    // Add active class to clicked tag
                    this.classList.add('active');
                    
                    const filterType = this.dataset.filter;
                    const filterText = this.querySelector('span').textContent.trim();
                    applyQuickFilter(filterType);
                    
                    // Show filter results message
                    if (filterType !== 'all') {
                        showSearchResultsMessage(`Showing ${filterText}`);
                    } else {
                        hideSearchResultsMessage();
                    }
                    
                    // Scroll to topics grid when applying filters
                    setTimeout(() => {
                        const topicsGrid = document.getElementById('topics-grid');
                        if (topicsGrid) {
                            topicsGrid.scrollIntoView({ 
                                behavior: 'smooth', 
                                block: 'start',
                                inline: 'nearest'
                            });
                        }
                    }, 100);
                });
            });
            
            function filterTopics() {
                const searchTerm = searchInput.value.toLowerCase();
                const selectedCategory = categoryFilter.value;
                const selectedStatus = statusFilter.value;
                
                // Add loading animation
                topicCards.forEach(card => {
                    card.style.opacity = '0.5';
                    card.style.transform = 'scale(0.95)';
                });
                
                setTimeout(() => {
                    topicCards.forEach((card, index) => {
                        const title = card.dataset.title;
                        const category = card.dataset.category;
                        
                        const matchesSearch = !searchTerm || title.includes(searchTerm);
                        const matchesCategory = !selectedCategory || category === selectedCategory;
                        const matchesStatus = !selectedStatus || checkStatusMatch(card, selectedStatus);
                        
                        if (matchesSearch && matchesCategory && matchesStatus) {
                            card.style.display = 'block';
                            card.classList.remove('hidden');
                            // Re-animate visible cards
                            card.style.opacity = '0';
                            card.style.transform = 'translateY(30px)';
                            card.style.animation = 'none';
                            
                            setTimeout(() => {
                                card.style.animation = `slideInUp 0.6s ease-out forwards`;
                                card.style.animationDelay = `${index * 0.1}s`;
                            }, 50);
                        } else {
                            card.style.display = 'none';
                            card.classList.add('hidden');
                        }
                    });
                    
                    updateResultsCount();
                }, 200);
            }
            
            function checkStatusMatch(card, status) {
                // This would need to be implemented based on your data structure
                // For now, we'll use placeholder logic
                switch(status) {
                    case 'favorites':
                        return card.querySelector('.favorite-btn[data-favorited="true"]') !== null;
                    case 'completed':
                        return card.querySelector('.completed-btn[data-completed="true"]') !== null;
                    case 'in-progress':
                        return card.querySelector('.completed-btn[data-completed="false"]') !== null && 
                               card.querySelector('.favorite-btn[data-favorited="true"]') !== null;
                    case 'not-started':
                        return card.querySelector('.completed-btn[data-completed="false"]') !== null && 
                               card.querySelector('.favorite-btn[data-favorited="false"]') !== null;
                    default:
                        return true;
                }
            }
            
            
            function applyQuickFilter(filterType) {
                // Reset all filters
                searchInput.value = '';
                categoryFilter.value = '';
                statusFilter.value = '';
                
                // Apply quick filter
                switch(filterType) {
                    case 'favorites':
                        statusFilter.value = 'favorites';
                        break;
                    case 'completed':
                        statusFilter.value = 'completed';
                        break;
                    case 'in-progress':
                        statusFilter.value = 'in-progress';
                        break;
                    case 'recent':
                        // For recent, we'll just show all topics (could be enhanced with date filtering)
                        break;
                    case 'all':
                    default:
                        // No specific filter
                        break;
                }
                
                filterTopics();
            }
            
            
            function updateResultsCount() {
                const visibleCards = document.querySelectorAll('.topic-card:not(.hidden)').length;
                // Update any result count displays if needed
            }
            
            // Global search functionality
            const globalSearch = document.getElementById('global-search');
            globalSearch.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    window.location.href = `<?php echo e(route('topics.index')); ?>?q=${encodeURIComponent(this.value)}`;
                }
            });
            
            // Smooth animations
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, observerOptions);
            
            topicCards.forEach(card => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                observer.observe(card);
            });
            
            // Favorite functionality for topics index page
            function initializeFavoriteButtons() {
                const favoriteButtons = document.querySelectorAll('.favorite-btn');
                favoriteButtons.forEach(button => {
                    const topicId = button.dataset.topicId;
                    if (topicId) {
                        // Load initial state
                        loadTopicFavoriteStatus(button, topicId);
                        
                        // Add click handler
                        button.addEventListener('click', function(e) {
                            e.preventDefault();
                            e.stopPropagation();
                            toggleTopicFavorite(button, topicId);
                        });
                    }
                });
            }
            
            async function loadTopicFavoriteStatus(button, topicId) {
                try {
                    const response = await fetch(`/api/user/topics/${topicId}/status`, {
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        }
                    });

                    if (response.ok) {
                        const data = await response.json();
                        updateFavoriteButtonState(button, data.favorited);
                    }
                } catch (error) {
                    console.error('Error loading favorite status for topic', topicId, ':', error);
                }
            }
            
            async function toggleTopicFavorite(button, topicId) {
                const originalContent = button.innerHTML;
                const originalClass = button.className;
                
                // Show loading state
                button.disabled = true;
                button.innerHTML = '<svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>';

                try {
                    const response = await fetch(`/api/user/topics/${topicId}/favorite`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        }
                    });

                    if (response.ok) {
                        const data = await response.json();
                        updateFavoriteButtonState(button, data.favorited);
                        showTopicsNotification(data.message, 'success');
                    } else {
                        throw new Error('Failed to toggle favorite');
                    }
                } catch (error) {
                    console.error('Error toggling favorite for topic', topicId, ':', error);
                    button.innerHTML = originalContent;
                    button.className = originalClass;
                    button.disabled = false;
                    showTopicsNotification('Failed to update favorite status', 'error');
                }
            }
            
            function updateFavoriteButtonState(button, favorited) {
                button.setAttribute('data-favorited', favorited);
                
                // Completely rebuild the button content with the enhanced heart icon
                if (favorited) {
                    button.className = 'favorite-btn p-1 transition-all duration-300 ease-in-out';
                    button.title = 'Remove from favorites';
                    button.innerHTML = `
                        <svg class="w-5 h-5 favorite-icon heart-filled" viewBox="0 0 24 24">
                            <defs>
                                <linearGradient id="heartGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" style="stop-color:#ff6b6b;stop-opacity:1" />
                                    <stop offset="50%" style="stop-color:#ee5a52;stop-opacity:1" />
                                    <stop offset="100%" style="stop-color:#e74c3c;stop-opacity:1" />
                                </linearGradient>
                                <filter id="heartShadow" x="-50%" y="-50%" width="200%" height="200%">
                                    <feDropShadow dx="0" dy="2" stdDeviation="3" flood-color="#e74c3c" flood-opacity="0.4"/>
                                    <feDropShadow dx="0" dy="1" stdDeviation="1" flood-color="#c0392b" flood-opacity="0.6"/>
                                </filter>
                            </defs>
                            <path fill="url(#heartGradient)" filter="url(#heartShadow)" stroke="#c0392b" stroke-width="0.5" d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                        </svg>
                    `;
                } else {
                    button.className = 'favorite-btn p-1 transition-all duration-300 ease-in-out';
                    button.title = 'Add to favorites';
                    button.innerHTML = `
                        <svg class="w-5 h-5 favorite-icon heart-outline" viewBox="0 0 24 24">
                            <defs>
                                <filter id="outlineShadow" x="-50%" y="-50%" width="200%" height="200%">
                                    <feDropShadow dx="0" dy="1" stdDeviation="2" flood-color="#64748b" flood-opacity="0.3"/>
                                </filter>
                            </defs>
                            <path fill="none" stroke="#64748b" stroke-width="2" filter="url(#outlineShadow)" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    `;
                }
                
                button.disabled = false;
            }
            
            // Completed functionality for topics index page
            function initializeCompletedButtons() {
                const completedButtons = document.querySelectorAll('.completed-btn');
                completedButtons.forEach(button => {
                    const topicId = button.dataset.topicId;
                    if (topicId) {
                        // Load initial state
                        loadTopicCompletedStatus(button, topicId);
                        
                        // Add click handler
                        button.addEventListener('click', function(e) {
                            e.preventDefault();
                            e.stopPropagation();
                            toggleTopicCompleted(button, topicId);
                        });
                    }
                });
            }
            
            async function loadTopicCompletedStatus(button, topicId) {
                try {
                    const response = await fetch(`/api/user/topics/${topicId}/status`, {
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        }
                    });

                    if (response.ok) {
                        const data = await response.json();
                        updateCompletedButtonState(button, data.completed);
                    }
                } catch (error) {
                    console.error('Error loading completed status for topic', topicId, ':', error);
                }
            }
            
            async function toggleTopicCompleted(button, topicId) {
                const originalContent = button.innerHTML;
                const originalClass = button.className;
                
                // Show loading state
                button.disabled = true;
                button.innerHTML = '<svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>';

                try {
                    const response = await fetch(`/api/user/topics/${topicId}/completed`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        }
                    });

                    if (response.ok) {
                        const data = await response.json();
                        updateCompletedButtonState(button, data.completed);
                        showTopicsNotification(data.message, 'success');
                    } else {
                        throw new Error('Failed to toggle completed');
                    }
                } catch (error) {
                    console.error('Error toggling completed for topic', topicId, ':', error);
                    button.innerHTML = originalContent;
                    button.className = originalClass;
                    button.disabled = false;
                    showTopicsNotification('Failed to update completed status', 'error');
                }
            }
            
            function updateCompletedButtonState(button, completed) {
                button.setAttribute('data-completed', completed);
                
                // Completely rebuild the button content with the enhanced checkmark icon
                if (completed) {
                    button.className = 'completed-btn p-1 transition-all duration-300 ease-in-out';
                    button.title = 'Mark as incomplete';
                    button.innerHTML = `
                        <svg class="w-5 h-5 completed-icon check-filled" viewBox="0 0 24 24">
                            <defs>
                                <linearGradient id="checkGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" style="stop-color:#10b981;stop-opacity:1" />
                                    <stop offset="50%" style="stop-color:#059669;stop-opacity:1" />
                                    <stop offset="100%" style="stop-color:#047857;stop-opacity:1" />
                                </linearGradient>
                                <filter id="checkShadow" x="-50%" y="-50%" width="200%" height="200%">
                                    <feDropShadow dx="0" dy="2" stdDeviation="3" flood-color="#10b981" flood-opacity="0.4"/>
                                    <feDropShadow dx="0" dy="1" stdDeviation="1" flood-color="#047857" flood-opacity="0.6"/>
                                </filter>
                            </defs>
                            <!-- Background circle -->
                            <circle cx="12" cy="12" r="10" fill="url(#checkGradient)" filter="url(#checkShadow)" stroke="#047857" stroke-width="0.5"/>
                            <!-- Elegant checkmark -->
                            <path fill="none" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" d="M8 12l2.5 2.5L16 9" filter="url(#checkShadow)"/>
                        </svg>
                    `;
                } else {
                    button.className = 'completed-btn p-1 transition-all duration-300 ease-in-out';
                    button.title = 'Mark as completed';
                    button.innerHTML = `
                        <svg class="w-5 h-5 completed-icon check-outline" viewBox="0 0 24 24">
                            <defs>
                                <filter id="checkOutlineShadow" x="-50%" y="-50%" width="200%" height="200%">
                                    <feDropShadow dx="0" dy="1" stdDeviation="2" flood-color="#64748b" flood-opacity="0.3"/>
                                </filter>
                            </defs>
                            <!-- Background circle outline -->
                            <circle cx="12" cy="12" r="10" fill="none" stroke="#64748b" stroke-width="2" filter="url(#checkOutlineShadow)"/>
                            <!-- Elegant checkmark outline -->
                            <path fill="none" stroke="#64748b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M8 12l2.5 2.5L16 9" filter="url(#checkOutlineShadow)"/>
                        </svg>
                    `;
                }
                
                button.disabled = false;
            }
            
            // Search Results Message Functions
            function showSearchResultsMessage(message) {
                const messageElement = document.getElementById('search-results-message');
                const textElement = document.getElementById('search-results-text');
                
                if (messageElement && textElement) {
                    textElement.textContent = message;
                    messageElement.classList.remove('hidden');
                    
                    // Add smooth fade-in animation
                    messageElement.style.opacity = '0';
                    messageElement.style.transform = 'translateY(-10px)';
                    
                    setTimeout(() => {
                        messageElement.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                        messageElement.style.opacity = '1';
                        messageElement.style.transform = 'translateY(0)';
                    }, 10);
                }
            }
            
            function hideSearchResultsMessage() {
                const messageElement = document.getElementById('search-results-message');
                
                if (messageElement) {
                    messageElement.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                    messageElement.style.opacity = '0';
                    messageElement.style.transform = 'translateY(-10px)';
                    
                    setTimeout(() => {
                        messageElement.classList.add('hidden');
                        messageElement.style.transition = '';
                        messageElement.style.opacity = '';
                        messageElement.style.transform = '';
                    }, 300);
                }
            }
            
            // Clear search message button functionality
            const clearSearchMessageBtn = document.getElementById('clear-search-message');
            if (clearSearchMessageBtn) {
                clearSearchMessageBtn.addEventListener('click', function() {
                    hideSearchResultsMessage();
                    // Also clear the search input
                    const searchInput = document.getElementById('topic-search');
                    if (searchInput) {
                        searchInput.value = '';
                        filterTopics();
                    }
                });
            }
            
            function showTopicsNotification(message, type = 'info') {
                // Create or update notification
                let notification = document.getElementById('topicsNotification');
                if (!notification) {
                    notification = document.createElement('div');
                    notification.id = 'topicsNotification';
                    notification.style.cssText = `
                        position: fixed;
                        top: 80px;
                        right: 20px;
                        padding: 12px 20px;
                        border-radius: 8px;
                        font-size: 14px;
                        font-weight: 500;
                        z-index: 1060;
                        box-shadow: 0 4px 20px rgba(0,0,0,0.15);
                        opacity: 0;
                        transition: opacity 0.3s ease;
                        pointer-events: none;
                        max-width: 300px;
                    `;
                    document.body.appendChild(notification);
                }
                
                // Set color based on type
                const colors = {
                    success: 'background: #10b981; color: white;',
                    error: 'background: #ef4444; color: white;',
                    info: 'background: #3b82f6; color: white;'
                };
                
                notification.style.cssText += colors[type] || colors.info;
                notification.textContent = message;
                notification.style.opacity = '1';
                
                setTimeout(() => {
                    notification.style.opacity = '0';
                }, 3000);
            }
        });
    </script>
    <?php $__env->stopPush(); ?>

    <?php $__env->startPush('styles'); ?>
    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
        
        .animate-blob {
            animation: blob 7s infinite;
        }
        
        .animation-delay-2000 {
            animation-delay: 2s;
        }
        
        .animation-delay-4000 {
            animation-delay: 4s;
        }
        
        
        /* Smooth transitions */
        * {
            scroll-behavior: smooth;
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
        
        /* Filter Tags */
        .filter-tag {
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .filter-tag:hover span {
            transform: scale(1.05);
        }
        
        .filter-tag.active span {
            background: #3b82f6 !important;
            color: white !important;
            border-color: #3b82f6 !important;
            transform: scale(1.05);
        }
        
        /* Topic Card Loading Animations */
        .topic-card {
            opacity: 0;
            transform: translateY(30px);
            animation: slideInUp 0.6s ease-out forwards;
        }
        
        @keyframes slideInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Staggered animation delays */
        .topic-card:nth-child(1) { animation-delay: 0.1s; }
        .topic-card:nth-child(2) { animation-delay: 0.2s; }
        .topic-card:nth-child(3) { animation-delay: 0.3s; }
        .topic-card:nth-child(4) { animation-delay: 0.4s; }
        .topic-card:nth-child(5) { animation-delay: 0.5s; }
        .topic-card:nth-child(6) { animation-delay: 0.6s; }
        .topic-card:nth-child(7) { animation-delay: 0.7s; }
        .topic-card:nth-child(8) { animation-delay: 0.8s; }
        .topic-card:nth-child(9) { animation-delay: 0.9s; }
        .topic-card:nth-child(10) { animation-delay: 1.0s; }
        .topic-card:nth-child(11) { animation-delay: 1.1s; }
        .topic-card:nth-child(12) { animation-delay: 1.2s; }
        .topic-card:nth-child(13) { animation-delay: 1.3s; }
        .topic-card:nth-child(14) { animation-delay: 1.4s; }
        .topic-card:nth-child(15) { animation-delay: 1.5s; }
        .topic-card:nth-child(16) { animation-delay: 1.6s; }
        .topic-card:nth-child(17) { animation-delay: 1.7s; }
        .topic-card:nth-child(18) { animation-delay: 1.8s; }
        .topic-card:nth-child(19) { animation-delay: 1.9s; }
        .topic-card:nth-child(20) { animation-delay: 2.0s; }
        
        /* Book icon hover animation */
        .book-icon {
            transition: all 0.3s ease;
        }
        
        .book-icon:hover {
            transform: rotate(5deg) scale(1.1);
        }
        
        /* Enhanced Heart Icon Animations */
        .favorite-btn {
            position: relative;
            overflow: visible;
        }
        
        .favorite-btn:hover {
            transform: scale(1.1);
        }
        
        .favorite-btn:active {
            transform: scale(0.95);
        }
        
        .heart-filled {
            animation: heartBeat 0.6s ease-in-out;
        }
        
        .heart-outline {
            transition: all 0.3s ease;
        }
        
        .heart-outline:hover {
            transform: scale(1.1);
            filter: drop-shadow(0 0 8px rgba(239, 68, 68, 0.4));
        }
        
        @keyframes heartBeat {
            0% {
                transform: scale(1);
            }
            14% {
                transform: scale(1.3);
            }
            28% {
                transform: scale(1);
            }
            42% {
                transform: scale(1.3);
            }
            70% {
                transform: scale(1);
            }
        }
        
        @keyframes heartPulse {
            0% {
                filter: drop-shadow(0 0 0px rgba(231, 76, 60, 0.7));
            }
            50% {
                filter: drop-shadow(0 0 10px rgba(231, 76, 60, 0.7));
            }
            100% {
                filter: drop-shadow(0 0 0px rgba(231, 76, 60, 0.7));
            }
        }
        
        .heart-filled:hover {
            animation: heartPulse 1.5s ease-in-out infinite;
        }
        
        /* Enhanced Checkmark Icon Animations */
        .completed-btn {
            position: relative;
            overflow: visible;
        }
        
        .completed-btn:hover {
            transform: scale(1.1);
        }
        
        .completed-btn:active {
            transform: scale(0.95);
        }
        
        .check-filled {
            animation: checkBounce 0.6s ease-in-out;
        }
        
        .check-outline {
            transition: all 0.3s ease;
        }
        
        .check-outline:hover {
            transform: scale(1.1);
            filter: drop-shadow(0 0 8px rgba(16, 185, 129, 0.4));
        }
        
        @keyframes checkBounce {
            0% {
                transform: scale(1);
            }
            25% {
                transform: scale(1.2) rotate(-5deg);
            }
            50% {
                transform: scale(1.1) rotate(5deg);
            }
            75% {
                transform: scale(1.15) rotate(-2deg);
            }
            100% {
                transform: scale(1);
            }
        }
        
        @keyframes checkPulse {
            0% {
                filter: drop-shadow(0 0 0px rgba(16, 185, 129, 0.7));
            }
            50% {
                filter: drop-shadow(0 0 10px rgba(16, 185, 129, 0.7));
            }
            100% {
                filter: drop-shadow(0 0 0px rgba(16, 185, 129, 0.7));
            }
        }
        
        .check-filled:hover {
            animation: checkPulse 1.5s ease-in-out infinite;
        }
        
        @keyframes checkMark {
            0% {
                stroke-dasharray: 0 20;
                stroke-dashoffset: 20;
            }
            100% {
                stroke-dasharray: 20 0;
                stroke-dashoffset: 0;
            }
        }
        
        .check-filled path {
            stroke-dasharray: 20;
            stroke-dashoffset: 0;
            animation: checkMark 0.8s ease-in-out;
        }
        
        @keyframes circleFill {
            0% {
                r: 0;
            }
            100% {
                r: 10;
            }
        }
        
        .check-filled circle {
            animation: circleFill 0.6s ease-out;
        }
        
        /* Loading spinner enhancement */
        .favorite-btn .animate-spin,
        .completed-btn .animate-spin {
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(360deg);
            }
        }
        
        /* Search Results Message Styles */
        #search-results-message {
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            border: 1px solid #93c5fd;
            box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.1), 0 2px 4px -1px rgba(59, 130, 246, 0.06);
            transition: all 0.3s ease;
        }
        
        #search-results-message:hover {
            box-shadow: 0 10px 15px -3px rgba(59, 130, 246, 0.1), 0 4px 6px -2px rgba(59, 130, 246, 0.05);
            transform: translateY(-1px);
        }
        
        #clear-search-message {
            transition: all 0.2s ease;
        }
        
        #clear-search-message:hover {
            transform: scale(1.1);
            background: rgba(59, 130, 246, 0.1);
            border-radius: 4px;
            padding: 2px;
        }
        
        /* Search results message animation */
        @keyframes slideInFromTop {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        #search-results-message.show {
            animation: slideInFromTop 0.4s ease-out;
        }
    </style>
    <?php $__env->stopPush(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?><?php /**PATH /homepages/38/d4299336130/htdocs/nephroapp/resources/views/topics/index.blade.php ENDPATH**/ ?>