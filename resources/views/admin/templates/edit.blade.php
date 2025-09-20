<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Template') }} - {{ $template->name }}
            </h2>
            <div class="flex items-center space-x-2">
                <a href="{{ route('admin.templates.interactive-preview', $template) }}" 
                   class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" target="_blank">
                    Interactive Preview
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
                    <form method="POST" action="{{ route('admin.templates.update', $template) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Left Column - Basic Info -->
                            <div class="space-y-6">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700">Template Name</label>
                                    <input type="text" name="name" id="name" value="{{ old('name', $template->name) }}" 
                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                                    @error('name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                    <textarea name="description" id="description" rows="3" 
                                              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('description', $template->description) }}</textarea>
                                </div>

                                <div>
                                    <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                                    <select name="category" id="category" 
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category }}" {{ old('category', $template->category) == $category ? 'selected' : '' }}>
                                                {{ ucfirst($category) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="order" class="block text-sm font-medium text-gray-700">Order</label>
                                    <input type="number" name="order" id="order" value="{{ old('order', $template->order) }}" min="0"
                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                </div>

                                <div class="flex items-center space-x-4">
                                    <div class="flex items-center">
                                        <input type="checkbox" name="is_active" id="is_active" value="1" 
                                               {{ old('is_active', $template->is_active) ? 'checked' : '' }}
                                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <label for="is_active" class="ml-2 block text-sm text-gray-900">Active</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="checkbox" name="is_default" id="is_default" value="1" 
                                               {{ old('is_default', $template->is_default) ? 'checked' : '' }}
                                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <label for="is_default" class="ml-2 block text-sm text-gray-900">Default for Category</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column - Content -->
                            <div class="space-y-6">
                                <div>
                                    <label for="html_content" class="block text-sm font-medium text-gray-700">HTML Content</label>
                                    <textarea name="html_content" id="html_content" rows="10" 
                                              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 font-mono text-sm" 
                                              placeholder="Enter your HTML template here. Use {!! '{{variable_name}}' !!} for dynamic content." required>{{ old('html_content', $template->html_content) }}</textarea>
                                    @error('html_content')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="css_content" class="block text-sm font-medium text-gray-700">CSS Content</label>
                                    <textarea name="css_content" id="css_content" rows="8" 
                                              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 font-mono text-sm" 
                                              placeholder="Enter your CSS styles here.">{{ old('css_content', $template->css_content) }}</textarea>
                                </div>

                                <div>
                                    <label for="js_content" class="block text-sm font-medium text-gray-700">JavaScript Content</label>
                                    <textarea name="js_content" id="js_content" rows="6" 
                                              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 font-mono text-sm" 
                                              placeholder="Enter your JavaScript code here.">{{ old('js_content', $template->js_content) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Variables Section -->
                        <div class="mt-8">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Template Variables</h3>
                            <div id="variables-container">
                                @if($template->variables && count($template->variables) > 0)
                                    @foreach($template->variables as $key => $value)
                                        <div class="variable-row flex items-center space-x-4 mb-2">
                                            <input type="text" name="variable_names[]" placeholder="Variable Name" 
                                                   value="{{ $key }}"
                                                   class="flex-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                            <input type="text" name="variable_defaults[]" placeholder="Default Value" 
                                                   value="{{ $value }}"
                                                   class="flex-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                            <button type="button" onclick="removeVariable(this)" 
                                                    class="text-red-600 hover:text-red-800">Remove</button>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="variable-row flex items-center space-x-4 mb-2">
                                        <input type="text" name="variable_names[]" placeholder="Variable Name" 
                                               class="flex-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                        <input type="text" name="variable_defaults[]" placeholder="Default Value" 
                                               class="flex-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                        <button type="button" onclick="removeVariable(this)" 
                                                class="text-red-600 hover:text-red-800">Remove</button>
                                    </div>
                                @endif
                            </div>
                            <button type="button" onclick="addVariable()" 
                                    class="mt-2 text-blue-600 hover:text-blue-800 text-sm font-medium">
                                + Add Variable
                            </button>
                        </div>

                        <div class="mt-8 flex justify-end space-x-4">
                            <a href="{{ route('admin.templates.index') }}" 
                               class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Update Template
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function addVariable() {
            const container = document.getElementById('variables-container');
            const newRow = document.createElement('div');
            newRow.className = 'variable-row flex items-center space-x-4 mb-2';
            newRow.innerHTML = `
                <input type="text" name="variable_names[]" placeholder="Variable Name" 
                       class="flex-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                <input type="text" name="variable_defaults[]" placeholder="Default Value" 
                       class="flex-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                <button type="button" onclick="removeVariable(this)" 
                        class="text-red-600 hover:text-red-800">Remove</button>
            `;
            container.appendChild(newRow);
        }

        function removeVariable(button) {
            button.parentElement.remove();
        }
    </script>
</x-admin-layout>
