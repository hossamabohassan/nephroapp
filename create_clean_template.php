<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Creating clean template...\n";

$template = \App\Models\LayoutTemplate::find(9);

if ($template) {
    // Create a completely clean HTML template
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
    
    echo "Clean template created and saved!\n";
    
    // Test the render
    $rendered = $template->render();
    echo "Testing render...\n";
    
    $testHtml = $rendered['html'];
    if (strpos($testHtml, 'MyWebsite') !== false && strpos($testHtml, '{MyWebsite}') === false) {
        echo "SUCCESS: Variables are properly replaced!\n";
    } else {
        echo "Still has issues. Let's check what's in the rendered HTML:\n";
        echo "Contains 'MyWebsite': " . (strpos($testHtml, 'MyWebsite') !== false ? 'YES' : 'NO') . "\n";
        echo "Contains '{MyWebsite}': " . (strpos($testHtml, '{MyWebsite}') !== false ? 'YES' : 'NO') . "\n";
        echo "Contains '{{site_name}}': " . (strpos($testHtml, '{{site_name}}') !== false ? 'YES' : 'NO') . "\n";
    }
} else {
    echo "Template not found!\n";
}

