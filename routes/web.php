<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TopicController as AdminTopicController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TopicController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // Check if we have custom HTML content in the database
    $customHtml = \App\Models\PageContent::getLandingPageHtml();
    
    // Debug: Log what we found
    \Log::info('Landing page route - Custom HTML length: ' . strlen($customHtml));
    
    if (!empty($customHtml)) {
        // Use the custom landing view that will render the HTML content
        \Log::info('Using custom landing page content');
        return view('landing-custom', ['customHtml' => $customHtml]);
    }
    
    // Fallback to the original blade view
    \Log::info('Using original landing page view');
    return view('landing');
})->name('landing');

Route::get('test-landing', function() {
    $html = \App\Models\PageContent::getLandingPageHtml();
    $dbRecord = \App\Models\PageContent::where('key', 'landing_page_html')->first();
    
    return response()->json([
        'has_content' => !empty($html),
        'content_length' => strlen($html),
        'first_200_chars' => substr($html, 0, 200),
        'contains_blade' => strpos($html, '{{') !== false,
        'db_record_exists' => $dbRecord ? true : false,
        'db_record_updated' => $dbRecord ? $dbRecord->updated_at : null,
        'current_time' => now()
    ]);
});

Route::get('debug/profile-favorites', function() {
    $templateService = new \App\Services\TemplateService();
    $template = $templateService->getTemplateForPage('profile/favorites');
    
    return response()->json([
        'template_found' => $template ? true : false,
        'template_id' => $template ? $template->id : null,
        'template_name' => $template ? $template->name : null,
        'template_variables' => $template ? $template->variables : null,
        'assignment_setting' => \App\Models\Setting::where('key', 'template_assignment')->first()?->value
    ]);
})->name('debug.profile-favorites');

Route::get('fix-template', function() {
    $template = \App\Models\LayoutTemplate::find(9);
    
    if ($template) {
        // Create clean HTML with proper double braces
        $cleanHtml = '<div class="bg-gray-50 min-h-screen font-sans text-gray-800">
  <header class="bg-white shadow-md sticky top-0 z-50">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex items-center justify-between h-20">
        <div class="flex-shrink-0">
          <a href="/" class="flex items-center space-x-2">
            <img class="h-10 w-auto" src="{{logo_url}}" alt="{{site_name}} Logo">
            <span class="text-xl font-bold text-gray-900">{{site_name}}</span>
          </a>
        </div>
        <nav class="hidden md:flex space-x-8">
          {{nav_items}}
        </nav>
        <div class="md:hidden flex items-center">
          <button id="mobile-menu-button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-500 hover:text-gray-700 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500" aria-expanded="false">
            <span class="sr-only">Open main menu</span>
            <svg id="menu-closed-icon" class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
            <svg id="menu-open-icon" class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
          </button>
        </div>
      </div>
    </div>
    <div id="mobile-menu" class="hidden md:hidden">
      <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
        {{nav_items}}
      </div>
    </div>
  </header>

  <main class="animate-fade-in">
    <div class="bg-gradient-to-r from-indigo-500 to-purple-600">
      <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-16 text-center">
        <h1 class="text-4xl md:text-5xl font-extrabold text-white tracking-tight">{{page_title}}</h1>
        <div class="mt-4 text-indigo-200">{{breadcrumbs}}</div>
      </div>
    </div>
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
      <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-lg">
        {{content}}
      </div>
    </div>
  </main>

  <footer class="bg-gray-800 text-white mt-12">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-10">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center md:text-left">
        <div>
          <h3 class="text-lg font-semibold mb-3">{{site_name}}</h3>
          <div class="text-gray-400">{{footer_content}}</div>
        </div>
        <div>
          <h3 class="text-lg font-semibold mb-3">Quick Links</h3>
          <ul class="space-y-2 text-gray-400">
            {{nav_items}}
          </ul>
        </div>
        <div>
          <h3 class="text-lg font-semibold mb-3">Contact Us</h3>
          <p class="text-gray-400">{{contact_address}}</p>
          <p class="text-gray-400">{{contact_email}}</p>
        </div>
      </div>
      <div class="mt-8 border-t border-gray-700 pt-6 text-center text-gray-500 text-sm">
        <p>&copy; {{current_year}} {{site_name}}. All Rights Reserved.</p>
      </div>
    </div>
  </footer>
</div>';

        $template->html_content = $cleanHtml;
        $template->save();
        
        return response()->json([
            'success' => true,
            'message' => 'Template fixed successfully!',
            'template_id' => $template->id,
            'template_name' => $template->name
        ]);
    }
    
    return response()->json([
        'success' => false,
        'message' => 'Template not found!'
    ]);
})->name('fix-template');

Route::middleware(['auth', 'verified', 'active'])->group(function () {
    Route::resource('topics', TopicController::class)
        ->only(['index', 'show'])
        ->scoped(['topic' => 'slug']);

    Route::get('/dashboard', function () {
        return redirect()->route('topics.index');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');


    Route::get('/profile/favorites', [ProfileController::class, 'favorites'])->name('profile.favorites');
    Route::get('/profile/completed', [ProfileController::class, 'completed'])->name('profile.completed');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // User preferences API routes (session-based auth)
    Route::prefix('api/user')->name('api.user.')->group(function () {
        Route::post('topics/{topic}/favorite', [\App\Http\Controllers\Api\UserPreferencesController::class, 'toggleFavorite'])
            ->name('toggle-favorite');
        Route::post('topics/{topic}/completed', [\App\Http\Controllers\Api\UserPreferencesController::class, 'toggleCompleted'])
            ->name('toggle-completed');
        Route::get('topics/{topic}/status', [\App\Http\Controllers\Api\UserPreferencesController::class, 'getTopicStatus'])
            ->name('topic-status');
        Route::put('topics/{topic}/completed/notes', [\App\Http\Controllers\Api\UserPreferencesController::class, 'updateCompletedNotes'])
            ->name('update-completed-notes');
        
        Route::get('favorites', [\App\Http\Controllers\Api\UserPreferencesController::class, 'getFavorites'])
            ->name('favorites');
        Route::get('completed', [\App\Http\Controllers\Api\UserPreferencesController::class, 'getCompleted'])
            ->name('completed');
        Route::get('stats', [\App\Http\Controllers\Api\UserPreferencesController::class, 'getStats'])
            ->name('stats');
    });
});

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'verified', 'active', 'can:access-admin'])
    ->group(function () {
        Route::get('/', DashboardController::class)->name('dashboard');

        Route::post('topics/preview', [AdminTopicController::class, 'preview'])->name('topics.preview');
        Route::post('topics/bulk-action', [AdminTopicController::class, 'bulkAction'])->name('topics.bulk-action');
        Route::get('topics/{topic}/wysiwyg', [AdminTopicController::class, 'wysiwyg'])->name('topics.wysiwyg');
        Route::post('topics/{topic}/wysiwyg', [AdminTopicController::class, 'wysiwygUpdate'])->name('topics.wysiwyg.update');

        Route::resource('topics', AdminTopicController::class)
            ->scoped(['topic' => 'slug']);

        Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);

        Route::resource('menu-items', \App\Http\Controllers\Admin\MenuItemController::class);
        
        // Template assignment routes (must be before resource routes)
        Route::get('templates/assign', [\App\Http\Controllers\Admin\TemplateController::class, 'showAssign'])->name('templates.assign.show');
        Route::post('templates/assign', [\App\Http\Controllers\Admin\TemplateController::class, 'assign'])->name('templates.assign');
        Route::delete('templates/unassign', [\App\Http\Controllers\Admin\TemplateController::class, 'unassign'])->name('templates.unassign');
        
        Route::resource('templates', \App\Http\Controllers\Admin\TemplateController::class);
        Route::get('templates/{template}/preview', [\App\Http\Controllers\Admin\TemplateController::class, 'preview'])->name('templates.preview');
        Route::get('templates/{template}/interactive-preview', [\App\Http\Controllers\Admin\TemplateController::class, 'interactivePreview'])->name('templates.interactive-preview');
        Route::post('templates/{template}/save-preview', [\App\Http\Controllers\Admin\TemplateController::class, 'savePreview'])->name('templates.save-preview');
Route::get('templates/{template}/debug', function(\App\Models\LayoutTemplate $template) {
    return response()->json([
        'template_id' => $template->id,
        'template_variables' => $template->variables,
        'variables_count' => $template->variables ? count($template->variables) : 0,
        'updated_at' => $template->updated_at
    ]);
})->name('templates.debug');

        Route::get('content', [\App\Http\Controllers\Admin\ContentController::class, 'index'])->name('content.index');
        Route::post('content', [\App\Http\Controllers\Admin\ContentController::class, 'update'])->name('content.update');

        Route::get('navigation-sections', [\App\Http\Controllers\Admin\NavigationSectionController::class, 'index'])->name('navigation-sections.index');
        Route::post('navigation-sections', [\App\Http\Controllers\Admin\NavigationSectionController::class, 'update'])->name('navigation-sections.update');
        Route::post('navigation-sections/reset', [\App\Http\Controllers\Admin\NavigationSectionController::class, 'reset'])->name('navigation-sections.reset');
        
        // Navigation Menu Management
        Route::resource('navigation-menu', \App\Http\Controllers\Admin\NavigationMenuController::class);
        Route::post('navigation-menu/reset', [\App\Http\Controllers\Admin\NavigationMenuController::class, 'reset'])->name('navigation-menu.reset');
        
        // Navigation Header Buttons Management
        Route::resource('navigation-header-buttons', \App\Http\Controllers\Admin\NavigationHeaderButtonController::class);
        Route::post('navigation-header-buttons/reset', [\App\Http\Controllers\Admin\NavigationHeaderButtonController::class, 'reset'])->name('navigation-header-buttons.reset');

        Route::get('settings', [\App\Http\Controllers\Admin\SettingsController::class, 'index'])->name('settings.index');
        Route::post('settings', [\App\Http\Controllers\Admin\SettingsController::class, 'update'])->name('settings.update');
        Route::post('settings/google-auth', [\App\Http\Controllers\Admin\SettingsController::class, 'updateGoogleAuth'])->name('settings.google-auth.update');

        Route::get('activity', [\App\Http\Controllers\Admin\ActivityController::class, 'index'])->name('activity.index');
        Route::get('permissions', [\App\Http\Controllers\Admin\PermissionController::class, 'index'])->name('permissions.index');

        Route::put('users/auth-settings', [AdminUserController::class, 'updateAuthSettings'])->name('users.auth-settings.update');

        Route::resource('users', AdminUserController::class)
            ->except(['show']);

        // Landing Page Management
        Route::get('landing-page', [\App\Http\Controllers\Admin\LandingPageController::class, 'index'])->name('landing-page.index');
        Route::post('landing-page', [\App\Http\Controllers\Admin\LandingPageController::class, 'update'])->name('landing-page.update');
        Route::post('landing-page/preview', [\App\Http\Controllers\Admin\LandingPageController::class, 'preview'])->name('landing-page.preview');
        Route::post('landing-page/reset', [\App\Http\Controllers\Admin\LandingPageController::class, 'reset'])->name('landing-page.reset');
    });

require __DIR__.'/auth.php';
