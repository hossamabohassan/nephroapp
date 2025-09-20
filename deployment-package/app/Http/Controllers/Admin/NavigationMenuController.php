<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NavigationMenuItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NavigationMenuController extends Controller
{
    public function index(): View
    {
        $menuItems = NavigationMenuItem::orderBy('sort_order')->get();
        return view('admin.navigation-menu.index', [
            'menuItems' => $menuItems,
        ]);
    }

    public function create(): View
    {
        return view('admin.navigation-menu.create');
    }

    public function edit(NavigationMenuItem $navigation_menu): View
    {
        return view('admin.navigation-menu.edit', [
            'menuItem' => $navigation_menu,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'icon' => 'nullable|string',
            'url' => 'nullable|string|max:255',
            'route_name' => 'nullable|string|max:255',
            'type' => 'required|in:link,dropdown,separator',
            'dropdown_items' => 'nullable|array',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
            'target' => 'in:_self,_blank',
            'css_class' => 'nullable|string|max:255',
            'permission' => 'required|in:public,editor,admin',
        ]);

        NavigationMenuItem::create($validated);

        return redirect()
            ->route('admin.navigation-menu.index')
            ->with('success', 'Menu item created successfully.');
    }

    public function update(Request $request, NavigationMenuItem $navigation_menu): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'icon' => 'nullable|string',
            'url' => 'nullable|string|max:255',
            'route_name' => 'nullable|string|max:255',
            'type' => 'required|in:link,dropdown,separator',
            'dropdown_items' => 'nullable|array',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
            'target' => 'in:_self,_blank',
            'css_class' => 'nullable|string|max:255',
            'permission' => 'required|in:public,editor,admin',
        ]);

        $navigation_menu->update($validated);

        return redirect()
            ->route('admin.navigation-menu.index')
            ->with('success', 'Menu item updated successfully.');
    }

    public function destroy(NavigationMenuItem $navigation_menu): RedirectResponse
    {
        $navigation_menu->delete();

        return redirect()
            ->route('admin.navigation-menu.index')
            ->with('success', 'Menu item deleted successfully.');
    }

    public function reset(): RedirectResponse
    {
        // Clear existing menu items
        NavigationMenuItem::truncate();

        // Initialize default menu items
        $this->initializeDefaultMenuItems();

        return redirect()
            ->route('admin.navigation-menu.index')
            ->with('success', 'Navigation menu reset to default successfully.');
    }

    private function initializeDefaultMenuItems(): void
    {
        $defaultMenuItems = [
            [
                'title' => 'Topics',
                'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>',
                'route_name' => 'topics.index',
                        'type' => 'link',
                        'is_active' => true,
                        'sort_order' => 1,
                        'target' => '_self',
                        'permission' => 'public',
                        'permission' => 'public',
            ],
            [
                'title' => 'Profile',
                'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>',
                'route_name' => 'profile.edit',
                'type' => 'link',
                'is_active' => true,
                'sort_order' => 2,
                'target' => '_self',
            ],
            [
                'title' => 'Favorites',
                'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>',
                'route_name' => 'profile.favorites',
                'type' => 'link',
                'is_active' => true,
                'sort_order' => 3,
                'target' => '_self',
            ],
            [
                'title' => 'Completed',
                'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
                'route_name' => 'profile.completed',
                'type' => 'link',
                'is_active' => true,
                'sort_order' => 4,
                'target' => '_self',
            ],
            [
                'title' => 'Settings',
                'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>',
                'route_name' => 'profile.edit',
                'type' => 'link',
                'is_active' => true,
                'sort_order' => 5,
                'target' => '_self',
            ],
        ];

        foreach ($defaultMenuItems as $menuItemData) {
            NavigationMenuItem::create($menuItemData);
        }
    }
}