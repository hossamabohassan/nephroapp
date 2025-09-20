<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserCompleted extends Model
{
    use HasFactory;

    protected $table = 'user_completed';

    protected $fillable = [
        'user_id',
        'topic_id',
        'completed_at',
        'notes',
    ];

    protected $casts = [
        'completed_at' => 'datetime',
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
     * Scope to get completed topics for a specific user
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Check if a user has completed a specific topic
     */
    public static function isCompleted($userId, $topicId): bool
    {
        return static::where('user_id', $userId)
            ->where('topic_id', $topicId)
            ->exists();
    }

    /**
     * Toggle completed status for a user and topic
     */
    public static function toggle($userId, $topicId, $notes = null): array
    {
        $completed = static::where('user_id', $userId)
            ->where('topic_id', $topicId)
            ->first();

        if ($completed) {
            $completed->delete();
            return ['completed' => false, 'action' => 'removed'];
        } else {
            static::create([
                'user_id' => $userId,
                'topic_id' => $topicId,
                'completed_at' => now(),
                'notes' => $notes,
            ]);
            return ['completed' => true, 'action' => 'added'];
        }
    }

    /**
     * Mark a topic as completed with optional notes
     */
    public static function markCompleted($userId, $topicId, $notes = null): self
    {
        return static::updateOrCreate(
            [
                'user_id' => $userId,
                'topic_id' => $topicId,
            ],
            [
                'completed_at' => now(),
                'notes' => $notes,
            ]
        );
    }
}