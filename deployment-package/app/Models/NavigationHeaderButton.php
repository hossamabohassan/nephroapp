<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NavigationHeaderButton extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'icon',
        'url',
        'route_name',
        'type',
        'dropdown_items',
        'is_active',
        'sort_order',
        'target',
        'css_class',
        'badge_text',
        'badge_color',
        'show_badge',
        'permission',
    ];

    protected $casts = [
        'dropdown_items' => 'array',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
        'show_badge' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }

    public function getResolvedUrlAttribute()
    {
        if ($this->route_name) {
            return route($this->route_name);
        }
        
        return $this->url;
    }

    public function getIconHtmlAttribute()
    {
        if (!$this->icon) {
            return '';
        }

        // Check if it's an emoji
        if (preg_match('/[\x{1F600}-\x{1F64F}]|[\x{1F300}-\x{1F5FF}]|[\x{1F680}-\x{1F6FF}]|[\x{1F1E0}-\x{1F1FF}]|[\x{2600}-\x{26FF}]|[\x{2700}-\x{27BF}]/u', $this->icon)) {
            return $this->icon;
        }

        // Check if it's an SVG path
        if (str_contains($this->icon, '<svg') || str_contains($this->icon, '<path')) {
            return $this->icon;
        }

        // Default to treating as SVG class or icon name
        return $this->icon;
    }

    public function getBadgeColorClassAttribute()
    {
        $colors = [
            'red' => 'bg-red-400',
            'blue' => 'bg-blue-400',
            'green' => 'bg-green-400',
            'yellow' => 'bg-yellow-400',
            'purple' => 'bg-purple-400',
            'pink' => 'bg-pink-400',
            'indigo' => 'bg-indigo-400',
            'gray' => 'bg-gray-400',
        ];

        return $colors[$this->badge_color] ?? 'bg-red-400';
    }

    public function scopeVisibleToUser($query, $userRole = 'public')
    {
        // Admin can see everything
        if ($userRole === 'admin') {
            return $query;
        }
        
        // Editor can see public and editor items
        if ($userRole === 'editor') {
            return $query->whereIn('permission', ['public', 'editor']);
        }
        
        // Public users can only see public items
        return $query->where('permission', 'public');
    }

    public function canUserAccess($user = null): bool
    {
        if (!$user) {
            $user = auth()->user();
        }

        $userRole = $user ? $user->role : 'public';

        // Admin can see everything
        if ($userRole === 'admin') {
            return true;
        }
        
        // Editor can see public and editor items
        if ($userRole === 'editor') {
            return in_array($this->permission, ['public', 'editor']);
        }
        
        // Public users can only see public items
        return $this->permission === 'public';
    }
}