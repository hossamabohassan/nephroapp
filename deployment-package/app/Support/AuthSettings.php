<?php

namespace App\Support;

use App\Models\AuthSetting;

class AuthSettings
{
    private static ?AuthSetting $settings = null;

    public static function get(): AuthSetting
    {
        if (! static::$settings) {
            static::$settings = AuthSetting::current();
        }

        return static::$settings;
    }

    public static function allowsEmailRegistration(): bool
    {
        return static::get()->allow_email_registration;
    }

    public static function allowsGoogleAuth(): bool
    {
        return static::get()->allow_google_auth;
    }

    public static function refresh(): void
    {
        static::$settings = null;
    }
}
