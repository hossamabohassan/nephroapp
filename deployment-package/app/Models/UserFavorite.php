<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserFavorite extends Model
{
    use HasFactory;

    protected $table = 'user_favorites';

    protected $fillable = [
        'user_id',
        'topic_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class);
    }

    /**
     * Scope to get favorites for a specific user
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Check if a user has favorited a specific topic
     */
    public static function isFavorited($userId, $topicId): bool
    {
        return static::where('user_id', $userId)
            ->where('topic_id', $topicId)
            ->exists();
    }

    /**
     * Toggle favorite status for a user and topic
     */
    public static function toggle($userId, $topicId): array
    {
        $favorite = static::where('user_id', $userId)
            ->where('topic_id', $topicId)
            ->first();

        if ($favorite) {
            $favorite->delete();
            return ['favorited' => false, 'action' => 'removed'];
        } else {
            static::create([
                'user_id' => $userId,
                'topic_id' => $topicId,
            ]);
            return ['favorited' => true, 'action' => 'added'];
        }
    }
}