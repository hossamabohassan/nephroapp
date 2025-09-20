<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $template->name }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('admin.templates.preview', $template) }}" 
                   class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded" target="_blank">
                    Preview
                </a>
                <a href="{{ route('admin.templates.edit', $template) }}" 
                   class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    Edit
                </a>
                <a href="{{ route('admin.templates.index') }}" 
                   class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Back to Templates
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Template Info -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                        <div class="lg:col-span-2">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Template Information</h3>
                            <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Name</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $template->name }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Slug</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $template->slug }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Category</dt>
                                    <dd class="mt-1">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                            {{ ucfirst($template->category) }}
                                        </span>
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Status</dt>
                                    <dd class="mt-1">
                                        @if($template->is_active)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Active
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                Inactive
                                            </span>
                                        @endif
                                        @if($template->is_default)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 ml-2">
                                                Default
                                            </span>
                                        @endif
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Order</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $template->order }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Created</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $template->created_at->format('M j, Y g:i A') }}</dd>
                                </div>
                            </dl>
                        </div>
                        
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Description</h3>
                            <p class="text-sm text-gray-600">{{ $template->description ?: 'No description provided.' }}</p>
                        </div>
                    </div>

                    <!-- Variables -->
                    @if($template->variables && count($template->variables) > 0)
                        <div class="mb-8">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Template Variables</h3>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    @foreach($template->variables as $key => $value)
                                        <div class="bg-white p-3 rounded border">
                                            <dt class="text-sm font-medium text-gray-500">{{ $key }}</dt>
                                            <dd class="mt-1 text-sm text-gray-900">{{ $value }}</dd>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Code Sections -->
                    <div class="space-y-8">
                        <!-- HTML Content -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">HTML Content</h3>
                            <div class="bg-gray-900 rounded-lg p-4 overflow-x-auto">
                                <pre class="text-green-400 text-sm"><code>{{ $template->html_content }}</code></pre>
                            </div>
                        </div>

                        <!-- CSS Content -->
                        @if($template->css_content)
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-4">CSS Content</h3>
                                <div class="bg-gray-900 rounded-lg p-4 overflow-x-auto">
                                    <pre class="text-blue-400 text-sm"><code>{{ $template->css_content }}</code></pre>
                                </div>
                            </div>
                        @endif

                        <!-- JavaScript Content -->
                        @if($template->js_content)
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-4">JavaScript Content</h3>
                                <div class="bg-gray-900 rounded-lg p-4 overflow-x-auto">
                                    <pre class="text-yellow-400 text-sm"><code>{{ $template->js_content }}</code></pre>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
