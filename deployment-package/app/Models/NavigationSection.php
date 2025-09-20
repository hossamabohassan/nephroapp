<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NavigationSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'title',
        'icon',
        'is_active',
        'sort_order',
    ];

    public $incrementing = false;
    protected $keyType = 'string';

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Scope to get only active navigation sections
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to order by sort_order
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }

    /**
     * Get all available navigation sections with their default settings
     */
    public static function getDefaultSections(): array
    {
        return [
            'topic-header' => [
                'id' => 'topic-header',
                'title' => 'Top',
                'icon' => '🏠',
                'is_active' => true,
                'sort_order' => 1,
            ],
            'overview' => [
                'id' => 'overview',
                'title' => 'Overview',
                'icon' => '📋',
                'is_active' => true,
                'sort_order' => 2,
            ],
            'priorities' => [
                'id' => 'priorities',
                'title' => 'Priorities',
                'icon' => '⭐',
                'is_active' => true,
                'sort_order' => 3,
            ],
            'diagnosis' => [
                'id' => 'diagnosis',
                'title' => 'Diagnosis',
                'icon' => '🔍',
                'is_active' => true,
                'sort_order' => 4,
            ],
            'quick-reference' => [
                'id' => 'quick-reference',
                'title' => 'Quick Ref',
                'icon' => '⚡',
                'is_active' => true,
                'sort_order' => 5,
            ],
            'investigations' => [
                'id' => 'investigations',
                'title' => 'Investigations',
                'icon' => '🔬',
                'is_active' => true,
                'sort_order' => 6,
            ],
            'emergency' => [
                'id' => 'emergency',
                'title' => 'Emergency',
                'icon' => '🚨',
                'is_active' => true,
                'sort_order' => 7,
            ],
            'management' => [
                'id' => 'management',
                'title' => 'Management',
                'icon' => '⚙️',
                'is_active' => true,
                'sort_order' => 8,
            ],
            'topic-blocks' => [
                'id' => 'topic-blocks',
                'title' => 'Topic Blocks',
                'icon' => '🧩',
                'is_active' => true,
                'sort_order' => 9,
            ],
            'quality-metrics' => [
                'id' => 'quality-metrics',
                'title' => 'Quality',
                'icon' => '📊',
                'is_active' => true,
                'sort_order' => 10,
            ],
            'safety-leadership' => [
                'id' => 'safety-leadership',
                'title' => 'Safety',
                'icon' => '🛡️',
                'is_active' => true,
                'sort_order' => 11,
            ],
            'cases' => [
                'id' => 'cases',
                'title' => 'Cases',
                'icon' => '📁',
                'is_active' => true,
                'sort_order' => 12,
            ],
            'viva' => [
                'id' => 'viva',
                'title' => 'Viva',
                'icon' => '💬',
                'is_active' => true,
                'sort_order' => 13,
            ],
            'additional' => [
                'id' => 'additional',
                'title' => 'Additional',
                'icon' => '➕',
                'is_active' => true,
                'sort_order' => 14,
            ],
            'additional-resources' => [
                'id' => 'additional-resources',
                'title' => 'Resources',
                'icon' => '📚',
                'is_active' => true,
                'sort_order' => 15,
            ],
            'pitfalls' => [
                'id' => 'pitfalls',
                'title' => 'Pitfalls',
                'icon' => '⚠️',
                'is_active' => true,
                'sort_order' => 16,
            ],
            'teaching-points' => [
                'id' => 'teaching-points',
                'title' => 'Teaching',
                'icon' => '🎓',
                'is_active' => true,
                'sort_order' => 17,
            ],
            'answer-structure' => [
                'id' => 'answer-structure',
                'title' => 'Structure',
                'icon' => '📝',
                'is_active' => true,
                'sort_order' => 18,
            ],
            'flowchart' => [
                'id' => 'flowchart',
                'title' => 'Flowchart',
                'icon' => '📈',
                'is_active' => true,
                'sort_order' => 19,
            ],
            'evidence' => [
                'id' => 'evidence',
                'title' => 'Evidence',
                'icon' => '📄',
                'is_active' => true,
                'sort_order' => 20,
            ],
            'guidelines' => [
                'id' => 'guidelines',
                'title' => 'Guidelines',
                'icon' => '📖',
                'is_active' => true,
                'sort_order' => 21,
            ],
            'aiChat' => [
                'id' => 'aiChat',
                'title' => 'AI Chat',
                'icon' => '🤖',
                'is_active' => true,
                'sort_order' => 22,
            ],
        ];
    }

    /**
     * Initialize default navigation sections if none exist
     */
    public static function initializeDefaults(): void
    {
        if (static::count() === 0) {
            $defaultSections = static::getDefaultSections();
            
            foreach ($defaultSections as $section) {
                static::create($section);
            }
        }
    }
}