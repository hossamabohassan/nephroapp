<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Topic;
use App\Services\TopicRenderer;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TopicController extends Controller
{
    public function __construct(private readonly TopicRenderer $renderer)
    {
        $this->middleware(['auth', 'verified', 'active']);
    }

    public function index(Request $request): View
    {
        $topics = Topic::query()
            ->published()
            ->with('category')
            ->latest('published_at')
            ->when($search = $request->string('q')->toString(), function ($query) use ($search) {
                $query->where(function ($inner) use ($search) {
                    $inner->where('title', 'like', "%{$search}%")
                        ->orWhere('slug', 'like', "%{$search}%")
                        ->orWhere('summary', 'like', "%{$search}%");
                });
            })
            ->get();

        $categories = Category::query()
            ->orderBy('name')
            ->with(['topics' => function ($query) {
                $query->published()
                    ->select(['id', 'title', 'slug', 'category_id'])
                    ->orderBy('title');
            }])
            ->get();

        return view('topics.index', [
            'topics' => $topics,
            'categories' => $categories,
        ]);
    }

    public function show(Topic $topic): View
    {
        if ($topic->status !== Topic::STATUS_PUBLISHED) {
            throw new NotFoundHttpException();
        }

        $topic->loadMissing('category');

        if (!$topic->rendered_html) {
            $rendered = $this->renderer->render($topic);
            $navigationSections = $this->renderer->getNavigationSections();
            $topic->forceFill([
                'rendered_html' => $rendered,
                'rendered_at' => now(),
            ])->save();
            \Log::info('Frontend: Rendered from JSON and cached', [
                'topic_id' => $topic->id,
                'content_length' => strlen($rendered)
            ]);
        } else {
            $rendered = $topic->rendered_html;
            // For cached content, we need to extract navigation sections from cached HTML
            $this->renderer->extractNavigationSections($rendered, $topic);
            $navigationSections = $this->renderer->getNavigationSections();
            \Log::info('Frontend: Using cached/edited HTML', [
                'topic_id' => $topic->id,
                'content_length' => strlen($rendered),
                'rendered_at' => $topic->rendered_at
            ]);
        }

        $menuItems = \App\Models\MenuItem::query()
            ->active()
            ->ordered()
            ->get();

        // Debug logging
        \Log::info('TopicController: Navigation sections debug', [
            'topic_id' => $topic->id,
            'navigationSections_count' => count($navigationSections ?? []),
            'navigationSections' => $navigationSections ?? [],
            'has_rendered_html' => !empty($topic->rendered_html),
        ]);

        return view('topics.show', [
            'topic' => $topic->fresh(['category']),
            'rendered' => $rendered,
            'menuItems' => $menuItems,
            'navigationSections' => $navigationSections ?? [],
        ]);
    }

    public function create(): RedirectResponse
    {
        return redirect()->route('topics.index');
    }

    public function store(Request $request): RedirectResponse
    {
        return redirect()->route('topics.index');
    }

    public function edit(Topic $topic): RedirectResponse
    {
        return redirect()->route('topics.show', $topic);
    }

    public function update(Request $request, Topic $topic): RedirectResponse
    {
        return redirect()->route('topics.show', $topic);
    }

    public function destroy(Topic $topic): RedirectResponse
    {
        return redirect()->route('topics.index');
    }
}


