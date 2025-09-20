@php
    $pageTitle = 'Edit Topic: ' . $topic->title;
    $pageDescription = 'Update medical topic content and preview changes';
@endphp

<x-admin-layout :page-title="$pageTitle" :page-description="$pageDescription">

    @php
        $dataJson = json_encode($topic->data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        $metaJson = $topic->meta ? json_encode($topic->meta, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) : '';
    @endphp

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">{{ $pageTitle }}</h1>
            <p class="text-sm text-slate-600">{{ $pageDescription }}</p>
        </div>
        <div class="flex items-center gap-3 text-sm">
            <a href="{{ route('admin.topics.wysiwyg', $topic) }}" class="inline-flex items-center px-3 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors">
                {{ __('WYSIWYG Editor') }}
            </a>
            <a href="{{ route('topics.show', $topic) }}" class="inline-flex items-center px-3 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                {{ __('View Live') }}
            </a>
            <a href="{{ route('admin.topics.show', $topic) }}" class="inline-flex items-center px-3 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                {{ __('Admin Preview') }}
            </a>
        </div>
    </div>

    <div class="space-y-6" id="topicStudio" data-preview-url="{{ route('admin.topics.preview') }}">
            @if (session('status'))
                <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded">
                    <p class="font-semibold">{{ __('Please fix the highlighted errors.') }}</p>
                </div>
            @endif

        <div class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_minmax(0,0.9fr)]">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200 space-y-6">
                    <form method="POST" action="{{ route('admin.topics.update', $topic) }}" class="space-y-6" id="topicForm">
                        @csrf
                        @method('PUT')

                        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                            <div class="text-sm text-gray-500">
                                {{ __('Update the structured data, preview changes instantly, then publish when ready.') }}
                            </div>
                            <div class="flex gap-2">
                                <button type="button" id="autofillFromJson" class="inline-flex items-center px-3 py-2 border border-indigo-200 text-sm font-medium rounded-md text-indigo-600 bg-white hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    {{ __('Refresh from JSON') }}
                                </button>
                                <button type="button" id="previewTopic" class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    {{ __('Preview') }}
                                </button>
                            </div>
                        </div>

                        <div>
                            <label for="data" class="block text-sm font-medium text-gray-700">{{ __('Topic JSON Payload') }}</label>
                            <textarea id="data" name="data" rows="16" class="mt-1 font-mono text-sm block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>{{ old('data', $dataJson) }}</textarea>
                            <x-input-error :messages="$errors->get('data')" class="mt-2" />
                        </div>

                        <div class="grid gap-6 md:grid-cols-2">
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700">{{ __('Title') }}</label>
                                <input id="title" name="title" type="text" value="{{ old('title', $topic->title) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" autocomplete="off" required>
                                <x-input-error :messages="$errors->get('title')" class="mt-2" />
                            </div>

                            <div>
                                <label for="slug" class="block text-sm font-medium text-gray-700">{{ __('Slug') }}</label>
                                <input id="slug" name="slug" type="text" value="{{ old('slug', $topic->slug) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" autocomplete="off" required>
                                <x-input-error :messages="$errors->get('slug')" class="mt-2" />
                            </div>

                            <div>
                                <label for="subtitle" class="block text-sm font-medium text-gray-700">{{ __('Subtitle') }}</label>
                                <input id="subtitle" name="subtitle" type="text" value="{{ old('subtitle', $topic->subtitle) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <x-input-error :messages="$errors->get('subtitle')" class="mt-2" />
                            </div>

                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700">{{ __('Status') }}</label>
                                <select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="draft" @selected(old('status', $topic->status) === 'draft')>{{ __('Draft') }}</option>
                                    <option value="review" @selected(old('status', $topic->status) === 'review')>{{ __('Review') }}</option>
                                    <option value="published" @selected(old('status', $topic->status) === 'published')>{{ __('Published') }}</option>
                                </select>
                                <x-input-error :messages="$errors->get('status')" class="mt-2" />
                            </div>

                            <div>
                                <label for="template_id" class="block text-sm font-medium text-gray-700">{{ __('Template') }}</label>
                                <select id="template_id" name="template_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">{{ __('Default template') }}</option>
                                    @foreach ($templates as $template)
                                        <option value="{{ $template->id }}" @selected(old('template_id', $topic->template_id) == $template->id)>{{ $template->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('template_id')" class="mt-2" />
                            </div>

                            <div>
                                <label for="category_id" class="block text-sm font-medium text-gray-700">{{ __('Category') }}</label>
                                <select id="category_id" name="category_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">{{ __('Uncategorized') }}</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" @selected(old('category_id', $topic->category_id) == $category->id)>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                            </div>

                            <div>
                                <label for="summary" class="block text-sm font-medium text-gray-700">{{ __('Summary (HTML)') }}</label>
                                <textarea id="summary" name="summary" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('summary', $topic->summary) }}</textarea>
                                <x-input-error :messages="$errors->get('summary')" class="mt-2" />
                            </div>
                        </div>

                        <div>
                            <label for="meta" class="block text-sm font-medium text-gray-700">{{ __('Meta (optional JSON)') }}</label>
                            <textarea id="meta" name="meta" rows="6" class="mt-1 font-mono text-sm block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('meta', $metaJson) }}</textarea>
                            <x-input-error :messages="$errors->get('meta')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-between">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="publish" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" @checked(old('publish', $topic->status === \App\Models\Topic::STATUS_PUBLISHED))>
                                <span class="ms-2 text-sm text-gray-700">{{ __('Publish now') }}</span>
                            </label>

                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:border-indigo-700 focus:ring focus:ring-indigo-200 disabled:opacity-25 transition">
                                {{ __('Update Topic') }}
                            </button>
                        </div>
                    </form>
                </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200 flex flex-col gap-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">{{ __('Live Preview') }}</h3>
                        <p class="text-sm text-gray-500">{{ __('Run a preview after editing the JSON to verify the rendered layout.') }}</p>
                    </div>
                    <div id="previewStatus" class="hidden rounded-md border px-4 py-2 text-sm"></div>
                    <iframe id="previewFrame" title="Live preview" class="w-full bg-gray-50 border border-dashed border-gray-200 rounded-lg" style="min-height:65vh;"></iframe>
                </div>
            </div>

        @if ($topic->status !== \App\Models\Topic::STATUS_PUBLISHED)
            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200 flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">{{ __('Danger zone') }}</h3>
                        <p class="text-sm text-gray-500">{{ __('Drafts and review topics can be deleted permanently from here.') }}</p>
                    </div>
                    <form method="POST" action="{{ route('admin.topics.destroy', $topic) }}" onsubmit="return confirm('{{ __('Are you sure? This cannot be undone.') }}');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:outline-none focus:border-red-700 focus:ring focus:ring-red-200 disabled:opacity-25 transition">
                            {{ __('Delete Topic') }}
                        </button>
                    </form>
            </div>
        @endif
    </div>

    <script>
        (function () {
            const studio = document.getElementById('topicStudio');
            if (!studio) return;

            const previewUrl = studio.dataset.previewUrl;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
            const jsonField = document.getElementById('data');
            const metaField = document.getElementById('meta');
            const titleField = document.getElementById('title');
            const slugField = document.getElementById('slug');
            const subtitleField = document.getElementById('subtitle');
            const summaryField = document.getElementById('summary');
            const templateField = document.getElementById('template_id');
            const autofillBtn = document.getElementById('autofillFromJson');
            const previewBtn = document.getElementById('previewTopic');
            const statusBox = document.getElementById('previewStatus');
            const frame = document.getElementById('previewFrame');

            const setFrameContent = (html) => {
                if (!frame) return;
                frame.srcdoc = `<!doctype html><html><head><base target="_blank"></head><body class="p-6 text-sm text-gray-700">${html}</body></html>`;
            };

            setFrameContent(`<p>{{ __('Preview output will appear here.') }}</p>`);

            const setStatus = (message, variant = 'info') => {
                const baseClasses = 'rounded-md border px-4 py-2 text-sm';
                const variants = {
                    info: 'border-blue-200 bg-blue-50 text-blue-700',
                    success: 'border-green-200 bg-green-50 text-green-700',
                    error: 'border-red-200 bg-red-50 text-red-700'
                };
                statusBox.className = `${baseClasses} ${variants[variant] ?? variants.info}`;
                statusBox.textContent = message;
                statusBox.classList.remove('hidden');
            };

            const clearStatus = () => {
                statusBox.classList.add('hidden');
                statusBox.textContent = '';
            };

            const parseJsonField = () => {
                const raw = jsonField.value.trim();
                if (!raw) {
                    setStatus('{{ __('Paste JSON into the payload field to continue.') }}', 'info');
                    return null;
                }
                try {
                    return JSON.parse(raw);
                } catch (error) {
                    setStatus('{{ __('The JSON payload could not be parsed. Check for syntax issues such as missing commas or quotes.') }}', 'error');
                    return null;
                }
            };

            const applyValuesFromJson = (payload) => {
                if (!payload || typeof payload !== 'object') return;

                if (!titleField.value && payload.TOPIC) {
                    titleField.value = payload.TOPIC;
                }
                if (!slugField.value) {
                    const jsonSlug = payload.slug || payload.SLUG;
                    if (jsonSlug) {
                        slugField.value = jsonSlug;
                    } else if (titleField.value) {
                        slugField.value = titleField.value.toLowerCase()
                            .trim()
                            .replace(/[^a-z0-9\s-]/g, '')
                            .replace(/\s+/g, '-')
                            .replace(/-+/g, '-');
                    }
                }
                if (!subtitleField.value && payload.SUBTITLE) {
                    subtitleField.value = payload.SUBTITLE;
                }
                if (!summaryField.value && payload.OPENING_PARAGRAPH_HTML_SAFE) {
                    summaryField.value = payload.OPENING_PARAGRAPH_HTML_SAFE;
                }
            };

            const preview = async () => {
                if (!jsonField.value.trim()) {
                    setStatus('{{ __('Paste JSON into the payload field to continue.') }}', 'info');
                    return;
                }

                clearStatus();
                setStatus('{{ __('Rendering preview...') }}', 'info');

                try {
                    const response = await fetch(previewUrl, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({
                            data: jsonField.value,
                            meta: metaField.value || null,
                            title: titleField.value,
                            slug: slugField.value,
                            summary: summaryField.value,
                            template_id: templateField.value || null,
                        }),
                    });

                    const raw = await response.text();
                    const cleaned = raw.replace(/^\uFEFF/, '');
                    let result = {};

                    if (cleaned) {
                        try {
                            result = JSON.parse(cleaned);
                        } catch (jsonError) {
                            throw new Error('{{ __('Preview response was not valid JSON.') }}');
                        }
                    }

                    if (!response.ok) {
                        throw new Error(result.detail || result.message || response.statusText);
                    }

                    if (result.title && !titleField.value) {
                        titleField.value = result.title;
                    }
                    if (result.slug && !slugField.value) {
                        slugField.value = result.slug;
                    }
                    if (result.summary && !summaryField.value) {
                        summaryField.value = result.summary;
                    }

                    setFrameContent(result.rendered_html || '<p class="text-sm text-gray-400">{{ __('Preview succeeded but returned empty output.') }}</p>');
                    setStatus('{{ __('Preview updated. Review the rendered output.') }}', 'success');
                } catch (error) {
                    setFrameContent('<p class="text-sm text-red-600">' + (error.message || '{{ __('Unable to render preview.') }}') + '</p>');
                    setStatus(error.message || '{{ __('Unable to render preview.') }}', 'error');
                }
            };

            autofillBtn?.addEventListener('click', () => {
                const payload = parseJsonField();
                if (!payload) return;
                applyValuesFromJson(payload);
                setStatus('{{ __('Key fields were filled from the JSON payload.') }}', 'success');
            });

            previewBtn?.addEventListener('click', preview);

            if (jsonField.value.trim()) {
                const payload = parseJsonField();
                if (payload) {
                    applyValuesFromJson(payload);
                    preview();
                }
            }
        })();
    </script>
</x-admin-layout>

