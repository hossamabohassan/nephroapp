<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    protected $fillable = [
        'title',
        'url',
        'icon',
        'order',
        'is_active',
        'opens_in_new_tab',
        'permission',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'opens_in_new_tab' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    public function scopeForPermission($query, $permission)
    {
        return $query->where('permission', $permission);
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
}