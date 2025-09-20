<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TopicRequest;
use App\Models\ActivityLog;
use App\Models\Template;
use App\Models\Category;
use App\Models\Topic;
use App\Services\TopicRenderer;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\HttpException;

class TopicController extends Controller
{
    public function __construct(private readonly TopicRenderer $renderer)
    {
        $this->middleware(['auth', 'verified', 'active']);
        $this->middleware('can:manage-topics');
    }

    public function index(Request $request): View
    {
        $topics = Topic::query()
            ->with(['template', 'creator', 'category'])
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->query('status')))
            ->when($search = $request->string('q')->toString(), function ($query) use ($search) {
                $query->where(function ($inner) use ($search) {
                    $inner->where('title', 'like', "%{$search}%")
                        ->orWhere('slug', 'like', "%{$search}%");
                });
            })
            ->latest('updated_at')
            ->paginate(20)
            ->withQueryString();

        $stats = [
            'total' => Topic::query()->count(),
            'published' => Topic::query()->where('status', Topic::STATUS_PUBLISHED)->count(),
            'drafts' => Topic::query()->where('status', Topic::STATUS_DRAFT)->count(),
            'in_review' => Topic::query()->where('status', Topic::STATUS_REVIEW)->count(),
        ];

        return view('admin.topics.index', [
            'topics' => $topics,
            'stats' => $stats,
            'categories' => Category::query()->orderBy('name')->get(),
            'filters' => [
                'status' => $request->query('status'),
                'q' => $request->query('q'),
            ],
        ]);
    }

    public function create(): View
    {
        return view('admin.topics.create', [
            'templates' => Template::query()->orderBy('name')->get(),
            'categories' => Category::query()->orderBy('name')->get(),
        ]);
    }

    public function store(TopicRequest $request): RedirectResponse
    {
        $payload = $request->payload();
        $user = Auth::user();

        $topic = DB::transaction(function () use ($payload, $user) {
            $topic = new Topic();
            $topic->fill(collect($payload)->except('publish')->toArray());
            $topic->created_by = $user?->id;
            $topic->updated_by = $user?->id;

            if (($payload['publish'] ?? false) || $topic->status === Topic::STATUS_PUBLISHED) {
                $topic->status = Topic::STATUS_PUBLISHED;
                $topic->published_at = now();
            }

            $topic->save();

            $rendered = $this->renderer->render($topic->fresh('template'));
            $topic->forceFill([
                'rendered_html' => $rendered,
                'rendered_at' => now(),
            ])->save();

            ActivityLog::create([
                'user_id' => $user?->id,
                'action' => 'topic.created',
                'subject_type' => Topic::class,
                'subject_id' => $topic->id,
                'properties' => [
                    'status' => $topic->status,
                    'slug' => $topic->slug,
                ],
            ]);

            return $topic;
        });

        return redirect()
            ->route('admin.topics.edit', $topic)
            ->with('status', 'Topic created');
    }

    public function show(Topic $topic): View
    {
        return view('admin.topics.show', [
            'topic' => $topic->load(['template', 'creator', 'editor']),
            'rendered' => $topic->rendered_html ?? $this->renderer->render($topic),
        ]);
    }

    public function edit(Topic $topic): View
    {
        return view('admin.topics.edit', [
            'topic' => $topic->load(['template', 'category']),
            'templates' => Template::query()->orderBy('name')->get(),
            'categories' => Category::query()->orderBy('name')->get(),
        ]);
    }

    public function update(TopicRequest $request, Topic $topic): RedirectResponse
    {
        $payload = $request->payload();
        $user = Auth::user();

        DB::transaction(function () use ($topic, $payload, $user) {
            $topic->fill(collect($payload)->except('publish')->toArray());
            $topic->updated_by = $user?->id;

            if (($payload['publish'] ?? false) || $topic->status === Topic::STATUS_PUBLISHED) {
                $topic->status = Topic::STATUS_PUBLISHED;
                $topic->published_at ??= now();
            } elseif ($topic->status !== Topic::STATUS_PUBLISHED) {
                $topic->published_at = null;
            }

            $topic->save();

            $rendered = $this->renderer->render($topic->fresh('template'));
            $topic->forceFill([
                'rendered_html' => $rendered,
                'rendered_at' => now(),
            ])->save();

            ActivityLog::create([
                'user_id' => $user?->id,
                'action' => 'topic.updated',
                'subject_type' => Topic::class,
                'subject_id' => $topic->id,
                'properties' => [
                    'status' => $topic->status,
                    'slug' => $topic->slug,
                ],
            ]);
        });

        return redirect()
            ->route('admin.topics.edit', $topic)
            ->with('status', 'Topic updated');
    }

    public function preview(Request $request): JsonResponse
    {
        $payloadRaw = $request->input('data');

        if ($payloadRaw === null || $payloadRaw === '') {
            return response()->json([
                'message' => 'JSON payload is required.',
            ], 422);
        }

        if (is_string($payloadRaw)) {
            try {
                $payload = json_decode($payloadRaw, true, 512, JSON_THROW_ON_ERROR);
            } catch (\JsonException $exception) {
                return response()->json([
                    'message' => 'Invalid JSON payload.',
                    'detail' => $exception->getMessage(),
                ], 422);
            }
        } elseif (is_array($payloadRaw)) {
            $payload = $payloadRaw;
        } else {
            return response()->json([
                'message' => 'Unsupported payload type.',
            ], 422);
        }

        $template = null;
        if ($templateId = $request->input('template_id')) {
            $template = Template::query()->find($templateId);

            if (!$template) {
                return response()->json([
                    'message' => 'Selected template could not be found.',
                ], 422);
            }
        }

        $title = $request->input('title') ?: Arr::get($payload, 'TOPIC');
        $summary = $request->input('summary') ?: Arr::get($payload, 'OPENING_PARAGRAPH_HTML_SAFE');

        $slug = $request->input('slug');
        if (!$slug) {
            $slug = Arr::get($payload, 'slug');
        }
        if (!$slug && $title) {
            $slug = Str::slug($title);
        }
        if (!$slug) {
            $slug = Str::slug('preview-' . Str::random(8));
        }

        $topic = new Topic([
            'title' => $title ?: 'Preview Topic',
            'slug' => $slug,
            'subtitle' => Arr::get($payload, 'SUBTITLE'),
            'summary' => $summary,
            'data' => $payload,
            'status' => Topic::STATUS_DRAFT,
        ]);

        if ($template) {
            $topic->setRelation('template', $template);
            $topic->template_id = $template->id;
        }

        $rendered = $this->renderer->render($topic, $template);

        return response()->json([
            'rendered_html' => $rendered,
            'title' => $topic->title,
            'slug' => $topic->slug,
            'summary' => $topic->summary,
        ]);
    }

    public function destroy(Topic $topic): RedirectResponse
    {
        if ($topic->status === Topic::STATUS_PUBLISHED) {
            throw new HttpException(409, 'Published topics cannot be deleted.');
        }

        $topic->delete();

        ActivityLog::create([
                'user_id' => Auth::id(),
            'action' => 'topic.deleted',
            'subject_type' => Topic::class,
            'subject_id' => $topic->id,
            'properties' => [
                'slug' => $topic->slug,
            ],
        ]);

        return redirect()
            ->route('admin.topics.index')
            ->with('status', 'Topic deleted');
    }

    public function wysiwyg(Topic $topic): View
    {
        // Always use rendered_html if it exists (from WYSIWYG edits), otherwise render from JSON
        if ($topic->rendered_html) {
            $rendered = $topic->rendered_html;
            \Log::info('WYSIWYG Load: Using saved HTML', [
                'topic_id' => $topic->id,
                'rendered_at' => $topic->rendered_at,
                'content_length' => strlen($rendered)
            ]);
        } else {
            $rendered = $this->renderer->render($topic);
            \Log::info('WYSIWYG Load: Rendering from JSON', [
                'topic_id' => $topic->id,
                'content_length' => strlen($rendered)
            ]);
        }
        
        return view('admin.topics.wysiwyg-vivatemplate', [
            'topic' => $topic->load(['template', 'category']),
            'rendered' => $rendered,
            'topicData' => $topic->data ?? [],
        ]);
    }

    public function wysiwygUpdate(Request $request, Topic $topic): JsonResponse
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $user = Auth::user();
        $content = $request->input('content');
        
        // Debug logging
        \Log::info('WYSIWYG Update', [
            'topic_id' => $topic->id,
            'content_length' => strlen($content),
            'content_preview' => substr($content, 0, 200),
            'user_id' => $user?->id
        ]);

        DB::transaction(function () use ($topic, $content, $user) {
            // Update the rendered HTML directly
            $topic->forceFill([
                'rendered_html' => $content,
                'rendered_at' => now(),
                'updated_by' => $user?->id,
            ])->save();

            ActivityLog::create([
                'user_id' => $user?->id,
                'action' => 'topic.wysiwyg_updated',
                'subject_type' => Topic::class,
                'subject_id' => $topic->id,
                'properties' => [
                    'slug' => $topic->slug,
                    'method' => 'wysiwyg',
                ],
            ]);
        });

        $response = [
            'message' => 'Topic updated successfully',
            'updated_at' => $topic->fresh()->updated_at->diffForHumans(),
        ];
        
        // Clean any output buffer before sending JSON
        if (ob_get_length()) {
            ob_clean();
        }
        
        return response()->json($response, 200, [
            'Content-Type' => 'application/json; charset=utf-8'
        ]);
    }

    public function bulkAction(Request $request): RedirectResponse
    {
        $request->validate([
            'action' => 'required|in:publish,unpublish,draft,review,delete,change_category',
            'topics' => 'required|array|min:1',
            'topics.*' => 'exists:topics,id',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        $action = $request->input('action');
        $topicIds = $request->input('topics');
        $categoryId = $request->input('category_id');
        $user = Auth::user();

        $topics = Topic::whereIn('id', $topicIds)->get();
        
        if ($topics->isEmpty()) {
            return redirect()
                ->route('admin.topics.index')
                ->with('error', 'No topics selected');
        }

        $count = 0;

        DB::transaction(function () use ($action, $topics, $categoryId, $user, &$count) {
            foreach ($topics as $topic) {
                $oldStatus = $topic->status;
                $oldCategoryId = $topic->category_id;
                $changed = false;

                switch ($action) {
                    case 'publish':
                        if ($topic->status !== Topic::STATUS_PUBLISHED) {
                            $topic->status = Topic::STATUS_PUBLISHED;
                            $topic->published_at = now();
                            $changed = true;
                        }
                        break;

                    case 'unpublish':
                        if ($topic->status === Topic::STATUS_PUBLISHED) {
                            $topic->status = Topic::STATUS_DRAFT;
                            $topic->published_at = null;
                            $changed = true;
                        }
                        break;

                    case 'draft':
                        if ($topic->status !== Topic::STATUS_DRAFT) {
                            $topic->status = Topic::STATUS_DRAFT;
                            $topic->published_at = null;
                            $changed = true;
                        }
                        break;

                    case 'review':
                        if ($topic->status !== Topic::STATUS_REVIEW) {
                            $topic->status = Topic::STATUS_REVIEW;
                            $topic->published_at = null;
                            $changed = true;
                        }
                        break;

                    case 'change_category':
                        if ($topic->category_id !== $categoryId) {
                            $topic->category_id = $categoryId;
                            $changed = true;
                        }
                        break;

                    case 'delete':
                        // Don't delete published topics
                        if ($topic->status !== Topic::STATUS_PUBLISHED) {
                            ActivityLog::create([
                                'user_id' => $user?->id,
                                'action' => 'topic.bulk_deleted',
                                'subject_type' => Topic::class,
                                'subject_id' => $topic->id,
                                'properties' => [
                                    'status' => $topic->status,
                                    'slug' => $topic->slug,
                                ],
                            ]);
                            $topic->delete();
                            $count++;
                        }
                        continue 2;
                }

                if ($changed) {
                    $topic->updated_by = $user?->id;
                    $topic->save();

                    // Re-render if status changed and it's published
                    if ($topic->status === Topic::STATUS_PUBLISHED && $oldStatus !== Topic::STATUS_PUBLISHED) {
                        $rendered = $this->renderer->render($topic->fresh('template'));
                        $topic->forceFill([
                            'rendered_html' => $rendered,
                            'rendered_at' => now(),
                        ])->save();
                    }

                    ActivityLog::create([
                        'user_id' => $user?->id,
                        'action' => 'topic.bulk_updated',
                        'subject_type' => Topic::class,
                        'subject_id' => $topic->id,
                        'properties' => [
                            'action' => $action,
                            'old_status' => $oldStatus,
                            'new_status' => $topic->status,
                            'old_category_id' => $oldCategoryId,
                            'new_category_id' => $topic->category_id,
                        ],
                    ]);

                    $count++;
                }
            }
        });

        $message = match ($action) {
            'publish' => "Published {$count} topic(s)",
            'unpublish' => "Unpublished {$count} topic(s)",
            'draft' => "Moved {$count} topic(s) to draft",
            'review' => "Moved {$count} topic(s) to review",
            'change_category' => "Changed category for {$count} topic(s)",
            'delete' => "Deleted {$count} topic(s)",
            default => "Updated {$count} topic(s)",
        };

        return redirect()
            ->route('admin.topics.index')
            ->with('status', $message);
    }
}













