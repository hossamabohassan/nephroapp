<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AdminLayout extends Component
{
    public string $pageTitle;
    public ?string $pageDescription;

    /**
     * Create a new component instance.
     */
    public function __construct(string $pageTitle = 'Admin Dashboard', ?string $pageDescription = null)
    {
        $this->pageTitle = $pageTitle;
        $this->pageDescription = $pageDescription;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('layouts.admin');
    }
}
