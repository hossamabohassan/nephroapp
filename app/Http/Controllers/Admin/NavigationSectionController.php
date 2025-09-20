<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NavigationSection;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class NavigationSectionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'active']);
        $this->middleware('can:manage-content');
    }

    public function index(): View
    {
        // Initialize default sections if none exist
        NavigationSection::initializeDefaults();
        
        $sections = NavigationSection::ordered()->get();
        
        return view('admin.navigation-sections.index', [
            'sections' => $sections,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'sections' => 'required|array',
            'sections.*.is_active' => 'nullable',
            'sections.*.sort_order' => 'nullable|integer|min:0',
            'sections.*.title' => 'nullable|string|max:255',
            'sections.*.icon' => 'nullable|string|max:10',
        ]);

        $updatedCount = 0;
        foreach ($validated['sections'] as $id => $data) {
            $section = NavigationSection::find($id);
            if ($section) {
                // Handle checkbox properly - it can be array if both hidden and checkbox are present
                $isActive = false;
                if (isset($data['is_active'])) {
                    if (is_array($data['is_active'])) {
                        // If it's an array, the checkbox was checked (value "1" is present)
                        $isActive = in_array('1', $data['is_active']);
                    } else {
                        // If it's a string, it's either "0" or "1"
                        $isActive = $data['is_active'] === '1' || $data['is_active'] === 1;
                    }
                }

                $section->update([
                    'is_active' => $isActive,
                    'sort_order' => $data['sort_order'] ?? $section->sort_order,
                    'title' => $data['title'] ?? $section->title,
                    'icon' => $data['icon'] ?? $section->icon,
                ]);
                
                $updatedCount++;
            }
        }

        return redirect()
            ->route('admin.navigation-sections.index')
            ->with('success', "Navigation sections updated successfully. {$updatedCount} sections updated. Changes will appear on topic pages immediately.");
    }

    public function reset(): RedirectResponse
    {
        // Clear existing sections
        NavigationSection::truncate();
        
        // Reinitialize with defaults
        NavigationSection::initializeDefaults();

        return redirect()
            ->route('admin.navigation-sections.index')
            ->with('success', 'Navigation sections reset to defaults successfully.');
    }
}
