<?php

namespace App\Helpers;

use App\Models\PageContent;
use Illuminate\Support\Facades\Cache;

class ContentHelper
{
    /**
     * Get dynamic content with fallback to default value
     */
    public static function get(string $key, string $default = ''): string
    {
        return Cache::remember("content.{$key}", 3600, function () use ($key, $default) {
            $content = PageContent::where('key', $key)->first();
            return $content ? $content->value : $default;
        });
    }

    /**
     * Get all content as an array for easy access
     */
    public static function all(): array
    {
        return Cache::remember('content.all', 3600, function () {
            return PageContent::all()->pluck('value', 'key')->toArray();
        });
    }

    /**
     * Clear content cache
     */
    public static function clearCache(): void
    {
        Cache::forget('content.all');
        // Clear individual content caches
        $keys = PageContent::pluck('key');
        foreach ($keys as $key) {
            Cache::forget("content.{$key}");
        }
    }
}
