<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class LayoutTemplate extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'html_content',
        'css_content',
        'js_content',
        'variables',
        'category',
        'is_active',
        'is_default',
        'order',
    ];

    protected $casts = [
        'variables' => 'array',
        'is_active' => 'boolean',
        'is_default' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($template) {
            if (empty($template->slug)) {
                $template->slug = Str::slug($template->name);
            }
        });

        static::updating(function ($template) {
            if ($template->is_default) {
                // Ensure only one template is default per category
                static::where('category', $template->category)
                    ->where('id', '!=', $template->id)
                    ->update(['is_default' => false]);
            }
        });
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('name');
    }

    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }

    public function render($variables = [])
    {
        $html = $this->html_content;
        $css = $this->css_content;
        $js = $this->js_content;

        // Merge template variables with passed variables
        $allVariables = array_merge($this->variables ?? [], $variables);

        // Replace placeholders in HTML (global replacement)
        foreach ($allVariables as $key => $value) {
            $placeholder = "{{$key}}";
            $html = str_replace($placeholder, $value, $html);
            $css = str_replace($placeholder, $value, $css);
            $js = str_replace($placeholder, $value, $js);
        }

        return [
            'html' => $html,
            'css' => $css,
            'js' => $js,
        ];
    }
}
