<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Topic extends Model
{
    use HasFactory;

    public const STATUS_DRAFT = 'draft';
    public const STATUS_REVIEW = 'review';
    public const STATUS_PUBLISHED = 'published';

    protected $fillable = [
        'template_id',
        'category_id',
        'created_by',
        'updated_by',
        'slug',
        'title',
        'subtitle',
        'status',
        'summary',
        'data',
        'meta',
        'rendered_html',
        'rendered_at',
        'published_at',
    ];

    protected $casts = [
        'data' => 'array',
        'meta' => 'array',
        'rendered_at' => 'datetime',
        'published_at' => 'datetime',
    ];

    public function template(): BelongsTo
    {
        return $this->belongsTo(Template::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function editor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_PUBLISHED);
    }

    public function scopeVisible(Builder $query): Builder
    {
        return $query->whereIn('status', [self::STATUS_PUBLISHED, self::STATUS_REVIEW]);
    }

    public function markPublished(): void
    {
        $this->forceFill([
            'status' => self::STATUS_PUBLISHED,
            'published_at' => now(),
        ])->save();
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(UserFavorite::class);
    }

    public function completed(): HasMany
    {
        return $this->hasMany(UserCompleted::class);
    }

    public function favoritedByUsers()
    {
        return $this->belongsToMany(User::class, 'user_favorites')
            ->withTimestamps();
    }

    public function completedByUsers()
    {
        return $this->belongsToMany(User::class, 'user_completed')
            ->withPivot(['completed_at', 'notes'])
            ->withTimestamps();
    }

    /**
     * Check if a topic is favorited by a specific user
     */
    public function isFavoritedBy($userId): bool
    {
        return $this->favorites()->where('user_id', $userId)->exists();
    }

    /**
     * Check if a topic is completed by a specific user
     */
    public function isCompletedBy($userId): bool
    {
        return $this->completed()->where('user_id', $userId)->exists();
    }

    /**
     * Get favorites count for this topic
     */
    public function getFavoritesCountAttribute(): int
    {
        return $this->favorites()->count();
    }

    /**
     * Get completion count for this topic
     */
    public function getCompletionsCountAttribute(): int
    {
        return $this->completed()->count();
    }
}

