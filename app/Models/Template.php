<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Template extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'view',
        'description',
        'is_default',
        'meta',
    ];

    protected $casts = [
        'is_default' => 'bool',
        'meta' => 'array',
    ];

    public function topics(): HasMany
    {
        return $this->hasMany(Topic::class);
    }
}
