<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Layout Templates') }}
            </h2>
            <a href="{{ route('admin.layout-templates.create') }}" 
               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Create Template
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($templates->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($templates as $template)
                                <div class="bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200">
                                    <div class="p-6">
                                        <div class="flex items-center justify-between mb-4">
                                            <h3 class="text-lg font-semibold text-gray-900">{{ $template->name }}</h3>
                                            <div class="flex items-center space-x-2">
                                                @if($template->is_default)
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        Default
                                                    </span>
                                                @endif
                                                @if($template->is_active)
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                        Active
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                        Inactive
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        
                                        <p class="text-gray-600 text-sm mb-4">{{ $template->description }}</p>
                                        
                                        <div class="flex items-center justify-between mb-4">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                                {{ ucfirst($template->category) }}
                                            </span>
                                            <span class="text-sm text-gray-500">Order: {{ $template->order }}</span>
                                        </div>

                                        @if($template->variables)
                                            <div class="mb-4">
                                                <h4 class="text-sm font-medium text-gray-700 mb-2">Variables:</h4>
                                                <div class="flex flex-wrap gap-1">
                                                    @foreach($template->variables as $key => $value)
                                                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-gray-100 text-gray-700">
                                                            {{ $key }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif

                                        <div class="flex items-center justify-between">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('admin.layout-templates.show', $template) }}" 
                                                   class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                                    View
                                                </a>
                                                <a href="{{ route('admin.layout-templates.edit', $template) }}" 
                                                   class="text-green-600 hover:text-green-800 text-sm font-medium">
                                                    Edit
                                                </a>
                                                <a href="{{ route('admin.layout-templates.preview', $template) }}" 
                                                   class="text-purple-600 hover:text-purple-800 text-sm font-medium" target="_blank">
                                                    Preview
                                                </a>
                                            </div>
                                            
                                            <form method="POST" action="{{ route('admin.layout-templates.destroy', $template) }}" 
                                                  class="inline" onsubmit="return confirm('Are you sure you want to delete this template?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No templates</h3>
                            <p class="mt-1 text-sm text-gray-500">Get started by creating a new layout template.</p>
                            <div class="mt-6">
                                <a href="{{ route('admin.layout-templates.create') }}" 
                                   class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                    Create Template
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
