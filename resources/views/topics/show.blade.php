@php
    $currentTopicSlug = $topic->slug;
@endphp

<x-app-layout>
    {{-- Add necessary headers for fonts and Tailwind --}}
    @push('styles')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }
        
        /* Hide sidebar completely */
        #sidebar {
            display: none !important;
        }
        
        /* Make main content full width */
        main {
            width: 100% !important;
            max-width: none !important;
        }
        
        /* Navigation styling improvements */
        .nav-link {
            margin: 15px 1px 1px 1px;
            text-decoration: none !important;
        }
        
        .nav-link:hover {
            text-decoration: none !important;
        }
        
        /* Remove underlines from all navigation links */
        nav a {
            text-decoration: none !important;
        }
        
        nav a:hover {
            text-decoration: none !important;
        }
        
        .logo-icon {
            position: relative;
            overflow: hidden;
            float: left;
            margin: 0px 14px;
        }
        
        p.text-sm.font-medium.text-slate-900 {
            margin: -1px 0px;
        }
        
        /* Print styles */
        @media print {
            .print-button {
                display: none !important;
            }
            
            #printable-content {
                box-shadow: none !important;
                border: none !important;
            }
            
            .print-button-container {
                display: none !important;
            }
        }
        
        
        /* Enhanced prose styling */
        .prose {
            color: #334155;
        }
        .prose h1, .prose h2, .prose h3, .prose h4, .prose h5, .prose h6 {
            color: #1e293b;
            font-weight: 700;
            letter-spacing: -0.025em;
        }
        .prose h1 {
            font-size: 2.5rem;
            line-height: 1.2;
        }
        .prose h2 {
            font-size: 2rem;
            line-height: 1.3;
        }
        .prose h3 {
            font-size: 1.5rem;
            line-height: 1.4;
        }
        .prose p {
            line-height: 1.7;
            margin-bottom: 1.5rem;
        }
        .prose ul, .prose ol {
            margin-bottom: 1.5rem;
        }
        .prose li {
            margin-bottom: 0.5rem;
        }
        .prose blockquote {
            border-left: 4px solid #3b82f6;
            background: linear-gradient(to right, #eff6ff, transparent);
            padding: 1rem 1.5rem;
            margin: 2rem 0;
            border-radius: 0 0.5rem 0.5rem 0;
        }
        .prose code {
            background: #f1f5f9;
            color: #1e293b;
            padding: 0.25rem 0.5rem;
            border-radius: 0.375rem;
            font-size: 0.875em;
            font-weight: 500;
        }
        .prose pre {
            background: #1e293b;
            color: #e2e8f0;
            padding: 1.5rem;
            border-radius: 0.75rem;
            overflow-x: auto;
            margin: 2rem 0;
        }
        .prose pre code {
            background: transparent;
            color: inherit;
            padding: 0;
        }
        .prose table {
            width: 100%;
            border-collapse: collapse;
            margin: 2rem 0;
        }
        .prose th, .prose td {
            border: 1px solid #e2e8f0;
            padding: 0.75rem 1rem;
            text-align: left;
        }
        .prose th {
            background: #f8fafc;
            font-weight: 600;
            color: #1e293b;
        }
        
        /* No animations for maximum performance */
        
        /* Fullscreen modal styles */
        .fullscreen-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.95);
            z-index: 10000;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .fullscreen-content {
            background: white;
            border-radius: 8px;
            padding: 20px;
            max-width: 90%;
            max-height: 90%;
            overflow: auto;
            position: relative;
        }
        
        .close-fullscreen {
            position: absolute;
            top: 10px;
            right: 15px;
            background: #ef4444;
            color: white;
            border: none;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            cursor: pointer;
            font-size: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .fullscreen-btn {
            background: #3b82f6;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 12px;
            margin: 10px 0;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        
        .fullscreen-btn:hover {
            background: #2563eb;
        }
        
        /* Section titles back to normal display */
        .section-title {
            display: block;
        }
        
        .section-title.mb-2 {
            display: block;
        }
        
        
        
        /* Progress bar */
        .reading-progress {
            position: fixed;
            top: 0;
            left: 0;
            width: 0%;
            height: 3px;
            background: #3b82f6;
            z-index: 10001;
        }
        
        /* Custom focus styles */
        .focus\:ring-2:focus {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        
        /* No hover effects for maximum performance */
        
        /* No loading animations for maximum performance */
        
        /* Custom gradient text */
        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>
    @endpush

    <!-- Reading Progress Bar -->
    <div class="reading-progress" id="reading-progress"></div>
    

    <div class="min-h-screen bg-gray-50" id="main-content">
        <!-- Top Navigation Bar -->
        <nav class="sticky top-0 z-50 backdrop-blur-xl bg-white/80 border-b border-slate-200/60 shadow-sm">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    
                    <!-- Logo Section -->
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('topics.index') }}" class="flex items-center space-x-3 group">
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
                                    {{ config('app.name', 'NephroCoach') }}
                                </h1>
                                <p class="text-xs text-slate-500 font-medium">{{ content('site_tagline', 'Expert Medical Training Platform') }}</p>
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
                                placeholder="{{ content('topics_search_placeholder', 'Search topics, categories...') }}"
                                value="{{ request('q') }}"
                            >
                        </div>
                    </div>

                    <!-- Right Section -->
                    <div class="flex items-center space-x-4">
                        
                        @foreach($navigationHeaderButtons as $headerButton)
                            @if($headerButton->type === 'button')
                                <a href="{{ $headerButton->resolved_url }}" 
                                   target="{{ $headerButton->target }}"
                                   class="relative p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-lg transition-colors duration-200 {{ $headerButton->css_class }}"
                                   title="{{ $headerButton->title }}">
                                    {!! $headerButton->icon_html !!}
                                    @if($headerButton->show_badge)
                                        <span class="absolute top-1 right-1 block h-2 w-2 rounded-full {{ $headerButton->badge_color_class }}"></span>
                                    @endif
                                </a>
                            @elseif($headerButton->type === 'dropdown')
                                <div class="relative" x-data="{ open: false }">
                                    <button @click="open = !open" class="relative p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-lg transition-colors duration-200 {{ $headerButton->css_class }}" title="{{ $headerButton->title }}">
                                        {!! $headerButton->icon_html !!}
                                        @if($headerButton->show_badge)
                                            <span class="absolute top-1 right-1 block h-2 w-2 rounded-full {{ $headerButton->badge_color_class }}"></span>
                                        @endif
                                    </button>
                                    <!-- Dropdown content would go here -->
                                </div>
                            @endif
                        @endforeach

                        <!-- User Profile Dropdown -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-slate-100 transition-colors duration-200">
                                <div class="relative">
                                    <img class="h-8 w-8 rounded-full ring-2 ring-white shadow-lg" src="https://ui-avatars.com/api/?name={{ auth()->user()->name ?? 'User' }}&background=6366f1&color=ffffff" alt="Profile">
                                    <div class="absolute -bottom-0.5 -right-0.5 h-3 w-3 bg-green-400 border-2 border-white rounded-full"></div>
                                </div>
                                <div class="hidden md:block text-left">
                                    <p class="text-sm font-medium text-slate-900">{{ auth()->user()->name ?? 'Admin User' }}</p>
                                    <p class="text-xs text-slate-500">{{ auth()->user()->email ?? 'admin@example.com' }}</p>
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
                                
                                @foreach($navigationMenuItems as $menuItem)
                                    <a href="{{ $menuItem->resolved_url }}" 
                                       target="{{ $menuItem->target }}"
                                       class="flex items-center px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 {{ $menuItem->css_class }}">
                                        <div class="w-4 h-4 mr-3 text-slate-400">
                                            {!! $menuItem->icon_html !!}
                                        </div>
                                        {{ $menuItem->title }}
                                    </a>
                                @endforeach
                                
                                <div class="border-t border-slate-100 my-1"></div>
                                
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
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

        <!-- Enhanced Main Content -->
            <div id="sidebar" class="bg-white border-r border-slate-200 text-slate-800 flex flex-col h-full flex-shrink-0" style="width: 320px;">
                <!-- Enhanced Search Bar -->
                <div class="p-6 border-b border-slate-200 bg-blue-50">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input id="search" name="search" class="block w-full pl-12 pr-4 py-3 border border-slate-300 rounded-xl bg-white text-slate-900 placeholder-slate-500 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-sm link-text shadow-sm " placeholder="Search topics..." type="search">
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center">
                            <kbd class="hidden sm:inline-flex items-center px-2 py-1 text-xs font-medium text-slate-500 bg-slate-100 border border-slate-200 rounded">⌘K</kbd>
                        </div>
                    </div>
                </div>

                <!-- Main Menu -->
                <div class="flex-grow overflow-y-auto sidebar-scroll">
                    <nav class="flex flex-col p-4">
                        <div class="space-y-1 mb-6">
                            @foreach ($menuItems as $menuItem)
                                @php($isCurrentPage = request()->is(ltrim($menuItem->url, '/')))
                                <a href="{{ $menuItem->url }}" 
                                   class="group flex items-center px-4 py-3 rounded-xl text-sm  {{ $isCurrentPage ? 'bg-blue-500 text-white' : 'text-slate-700 hover:bg-slate-100' }}"
                                   @if($menuItem->opens_in_new_tab) target="_blank" @endif>
                                    <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 flex-shrink-0 {{ $isCurrentPage ? 'bg-white/20' : 'bg-slate-100 group-hover:bg-slate-200' }} ">
                                        @if($menuItem->icon === 'home')
                                            <svg class="w-4 h-4 {{ $isCurrentPage ? 'text-white' : 'text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                            </svg>
                                        @elseif($menuItem->icon === 'book')
                                            <svg class="w-4 h-4 {{ $isCurrentPage ? 'text-white' : 'text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                            </svg>
                                        @elseif($menuItem->icon === 'info')
                                            <svg class="w-4 h-4 {{ $isCurrentPage ? 'text-white' : 'text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        @elseif($menuItem->icon === 'user')
                                            <svg class="w-4 h-4 {{ $isCurrentPage ? 'text-white' : 'text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                        @elseif($menuItem->icon === 'settings')
                                            <svg class="w-4 h-4 {{ $isCurrentPage ? 'text-white' : 'text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                        @elseif($menuItem->icon === 'mail')
                                            <svg class="w-4 h-4 {{ $isCurrentPage ? 'text-white' : 'text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                            </svg>
                                        @else
                                            <svg class="w-4 h-4 {{ $isCurrentPage ? 'text-white' : 'text-slate-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        @endif
                                    </div>
                                    <span class="link-text truncate font-medium">{{ $menuItem->title }}</span>
                                    @if($isCurrentPage)
                                        <div class="ml-auto">
                                            <div class="w-2 h-2 bg-white rounded-full"></div>
                                        </div>
                                    @endif
                                </a>
                            @endforeach
                        </div>
                    </nav>

                </div>
            </div>

            <!-- Enhanced Main Content -->
            <main class="flex-grow p-6 md:p-8 h-full overflow-y-auto bg-gray-50">
                <div class="max-w-6xl mx-auto">
                    
                    <!-- Enhanced Topic Header -->
                    <div class="bg-white rounded-2xl border border-slate-200 p-8 md:p-10 mb-8 relative">
                        <!-- Print Button - Top Right Icon -->
                        <button 
                            onclick="printArticle()" 
                            class="print-button fixed top-20 right-6 inline-flex items-center justify-center w-10 h-10 bg-blue-600 text-white rounded-full hover:bg-blue-700 transition-all duration-200 shadow-lg hover:shadow-xl z-50"
                            title="Print this article"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                            </svg>
                        </button>
                        
                        <!-- No background patterns for performance -->
                        
                        <div class="relative z-10">
                            <!-- Enhanced Tags Section -->
                            <div class="flex flex-wrap gap-3 mb-6">
                                {{-- Topic Chips/Tags --}}
                                @foreach (array_filter([$topic->data['CHIP_1'] ?? null, $topic->data['CHIP_2'] ?? null, $topic->data['CHIP_3'] ?? null]) as $chip)
                                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm bg-blue-100 text-blue-800 font-semibold border border-blue-200">
                                        <div class="w-2 h-2 bg-blue-500 rounded-full mr-2"></div>
                                        {{ $chip }}
                                    </span>
                                @endforeach
                                @if ($topic->category)
                                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm bg-emerald-100 text-emerald-800 font-semibold border border-emerald-200">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                        </svg>
                                        {{ $topic->category->name }}
                                    </span>
                                @endif
                            </div>

                            <!-- Enhanced Title and Actions -->
                            <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-6 mb-8">
                                <div class="flex-1">
                                    <h1 class="text-4xl md:text-5xl font-bold text-slate-900 leading-tight mb-4">
                                        {{ $topic->title }}
                                    </h1>
                                    
                                    @if ($topic->summary)
                                        <div class="prose prose-lg max-w-none text-slate-700 leading-relaxed">
                                            {!! $topic->summary !!}
                                        </div>
                                    @endif
                                </div>
                                
                                @auth
                                <!-- Enhanced User Action Buttons -->
                                <div class="flex flex-col sm:flex-row lg:flex-col items-stretch sm:items-center lg:items-stretch gap-3 flex-shrink-0">
                                    <!-- Favorite Button -->
                                    <button 
                                        id="favorite-btn" 
                                        data-topic-id="{{ $topic->id }}"
                                        class="favorite-btn group inline-flex items-center justify-center px-6 py-3 rounded-xl border-2  focus:outline-none focus:ring-2 focus:ring-offset-2 shadow-sm hover:shadow-md"
                                        data-favorited="false"
                                    >
                                        <svg class="w-5 h-5 mr-2 favorite-icon " fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                        </svg>
                                        <span class="favorite-text font-semibold">Add to Favorites</span>
                                    </button>

                                    <!-- Completed Button -->
                                    <button 
                                        id="completed-btn" 
                                        data-topic-id="{{ $topic->id }}"
                                        class="completed-btn group inline-flex items-center justify-center px-6 py-3 rounded-xl border-2  focus:outline-none focus:ring-2 focus:ring-offset-2 shadow-sm hover:shadow-md"
                                        data-completed="false"
                                    >
                                        <svg class="w-5 h-5 mr-2 completed-icon " fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span class="completed-text font-semibold">Mark Complete</span>
                                    </button>
                                </div>
                                @endauth
                            </div>
                            
                            <!-- Enhanced Metadata -->
                            <div class="flex flex-wrap items-center gap-8 text-sm">
                                @if ($topic->published_at)
                                    <div class="flex items-center text-slate-600">
                                        <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center mr-3">
                                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="font-medium text-slate-900">Published</div>
                                            <div class="text-slate-500">{{ $topic->published_at->format('M d, Y') }}</div>
                                        </div>
                                    </div>
                                @endif
                                <div class="flex items-center text-slate-600">
                                    <div class="w-8 h-8 rounded-lg bg-indigo-100 flex items-center justify-center mr-3">
                                        <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="font-medium text-slate-900">Last Updated</div>
                                        <div class="text-slate-500">{{ $topic->updated_at->format('M d, Y') }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Enhanced Topic Content -->
                    <article class="bg-white rounded-2xl border border-slate-200 overflow-hidden mb-8" id="printable-content">
                        <div class="p-8 md:p-10 prose prose-lg max-w-none prose-headings:text-slate-900 prose-headings:font-bold prose-p:text-slate-700 prose-p:leading-relaxed prose-a:text-blue-600 prose-a:no-underline hover:prose-a:underline prose-strong:text-slate-900 prose-code:text-slate-800 prose-code:bg-slate-100 prose-code:px-2 prose-code:py-1 prose-code:rounded prose-pre:bg-slate-900 prose-pre:text-slate-100">
                            {!! $rendered !!}
                        </div>
                    </article>

                                    </div>
        </main>
                                    </div>
</div>

<!-- Floating Quick Navigation Button -->
@if(isset($navigationSections) && count($navigationSections) > 0)
<!-- Floating Navigation Button -->
<div style="position: fixed; bottom: 20px; right: 20px; z-index: 9999;">
    <button id="floating-nav-btn" style="width: 60px; height: 60px; background: #3b82f6; color: white; border: none; border-radius: 50%; font-weight: bold; font-size: 16px; cursor: pointer;">
        ☰
                                    </button>
                                </div>

<!-- Full-Screen Navigation Overlay -->
<div id="nav-overlay" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: #3b82f6; z-index: 9998; display: none;">
    <!-- Close Button -->
    <button id="close-nav" style="position: absolute; top: 30px; right: 30px; background: rgba(255,255,255,0.2); border: none; color: white; font-size: 24px; width: 50px; height: 50px; border-radius: 50%; cursor: pointer;">
        ×
    </button>
    
    <!-- Header -->
    <div style="text-align: center; padding: 30px 20px 20px; color: white;">
        <h1 style="font-size: 2rem; font-weight: 700; margin: 0 0 5px 0; text-shadow: 0 2px 10px rgba(0,0,0,0.3);">Quick Navigation</h1>
        <p style="font-size: 1rem; margin: 0; opacity: 0.9; font-weight: 300;">Choose a section to jump to</p>
                            </div>
    
    <!-- Navigation Grid -->
    <div style="max-width: 1400px; margin: 0 auto; padding: 0 20px 20px; display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 12px; height: calc(100vh - 140px); overflow: hidden;">
        @foreach($navigationSections as $index => $section)
            <a href="#{{ $section['id'] }}" 
               class="nav-item" 
               data-section="{{ $section['id'] }}"
               style="display: flex; flex-direction: column; justify-content: center; align-items: center; text-align: center; padding: 12px; background: rgba(255,255,255,0.15); border-radius: 12px; text-decoration: none; color: white; border: 1px solid rgba(255,255,255,0.2); position: relative; overflow: hidden; min-height: 100px;">
                
                <!-- Section Icon -->
                <div style="width: 40px; height: 40px; background: rgba(255,255,255,0.2); border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-bottom: 8px; font-size: 18px;">
                    {{ $section['icon'] ?? '📌' }}
                    </div>
                
                <!-- Section Content -->
                <div>
                    <h3 style="font-size: 1rem; font-weight: 600; margin: 0 0 4px 0; text-shadow: 0 1px 3px rgba(0,0,0,0.3); line-height: 1.2;">{{ $section['title'] }}</h3>
                    <p style="font-size: 0.75rem; margin: 0; opacity: 0.7; font-weight: 300; line-height: 1.2;">{{ $section['id'] }}</p>
                    </div>
                
                <!-- No hover arrow for maximum performance -->
            </a>
        @endforeach
        </div>
    
    <!-- No background patterns for performance -->
    </div>
@endif

    @push('scripts')
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    
    <!-- User Preferences JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const favoriteBtn = document.getElementById('favorite-btn');
            const completedBtn = document.getElementById('completed-btn');
            const topicId = {{ $topic->id }};

            // Get CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            // Global search functionality
            const globalSearch = document.getElementById('global-search');
            if (globalSearch) {
                globalSearch.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        window.location.href = `{{ route('topics.index') }}?q=${encodeURIComponent(this.value)}`;
                    }
                });
            }

            // Initialize button states
            loadTopicStatus();

            // Favorite button functionality
            if (favoriteBtn) {
                favoriteBtn.addEventListener('click', function() {
                    toggleFavorite();
                });
            }

            // Completed button functionality
            if (completedBtn) {
                completedBtn.addEventListener('click', function() {
                    toggleCompleted();
                });
            }

            async function loadTopicStatus() {
                try {
                    const response = await fetch(`/api/user/topics/${topicId}/status`, {
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        }
                    });

                    if (response.ok) {
                        const data = await response.json();
                        updateFavoriteButton(data.favorited);
                        updateCompletedButton(data.completed);
                    }
                } catch (error) {
                    console.error('Error loading topic status:', error);
                }
            }

            async function toggleFavorite() {
                const button = favoriteBtn;
                if (!button) return; // Guard against null button
                const originalContent = button.innerHTML;
                
                // Show loading state
                button.disabled = true;
                button.innerHTML = '<svg class="w-5 h-5 mr-2 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg><span>Loading...</span>';

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
                        console.log('Favorite API response:', data);
                        updateFavoriteButton(data.favorited);
                        showNotification(data.message, 'success');
                    } else {
                        console.error('API response not ok:', response.status, response.statusText);
                        throw new Error('Failed to toggle favorite');
                    }
                } catch (error) {
                    console.error('Error toggling favorite:', error);
                    button.innerHTML = originalContent;
                    button.disabled = false;
                    showNotification('Failed to update favorite status', 'error');
                }
            }

            async function toggleCompleted() {
                const button = completedBtn;
                if (!button) return; // Guard against null button
                const originalContent = button.innerHTML;
                
                // Show loading state
                button.disabled = true;
                button.innerHTML = '<svg class="w-5 h-5 mr-2 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg><span>Loading...</span>';

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
                        console.log('Completed API response:', data);
                        updateCompletedButton(data.completed);
                        showNotification(data.message, 'success');
                    } else {
                        console.error('API response not ok:', response.status, response.statusText);
                        throw new Error('Failed to toggle completed');
                    }
                } catch (error) {
                    console.error('Error toggling completed:', error);
                    button.innerHTML = originalContent;
                    button.disabled = false;
                    showNotification('Failed to update completed status', 'error');
                }
            }

            function updateFavoriteButton(favorited) {
                const button = favoriteBtn;
                if (!button) return; // Guard against null button
                
                button.setAttribute('data-favorited', favorited);

                if (favorited) {
                    button.className = 'favorite-btn group inline-flex items-center justify-center px-6 py-3 rounded-xl border-2 border-red-200 bg-gradient-to-r from-red-50 to-pink-50 text-red-700 hover:from-red-100 hover:to-pink-100  focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 shadow-sm hover:shadow-md';
                    button.innerHTML = `
                        <svg class="w-5 h-5 mr-2 favorite-icon " fill="currentColor" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                        <span class="favorite-text font-semibold">Favorited</span>
                    `;
                } else {
                    button.className = 'favorite-btn group inline-flex items-center justify-center px-6 py-3 rounded-xl border-2 border-slate-200 bg-white text-slate-700 hover:bg-slate-50  focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500 shadow-sm hover:shadow-md';
                    button.innerHTML = `
                        <svg class="w-5 h-5 mr-2 favorite-icon " fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                        <span class="favorite-text font-semibold">Add to Favorites</span>
                    `;
                }
                
                // Ensure button is enabled after updating
                button.disabled = false;
            }

            function updateCompletedButton(completed) {
                const button = completedBtn;
                if (!button) return; // Guard against null button
                
                button.setAttribute('data-completed', completed);

                if (completed) {
                    button.className = 'completed-btn group inline-flex items-center justify-center px-6 py-3 rounded-xl border-2 border-green-200 bg-gradient-to-r from-green-50 to-emerald-50 text-green-700 hover:from-green-100 hover:to-emerald-100  focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 shadow-sm hover:shadow-md';
                    button.innerHTML = `
                        <svg class="w-5 h-5 mr-2 completed-icon " fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="completed-text font-semibold">Completed</span>
                    `;
                } else {
                    button.className = 'completed-btn group inline-flex items-center justify-center px-6 py-3 rounded-xl border-2 border-slate-200 bg-white text-slate-700 hover:bg-slate-50  focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500 shadow-sm hover:shadow-md';
                    button.innerHTML = `
                        <svg class="w-5 h-5 mr-2 completed-icon " fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="completed-text font-semibold">Mark Complete</span>
                    `;
                }
                
                // Ensure button is enabled after updating
                button.disabled = false;
            }

            function showNotification(message, type = 'info') {
                // Create notification element
                const notification = document.createElement('div');
                notification.className = `fixed top-4 right-4 px-6 py-4 rounded-xl z-50 border`;
                
                if (type === 'success') {
                    notification.className += ' bg-green-500/90 text-white border-green-400/50';
                } else if (type === 'error') {
                    notification.className += ' bg-red-500/90 text-white border-red-400/50';
                } else {
                    notification.className += ' bg-blue-500/90 text-white border-blue-400/50';
                }
                
                notification.innerHTML = `
                    <div class="flex items-center">
                        <div class="flex-shrink-0 mr-3">
                            ${type === 'success' ? 
                                '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>' :
                                type === 'error' ?
                                '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>' :
                                '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>'
                            }
                        </div>
                        <span class="font-medium">${message}</span>
                        <button class="ml-4 text-white/80 hover:text-white " onclick="this.parentElement.parentElement.remove()">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                `;
                
                document.body.appendChild(notification);
                
                // Animate in
                setTimeout(() => {
                    notification.classList.remove('translate-x-full');
                }, 10);
                
                // Auto remove after 5 seconds
                setTimeout(() => {
                    notification.classList.add('translate-x-full');
                    setTimeout(() => notification.remove(), 300);
                }, 5000);
            }
        });

        // Copy to clipboard functionality
        function copyToClipboard(button) {
            const codeBlock = button.closest('.mt-4').querySelector('code');
            const text = codeBlock.textContent;
            
            navigator.clipboard.writeText(text).then(() => {
                const originalText = button.innerHTML;
                button.innerHTML = `
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Copied!
                `;
                button.classList.add('text-green-600');
                
                setTimeout(() => {
                    button.innerHTML = originalText;
                    button.classList.remove('text-green-600');
                }, 2000);
            }).catch(() => {
                // Fallback for older browsers
                const textArea = document.createElement('textarea');
                textArea.value = text;
                document.body.appendChild(textArea);
                textArea.select();
                document.execCommand('copy');
                document.body.removeChild(textArea);
                
                const originalText = button.innerHTML;
                button.innerHTML = `
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Copied!
                `;
                button.classList.add('text-green-600');
                
                setTimeout(() => {
                    button.innerHTML = originalText;
                    button.classList.remove('text-green-600');
                }, 2000);
            });
        }
        
        // Fullscreen functionality for flowcharts and diagrams
        function initFullscreenButtons() {
            // Define sections that should have section-level fullscreen buttons
            const sectionsWithFullscreen = [
                'flowchart', 'concept-diagram', 'pharmacology', 'emergency'
            ];
            
            // Add fullscreen buttons to ASCII flowcharts and diagrams (excluding those in sections that already have buttons)
            const flowcharts = document.querySelectorAll('.ascii-flow, pre, .flowchart, .diagram, code');
            flowcharts.forEach((element, index) => {
                // Skip if this element is inside a section that already has a fullscreen button
                const parentSection = element.closest('section');
                if (parentSection && sectionsWithFullscreen.includes(parentSection.id)) {
                    return; // Skip this element as the section already has a button
                }
                
                // Check if element already has a fullscreen button
                const existingBtn = element.parentNode.querySelector('.fullscreen-btn');
                if (existingBtn) {
                    return; // Skip if button already exists
                }
                
                // Check if it looks like a flowchart or diagram
                const text = element.textContent || element.innerText;
                if (text.includes('┌') || text.includes('┐') || text.includes('└') || text.includes('┘') || 
                    text.includes('├') || text.includes('┤') || text.includes('┬') || text.includes('┴') ||
                    text.includes('─') || text.includes('│') || text.includes('→') || text.includes('↓') ||
                    text.includes('flowchart') || text.includes('diagram') || text.includes('ASCII') ||
                    element.classList.contains('ascii-flow')) {
                    
                    // Create fullscreen button
                    const fullscreenBtn = document.createElement('button');
                    fullscreenBtn.className = 'fullscreen-btn';
                    fullscreenBtn.innerHTML = '⛶';
                    fullscreenBtn.title = 'Fullscreen';
                    fullscreenBtn.onclick = () => openFullscreen(element, index);
                    
                    // Insert button before the element
                    element.parentNode.insertBefore(fullscreenBtn, element);
                }
            });
        }
        
        function openFullscreen(element, index) {
            // Create modal
            const modal = document.createElement('div');
            modal.className = 'fullscreen-modal';
            modal.id = `fullscreen-modal-${index}`;
            
            // Create content
            const content = document.createElement('div');
            content.className = 'fullscreen-content';
            
            // Create close button
            const closeBtn = document.createElement('button');
            closeBtn.className = 'close-fullscreen';
            closeBtn.innerHTML = '×';
            closeBtn.onclick = () => closeFullscreen(index);
            
            // Clone the element content
            const clonedElement = element.cloneNode(true);
            clonedElement.style.fontSize = '16px';
            clonedElement.style.lineHeight = '1.6';
            clonedElement.style.whiteSpace = 'pre-wrap';
            clonedElement.style.fontFamily = 'Monaco, Consolas, "Courier New", monospace';
            
            // Add title
            const title = document.createElement('h3');
            title.textContent = 'Diagram - Fullscreen View';
            title.style.marginBottom = '20px';
            title.style.color = '#1f2937';
            
            content.appendChild(closeBtn);
            content.appendChild(title);
            content.appendChild(clonedElement);
            modal.appendChild(content);
            
            // Add to page
            document.body.appendChild(modal);
            modal.style.display = 'flex';
            
            // Close on escape key
            const handleEscape = (e) => {
                if (e.key === 'Escape') {
                    closeFullscreen(index);
                    document.removeEventListener('keydown', handleEscape);
                }
            };
            document.addEventListener('keydown', handleEscape);
        }
        
        function closeFullscreen(index) {
            const modal = document.getElementById(`fullscreen-modal-${index}`);
            if (modal) {
                modal.remove();
            }
        }
        
        // Initialize fullscreen buttons when page loads
        document.addEventListener('DOMContentLoaded', function() {
            initFullscreenButtons();
            initSectionFullscreenButtons();
            initReadingProgress();
        });
        
        // Add fullscreen buttons to entire sections
        function initSectionFullscreenButtons() {
            // Define sections that should have fullscreen buttons
            const sectionsWithFullscreen = [
                'flowchart', 'concept-diagram', 'pharmacology', 'emergency'
            ];
            
            // Add fullscreen buttons to all specified sections
            sectionsWithFullscreen.forEach(sectionId => {
                const section = document.getElementById(sectionId);
                if (section) {
                    // Check if section already has a fullscreen button
                    const existingBtn = section.querySelector('.fullscreen-btn');
                    if (existingBtn) {
                        return; // Skip if button already exists
                    }
                    
                    const fullscreenBtn = document.createElement('button');
                    fullscreenBtn.className = 'fullscreen-btn';
                    fullscreenBtn.innerHTML = '⛶';
                    fullscreenBtn.title = 'Fullscreen';
                    fullscreenBtn.style.marginBottom = '10px';
                    fullscreenBtn.onclick = () => openSectionFullscreen(section, sectionId);
                    
                    // Position button in top right corner of section
                    fullscreenBtn.style.position = 'absolute';
                    fullscreenBtn.style.top = '10px';
                    fullscreenBtn.style.right = '10px';
                    fullscreenBtn.style.zIndex = '10';
                    fullscreenBtn.style.marginLeft = '0';
                    fullscreenBtn.style.marginBottom = '0';
                    
                    // Make section relative positioned to contain the absolute button
                    section.style.position = 'relative';
                    
                    // Insert button at the end of section
                    section.appendChild(fullscreenBtn);
                }
            });
            
            // Add fullscreen buttons to tables (but not if they're inside sections with section-level buttons)
            const tables = document.querySelectorAll('table');
            tables.forEach((table, index) => {
                // Check if this table is inside a section that already has a section-level fullscreen button
                const parentSection = table.closest('section');
                if (parentSection && sectionsWithFullscreen.includes(parentSection.id)) {
                    // Skip adding table-level button for these sections
                    return;
                }
                
                // Check if table already has a fullscreen button
                const existingBtn = table.parentNode.querySelector('.fullscreen-btn');
                if (existingBtn) {
                    return; // Skip if button already exists
                }
                
                const fullscreenBtn = document.createElement('button');
                fullscreenBtn.className = 'fullscreen-btn';
                fullscreenBtn.innerHTML = '⛶';
                fullscreenBtn.title = 'Fullscreen';
                fullscreenBtn.style.marginBottom = '10px';
                fullscreenBtn.onclick = () => openTableFullscreen(table, index);
                
                // Insert button before the table
                table.parentNode.insertBefore(fullscreenBtn, table);
            });
        }
        
        function openSectionFullscreen(section, sectionId) {
            // Create modal
            const modal = document.createElement('div');
            modal.className = 'fullscreen-modal';
            modal.id = `section-fullscreen-modal-${sectionId}`;
            
            // Create content
            const content = document.createElement('div');
            content.className = 'fullscreen-content';
            
            // Create close button
            const closeBtn = document.createElement('button');
            closeBtn.className = 'close-fullscreen';
            closeBtn.innerHTML = '×';
            closeBtn.onclick = () => closeSectionFullscreen(sectionId);
            
            // Clone the section content
            const clonedSection = section.cloneNode(true);
            clonedSection.style.fontSize = '16px';
            clonedSection.style.lineHeight = '1.6';
            
            // Add title
            const title = document.createElement('h3');
            title.textContent = section.querySelector('.section-title')?.textContent || 'Fullscreen View';
            title.style.marginBottom = '20px';
            title.style.color = '#1f2937';
            
            content.appendChild(closeBtn);
            content.appendChild(title);
            content.appendChild(clonedSection);
            modal.appendChild(content);
            
            // Add to page
            document.body.appendChild(modal);
            modal.style.display = 'flex';
            
            // Close on escape key
            const handleEscape = (e) => {
                if (e.key === 'Escape') {
                    closeSectionFullscreen(sectionId);
                    document.removeEventListener('keydown', handleEscape);
                }
            };
            document.addEventListener('keydown', handleEscape);
        }
        
        function closeSectionFullscreen(sectionId) {
            const modal = document.getElementById(`section-fullscreen-modal-${sectionId}`);
            if (modal) {
                modal.remove();
            }
        }
        
        function openTableFullscreen(table, index) {
            // Create modal
            const modal = document.createElement('div');
            modal.className = 'fullscreen-modal';
            modal.id = `table-fullscreen-modal-${index}`;
            
            // Create content
            const content = document.createElement('div');
            content.className = 'fullscreen-content';
            
            // Create close button
            const closeBtn = document.createElement('button');
            closeBtn.className = 'close-fullscreen';
            closeBtn.innerHTML = '×';
            closeBtn.onclick = () => closeTableFullscreen(index);
            
            // Clone the table
            const clonedTable = table.cloneNode(true);
            clonedTable.style.fontSize = '16px';
            clonedTable.style.width = '100%';
            clonedTable.style.borderCollapse = 'collapse';
            
            // Add title
            const title = document.createElement('h3');
            title.textContent = 'Table - Fullscreen View';
            title.style.marginBottom = '20px';
            title.style.color = '#1f2937';
            
            content.appendChild(closeBtn);
            content.appendChild(title);
            content.appendChild(clonedTable);
            modal.appendChild(content);
            
            // Add to page
            document.body.appendChild(modal);
            modal.style.display = 'flex';
            
            // Close on escape key
            const handleEscape = (e) => {
                if (e.key === 'Escape') {
                    closeTableFullscreen(index);
                    document.removeEventListener('keydown', handleEscape);
                }
            };
            document.addEventListener('keydown', handleEscape);
        }
        
        function closeTableFullscreen(index) {
            const modal = document.getElementById(`table-fullscreen-modal-${index}`);
            if (modal) {
                modal.remove();
            }
        }
        
        // Reading progress functionality
        function initReadingProgress() {
            const progressBar = document.getElementById('reading-progress');
            const content = document.querySelector('article');
            
            if (!progressBar || !content) return;
            
            window.addEventListener('scroll', () => {
                const scrollTop = window.pageYOffset;
                const docHeight = document.body.scrollHeight - window.innerHeight;
                const scrollPercent = (scrollTop / docHeight) * 100;
                progressBar.style.width = scrollPercent + '%';
            });
        }
        
        // Print article functionality
        function printArticle() {
            const article = document.getElementById('printable-content');
            if (!article) {
                console.error('Article content not found');
                return;
            }
            
            // Expand all accordions before printing
            expandAllAccordions();
            
            // Wait a moment for accordions to expand, then proceed with printing
            setTimeout(() => {
                // Create a new window for printing
                const printWindow = window.open('', '_blank', 'width=800,height=600');
                
                // Get the article content after accordions are expanded
                const articleContent = article.innerHTML;
            
            // Create the print document
            const printDocument = `
                <!DOCTYPE html>
                <html>
                <head>
                    <title>Print - {{ $topic->title }}</title>
                    <style>
                        body {
                            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
                            line-height: 1.6;
                            color: #333;
                            max-width: 800px;
                            margin: 0 auto;
                            padding: 20px;
                        }
                        h1, h2, h3, h4, h5, h6 {
                            color: #1a1a1a;
                            margin-top: 1.5em;
                            margin-bottom: 0.5em;
                        }
                        h1 { font-size: 2em; }
                        h2 { font-size: 1.5em; }
                        h3 { font-size: 1.25em; }
                        p {
                            margin-bottom: 1em;
                            text-align: justify;
                        }
                        ul, ol {
                            margin-bottom: 1em;
                            padding-left: 2em;
                        }
                        li {
                            margin-bottom: 0.5em;
                        }
                        blockquote {
                            border-left: 4px solid #3b82f6;
                            padding-left: 1em;
                            margin: 1em 0;
                            font-style: italic;
                            background: #f8fafc;
                            padding: 1em;
                        }
                        code {
                            background: #f1f5f9;
                            padding: 0.2em 0.4em;
                            border-radius: 3px;
                            font-family: 'Courier New', monospace;
                        }
                        pre {
                            background: #1e293b;
                            color: #e2e8f0;
                            padding: 1em;
                            border-radius: 5px;
                            overflow-x: auto;
                            margin: 1em 0;
                        }
                        pre code {
                            background: transparent;
                            padding: 0;
                        }
                        table {
                            width: 100%;
                            border-collapse: collapse;
                            margin: 1em 0;
                        }
                        th, td {
                            border: 1px solid #ddd;
                            padding: 0.5em;
                            text-align: left;
                        }
                        th {
                            background: #f8fafc;
                            font-weight: bold;
                        }
                        .print-header {
                            text-align: center;
                            margin-bottom: 2em;
                            padding-bottom: 1em;
                            border-bottom: 2px solid #3b82f6;
                        }
                        .print-title {
                            font-size: 2.5em;
                            font-weight: bold;
                            color: #1a1a1a;
                            margin-bottom: 0.5em;
                        }
                        .print-subtitle {
                            color: #666;
                            font-size: 1.1em;
                        }
                        .print-date {
                            color: #888;
                            font-size: 0.9em;
                            margin-top: 1em;
                        }
                        @media print {
                            body { margin: 0; padding: 15px; }
                            .print-header { page-break-after: avoid; }
                            h1, h2, h3 { page-break-after: avoid; }
                            pre, blockquote { page-break-inside: avoid; }
                        }
                    </style>
                </head>
                <body>
                    <div class="print-header">
                        <div class="print-title">{{ $topic->title }}</div>
                        <div class="print-subtitle">{{ config('app.name', 'NephroCoach') }} - {{ content('site_tagline', 'Expert Medical Training Platform') }}</div>
                        <div class="print-date">Printed on: ${new Date().toLocaleDateString()}</div>
                    </div>
                    <div class="article-content">
                        ${articleContent}
                    </div>
                </body>
                </html>
            `;
            
            // Write the content to the new window
            printWindow.document.write(printDocument);
            printWindow.document.close();
            
                // Wait for content to load, then print
                printWindow.onload = function() {
                    printWindow.focus();
                    printWindow.print();
                    
                    // Close the window after printing (optional)
                    printWindow.onafterprint = function() {
                        printWindow.close();
                    };
                };
            }, 500); // Wait 500ms for accordions to expand
        }
        
        // Function to expand all accordions on the page
        function expandAllAccordions() {
            // Handle different types of accordions that might be on the page
            
            // 1. Bootstrap accordions
            const bootstrapAccordions = document.querySelectorAll('.accordion-collapse');
            bootstrapAccordions.forEach(accordion => {
                if (accordion.classList.contains('collapse')) {
                    accordion.classList.remove('collapse');
                    accordion.classList.add('show');
                }
            });
            
            // 2. Custom accordions with data attributes
            const customAccordions = document.querySelectorAll('[data-bs-toggle="collapse"]');
            customAccordions.forEach(button => {
                const target = button.getAttribute('data-bs-target') || button.getAttribute('href');
                if (target) {
                    const targetElement = document.querySelector(target);
                    if (targetElement && targetElement.classList.contains('collapse')) {
                        targetElement.classList.remove('collapse');
                        targetElement.classList.add('show');
                    }
                }
            });
            
            // 3. Alpine.js accordions
            const alpineAccordions = document.querySelectorAll('[x-data]');
            alpineAccordions.forEach(element => {
                if (element._x_dataStack && element._x_dataStack[0]) {
                    const data = element._x_dataStack[0];
                    // Look for common accordion properties
                    if (data.hasOwnProperty('open')) {
                        data.open = true;
                    }
                    if (data.hasOwnProperty('expanded')) {
                        data.expanded = true;
                    }
                    if (data.hasOwnProperty('show')) {
                        data.show = true;
                    }
                }
            });
            
            // 4. Generic accordions with hidden content
            const hiddenContent = document.querySelectorAll('.accordion-content, .collapsible-content, .expandable-content');
            hiddenContent.forEach(content => {
                if (content.style.display === 'none' || content.classList.contains('hidden')) {
                    content.style.display = 'block';
                    content.classList.remove('hidden');
                    content.classList.add('show');
                }
            });
            
            // 5. Details/Summary elements
            const detailsElements = document.querySelectorAll('details');
            detailsElements.forEach(details => {
                details.open = true;
            });
            
            console.log('All accordions expanded for printing');
        }
        
    </script>
    @endpush
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            // Floating Quick Navigation Scroll Spy
            const floatingNavLinks = document.querySelectorAll('#floating-quick-navigation .nav-link');
            const mainContent = document.querySelector('main');
            
            if (floatingNavLinks.length > 0 && mainContent) {
                let ticking = false;
                
                function updateActiveNavItem() {
                    if (!ticking) {
                        requestAnimationFrame(() => {
                            const sections = Array.from(floatingNavLinks).map(link => {
                                const targetId = link.getAttribute('data-section');
                                const targetElement = document.getElementById(targetId);
                                return { link, element: targetElement, id: targetId };
                            }).filter(item => item.element);

                            // Find the section that's currently in view
                            let currentSection = null;
                            const scrollPosition = mainContent.scrollTop + 100; // offset for header
                            
                            sections.forEach(section => {
                                const rect = section.element.getBoundingClientRect();
                                const mainContentRect = mainContent.getBoundingClientRect();
                                
                                // Check if section is in the viewport
                                const sectionTop = rect.top - mainContentRect.top;
                                const sectionBottom = rect.bottom - mainContentRect.top;
                                
                                if (sectionTop <= 100 && sectionBottom >= 0) {
                                    currentSection = section;
                                }
                            });

                            // Update active states
                            floatingNavLinks.forEach(link => {
                                link.classList.remove('bg-blue-500', 'text-white');
                                link.classList.add('text-slate-700', 'hover:bg-slate-100');
                                
                                const iconContainer = link.querySelector('.w-10.h-10');
                                const svg = link.querySelector('svg');
                                if (iconContainer && svg) {
                                    iconContainer.classList.remove('bg-white/20');
                                    iconContainer.classList.add('bg-slate-100');
                                    svg.classList.remove('text-white');
                                    svg.classList.add('text-slate-600');
                                }
                            });

                            if (currentSection) {
                                currentSection.link.classList.remove('text-slate-700', 'hover:bg-slate-100');
                                currentSection.link.classList.add('bg-blue-500', 'text-white');
                                
                                const iconContainer = currentSection.link.querySelector('.w-10.h-10');
                                const svg = currentSection.link.querySelector('svg');
                                if (iconContainer && svg) {
                                    iconContainer.classList.remove('bg-slate-100');
                                    iconContainer.classList.add('bg-white/20');
                                    svg.classList.remove('text-slate-600');
                                    svg.classList.add('text-white');
                                }
                            }
                            
                            ticking = false;
                        });
                        ticking = true;
                    }
                }

                // Add scroll listener to main content
                mainContent.addEventListener('scroll', updateActiveNavItem);
                
                // Initial update
                setTimeout(updateActiveNavItem, 100);

                // Add smooth scroll behavior to nav links
                floatingNavLinks.forEach(link => {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();
                        const targetId = this.getAttribute('data-section');
                        const targetElement = document.getElementById(targetId);
                        
                        console.log('Clicking floating nav link for:', targetId);
                        console.log('Target element:', targetElement);
                        
                        if (targetElement) {
                            // Try scrollIntoView first (simpler approach)
                            try {
                                targetElement.scrollIntoView({
                                    behavior: 'smooth',
                                    block: 'start',
                                    inline: 'nearest'
                                });
                                console.log('Used scrollIntoView for:', targetId);
                            } catch (error) {
                                console.log('scrollIntoView failed, trying manual scroll');
                                // Fallback: Calculate the exact position relative to the main content container
                                const mainContentRect = mainContent.getBoundingClientRect();
                                const targetRect = targetElement.getBoundingClientRect();
                                const currentScrollTop = mainContent.scrollTop;
                                
                                // Calculate relative position
                                const relativeTop = targetRect.top - mainContentRect.top;
                                const targetScrollTop = currentScrollTop + relativeTop - 100; // 100px offset for header
                                
                                // Smooth scroll to the calculated position
                                mainContent.scrollTo({
                                    top: targetScrollTop,
                                    behavior: 'smooth'
                                });
                                console.log('Used manual scroll for:', targetId);
                            }
                        }
                    });
                });
            }

            // Keyboard shortcuts for floating navigation
            document.addEventListener('keydown', function(e) {
                // Ctrl/Cmd + N to toggle floating navigation
                if ((e.ctrlKey || e.metaKey) && e.key === 'n') {
                    e.preventDefault();
                    const floatingNav = document.querySelector('[x-data]');
                    if (floatingNav && floatingNav._x_dataStack && floatingNav._x_dataStack[0]) {
                        floatingNav._x_dataStack[0].open = !floatingNav._x_dataStack[0].open;
                    }
                }
                
                // Escape to close floating navigation
                if (e.key === 'Escape') {
                    const floatingNav = document.querySelector('[x-data]');
                    if (floatingNav && floatingNav._x_dataStack && floatingNav._x_dataStack[0]) {
                        floatingNav._x_dataStack[0].open = false;
                    }
                }
            });


            // Floating navigation button functionality
            const floatingNavBtn = document.getElementById('floating-nav-btn');
            const navOverlay = document.getElementById('nav-overlay');
            const closeNavBtn = document.getElementById('close-nav');
            
            if (floatingNavBtn && navOverlay) {
                floatingNavBtn.addEventListener('click', function() {
                    navOverlay.style.display = 'block';
                    // Add fade-in animation
                    navOverlay.style.opacity = '0';
                    setTimeout(() => {
                        navOverlay.style.transition = 'all 0.3s ease';
                        navOverlay.style.opacity = '1';
                    }, 10);
                });
            }
            
            if (closeNavBtn && navOverlay) {
                closeNavBtn.addEventListener('click', function() {
                    // Add fade-out animation
                    navOverlay.style.transition = 'all 0.3s ease';
                    navOverlay.style.opacity = '0';
                    setTimeout(() => {
                        navOverlay.style.display = 'none';
                    }, 300);
                });
            }
            
            // Close overlay when clicking outside
            if (navOverlay) {
                navOverlay.addEventListener('click', function(e) {
                    if (e.target === navOverlay) {
                        // Close immediately - no animations
                        navOverlay.style.display = 'none';
                    }
                });
            }
            
            // Handle navigation item clicks - no animations for maximum performance
            const navItems = document.querySelectorAll('.nav-item');
            navItems.forEach((item) => {
                item.addEventListener('click', function(e) {
                    e.preventDefault();
                    const targetId = this.getAttribute('data-section');
                    const targetElement = document.getElementById(targetId);
                    
                    if (targetElement) {
                        // Add click animation
                        this.style.transform = 'scale(0.95)';
                        setTimeout(() => {
                            this.style.transform = 'scale(1.02)';
                        }, 100);
                        
                        // Close overlay with animation
                        setTimeout(() => {
                            navOverlay.style.transition = 'all 0.3s ease';
                            navOverlay.style.opacity = '0';
                            setTimeout(() => {
                                navOverlay.style.display = 'none';
                                
                                // Smooth scroll to section
                                targetElement.scrollIntoView({
                                    behavior: 'smooth',
                                    block: 'start'
                                });
                            }, 300);
                        }, 200);
                    }
                });
            });
            
            // Keyboard shortcuts
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && navOverlay.style.display === 'block') {
                    // Close with animation
                    navOverlay.style.transition = 'all 0.3s ease';
                    navOverlay.style.opacity = '0';
                    setTimeout(() => {
                        navOverlay.style.display = 'none';
                    }, 300);
                }
            });

        });
    </script>
</x-app-layout>