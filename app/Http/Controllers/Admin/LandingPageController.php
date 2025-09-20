<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class LandingPageController extends Controller
{
    /**
     * Display the landing page editor
     */
    public function index()
    {
        // Get current HTML content from database or fallback to file
        $htmlContent = PageContent::getLandingPageHtml();
        
        // If no content in database, load from the current landing.blade.php file
        if (empty($htmlContent)) {
            $htmlContent = $this->getCurrentLandingPageContent();
        }

        return view('admin.landing-page.index', compact('htmlContent'));
    }

    /**
     * Update the landing page HTML content
     */
    public function update(Request $request)
    {
        $request->validate([
            'html_content' => 'required|string',
        ]);

        // Save to database
        PageContent::setLandingPageHtml($request->html_content);

        // Optionally update the actual blade file as well
        if ($request->has('update_file') && $request->update_file) {
            $this->updateLandingPageFile($request->html_content);
        }

        return redirect()->route('admin.landing-page.index')
            ->with('success', 'Landing page HTML updated successfully!');
    }

    /**
     * Preview the landing page with current HTML
     */
    public function preview(Request $request)
    {
        $htmlContent = $request->html_content ?? PageContent::getLandingPageHtml();
        
        if (empty($htmlContent)) {
            $htmlContent = $this->getCurrentLandingPageContent();
        }

        // If the content contains Blade syntax, render it
        if (strpos($htmlContent, '{{') !== false || strpos($htmlContent, '@') !== false) {
            try {
                $renderedContent = \Illuminate\Support\Facades\Blade::render($htmlContent);
                return response($renderedContent)->header('Content-Type', 'text/html');
            } catch (\Exception $e) {
                // If rendering fails, return the raw content with an error message
                $errorMessage = '<div style="background: #fee; border: 1px solid #fcc; padding: 10px; margin: 10px; border-radius: 4px;"><strong>Blade Rendering Error:</strong> ' . htmlspecialchars($e->getMessage()) . '</div>';
                return response($errorMessage . $htmlContent)->header('Content-Type', 'text/html');
            }
        }

        return response($htmlContent)
            ->header('Content-Type', 'text/html');
    }

    /**
     * Reset to original file content
     */
    public function reset()
    {
        $originalContent = $this->getCurrentLandingPageContent();
        PageContent::setLandingPageHtml($originalContent);

        return redirect()->route('admin.landing-page.index')
            ->with('success', 'Landing page reset to original content!');
    }

    /**
     * Get current content from the landing.blade.php file
     */
    private function getCurrentLandingPageContent(): string
    {
        $filePath = resource_path('views/landing.blade.php');
        
        if (File::exists($filePath)) {
            return File::get($filePath);
        }

        return '';
    }

    /**
     * Update the actual landing.blade.php file
     */
    private function updateLandingPageFile(string $htmlContent): void
    {
        $filePath = resource_path('views/landing.blade.php');
        
        // Create backup
        if (File::exists($filePath)) {
            File::copy($filePath, $filePath . '.backup.' . date('Y-m-d-H-i-s'));
        }

        // Write new content
        File::put($filePath, $htmlContent);
    }
}