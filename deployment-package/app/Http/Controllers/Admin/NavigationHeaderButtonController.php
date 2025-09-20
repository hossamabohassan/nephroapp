<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NavigationHeaderButton;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NavigationHeaderButtonController extends Controller
{
    public function index(): View
    {
        $headerButtons = NavigationHeaderButton::orderBy('sort_order')->get();
        return view('admin.navigation-header-buttons.index', [
            'headerButtons' => $headerButtons,
        ]);
    }

    public function create(): View
    {
        return view('admin.navigation-header-buttons.create');
    }

    public function edit(NavigationHeaderButton $navigation_header_button): View
    {
        return view('admin.navigation-header-buttons.edit', [
            'headerButton' => $navigation_header_button,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'icon' => 'nullable|string',
            'url' => 'nullable|string|max:255',
            'route_name' => 'nullable|string|max:255',
            'type' => 'required|in:button,dropdown,modal',
            'dropdown_items' => 'nullable|array',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
            'target' => 'in:_self,_blank,modal',
            'css_class' => 'nullable|string|max:255',
            'badge_text' => 'nullable|string|max:10',
            'badge_color' => 'in:red,blue,green,yellow,purple,pink,indigo,gray',
            'show_badge' => 'boolean',
            'permission' => 'required|in:public,editor,admin',
        ]);

        NavigationHeaderButton::create($validated);

        return redirect()
            ->route('admin.navigation-header-buttons.index')
            ->with('success', 'Header button created successfully.');
    }

    public function update(Request $request, NavigationHeaderButton $navigation_header_button): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'icon' => 'nullable|string',
            'url' => 'nullable|string|max:255',
            'route_name' => 'nullable|string|max:255',
            'type' => 'required|in:button,dropdown,modal',
            'dropdown_items' => 'nullable|array',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
            'target' => 'in:_self,_blank,modal',
            'css_class' => 'nullable|string|max:255',
            'badge_text' => 'nullable|string|max:10',
            'badge_color' => 'in:red,blue,green,yellow,purple,pink,indigo,gray',
            'show_badge' => 'boolean',
            'permission' => 'required|in:public,editor,admin',
        ]);

        $navigation_header_button->update($validated);

        return redirect()
            ->route('admin.navigation-header-buttons.index')
            ->with('success', 'Header button updated successfully.');
    }

    public function destroy(NavigationHeaderButton $navigation_header_button): RedirectResponse
    {
        $navigation_header_button->delete();

        return redirect()
            ->route('admin.navigation-header-buttons.index')
            ->with('success', 'Header button deleted successfully.');
    }

    public function reset(): RedirectResponse
    {
        // Clear existing header buttons
        NavigationHeaderButton::truncate();

        // Initialize default header buttons
        $this->initializeDefaultHeaderButtons();

        return redirect()
            ->route('admin.navigation-header-buttons.index')
            ->with('success', 'Header buttons reset to default successfully.');
    }

    private function initializeDefaultHeaderButtons(): void
    {
        $defaultButtons = [
            [
                'title' => 'Notifications',
                'icon' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5-5-5 5h5zm0 0v1a3 3 0 01-6 0v-1m6 0V9a3 3 0 00-6 0v8"/></svg>',
                'type' => 'button',
                'is_active' => true,
                'sort_order' => 1,
                'target' => '_self',
                'show_badge' => true,
                'badge_text' => '',
                'badge_color' => 'red',
                'permission' => 'public',
            ],
            [
                'title' => 'Settings',
                'icon' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>',
                'route_name' => 'profile.edit',
                'type' => 'button',
                'is_active' => true,
                'sort_order' => 2,
                'target' => '_self',
                'show_badge' => false,
                'permission' => 'public',
            ],
        ];

        foreach ($defaultButtons as $buttonData) {
            NavigationHeaderButton::create($buttonData);
        }
    }
}