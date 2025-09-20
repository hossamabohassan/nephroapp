<?php

namespace App\Services;

use App\Models\LayoutTemplate;
use App\Models\Setting;

class TemplateService
{
    /**
     * Get template for a specific page/route
     */
    public function getTemplateForPage(string $route): ?LayoutTemplate
    {
        // First, try to get a specific template assigned to this route
        $templateId = Setting::where('key', 'page_template_' . $route)->value('value');
        
        if ($templateId) {
            $template = LayoutTemplate::find($templateId);
            if ($template && $template->is_active) {
                return $template;
            }
        }
        
        // If no specific template, try to get default template for the route category
        $category = $this->getCategoryFromRoute($route);
        $template = LayoutTemplate::byCategory($category)->default()->active()->first();
        
        if ($template) {
            return $template;
        }
        
        // Fallback to general default template
        return LayoutTemplate::byCategory('general')->default()->active()->first();
    }
    
    /**
     * Get template by category
     */
    public function getTemplateByCategory(string $category): ?LayoutTemplate
    {
        return LayoutTemplate::byCategory($category)->default()->active()->first();
    }
    
    /**
     * Get template by slug
     */
    public function getTemplateBySlug(string $slug): ?LayoutTemplate
    {
        return LayoutTemplate::where('slug', $slug)->active()->first();
    }
    
    /**
     * Get all available templates for a category
     */
    public function getTemplatesForCategory(string $category): \Illuminate\Database\Eloquent\Collection
    {
        return LayoutTemplate::byCategory($category)->active()->ordered()->get();
    }
    
    /**
     * Render template with variables
     */
    public function renderTemplate(LayoutTemplate $template, array $variables = []): array
    {
        return $template->render($variables);
    }
    
    /**
     * Assign template to a page
     */
    public function assignTemplateToPage(string $route, int $templateId): bool
    {
        try {
            Setting::updateOrCreate(
                ['key' => 'page_template_' . $route],
                ['value' => $templateId]
            );
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
    
    /**
     * Get available page routes for template assignment
     */
    public function getAvailableRoutes(): array
    {
        return [
            'home' => 'Home Page',
            'profile' => 'Profile Page',
            'profile/favorites' => 'Profile Favorites',
            'profile/completed' => 'Profile Completed',
            'admin' => 'Admin Dashboard',
            'admin/topics' => 'Admin Topics',
            'admin/categories' => 'Admin Categories',
            'admin/menu-items' => 'Admin Menu Items',
            'admin/templates' => 'Admin Templates',
            'admin/settings' => 'Admin Settings',
        ];
    }
    
    /**
     * Determine category from route
     */
    private function getCategoryFromRoute(string $route): string
    {
        if (str_starts_with($route, 'admin')) {
            return 'admin';
        }
        
        if (str_starts_with($route, 'profile')) {
            return 'profile';
        }
        
        if (in_array($route, ['home', 'landing'])) {
            return 'landing';
        }
        
        return 'general';
    }
}
