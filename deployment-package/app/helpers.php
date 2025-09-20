<?php

use App\Helpers\ContentHelper;

if (!function_exists('content')) {
    /**
     * Get dynamic content value
     */
    function content(string $key, string $default = ''): string
    {
        return ContentHelper::get($key, $default);
    }
}
