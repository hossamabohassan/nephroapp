<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo $__env->yieldContent('title', 'Admin'); ?> - <?php echo e(config('app.name', 'NephroCoach')); ?></title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>

    <!-- Additional Styles -->
    <?php echo $__env->yieldPushContent('styles'); ?>

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        
        /* Custom scrollbar styling */
        .admin-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        .admin-scrollbar::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 3px;
        }
        .admin-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }
        .admin-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Sidebar animations */
        .sidebar-transition {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Modern glassmorphism effect */
        .glass-effect {
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }

        /* Gradient animations */
        @keyframes gradient-shift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        
        .gradient-animated {
            background: linear-gradient(-45deg, #6366f1, #8b5cf6, #ec4899, #f59e0b);
            background-size: 400% 400%;
            animation: gradient-shift 8s ease infinite;
        }

        /* Card hover effects */
        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
    </style>
</head>
<body class="font-sans antialiased bg-slate-50">
    <div class="flex h-screen overflow-hidden">
        
        <!-- Sidebar -->
        <div id="sidebar" class="relative flex flex-col w-64 bg-white shadow-xl border-r border-slate-200 sidebar-transition">
            <!-- Sidebar Header -->
            <div class="flex items-center justify-between h-16 px-6 bg-gradient-to-r from-blue-600 to-purple-600 text-white">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-lg font-bold"><?php echo e(config('app.name', 'NephroCoach')); ?></h1>
                        <p class="text-xs text-white/80">Admin Panel</p>
                    </div>
                </div>
                <button id="sidebar-toggle" class="lg:hidden p-1 rounded-md hover:bg-white/20 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 px-4 py-6 space-y-2 admin-scrollbar overflow-y-auto">
                <!-- Dashboard -->
                <a href="<?php echo e(route('admin.dashboard')); ?>" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 <?php echo e(request()->routeIs('admin.dashboard') ? 'bg-blue-50 text-blue-700 border-r-4 border-blue-600' : 'text-slate-700 hover:bg-slate-100'); ?>">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2v0m0 4h14m-4 6V7"/>
                    </svg>
                    Dashboard
                </a>

                <!-- Content Management Section -->
                <div class="pt-4">
                    <h3 class="px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider mb-3">Content Management</h3>
                    
                    <!-- Topics -->
                    <a href="<?php echo e(route('admin.topics.index')); ?>" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 <?php echo e(request()->routeIs('admin.topics.*') ? 'bg-blue-50 text-blue-700 border-r-4 border-blue-600' : 'text-slate-700 hover:bg-slate-100'); ?>">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Topics
                        <span class="ml-auto bg-blue-100 text-blue-800 text-xs font-medium px-2 py-1 rounded-full"><?php echo e(\App\Models\Topic::count()); ?></span>
                    </a>

                    <!-- Categories -->
                    <a href="<?php echo e(route('admin.categories.index')); ?>" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 <?php echo e(request()->routeIs('admin.categories.*') ? 'bg-blue-50 text-blue-700 border-r-4 border-blue-600' : 'text-slate-700 hover:bg-slate-100'); ?>">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                        Categories
                        <span class="ml-auto bg-green-100 text-green-800 text-xs font-medium px-2 py-1 rounded-full"><?php echo e(\App\Models\Category::count()); ?></span>
                    </a>

                    <!-- Menu Items -->
                    <a href="<?php echo e(route('admin.menu-items.index')); ?>" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 <?php echo e(request()->routeIs('admin.menu-items.*') ? 'bg-blue-50 text-blue-700 border-r-4 border-blue-600' : 'text-slate-700 hover:bg-slate-100'); ?>">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                        </svg>
                        Menu Items
                        <span class="ml-auto bg-purple-100 text-purple-800 text-xs font-medium px-2 py-1 rounded-full"><?php echo e(\App\Models\MenuItem::count()); ?></span>
                    </a>

                    <!-- Page Content -->
                    <a href="<?php echo e(route('admin.content.index')); ?>" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 <?php echo e(request()->routeIs('admin.content.*') ? 'bg-blue-50 text-blue-700 border-r-4 border-blue-600' : 'text-slate-700 hover:bg-slate-100'); ?>">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Page Content
                    </a>

                    <!-- Landing Page Editor -->
                    <a href="<?php echo e(route('admin.landing-page.index')); ?>" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 <?php echo e(request()->routeIs('admin.landing-page.*') ? 'bg-blue-50 text-blue-700 border-r-4 border-blue-600' : 'text-slate-700 hover:bg-slate-100'); ?>">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2v0m0 4h14m-4 6V7"/>
                        </svg>
                        Landing Page Editor
                    </a>

                    <!-- Navigation Sections -->
                    <a href="<?php echo e(route('admin.navigation-sections.index')); ?>" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 <?php echo e(request()->routeIs('admin.navigation-sections.*') ? 'bg-blue-50 text-blue-700 border-r-4 border-blue-600' : 'text-slate-700 hover:bg-slate-100'); ?>">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                        Navigation Sections
                        <span class="ml-auto bg-green-100 text-green-800 text-xs font-medium px-2 py-1 rounded-full"><?php echo e(\App\Models\NavigationSection::where('is_active', true)->count()); ?>/<?php echo e(\App\Models\NavigationSection::count()); ?></span>
                    </a>

                    <!-- Navigation Menu -->
                    <a href="<?php echo e(route('admin.navigation-menu.index')); ?>" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 <?php echo e(request()->routeIs('admin.navigation-menu.*') ? 'bg-blue-50 text-blue-700 border-r-4 border-blue-600' : 'text-slate-700 hover:bg-slate-100'); ?>">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                        Navigation Menu
                        <span class="ml-auto bg-blue-100 text-blue-800 text-xs font-medium px-2 py-1 rounded-full"><?php echo e(\App\Models\NavigationMenuItem::where('is_active', true)->count()); ?>/<?php echo e(\App\Models\NavigationMenuItem::count()); ?></span>
                    </a>

                    <!-- Header Buttons -->
                    <a href="<?php echo e(route('admin.navigation-header-buttons.index')); ?>" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 <?php echo e(request()->routeIs('admin.navigation-header-buttons.*') ? 'bg-blue-50 text-blue-700 border-r-4 border-blue-600' : 'text-slate-700 hover:bg-slate-100'); ?>">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5-5-5 5h5zm0 0v1a3 3 0 01-6 0v-1m6 0V9a3 3 0 00-6 0v8"/>
                        </svg>
                        Header Buttons
                        <span class="ml-auto bg-purple-100 text-purple-800 text-xs font-medium px-2 py-1 rounded-full"><?php echo e(\App\Models\NavigationHeaderButton::where('is_active', true)->count()); ?>/<?php echo e(\App\Models\NavigationHeaderButton::count()); ?></span>
                    </a>
                </div>

                <!-- User Management Section -->
                <div class="pt-4">
                    <h3 class="px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider mb-3">User Management</h3>
                    
                    <!-- Users -->
                    <a href="<?php echo e(route('admin.users.index')); ?>" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 <?php echo e(request()->routeIs('admin.users.*') ? 'bg-blue-50 text-blue-700 border-r-4 border-blue-600' : 'text-slate-700 hover:bg-slate-100'); ?>">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                        </svg>
                        Users
                        <span class="ml-auto bg-purple-100 text-purple-800 text-xs font-medium px-2 py-1 rounded-full"><?php echo e(\App\Models\User::count()); ?></span>
                    </a>

                    <!-- Permissions -->
                    <a href="<?php echo e(route('admin.permissions.index')); ?>" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 <?php echo e(request()->routeIs('admin.permissions.*') ? 'bg-blue-50 text-blue-700 border-r-4 border-blue-600' : 'text-slate-700 hover:bg-slate-100'); ?>">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.031 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        Permissions
                    </a>
                </div>

                <!-- System Section -->
                <div class="pt-4">
                    <h3 class="px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider mb-3">System</h3>
                    
                    <!-- Settings -->
                    <a href="<?php echo e(route('admin.settings.index')); ?>" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 <?php echo e(request()->routeIs('admin.settings.*') ? 'bg-blue-50 text-blue-700 border-r-4 border-blue-600' : 'text-slate-700 hover:bg-slate-100'); ?>">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        Settings
                    </a>

                    <!-- Activity Logs -->
                    <a href="<?php echo e(route('admin.activity.index')); ?>" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 <?php echo e(request()->routeIs('admin.activity.*') ? 'bg-blue-50 text-blue-700 border-r-4 border-blue-600' : 'text-slate-700 hover:bg-slate-100'); ?>">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        Activity Logs
                    </a>
                </div>

                <!-- Custom Menu Items -->
                <?php if(isset($adminMenuItems) && $adminMenuItems->count() > 0): ?>
                    <div class="pt-4">
                        <h3 class="px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider mb-3">Custom Menu</h3>
                        <?php $__currentLoopData = $adminMenuItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menuItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="<?php echo e($menuItem->url); ?>" 
                               class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 <?php echo e(request()->is(ltrim($menuItem->url, '/')) ? 'bg-blue-50 text-blue-700 border-r-4 border-blue-600' : 'text-slate-700 hover:bg-slate-100'); ?>"
                               <?php if($menuItem->opens_in_new_tab): ?> target="_blank" <?php endif; ?>>
                                <?php if($menuItem->icon === 'home'): ?>
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                    </svg>
                                <?php elseif($menuItem->icon === 'book'): ?>
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                <?php elseif($menuItem->icon === 'info'): ?>
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                <?php elseif($menuItem->icon === 'user'): ?>
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                <?php elseif($menuItem->icon === 'settings'): ?>
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                <?php elseif($menuItem->icon === 'mail'): ?>
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                <?php else: ?>
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                <?php endif; ?>
                                <?php echo e($menuItem->title); ?>

                                <?php if($menuItem->opens_in_new_tab): ?>
                                    <svg class="w-3 h-3 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                    </svg>
                                <?php endif; ?>
                            </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>

                <!-- Quick Actions -->
                <div class="pt-6 border-t border-slate-200 mt-6">
                    <div class="px-4 space-y-2">
                        <a href="<?php echo e(route('admin.topics.create')); ?>" class="flex items-center justify-center w-full px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            New Topic
                        </a>
                        <a href="<?php echo e(route('topics.index')); ?>" class="flex items-center justify-center w-full px-4 py-2 bg-slate-600 text-white text-sm font-medium rounded-lg hover:bg-slate-700 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                            View Site
                        </a>
                    </div>
                </div>
            </nav>
        </div>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Header -->
            <header class="bg-white border-b border-slate-200 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <button id="mobile-sidebar-toggle" class="lg:hidden p-2 rounded-md text-slate-400 hover:text-slate-600 hover:bg-slate-100 focus:outline-none">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </button>
                        
                        <div>
                            <h1 class="text-2xl font-bold text-slate-900"><?php echo e($pageTitle ?? 'Admin Dashboard'); ?></h1>
                            <?php if($pageDescription ?? false): ?>
                                <p class="text-sm text-slate-600"><?php echo e($pageDescription); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="flex items-center space-x-4">
                        <!-- Notifications -->
                        <button class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-lg transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM10.5 3.75a6 6 0 113.5 5.43l-4 4-4-4a6 6 0 010-8.49z"/>
                            </svg>
                        </button>

                        <!-- User Dropdown -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-slate-100 transition-colors">
                                <img class="w-8 h-8 rounded-full ring-2 ring-white shadow-lg" src="https://ui-avatars.com/api/?name=<?php echo e(auth()->user()->name); ?>&background=6366f1&color=ffffff" alt="Profile">
                                <div class="hidden md:block text-left">
                                    <p class="text-sm font-medium text-slate-900"><?php echo e(auth()->user()->name); ?></p>
                                    <p class="text-xs text-slate-500"><?php echo e(auth()->user()->role); ?></p>
                                </div>
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>

                            <div x-show="open" 
                                 x-transition
                                 @click.outside="open = false"
                                 class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg border border-slate-200 py-1 z-50">
                                <a href="<?php echo e(route('profile.edit')); ?>" class="flex items-center px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">
                                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    Your Profile
                                </a>
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
            </header>

            <!-- Main Content -->
            <main class="flex-1 overflow-y-auto bg-slate-50 p-6 admin-scrollbar">
                <?php echo e($slot); ?>

            </main>
        </div>
    </div>

    <!-- Mobile Sidebar Overlay -->
    <div id="mobile-sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden hidden"></div>

    <!-- Additional Scripts -->
    <?php echo $__env->yieldPushContent('scripts'); ?>

    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const mobileToggle = document.getElementById('mobile-sidebar-toggle');
            const overlay = document.getElementById('mobile-sidebar-overlay');

            // Mobile sidebar toggle
            if (mobileToggle) {
                mobileToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('-translate-x-full');
                    overlay.classList.toggle('hidden');
                });
            }

            // Close sidebar when clicking overlay
            if (overlay) {
                overlay.addEventListener('click', function() {
                    sidebar.classList.add('-translate-x-full');
                    overlay.classList.add('hidden');
                });
            }

            // Handle responsive behavior
            function handleResize() {
                if (window.innerWidth >= 1024) {
                    sidebar.classList.remove('-translate-x-full');
                    overlay.classList.add('hidden');
                }
            }

            window.addEventListener('resize', handleResize);
            handleResize(); // Initial check
        });
    </script>
</body>
</html>
<?php /**PATH /homepages/38/d4299336130/htdocs/resources/views/layouts/admin.blade.php ENDPATH**/ ?>