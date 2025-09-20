<x-app-layout>
    <x-slot name="header">
        <div class="relative overflow-hidden">
            <!-- Animated Background -->
            <div class="absolute inset-0 bg-gradient-to-r from-red-600 via-pink-600 to-purple-600 opacity-90"></div>
            <div class="absolute inset-0 bg-gradient-to-br from-transparent via-white/10 to-transparent"></div>
            
            <!-- Floating Elements -->
            <div class="absolute top-4 left-4 w-20 h-20 bg-white/20 rounded-full animate-pulse"></div>
            <div class="absolute top-8 right-8 w-16 h-16 bg-white/10 rounded-full animate-bounce"></div>
            <div class="absolute bottom-4 left-1/4 w-12 h-12 bg-white/15 rounded-full animate-ping"></div>
            
            <div class="relative z-10 flex items-center justify-between py-8">
                <div class="text-white">
                    <h2 class="text-3xl font-bold bg-gradient-to-r from-white to-red-100 bg-clip-text text-transparent animate-fade-in">
                        {{ __('My Favorites') }}
                    </h2>
                    <p class="text-red-100 mt-2 animate-slide-up">
                        {{ $stats['favorites_count'] }} favorite topics
                    </p>
                </div>
                
                <!-- Profile Quick Access -->
                <div class="flex items-center space-x-4">
                    <div class="text-right text-white">
                        <div class="text-2xl font-bold">{{ $stats['favorites_count'] }}</div>
                        <div class="text-sm text-red-100">Favorite Topics</div>
                    </div>
                    @if(auth()->user()->avatar)
                        <img class="h-16 w-16 rounded-full object-cover border-4 border-white/30 shadow-2xl animate-pulse" 
                             src="{{ auth()->user()->avatar }}" 
                             alt="{{ auth()->user()->name }}">
                    @else
                        <div class="h-16 w-16 rounded-full flex items-center justify-center text-white text-xl font-bold shadow-2xl animate-pulse"
                             style="background: linear-gradient(135deg, #ef4444 0%, #ec4899 50%, #9333ea 100%);">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </x-slot>

    <div class="min-h-screen bg-gradient-to-br from-red-50 via-pink-50 to-purple-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Main Content -->
            <div class="w-full">
            
            <!-- Database Menu Items Navigation -->
            @if(isset($userMenuItems) && $userMenuItems->count() > 0)
                <div class="mb-8">
                    <div class="bg-white/90 backdrop-blur-lg rounded-2xl shadow-2xl border border-gray-200 p-2">
                        <nav class="flex flex-wrap gap-2 justify-center">
                            @foreach($userMenuItems as $menuItem)
                                <a href="{{ $menuItem->url }}" 
                                   class="group relative flex items-center justify-center px-6 py-4 rounded-xl text-gray-700 font-semibold transition-all duration-300 transform hover:scale-105 hover:shadow-lg hover:text-white"
                                   style="background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);"
                                   onmouseover="this.style.background='linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%)'"
                                   onmouseout="this.style.background='linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%)'"
                                   @if($menuItem->opens_in_new_tab) target="_blank" @endif>
                                    <div class="flex items-center space-x-3">
                                        @if($menuItem->icon === 'home')
                                            <svg class="w-5 h-5 text-indigo-500 group-hover:text-white group-hover:animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                            </svg>
                                        @elseif($menuItem->icon === 'book')
                                            <svg class="w-5 h-5 text-indigo-500 group-hover:text-white group-hover:animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                            </svg>
                                        @elseif($menuItem->icon === 'mail')
                                            <svg class="w-5 h-5 text-indigo-500 group-hover:text-white group-hover:animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                            </svg>
                                        @else
                                            <svg class="w-5 h-5 text-indigo-500 group-hover:text-white group-hover:animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        @endif
                                        <span>{{ $menuItem->title }}</span>
                                        @if($menuItem->opens_in_new_tab)
                                            <svg class="w-4 h-4 text-indigo-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                            </svg>
                                        @endif
                                    </div>
                                    <div class="absolute inset-0 bg-white/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-xl"></div>
                                </a>
                            @endforeach
                        </nav>
                    </div>
                </div>
            @endif

            <!-- Profile Navigation Menu -->
            <div class="mb-12">
                <div class="bg-white/90 backdrop-blur-lg rounded-2xl shadow-2xl border border-gray-200 p-2">
                    <nav class="flex space-x-2">
                        <a href="{{ route('profile.edit') }}" 
                           class="group relative flex-1 flex items-center justify-center px-6 py-4 rounded-xl text-gray-700 font-semibold transition-all duration-300 transform hover:scale-105 hover:shadow-lg hover:text-white"
                           style="background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);"
                           onmouseover="this.style.background='linear-gradient(135deg, #3b82f6 0%, #9333ea 100%)'"
                           onmouseout="this.style.background='linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%)'">
                            <div class="flex items-center space-x-3">
                                <svg class="w-5 h-5 text-blue-500 group-hover:text-white group-hover:animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                <span>Profile</span>
                            </div>
                            <div class="absolute inset-0 bg-white/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-xl"></div>
                        </a>
                        
                        <a href="{{ route('profile.favorites') }}" 
                           class="group relative flex-1 flex items-center justify-center px-6 py-4 rounded-xl text-white font-semibold transition-all duration-300 transform hover:scale-105 hover:shadow-lg"
                           style="background: linear-gradient(135deg, #ef4444 0%, #ec4899 100%);">
                            <div class="flex items-center space-x-3">
                                <svg class="w-5 h-5 group-hover:animate-bounce" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                                </svg>
                                <span>Favorites</span>
                                <span class="text-white text-xs px-3 py-1 rounded-full shadow-lg animate-pulse border" 
                                      style="background-color: #ef4444; border-color: #fca5a5;">{{ $stats['favorites_count'] }}</span>
                            </div>
                            <div class="absolute inset-0 bg-white/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-xl"></div>
                        </a>
                        
                        <a href="{{ route('profile.completed') }}" 
                           class="group relative flex-1 flex items-center justify-center px-6 py-4 rounded-xl text-gray-700 font-semibold transition-all duration-300 transform hover:scale-105 hover:shadow-lg hover:text-white"
                           style="background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);"
                           onmouseover="this.style.background='linear-gradient(135deg, #10b981 0%, #059669 100%)'"
                           onmouseout="this.style.background='linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%)'">
                            <div class="flex items-center space-x-3">
                                <svg class="w-5 h-5 text-green-500 group-hover:text-white group-hover:animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span>Completed</span>
                                <span class="text-white text-xs px-3 py-1 rounded-full shadow-lg animate-pulse border" 
                                      style="background-color: #10b981; border-color: #6ee7b7;">{{ $stats['completed_count'] }}</span>
                            </div>
                            <div class="absolute inset-0 bg-white/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-xl"></div>
                        </a>
                    </nav>
                </div>
            </div>

            <!-- Favorites Overview Card with Animation -->
            <div class="mb-12 animate-fade-in-up">
                <div class="relative overflow-hidden bg-white/95 backdrop-blur-lg rounded-3xl shadow-2xl border border-gray-200">
                    <!-- Animated Background -->
                    <div class="absolute inset-0 bg-gradient-to-br from-red-500/5 via-pink-500/5 to-purple-500/5"></div>
                    <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br from-red-400/10 to-pink-500/10 rounded-full -translate-y-32 translate-x-32 animate-pulse"></div>
                    <div class="absolute bottom-0 left-0 w-48 h-48 bg-gradient-to-tr from-pink-400/10 to-purple-500/10 rounded-full translate-y-24 -translate-x-24 animate-bounce"></div>
                    
                    <div class="relative z-10 p-8">
                        <div class="flex flex-col lg:flex-row items-center space-y-6 lg:space-y-0 lg:space-x-8">
                            <!-- Animated Heart Icon -->
                            <div class="flex-shrink-0 relative">
                                <div class="relative">
                                    <div class="absolute inset-0 bg-gradient-to-r from-red-500 to-pink-600 rounded-full animate-ping opacity-75"></div>
                                    <div class="relative h-32 w-32 rounded-full flex items-center justify-center text-white text-6xl font-bold shadow-2xl animate-pulse"
                                         style="background: linear-gradient(135deg, #ef4444 0%, #ec4899 50%, #9333ea 100%);">
                                        <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Favorites Info with Animation -->
                            <div class="flex-1 text-center lg:text-left">
                                <h1 class="text-4xl font-bold text-gray-900 mb-2 animate-fade-in">
                                    My Favorite Topics
                                </h1>
                                <p class="text-gray-700 text-lg mb-1 animate-slide-up">Topics you've marked as favorites</p>
                                <p class="text-gray-600 text-base mb-4 animate-slide-up">Keep track of your most loved content</p>
                                
                                <div class="flex flex-wrap justify-center lg:justify-start gap-3 mb-6">
                                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium text-white shadow-lg animate-bounce"
                                          style="background: linear-gradient(135deg, #ef4444 0%, #ec4899 100%);">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $stats['favorites_count'] }} Favorites
                                    </span>
                                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium text-white shadow-lg animate-pulse"
                                          style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        {{ $stats['completed_count'] }} Completed
                                    </span>
                                </div>
                            </div>
                            
                            <!-- Animated Stats -->
                            <div class="flex space-x-8">
                                <div class="text-center group">
                                    <div class="text-4xl font-bold text-red-600 group-hover:scale-110 transition-transform duration-300">
                                        {{ $stats['favorites_count'] }}
                                    </div>
                                    <div class="text-sm text-gray-700 font-medium">Favorites</div>
                                    <div class="w-12 h-1 bg-gradient-to-r from-red-500 to-pink-600 rounded-full mx-auto mt-2 animate-pulse"></div>
                                </div>
                                <div class="text-center group">
                                    <div class="text-4xl font-bold text-green-600 group-hover:scale-110 transition-transform duration-300">
                                        {{ $stats['completed_count'] }}
                                    </div>
                                    <div class="text-sm text-gray-700 font-medium">Completed</div>
                                    <div class="w-12 h-1 bg-gradient-to-r from-green-500 to-emerald-600 rounded-full mx-auto mt-2 animate-pulse"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Favorites Content -->
            <div class="animate-fade-in-up">
                <div class="relative overflow-hidden bg-white/95 backdrop-blur-lg rounded-3xl shadow-2xl border border-gray-200">
                    <div class="absolute inset-0 bg-gradient-to-br from-red-500/3 via-pink-500/3 to-purple-500/3"></div>
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-red-400/10 to-pink-500/10 rounded-full -translate-y-16 translate-x-16 animate-pulse"></div>
                    
                    <div class="relative z-10 p-8">
                        <h3 class="text-2xl font-bold text-gray-900 mb-8 text-center">
                            Your Favorite Topics
                        </h3>
                        
                        @if($favorites->count() > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach($favorites as $topic)
                                    <div class="group relative overflow-hidden rounded-2xl p-6 bg-white shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:scale-105 hover:-translate-y-2 border border-gray-200">
                                        <div class="absolute inset-0 bg-gradient-to-br from-red-500/5 to-pink-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                        <div class="relative z-10">
                                            <div class="flex items-center justify-between mb-4">
                                                @if($topic->category)
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium text-white"
                                                          style="background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);">
                                                        {{ $topic->category->name }}
                                                    </span>
                                                @endif
                                                <button class="text-red-500 hover:text-red-700 transition-colors duration-200" 
                                                        onclick="toggleFavorite({{ $topic->id }})">
                                                    <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                                                    </svg>
                                                </button>
                                            </div>
                                            <h4 class="text-lg font-semibold text-gray-900 mb-2 group-hover:text-red-600 transition-colors duration-200">
                                                {{ $topic->title }}
                                            </h4>
                                            @if($topic->excerpt)
                                                <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                                                    {{ $topic->excerpt }}
                                                </p>
                                            @endif
                                            <a href="{{ route('topics.show', $topic->slug) }}" 
                                               class="inline-flex items-center text-red-600 hover:text-red-700 font-medium text-sm transition-colors duration-200">
                                                Read More
                                                <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            
                            <!-- Pagination -->
                            <div class="mt-8">
                                {{ $favorites->links() }}
                            </div>
                        @else
                            <div class="text-center py-12">
                                <div class="text-6xl text-gray-300 mb-4">
                                    <svg class="w-16 h-16 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-semibold text-gray-900 mb-2">No favorites yet</h3>
                                <p class="text-gray-600 mb-6">Start exploring topics and mark your favorites!</p>
                                <a href="{{ route('topics.index') }}" 
                                   class="inline-flex items-center px-6 py-3 rounded-xl text-white font-semibold shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:scale-105"
                                   style="background: linear-gradient(135deg, #ef4444 0%, #ec4899 100%);">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                    Browse Topics
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom CSS for Animations -->
    <style>
        @keyframes fade-in {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes fade-in-up {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes fade-in-left {
            from { opacity: 0; transform: translateX(-30px); }
            to { opacity: 1; transform: translateX(0); }
        }
        
        @keyframes fade-in-right {
            from { opacity: 0; transform: translateX(30px); }
            to { opacity: 1; transform: translateX(0); }
        }
        
        @keyframes slide-up {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .animate-fade-in { animation: fade-in 0.8s ease-out; }
        .animate-fade-in-up { animation: fade-in-up 1s ease-out; }
        .animate-fade-in-left { animation: fade-in-left 1s ease-out; }
        .animate-fade-in-right { animation: fade-in-right 1s ease-out; }
        .animate-slide-up { animation: slide-up 0.6s ease-out; }
        
        .shadow-3xl {
            box-shadow: 0 35px 60px -12px rgba(0, 0, 0, 0.25);
        }
        
        .backdrop-blur-lg {
            backdrop-filter: blur(16px);
        }
        
        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>

    <!-- JavaScript for favorite toggle -->
    <script>
        function toggleFavorite(topicId) {
            fetch(`/api/user/topics/${topicId}/favorite`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Reload the page to update the favorites list
                    window.location.reload();
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    </script>
</x-app-layout>