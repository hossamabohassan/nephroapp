<?php

namespace App\View\Components;

use App\Models\LayoutTemplate;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DynamicLayout extends Component
{
    public $template;
    public $variables;
    public $rendered;

    /**
     * Create a new component instance.
     */
    public function __construct($template = null, $category = null, $variables = [])
    {
        // If template is provided as string (slug), find it
        if (is_string($template)) {
            $this->template = LayoutTemplate::where('slug', $template)->active()->first();
        } 
        // If template is provided as ID, find it
        elseif (is_numeric($template)) {
            $this->template = LayoutTemplate::find($template);
        }
        // If template is provided as object, use it
        elseif ($template instanceof LayoutTemplate) {
            $this->template = $template;
        }
        // If category is provided, get default template for that category
        elseif ($category) {
            $this->template = LayoutTemplate::byCategory($category)->default()->active()->first();
        }
        // If no template found, get default general template
        else {
            $this->template = LayoutTemplate::byCategory('general')->default()->active()->first();
        }

        $this->variables = $variables;
        
        // Render the template if found
        if ($this->template) {
            $this->rendered = $this->template->render($variables);
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        if (!$this->template) {
            return '<div class="p-4 bg-red-100 text-red-700 rounded">Template not found</div>';
        }

        return view('components.dynamic-layout');
    }
}
