<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TopicRequest;
use App\Models\ActivityLog;
use App\Models\Topic;
use App\Services\TopicRenderer;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class TopicController extends Controller
{
    public function __construct(private readonly TopicRenderer $renderer)
    {
        $this->middleware(['auth', 'active']);
        $this->middleware('can:manage-topics');
    }

    public function index(): JsonResponse
    {
        $topics = Topic::query()
            ->select(['id', 'slug', 'title', 'status', 'updated_at', 'published_at'])
            ->latest('updated_at')
            ->paginate(25);

        return response()->json($topics);
    }

    public function store(TopicRequest $request): JsonResponse
    {
        $payload = $request->payload();
        $topic = new Topic();
        $topic->fill(collect($payload)->except('publish')->toArray());
        $topic->created_by = Auth::id();
        $topic->updated_by = Auth::id();

        if (($payload['publish'] ?? false) || $topic->status === Topic::STATUS_PUBLISHED) {
            $topic->status = Topic::STATUS_PUBLISHED;
            $topic->published_at = now();
        }

        $topic->save();
        $topic->forceFill([
            'rendered_html' => $this->renderer->render($topic->fresh('template')),
            'rendered_at' => now(),
        ])->save();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'topic.created.api',
            'subject_type' => Topic::class,
            'subject_id' => $topic->id,
            'properties' => [
                'slug' => $topic->slug,
            ],
        ]);

        return response()->json($topic->refresh(), 201);
    }

    public function show(Topic $topic): JsonResponse
    {
        return response()->json($topic);
    }

    public function update(TopicRequest $request, Topic $topic): JsonResponse
    {
        $payload = $request->payload();
        $topic->fill(collect($payload)->except('publish')->toArray());
        $topic->updated_by = Auth::id();

        if (($payload['publish'] ?? false) || $topic->status === Topic::STATUS_PUBLISHED) {
            $topic->status = Topic::STATUS_PUBLISHED;
            $topic->published_at ??= now();
        } elseif ($topic->status !== Topic::STATUS_PUBLISHED) {
            $topic->published_at = null;
        }

        $topic->save();
        $topic->forceFill([
            'rendered_html' => $this->renderer->render($topic->fresh('template')),
            'rendered_at' => now(),
        ])->save();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'topic.updated.api',
            'subject_type' => Topic::class,
            'subject_id' => $topic->id,
            'properties' => [
                'slug' => $topic->slug,
            ],
        ]);

        return response()->json($topic->refresh());
    }

    public function destroy(Topic $topic): JsonResponse
    {
        if ($topic->status === Topic::STATUS_PUBLISHED) {
            return response()->json(['message' => 'Published topics cannot be removed'], 409);
        }

        $topic->delete();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'topic.deleted.api',
            'subject_type' => Topic::class,
            'subject_id' => $topic->id,
            'properties' => [
                'slug' => $topic->slug,
            ],
        ]);

        return response()->json(['status' => 'deleted']);
    }
}
