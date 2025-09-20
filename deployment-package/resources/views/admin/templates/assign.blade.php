<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Assign Templates to Pages') }}
            </h2>
            <a href="{{ route('admin.templates.index') }}" 
               class="inline-block bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded transition-colors duration-200">
                Back to Templates
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Template Assignment</h3>
                        <p class="text-sm text-gray-600">Assign different templates to different pages in your website.</p>
                    </div>

                    <form method="POST" action="{{ route('admin.templates.assign') }}">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="page_route" class="block text-sm font-medium text-gray-700">Page Route</label>
                                <select name="page_route" id="page_route" 
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                                    <option value="">Select a page</option>
                                    @foreach($availableRoutes as $route => $name)
                                        <option value="{{ $route }}">{{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div>
                                <label for="template_id" class="block text-sm font-medium text-gray-700">Template</label>
                                <select name="template_id" id="template_id" 
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                                    <option value="">Select a template</option>
                                    @foreach($templates as $template)
                                        <option value="{{ $template->id }}">{{ $template->name }} ({{ ucfirst($template->category) }})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mt-6">
                            <button type="submit" 
                                    class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition-colors duration-200">
                                Assign Template
                            </button>
                        </div>
                    </form>

                    <!-- Current Assignments -->
                    <div class="mt-12">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Current Template Assignments</h3>
                        <div class="bg-gray-50 rounded-lg p-4">
                            @if($currentAssignments->count() > 0)
                                <div class="space-y-2">
                                    @foreach($currentAssignments as $assignment)
                                        <div class="flex items-center justify-between bg-white p-3 rounded border">
                                            <div>
                                                <span class="font-medium">{{ $assignment->page_name }}</span>
                                                <span class="text-gray-500 ml-2">({{ $assignment->route }})</span>
                                            </div>
                                            <div class="flex items-center space-x-2">
                                                <span class="text-sm text-gray-600">{{ $assignment->template_name }}</span>
                                                <form method="POST" action="{{ route('admin.templates.unassign') }}" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="route" value="{{ $assignment->route }}">
                                                    <button type="submit" class="inline-block bg-red-100 hover:bg-red-200 text-red-700 hover:text-red-800 font-medium py-1 px-3 rounded text-sm transition-colors duration-200">
                                                        Remove
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-500 text-center py-4">No template assignments found.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>