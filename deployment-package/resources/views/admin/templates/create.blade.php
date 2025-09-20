<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Create Layout Template') }}
            </h2>
            <a href="{{ route('admin.templates.index') }}" 
               class="inline-block bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded transition-colors duration-200">
                Back to Templates
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Template Presets -->
            <div class="mb-8">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Start Templates</h3>
                <p class="text-sm text-gray-600 mb-4">Choose a preset template to auto-fill the form, or start from scratch.</p>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <!-- Modern Profile Template -->
                    <div class="template-preset bg-white border border-gray-200 rounded-lg p-4 hover:border-blue-500 cursor-pointer transition-colors" 
                         onclick="loadTemplate('modern-profile')">
                        <div class="flex items-center mb-2">
                            <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center text-white text-sm font-bold mr-3">P</div>
                            <h4 class="font-medium text-gray-900">Modern Profile</h4>
                        </div>
                        <p class="text-sm text-gray-600">Animated profile layout with sidebar and user info</p>
                        <span class="inline-block mt-2 px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded">Profile</span>
                    </div>

                    <!-- Clean Admin Template -->
                    <div class="template-preset bg-white border border-gray-200 rounded-lg p-4 hover:border-green-500 cursor-pointer transition-colors" 
                         onclick="loadTemplate('clean-admin')">
                        <div class="flex items-center mb-2">
                            <div class="w-8 h-8 bg-green-500 rounded-lg flex items-center justify-center text-white text-sm font-bold mr-3">A</div>
                            <h4 class="font-medium text-gray-900">Clean Admin</h4>
                        </div>
                        <p class="text-sm text-gray-600">Professional admin dashboard layout</p>
                        <span class="inline-block mt-2 px-2 py-1 bg-green-100 text-green-800 text-xs rounded">Admin</span>
                    </div>

                    <!-- Hero Landing Template -->
                    <div class="template-preset bg-white border border-gray-200 rounded-lg p-4 hover:border-purple-500 cursor-pointer transition-colors" 
                         onclick="loadTemplate('hero-landing')">
                        <div class="flex items-center mb-2">
                            <div class="w-8 h-8 bg-purple-500 rounded-lg flex items-center justify-center text-white text-sm font-bold mr-3">H</div>
                            <h4 class="font-medium text-gray-900">Hero Landing</h4>
                        </div>
                        <p class="text-sm text-gray-600">Modern hero section with call-to-action buttons</p>
                        <span class="inline-block mt-2 px-2 py-1 bg-purple-100 text-purple-800 text-xs rounded">Landing</span>
                    </div>

                    <!-- Blog Post Template -->
                    <div class="template-preset bg-white border border-gray-200 rounded-lg p-4 hover:border-orange-500 cursor-pointer transition-colors" 
                         onclick="loadTemplate('blog-post')">
                        <div class="flex items-center mb-2">
                            <div class="w-8 h-8 bg-orange-500 rounded-lg flex items-center justify-center text-white text-sm font-bold mr-3">B</div>
                            <h4 class="font-medium text-gray-900">Blog Post</h4>
                        </div>
                        <p class="text-sm text-gray-600">Clean blog post layout with author info</p>
                        <span class="inline-block mt-2 px-2 py-1 bg-orange-100 text-orange-800 text-xs rounded">Blog</span>
                    </div>

                    <!-- Contact Page Template -->
                    <div class="template-preset bg-white border border-gray-200 rounded-lg p-4 hover:border-red-500 cursor-pointer transition-colors" 
                         onclick="loadTemplate('contact-page')">
                        <div class="flex items-center mb-2">
                            <div class="w-8 h-8 bg-red-500 rounded-lg flex items-center justify-center text-white text-sm font-bold mr-3">C</div>
                            <h4 class="font-medium text-gray-900">Contact Page</h4>
                        </div>
                        <p class="text-sm text-gray-600">Contact form with company information</p>
                        <span class="inline-block mt-2 px-2 py-1 bg-red-100 text-red-800 text-xs rounded">General</span>
                    </div>

                    <!-- E-commerce Product Template -->
                    <div class="template-preset bg-white border border-gray-200 rounded-lg p-4 hover:border-indigo-500 cursor-pointer transition-colors" 
                         onclick="loadTemplate('product-page')">
                        <div class="flex items-center mb-2">
                            <div class="w-8 h-8 bg-indigo-500 rounded-lg flex items-center justify-center text-white text-sm font-bold mr-3">E</div>
                            <h4 class="font-medium text-gray-900">Product Page</h4>
                        </div>
                        <p class="text-sm text-gray-600">E-commerce product showcase layout</p>
                        <span class="inline-block mt-2 px-2 py-1 bg-indigo-100 text-indigo-800 text-xs rounded">Custom</span>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- JSON Import Section -->
                    <div class="mb-8 p-4 bg-gray-50 rounded-lg border">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Import from JSON</h3>
                        <p class="text-sm text-gray-600 mb-4">Paste a JSON template code here to auto-fill all fields. You can get this from AI tools like ChatGPT or Gemini.</p>
                        <div class="mb-4 p-3 bg-blue-50 border border-blue-200 rounded-md">
                            <p class="text-sm text-blue-800">
                                <strong>For AI tools:</strong> When asking ChatGPT or other AI tools to generate template JSON, specify that you need valid JSON format with proper escaping for HTML content. 
                                Use <code>{content}</code> for variables in HTML content, or <code>@{{content}}</code> if you need Blade template syntax.
                            </p>
                        </div>
                        <div class="flex space-x-4">
                        <textarea id="json-import" rows="6" 
                                  class="flex-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 font-mono text-sm" 
                                  placeholder="Paste your JSON template code here, for example:
{
  &quot;name&quot;: &quot;My Template&quot;,
  &quot;description&quot;: &quot;Template description&quot;,
  &quot;category&quot;: &quot;profile&quot;,
  &quot;html_content&quot;: &quot;&lt;div&gt;{content}&lt;/div&gt;&quot;,
  &quot;css_content&quot;: &quot;.my-class { color: blue; }&quot;,
  &quot;js_content&quot;: &quot;console.log('Hello');&quot;,
  &quot;variables&quot;: {
    &quot;content&quot;: &quot;Default content&quot;,
    &quot;title&quot;: &quot;Default title&quot;
  }
}"></textarea>
                            <div class="flex flex-col space-y-2">
                                <button type="button" onclick="importFromJson()" 
                                        class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition-colors duration-200">
                                    Apply JSON
                                </button>
                                <button type="button" onclick="clearForm()" 
                                        class="inline-block bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded transition-colors duration-200">
                                    Clear Form
                                </button>
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('admin.templates.store') }}">
                        @csrf
                        
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Left Column - Basic Info -->
                            <div class="space-y-6">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700">Template Name</label>
                                    <input type="text" name="name" id="name" value="{{ old('name') }}" 
                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                                    @error('name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                    <textarea name="description" id="description" rows="3" 
                                              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('description') }}</textarea>
                                </div>

                                <div>
                                    <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                                    <select name="category" id="category" 
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category }}" {{ old('category') == $category ? 'selected' : '' }}>
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
                                    <input type="number" name="order" id="order" value="{{ old('order', 0) }}" min="0"
                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                </div>

                                <div class="flex items-center space-x-4">
                                    <div class="flex items-center">
                                        <input type="checkbox" name="is_active" id="is_active" value="1" 
                                               {{ old('is_active', true) ? 'checked' : '' }}
                                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <label for="is_active" class="ml-2 block text-sm text-gray-900">Active</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="checkbox" name="is_default" id="is_default" value="1" 
                                               {{ old('is_default') ? 'checked' : '' }}
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
                                              placeholder="Enter your HTML template here. Use {!! '{{variable_name}}' !!} for dynamic content." required>{{ old('html_content') }}</textarea>
                                    @error('html_content')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="css_content" class="block text-sm font-medium text-gray-700">CSS Content</label>
                                    <textarea name="css_content" id="css_content" rows="8" 
                                              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 font-mono text-sm" 
                                              placeholder="Enter your CSS styles here.">{{ old('css_content') }}</textarea>
                                </div>

                                <div>
                                    <label for="js_content" class="block text-sm font-medium text-gray-700">JavaScript Content</label>
                                    <textarea name="js_content" id="js_content" rows="6" 
                                              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 font-mono text-sm" 
                                              placeholder="Enter your JavaScript code here.">{{ old('js_content') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Variables Section -->
                        <div class="mt-8">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Template Variables</h3>
                            <div id="variables-container">
                                <div class="variable-row flex items-center space-x-4 mb-2">
                                    <input type="text" name="variable_names[]" placeholder="Variable Name" 
                                           class="flex-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    <input type="text" name="variable_defaults[]" placeholder="Default Value" 
                                           class="flex-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    <button type="button" onclick="removeVariable(this)" 
                                            class="inline-block bg-red-100 hover:bg-red-200 text-red-700 hover:text-red-800 font-medium py-1 px-3 rounded text-sm transition-colors duration-200">Remove</button>
                                </div>
                            </div>
                            <button type="button" onclick="addVariable()" 
                                    class="mt-2 inline-block bg-blue-100 hover:bg-blue-200 text-blue-700 hover:text-blue-800 font-medium py-2 px-4 rounded text-sm transition-colors duration-200">
                                + Add Variable
                            </button>
                        </div>

                        <div class="mt-8 flex justify-end space-x-4">
                            <a href="{{ route('admin.templates.index') }}" 
                               class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded transition-colors duration-200">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition-colors duration-200">
                                Create Template
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
                        class="inline-block bg-red-100 hover:bg-red-200 text-red-700 hover:text-red-800 font-medium py-1 px-3 rounded text-sm transition-colors duration-200">Remove</button>
            `;
            container.appendChild(newRow);
        }

        function removeVariable(button) {
            button.parentElement.remove();
        }

        function importFromJson() {
            const jsonText = document.getElementById('json-import').value.trim();
            
            if (!jsonText) {
                alert('Please paste JSON code first');
                return;
            }

            try {
                // Clean up the JSON text - remove any potential Blade syntax issues
                let cleanJsonText = jsonText;
                
                // Parse the JSON
                const templateData = JSON.parse(cleanJsonText);
                
                // Validate required fields
                if (!templateData.name) {
                    alert('JSON must contain a "name" field');
                    return;
                }
                
                if (!templateData.html_content) {
                    alert('JSON must contain an "html_content" field');
                    return;
                }
                
                // Fill basic fields
                if (templateData.name) document.getElementById('name').value = templateData.name;
                if (templateData.description) document.getElementById('description').value = templateData.description;
                if (templateData.category) document.getElementById('category').value = templateData.category;
                if (templateData.order !== undefined) document.getElementById('order').value = templateData.order;
                
                // Fill content fields
                if (templateData.html_content) document.getElementById('html_content').value = templateData.html_content;
                if (templateData.css_content) document.getElementById('css_content').value = templateData.css_content;
                if (templateData.js_content) document.getElementById('js_content').value = templateData.js_content;
                
                // Handle variables
                if (templateData.variables && typeof templateData.variables === 'object') {
                    // Clear existing variables
                    const container = document.getElementById('variables-container');
                    container.innerHTML = '';
                    
                    // Add variables from JSON
                    Object.entries(templateData.variables).forEach(([key, value]) => {
                        const newRow = document.createElement('div');
                        newRow.className = 'variable-row flex items-center space-x-4 mb-2';
                        newRow.innerHTML = `
                            <input type="text" name="variable_names[]" placeholder="Variable Name" 
                                   value="${key.replace(/"/g, '&quot;')}" class="flex-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <input type="text" name="variable_defaults[]" placeholder="Default Value" 
                                   value="${String(value).replace(/"/g, '&quot;')}" class="flex-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <button type="button" onclick="removeVariable(this)" 
                                    class="inline-block bg-red-100 hover:bg-red-200 text-red-700 hover:text-red-800 font-medium py-1 px-3 rounded text-sm transition-colors duration-200">Remove</button>
                        `;
                        container.appendChild(newRow);
                    });
                }
                
                // Set checkboxes
                if (templateData.is_active !== undefined) {
                    document.getElementById('is_active').checked = Boolean(templateData.is_active);
                }
                if (templateData.is_default !== undefined) {
                    document.getElementById('is_default').checked = Boolean(templateData.is_default);
                }
                
                alert('Template data imported successfully!');
                
            } catch (error) {
                let errorMessage = 'Invalid JSON format. Please check your JSON code.\n\n';
                
                if (error.message.includes('Unexpected token')) {
                    errorMessage += 'Common issues:\n';
                    errorMessage += '- Missing quotes around property names\n';
                    errorMessage += '- Trailing commas\n';
                    errorMessage += '- Unescaped quotes in strings\n';
                    errorMessage += '- Invalid characters\n\n';
                }
                
                errorMessage += 'Error: ' + error.message;
                alert(errorMessage);
            }
        }

        function clearForm() {
            if (confirm('Are you sure you want to clear all form fields?')) {
                document.querySelector('form').reset();
                document.getElementById('json-import').value = '';
                document.getElementById('variables-container').innerHTML = `
                    <div class="variable-row flex items-center space-x-4 mb-2">
                        <input type="text" name="variable_names[]" placeholder="Variable Name" 
                               class="flex-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <input type="text" name="variable_defaults[]" placeholder="Default Value" 
                               class="flex-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <button type="button" onclick="removeVariable(this)" 
                                class="inline-block bg-red-100 hover:bg-red-200 text-red-700 hover:text-red-800 font-medium py-1 px-3 rounded text-sm transition-colors duration-200">Remove</button>
                    </div>
                `;
            }
        }
    </script>
</x-admin-layout>
