<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Topic;
use App\Models\UserFavorite;
use App\Models\UserCompleted;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserPreferencesController extends Controller
{
    /**
     * Toggle favorite status for a topic
     */
    public function toggleFavorite(Request $request, Topic $topic): JsonResponse
    {
        $user = Auth::user();
        
        $result = UserFavorite::toggle($user->id, $topic->id);
        
        $response = [
            'success' => true,
            'favorited' => $result['favorited'],
            'action' => $result['action'],
            'message' => $result['favorited'] 
                ? 'Topic added to favorites' 
                : 'Topic removed from favorites',
        ];
        
        // Clean any output buffer before sending JSON
        if (ob_get_length()) {
            ob_clean();
        }
        
        return response()->json($response, 200, [
            'Content-Type' => 'application/json; charset=utf-8'
        ]);
    }

    /**
     * Toggle completed status for a topic
     */
    public function toggleCompleted(Request $request, Topic $topic): JsonResponse
    {
        $user = Auth::user();
        $notes = $request->input('notes');
        
        $result = UserCompleted::toggle($user->id, $topic->id, $notes);
        
        $response = [
            'success' => true,
            'completed' => $result['completed'],
            'action' => $result['action'],
            'message' => $result['completed'] 
                ? 'Topic marked as completed' 
                : 'Topic unmarked as completed',
        ];
        
        // Clean any output buffer before sending JSON
        if (ob_get_length()) {
            ob_clean();
        }
        
        return response()->json($response, 200, [
            'Content-Type' => 'application/json; charset=utf-8'
        ]);
    }

    /**
     * Get user's favorites
     */
    public function getFavorites(Request $request): JsonResponse
    {
        $user = Auth::user();
        
        $favorites = $user->favoriteTopics()
            ->published()
            ->with(['category'])
            ->paginate(20);
            
        return response()->json([
            'success' => true,
            'favorites' => $favorites,
        ]);
    }

    /**
     * Get user's completed topics
     */
    public function getCompleted(Request $request): JsonResponse
    {
        $user = Auth::user();
        
        $completed = $user->completedTopics()
            ->published()
            ->with(['category'])
            ->paginate(20);
            
        return response()->json([
            'success' => true,
            'completed' => $completed,
        ]);
    }

    /**
     * Get topic status for current user
     */
    public function getTopicStatus(Topic $topic): JsonResponse
    {
        $user = Auth::user();
        
        $response = [
            'success' => true,
            'favorited' => $user->hasFavorited($topic->id),
            'completed' => $user->hasCompleted($topic->id),
        ];
        
        // Clean any output buffer before sending JSON
        if (ob_get_length()) {
            ob_clean();
        }
        
        return response()->json($response, 200, [
            'Content-Type' => 'application/json; charset=utf-8'
        ]);
    }

    /**
     * Add notes to a completed topic
     */
    public function updateCompletedNotes(Request $request, Topic $topic): JsonResponse
    {
        $request->validate([
            'notes' => 'nullable|string|max:1000',
        ]);

        $user = Auth::user();
        
        $completed = UserCompleted::where('user_id', $user->id)
            ->where('topic_id', $topic->id)
            ->first();
            
        if (!$completed) {
            return response()->json([
                'success' => false,
                'message' => 'Topic not marked as completed',
            ], 404);
        }
        
        $completed->update([
            'notes' => $request->input('notes'),
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Notes updated successfully',
            'notes' => $completed->notes,
        ]);
    }

    /**
     * Get user's preference statistics
     */
    public function getStats(): JsonResponse
    {
        $user = Auth::user();
        
        $stats = [
            'favorites_count' => $user->favorites()->count(),
            'completed_count' => $user->completed()->count(),
            'recent_favorites' => $user->favoriteTopics()
                ->published()
                ->limit(5)
                ->get(['id', 'title', 'slug']),
            'recent_completed' => $user->completedTopics()
                ->published()
                ->limit(5)
                ->get(['id', 'title', 'slug']),
        ];
        
        return response()->json([
            'success' => true,
            'stats' => $stats,
        ]);
    }
}