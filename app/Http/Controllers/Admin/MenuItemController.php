<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MenuItemRequest;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class MenuItemController extends Controller
{
    public function index(): View
    {
        $menuItems = MenuItem::query()
            ->orderBy('order')
            ->orderBy('id')
            ->get();

        return view('admin.menu-items.index', compact('menuItems'));
    }

    public function create(): View
    {
        return view('admin.menu-items.create');
    }

    public function store(MenuItemRequest $request): RedirectResponse
    {
        MenuItem::create($request->validated());

        return redirect()
            ->route('admin.menu-items.index')
            ->with('success', 'Menu item created successfully.');
    }

    public function show(MenuItem $menuItem): View
    {
        return view('admin.menu-items.show', compact('menuItem'));
    }

    public function edit(MenuItem $menuItem): View
    {
        return view('admin.menu-items.edit', compact('menuItem'));
    }

    public function update(MenuItemRequest $request, MenuItem $menuItem): RedirectResponse
    {
        $menuItem->update($request->validated());

        return redirect()
            ->route('admin.menu-items.index')
            ->with('success', 'Menu item updated successfully.');
    }

    public function destroy(MenuItem $menuItem): RedirectResponse
    {
        $menuItem->delete();

        return redirect()
            ->route('admin.menu-items.index')
            ->with('success', 'Menu item deleted successfully.');
    }
}