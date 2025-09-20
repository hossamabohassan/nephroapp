<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuthSetting extends Model
{
    protected $fillable = [
        'allow_email_registration',
        'allow_google_auth',
    ];

    protected $casts = [
        'allow_email_registration' => 'boolean',
        'allow_google_auth' => 'boolean',
    ];

    public static function current(): self
    {
        return static::query()->first() ?? static::create([
            'allow_email_registration' => true,
            'allow_google_auth' => false,
        ]);
    }
}
