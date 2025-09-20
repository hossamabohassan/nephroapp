<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LayoutTemplate;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $templates = LayoutTemplate::ordered()->get();
        return view('admin.templates.index', compact('templates'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $categories = ['general', 'profile', 'admin', 'landing', 'blog', 'custom'];
        return view('admin.templates.create', compact('categories'));
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
        $variables = [];
        $variableNames = $request->input('variable_names', []);
        $variableDefaults = $request->input('variable_defaults', []);
        
        for ($i = 0; $i < count($variableNames); $i++) {
            if (!empty($variableNames[$i])) {
                $variables[$variableNames[$i]] = $variableDefaults[$i] ?? '';
            }
        }
        $data['variables'] = !empty($variables) ? $variables : null;

        LayoutTemplate::create($data);

        return redirect()
            ->route('admin.templates.index')
            ->with('success', 'Template created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(LayoutTemplate $template): View
    {
        return view('admin.templates.show', compact('template'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LayoutTemplate $template): View
    {
        $categories = ['general', 'profile', 'admin', 'landing', 'blog', 'custom'];
        return view('admin.templates.edit', compact('template', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LayoutTemplate $template): RedirectResponse
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
        $variables = [];
        $variableNames = $request->input('variable_names', []);
        $variableDefaults = $request->input('variable_defaults', []);
        
        for ($i = 0; $i < count($variableNames); $i++) {
            if (!empty($variableNames[$i])) {
                $variables[$variableNames[$i]] = $variableDefaults[$i] ?? '';
            }
        }
        $data['variables'] = !empty($variables) ? $variables : null;

        $template->update($data);

        return redirect()
            ->route('admin.templates.index')
            ->with('success', 'Template updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LayoutTemplate $template): RedirectResponse
    {
        $template->delete();

        return redirect()
            ->route('admin.templates.index')
            ->with('success', 'Template deleted successfully.');
    }

    /**
     * Preview the template
     */
    public function preview(LayoutTemplate $template): View
    {
        $rendered = $template->render();
        return view('admin.templates.preview', compact('template', 'rendered'));
    }

    /**
     * Show interactive preview with drag-and-drop variables
     */
    public function interactivePreview(LayoutTemplate $template): View
    {
        // Get sample variables for preview
        $sampleVariables = [
            'site_url' => url('/'),
            'site_name' => config('app.name', 'NephroApp'),
            'page_title' => 'Sample Page Title',
            'user_name' => 'John Doe',
            'content' => '<div class="sample-content">
                <h2>Sample Content</h2>
                <p>This is sample content to show how your template will look. You can drag and drop the variables to reposition them.</p>
                <ul>
                    <li>Sample list item 1</li>
                    <li>Sample list item 2</li>
                    <li>Sample list item 3</li>
                </ul>
            </div>',
            'sidebar_content' => '<nav class="sample-sidebar">
                <ul>
                    <li><a href="#">Dashboard</a></li>
                    <li><a href="#">Users</a></li>
                    <li><a href="#">Settings</a></li>
                </ul>
            </nav>',
            'footer_content' => '<p>&copy; 2025 Sample Company. All rights reserved.</p>',
            'header_content' => '<h1>Sample Header</h1>',
        ];

        // Start with sample variables as defaults
        $allVariables = $sampleVariables;
        
        // Override with template variables if they exist (template variables take precedence)
        if ($template->variables && is_array($template->variables)) {
            $allVariables = array_merge($allVariables, $template->variables);
        }
        
        \Log::info('Loading interactive preview', [
            'template_id' => $template->id,
            'template_variables_count' => $template->variables ? count($template->variables) : 0,
            'all_variables_count' => count($allVariables),
            'template_variables' => $template->variables,
            'sample_variables' => $sampleVariables,
            'final_variables' => $allVariables
        ]);
        
        return view('admin.templates.interactive-preview', compact('template', 'allVariables'));
    }

    /**
     * Save preview changes
     */
    public function savePreview(Request $request, LayoutTemplate $template)
    {
        try {
            \Log::info('Save preview request received', [
                'template_id' => $template->id,
                'html_content_length' => strlen($request->html_content ?? ''),
                'variables' => $request->variables,
                'request_method' => $request->method(),
                'is_ajax' => $request->ajax(),
                'expects_json' => $request->expectsJson()
            ]);

            $request->validate([
                'html_content' => 'required|string',
                'variables' => 'nullable',
            ]);

            // Handle variables - could be array (JSON) or string (form)
            $variables = $request->variables;
            if (is_string($variables)) {
                $variables = json_decode($variables, true);
            }

            \Log::info('Updating template', [
                'template_id' => $template->id,
                'html_content_preview' => substr($request->html_content, 0, 200) . '...',
                'variables_count' => is_array($variables) ? count($variables) : 0
            ]);

            $template->update([
                'html_content' => $request->html_content,
                'variables' => $variables,
            ]);

            \Log::info('Template updated successfully', ['template_id' => $template->id]);

            // Check if it's an AJAX request
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Template updated successfully!'
                ], 200, [], JSON_UNESCAPED_UNICODE);
            }

            // For form submissions, redirect back with success message
            return redirect()
                ->route('admin.templates.interactive-preview', $template)
                ->with('success', 'Template updated successfully!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed: ' . implode(', ', $e->validator->errors()->all())
                ], 422, [], JSON_UNESCAPED_UNICODE);
            }
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            \Log::error('Template save error: ' . $e->getMessage());
            
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred while saving the template: ' . $e->getMessage()
                ], 500, [], JSON_UNESCAPED_UNICODE);
            }
            
            return redirect()->back()->with('error', 'An error occurred while saving the template.');
        }
    }

    /**
     * Show template assignment page
     */
    public function showAssign(): View
    {
        $templates = LayoutTemplate::active()->ordered()->get();
        $templateService = new \App\Services\TemplateService();
        $availableRoutes = $templateService->getAvailableRoutes();
        
        // Get current assignments
        $currentAssignments = collect();
        foreach ($availableRoutes as $route => $name) {
            $templateId = \App\Models\Setting::where('key', 'page_template_' . $route)->value('value');
            if ($templateId) {
                $template = LayoutTemplate::find($templateId);
                if ($template) {
                    $currentAssignments->push((object)[
                        'route' => $route,
                        'page_name' => $name,
                        'template_name' => $template->name,
                        'template_id' => $templateId
                    ]);
                }
            }
        }

        return view('admin.templates.assign', compact('templates', 'availableRoutes', 'currentAssignments'));
    }

    /**
     * Assign template to a page
     */
    public function assign(Request $request): RedirectResponse
    {
        $request->validate([
            'template_id' => 'required|exists:layout_templates,id',
            'page_route' => 'required|string',
        ]);

        // Store template assignment in settings
        \App\Models\Setting::updateOrCreate(
            ['key' => 'page_template_' . $request->page_route],
            ['value' => $request->template_id]
        );

        return redirect()
            ->back()
            ->with('success', 'Template assigned to page successfully.');
    }

    /**
     * Unassign template from a page
     */
    public function unassign(Request $request): RedirectResponse
    {
        $request->validate([
            'route' => 'required|string',
        ]);

        \App\Models\Setting::where('key', 'page_template_' . $request->route)->delete();

        return redirect()
            ->back()
            ->with('success', 'Template assignment removed successfully.');
    }
}
