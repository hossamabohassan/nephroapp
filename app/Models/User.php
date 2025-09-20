<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    public const ROLE_ADMIN = 'admin';
    public const ROLE_EDITOR = 'editor';
    public const ROLE_MEMBER = 'member';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'mobile_number',
        'password',
        'role',
        'is_active',
        'provider',
        'provider_id',
        'avatar',
    ];

    /**
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'provider',
        'provider_id',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'bool',
            'last_login_at' => 'datetime',
        ];
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isEditor(): bool
    {
        return in_array($this->role, [self::ROLE_ADMIN, self::ROLE_EDITOR], true);
    }

    public function topicsCreated(): HasMany
    {
        return $this->hasMany(Topic::class, 'created_by');
    }

    public function topicsUpdated(): HasMany
    {
        return $this->hasMany(Topic::class, 'updated_by');
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(UserFavorite::class);
    }

    public function favoriteTopics()
    {
        return $this->belongsToMany(Topic::class, 'user_favorites')
            ->withTimestamps()
            ->orderBy('user_favorites.created_at', 'desc');
    }

    public function completed(): HasMany
    {
        return $this->hasMany(UserCompleted::class);
    }

    public function completedTopics()
    {
        return $this->belongsToMany(Topic::class, 'user_completed')
            ->withPivot(['completed_at', 'notes'])
            ->withTimestamps()
            ->orderBy('user_completed.completed_at', 'desc');
    }

    /**
     * Check if user has favorited a topic
     */
    public function hasFavorited($topicId): bool
    {
        return $this->favorites()->where('topic_id', $topicId)->exists();
    }

    /**
     * Check if user has completed a topic
     */
    public function hasCompleted($topicId): bool
    {
        return $this->completed()->where('topic_id', $topicId)->exists();
    }
}
