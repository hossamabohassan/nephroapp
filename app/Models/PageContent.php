<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
        'description',
    ];

    /**
     * Get content value by key with optional default
     */
    public static function get(string $key, string $default = ''): string
    {
        $content = static::where('key', $key)->first();
        return $content ? $content->value : $default;
    }

    /**
     * Set content value by key
     */
    public static function set(string $key, string $value, string $type = 'text', string $group = 'general', string $description = null): self
    {
        return static::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'type' => $type,
                'group' => $group,
                'description' => $description,
            ]
        );
    }

    /**
     * Get the landing page HTML content
     */
    public static function getLandingPageHtml(): string
    {
        return static::get('landing_page_html', '');
    }

    /**
     * Set the landing page HTML content
     */
    public static function setLandingPageHtml(string $html): self
    {
        return static::set('landing_page_html', $html, 'html', 'pages', 'Full HTML content for the landing page');
    }
}
