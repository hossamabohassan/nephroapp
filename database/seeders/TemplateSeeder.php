<?php

namespace Database\Seeders;

use App\Models\LayoutTemplate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a modern profile template
        LayoutTemplate::create([
            'name' => 'Modern Profile Layout',
            'slug' => 'modern-profile',
            'description' => 'A modern, animated profile layout with sidebar and main content area',
            'html_content' => '
                <div class="min-h-screen bg-gradient-to-br from-purple-50 via-pink-50 to-blue-50">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                        <div class="flex flex-col lg:flex-row gap-8">
                            <!-- Sidebar -->
                            <div class="lg:w-64 flex-shrink-0">
                                <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 p-6">
                                    <div class="text-center mb-6">
                                        <div class="relative inline-block">
                                            <div class="w-20 h-20 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center text-white text-2xl font-bold shadow-lg">
                                                {{user_initial}}
                                            </div>
                                            <div class="absolute -top-1 -right-1 w-6 h-6 bg-green-500 rounded-full border-2 border-white"></div>
                                        </div>
                                        <h3 class="mt-4 text-lg font-semibold text-gray-900">{{user_name}}</h3>
                                        <p class="text-sm text-gray-600">{{user_email}}</p>
                                    </div>
                                    
                                    <nav class="space-y-2">
                                        <a href="/profile" class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 transition-colors">
                                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                            Profile
                                        </a>
                                        <a href="/profile/favorites" class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-red-50 transition-colors">
                                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                            </svg>
                                            Favorites
                                            <span class="ml-auto bg-red-500 text-white text-xs px-2 py-1 rounded-full">{{favorites_count}}</span>
                                        </a>
                                        <a href="/profile/completed" class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-green-50 transition-colors">
                                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            Completed
                                            <span class="ml-auto bg-green-500 text-white text-xs px-2 py-1 rounded-full">{{completed_count}}</span>
                                        </a>
                                    </nav>
                                </div>
                            </div>

                            <!-- Main Content -->
                            <div class="flex-1">
                                <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 p-8">
                                    {{content}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            ',
            'css_content' => '
                .animate-fade-in {
                    animation: fadeIn 0.6s ease-in-out;
                }
                
                @keyframes fadeIn {
                    from { opacity: 0; transform: translateY(20px); }
                    to { opacity: 1; transform: translateY(0); }
                }
                
                .hover-lift {
                    transition: transform 0.2s ease-in-out;
                }
                
                .hover-lift:hover {
                    transform: translateY(-2px);
                }
            ',
            'js_content' => '
                // Add some interactive animations
                document.addEventListener("DOMContentLoaded", function() {
                    const cards = document.querySelectorAll(".bg-white");
                    cards.forEach((card, index) => {
                        card.style.animationDelay = `${index * 0.1}s`;
                        card.classList.add("animate-fade-in");
                    });
                });
            ',
            'variables' => [
                'user_name' => 'John Doe',
                'user_email' => 'john@example.com',
                'user_initial' => 'J',
                'favorites_count' => '4',
                'completed_count' => '12',
                'content' => '<h1 class="text-3xl font-bold text-gray-900 mb-6">Welcome to your profile!</h1><p class="text-gray-600">This is a sample template that can be customized through the admin panel.</p>'
            ],
            'category' => 'profile',
            'is_active' => true,
            'is_default' => true,
            'order' => 1
        ]);

        // Create a simple admin template
        LayoutTemplate::create([
            'name' => 'Clean Admin Layout',
            'slug' => 'clean-admin',
            'description' => 'A clean, professional admin layout',
            'html_content' => '
                <div class="min-h-screen bg-gray-100">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                        <div class="bg-white shadow rounded-lg">
                            <div class="px-6 py-4 border-b border-gray-200">
                                <h1 class="text-2xl font-semibold text-gray-900">{{page_title}}</h1>
                                <p class="text-gray-600">{{page_description}}</p>
                            </div>
                            <div class="p-6">
                                {{content}}
                            </div>
                        </div>
                    </div>
                </div>
            ',
            'css_content' => '
                .admin-card {
                    transition: box-shadow 0.2s ease-in-out;
                }
                
                .admin-card:hover {
                    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
                }
            ',
            'js_content' => '',
            'variables' => [
                'page_title' => 'Admin Dashboard',
                'page_description' => 'Manage your application',
                'content' => '<p>Admin content goes here</p>'
            ],
            'category' => 'admin',
            'is_active' => true,
            'is_default' => true,
            'order' => 1
        ]);

        // Create a landing page template
        LayoutTemplate::create([
            'name' => 'Hero Landing Page',
            'slug' => 'hero-landing',
            'description' => 'A modern hero-style landing page template',
            'html_content' => '
                <div class="min-h-screen bg-gradient-to-br from-blue-600 via-purple-600 to-indigo-800">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
                        <div class="text-center">
                            <h1 class="text-4xl md:text-6xl font-bold text-white mb-6">
                                {{hero_title}}
                            </h1>
                            <p class="text-xl text-blue-100 mb-8 max-w-3xl mx-auto">
                                {{hero_subtitle}}
                            </p>
                            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                                <a href="{{cta_primary_link}}" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                                    {{cta_primary_text}}
                                </a>
                                <a href="{{cta_secondary_link}}" class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-600 transition-colors">
                                    {{cta_secondary_text}}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            ',
            'css_content' => '
                .hero-animation {
                    animation: heroFadeIn 1s ease-out;
                }
                
                @keyframes heroFadeIn {
                    from { opacity: 0; transform: translateY(30px); }
                    to { opacity: 1; transform: translateY(0); }
                }
            ',
            'js_content' => '
                document.addEventListener("DOMContentLoaded", function() {
                    const hero = document.querySelector(".text-center");
                    hero.classList.add("hero-animation");
                });
            ',
            'variables' => [
                'hero_title' => 'Welcome to Our Platform',
                'hero_subtitle' => 'Discover amazing features and start your journey with us today.',
                'cta_primary_text' => 'Get Started',
                'cta_primary_link' => '/register',
                'cta_secondary_text' => 'Learn More',
                'cta_secondary_link' => '/about'
            ],
            'category' => 'landing',
            'is_active' => true,
            'is_default' => true,
            'order' => 1
        ]);
    }
}
