<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LayoutTemplate;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class LayoutTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $templates = LayoutTemplate::ordered()->get();
        return view('admin.layout-templates.index', compact('templates'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $categories = ['general', 'profile', 'admin', 'landing', 'blog', 'custom'];
        return view('admin.layout-templates.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'html_content' => 'required|string',
            'css_content' => 'nullable|string',
            'js_content' => 'nullable|string',
            'category' => 'required|string|in:general,profile,admin,landing,blog,custom',
            'is_active' => 'boolean',
            'is_default' => 'boolean',
            'order' => 'integer|min:0',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');
        $data['is_default'] = $request->has('is_default');

        // Handle variables JSON
        if ($request->has('variables')) {
            $variables = [];
            $variableNames = $request->input('variable_names', []);
            $variableDefaults = $request->input('variable_defaults', []);
            
            for ($i = 0; $i < count($variableNames); $i++) {
                if (!empty($variableNames[$i])) {
                    $variables[$variableNames[$i]] = $variableDefaults[$i] ?? '';
                }
            }
            $data['variables'] = $variables;
        }

        LayoutTemplate::create($data);

        return redirect()
            ->route('admin.layout-templates.index')
            ->with('success', 'Layout template created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(LayoutTemplate $layoutTemplate): View
    {
        return view('admin.layout-templates.show', compact('layoutTemplate'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LayoutTemplate $layoutTemplate): View
    {
        $categories = ['general', 'profile', 'admin', 'landing', 'blog', 'custom'];
        return view('admin.layout-templates.edit', compact('layoutTemplate', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LayoutTemplate $layoutTemplate): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'html_content' => 'required|string',
            'css_content' => 'nullable|string',
            'js_content' => 'nullable|string',
            'category' => 'required|string|in:general,profile,admin,landing,blog,custom',
            'is_active' => 'boolean',
            'is_default' => 'boolean',
            'order' => 'integer|min:0',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');
        $data['is_default'] = $request->has('is_default');

        // Handle variables JSON
        if ($request->has('variables')) {
            $variables = [];
            $variableNames = $request->input('variable_names', []);
            $variableDefaults = $request->input('variable_defaults', []);
            
            for ($i = 0; $i < count($variableNames); $i++) {
                if (!empty($variableNames[$i])) {
                    $variables[$variableNames[$i]] = $variableDefaults[$i] ?? '';
                }
            }
            $data['variables'] = $variables;
        }

        $layoutTemplate->update($data);

        return redirect()
            ->route('admin.layout-templates.index')
            ->with('success', 'Layout template updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LayoutTemplate $layoutTemplate): RedirectResponse
    {
        $layoutTemplate->delete();

        return redirect()
            ->route('admin.layout-templates.index')
            ->with('success', 'Layout template deleted successfully.');
    }

    /**
     * Preview the template
     */
    public function preview(LayoutTemplate $layoutTemplate): View
    {
        $rendered = $layoutTemplate->render();
        return view('admin.layout-templates.preview', compact('layoutTemplate', 'rendered'));
    }
}
