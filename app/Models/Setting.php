<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
    ];

    /**
     * Get setting value by key with optional default
     */
    public static function get(string $key, string $default = ''): string
    {
        $setting = static::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    /**
     * Set setting value by key
     */
    public static function set(string $key, string $value, string $type = 'text', string $group = 'general'): self
    {
        return static::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'type' => $type,
                'group' => $group,
            ]
        );
    }

    /**
     * Get all settings as key-value array
     */
    public static function getAllAsArray(): array
    {
        return Cache::remember('settings', 3600, function () {
            return static::query()->pluck('value', 'key')->toArray();
        });
    }

    /**
     * Clear settings cache
     */
    public static function clearCache(): void
    {
        Cache::forget('settings');
    }
}
