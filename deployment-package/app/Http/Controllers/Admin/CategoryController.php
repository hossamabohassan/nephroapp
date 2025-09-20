<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'active']);
        $this->middleware('can:manage-topics');
    }

    public function index(Request $request): View
    {
        $categories = Category::query()
            ->withCount('topics')
            ->when($search = $request->string('q')->toString(), function ($query) use ($search) {
                $query->where(function ($inner) use ($search) {
                    $inner->where('name', 'like', "%{$search}%")
                        ->orWhere('slug', 'like', "%{$search}%");
                });
            })
            ->orderBy('name')
            ->paginate(20)
            ->withQueryString();

        $stats = [
            'total' => Category::count(),
            'withTopics' => Category::has('topics')->count(),
            'empty' => Category::doesntHave('topics')->count(),
        ];

        return view('admin.categories.index', [
            'categories' => $categories,
            'stats' => $stats,
            'filters' => [
                'q' => $request->query('q'),
            ],
        ]);
    }

    public function create(): View
    {
        return view('admin.categories.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:categories,name'],
            'slug' => ['nullable', 'string', 'max:255', 'alpha_dash', 'unique:categories,slug'],
            'description' => ['nullable', 'string', 'max:500'],
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        // Ensure slug is unique
        $originalSlug = $validated['slug'];
        $counter = 1;
        while (Category::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $originalSlug . '-' . $counter;
            $counter++;
        }

        Category::create($validated);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category created successfully.');
    }

    public function show(Category $category): View
    {
        $category->load(['topics' => function ($query) {
            $query->latest('updated_at')->limit(10);
        }]);

        return view('admin.categories.show', [
            'category' => $category,
            'recentTopics' => $category->topics,
            'stats' => [
                'topicsCount' => $category->topics()->count(),
                'publishedCount' => $category->topics()->where('status', 'published')->count(),
                'draftCount' => $category->topics()->where('status', 'draft')->count(),
            ],
        ]);
    }

    public function edit(Category $category): View
    {
        return view('admin.categories.edit', [
            'category' => $category,
        ]);
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('categories', 'name')->ignore($category)],
            'slug' => ['nullable', 'string', 'max:255', 'alpha_dash', Rule::unique('categories', 'slug')->ignore($category)],
            'description' => ['nullable', 'string', 'max:500'],
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        // Ensure slug is unique (excluding current category)
        $originalSlug = $validated['slug'];
        $counter = 1;
        while (Category::where('slug', $validated['slug'])->where('id', '!=', $category->id)->exists()) {
            $validated['slug'] = $originalSlug . '-' . $counter;
            $counter++;
        }

        $category->update($validated);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        // Check if category has topics
        if ($category->topics()->exists()) {
            return redirect()
                ->route('admin.categories.index')
                ->with('error', 'Cannot delete category that contains topics. Please move or delete the topics first.');
        }

        $category->delete();

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category deleted successfully.');
    }
}
