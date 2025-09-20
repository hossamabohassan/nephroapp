<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Interactive Preview - {{ $template->name }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Alpine.js for template interactivity -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- SortableJS for drag and drop -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    
    <!-- Template CSS -->
    <style>
        {!! $template->css_content !!}
        
        /* Interactive Preview Styles */
        .preview-container {
            position: relative;
        }
        
        .template-variable {
            position: relative;
            outline: 2px dashed transparent;
            transition: outline-color 0.2s;
        }
        
        .template-variable:hover {
            outline-color: #3b82f6;
        }
        
        .template-variable.editing {
            outline-color: #ef4444;
            outline-style: solid;
        }
        
        .variable-controls {
            position: absolute;
            top: -30px;
            right: 0;
            background: #1f2937;
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            opacity: 0;
            transition: opacity 0.2s;
            z-index: 1000;
        }
        
        .template-variable:hover .variable-controls {
            opacity: 1;
        }
        
        .variable-content {
            display: inline;
        }
        
        .toolbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: #1f2937;
            color: white;
            padding: 12px 20px;
            z-index: 9999;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .main-content {
            margin-top: 60px;
        }
        
        .variables-panel {
            position: fixed;
            left: -300px;
            top: 60px;
            bottom: 0;
            width: 300px;
            background: white;
            border-right: 1px solid #e5e7eb;
            transition: left 0.3s;
            z-index: 9998;
            overflow-y: auto;
        }
        
        .variables-panel.open {
            left: 0;
        }
        
        .variable-item {
            padding: 12px;
            border-bottom: 1px solid #e5e7eb;
            cursor: move;
            transition: all 0.2s;
        }
        
        .variable-item:hover {
            background: #f3f4f6;
            transform: translateX(4px);
        }
        
        .variable-item[draggable="true"]:hover {
            background: #dbeafe;
            border-left: 4px solid #3b82f6;
        }
        
        .drop-zone-active {
            outline: 2px dashed #3b82f6 !important;
            background-color: rgba(59, 130, 246, 0.1) !important;
        }
        
        .drop-zone-active::after {
            content: "Drop variable here";
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: #3b82f6;
            color: white;
            padding: 8px 16px;
            border-radius: 4px;
            font-size: 14px;
            pointer-events: none;
            z-index: 1000;
        }
        
        .edit-modal {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.5);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 10000;
        }
        
        .edit-modal.show {
            display: flex;
        }
        
        .modal-content {
            background: white;
            padding: 24px;
            border-radius: 8px;
            max-width: 600px;
            width: 90%;
            max-height: 80vh;
            overflow-y: auto;
        }
    </style>
</head>
<body class="font-sans antialiased">
    <!-- Success/Error Messages -->
    @if(session('success'))
        <div id="successMessage" class="fixed top-16 left-1/2 transform -translate-x-1/2 bg-green-500 text-white px-6 py-3 rounded shadow-lg z-50">
            {{ session('success') }}
        </div>
    @endif
    
    @if(session('error'))
        <div id="errorMessage" class="fixed top-16 left-1/2 transform -translate-x-1/2 bg-red-500 text-white px-6 py-3 rounded shadow-lg z-50">
            {{ session('error') }}
        </div>
    @endif

    <!-- Toolbar -->
    <div class="toolbar">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <h1 class="text-lg font-semibold">Interactive Preview - {{ $template->name }}</h1>
                <button id="toggleVariables" class="bg-blue-600 hover:bg-blue-700 px-3 py-1 rounded text-sm">
                    Toggle Variables Panel
                </button>
                <button id="editMode" class="bg-green-600 hover:bg-green-700 px-3 py-1 rounded text-sm">
                    Edit Mode: OFF
                </button>
            </div>
            <div class="flex items-center space-x-2">
                <button id="saveChanges" class="bg-purple-600 hover:bg-purple-700 px-4 py-2 rounded">
                    Save Changes
                </button>
                <button id="saveChangesForm" class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded">
                    Save (Form Method)
                </button>
                <button id="showVariables" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded">
                    Show Variables
                </button>
                <a href="{{ route('admin.templates.edit', $template) }}" class="bg-gray-600 hover:bg-gray-700 px-4 py-2 rounded">
                    Back to Edit
                </a>
            </div>
        </div>
    </div>

    <!-- Variables Panel -->
    <div id="variablesPanel" class="variables-panel">
        <div class="p-4 border-b">
            <h3 class="font-semibold text-gray-900">Available Variables</h3>
            <p class="text-sm text-gray-600 mt-1">Drag these into your template or click to edit content</p>
            <div class="mt-2 p-2 bg-blue-50 rounded text-xs text-blue-700">
                💡 <strong>Tip:</strong> Enable "Edit Mode" first, then drag variables to the preview area to add them to your template.
            </div>
        </div>
        
        @foreach($allVariables as $key => $value)
            <div class="variable-item" data-variable="{{ $key }}">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="font-medium text-sm">{{ $key }}</div>
                        <div class="text-xs text-gray-500 truncate">
                            {{ is_string($value) ? Str::limit(strip_tags($value), 50) : 'Complex Value' }}
                        </div>
                    </div>
                    <button class="edit-variable text-blue-600 hover:text-blue-800 text-sm" data-variable="{{ $key }}">
                        Edit
                    </button>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Hidden Form for Fallback Save -->
    <form id="saveForm" action="{{ route('admin.templates.save-preview', $template) }}" method="POST" style="display: none;">
        @csrf
        <input type="hidden" id="formHtmlContent" name="html_content" value="">
        <input type="hidden" id="formVariables" name="variables" value="">
    </form>

    <!-- Debug Info -->
    <div class="bg-yellow-100 p-4 mb-4 rounded">
        <h3 class="font-bold">Debug Info:</h3>
        <p><strong>Template Variables Count:</strong> {{ count($template->variables ?? []) }}</p>
        <p><strong>All Variables Count:</strong> {{ count($allVariables) }}</p>
        <p><strong>Sample Variables:</strong> {{ json_encode(array_keys($allVariables)) }}</p>
    </div>

    <!-- Main Content -->
    <div class="main-content preview-container" id="previewContainer">
        <!-- Content will be rendered by JavaScript -->
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="edit-modal">
        <div class="modal-content">
            <h3 class="text-lg font-semibold mb-4">Edit Variable Content</h3>
            <form id="editForm">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Variable Name</label>
                    <input type="text" id="editVariableName" readonly class="w-full border-gray-300 rounded-md bg-gray-50">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Content</label>
                    <textarea id="editVariableContent" rows="8" class="w-full border-gray-300 rounded-md font-mono text-sm"></textarea>
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" id="cancelEdit" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                        Cancel
                    </button>
                    <button type="button" id="saveEdit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Template JavaScript -->
    @if($template->js_content)
        <script>
            {!! $template->js_content !!}
        </script>
    @endif

    <!-- Interactive Preview JavaScript -->
    <script>
        let editMode = false;
        let currentVariables = @json($allVariables);
        let originalHtml = @json($template->html_content);
        
        // Initialize the interactive preview
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Initializing preview with variables:', currentVariables);
            initializePreview();
            
            // Auto-hide success/error messages
            setTimeout(function() {
                const successMessage = document.getElementById('successMessage');
                const errorMessage = document.getElementById('errorMessage');
                if (successMessage) successMessage.style.display = 'none';
                if (errorMessage) errorMessage.style.display = 'none';
            }, 3000);
        });
        
        function initializePreview() {
            // Render template with current variables
            renderTemplate();
            
            // Setup event listeners
            setupEventListeners();
            
            // Make variables draggable
            setupDragAndDrop();
        }
        
        function renderTemplate() {
            let html = originalHtml;
            
            console.log('Original HTML:', html);
            console.log('Current variables:', currentVariables);
            
            // Replace variables in HTML
            Object.entries(currentVariables).forEach(([key, value]) => {
                const placeholder = '{{' + key + '}}';
                const wrappedValue = editMode ? 
                    '<div class="template-variable" data-variable="' + key + '">' +
                        '<div class="variable-controls">' +
                            '<span class="text-xs text-gray-500">' + key + '</span>' +
                            '<button class="edit-variable-inline ml-2" data-variable="' + key + '">✏️</button>' +
                        '</div>' +
                        '<div class="variable-content">' + value + '</div>' +
                    '</div>' : value;
                
                console.log('Replacing:', placeholder, 'with:', wrappedValue);
                
                // Use global replacement to catch all instances
                const regex = new RegExp(placeholder.replace(/[.*+?^${}()|[\]\\]/g, '\\$&'), 'g');
                html = html.replace(regex, wrappedValue);
            });
            
            console.log('Final HTML:', html);
            document.getElementById('previewContainer').innerHTML = html;
            
            // Re-setup drag and drop after rendering
            if (editMode) {
                setupVariableInteraction();
            }
        }
        
        function setupEventListeners() {
            // Toggle variables panel
            document.getElementById('toggleVariables').addEventListener('click', function() {
                const panel = document.getElementById('variablesPanel');
                panel.classList.toggle('open');
            });
            
            // Toggle edit mode
            document.getElementById('editMode').addEventListener('click', function() {
                editMode = !editMode;
                this.textContent = `Edit Mode: ${editMode ? 'ON' : 'OFF'}`;
                this.className = editMode ? 
                    'bg-red-600 hover:bg-red-700 px-3 py-1 rounded text-sm' : 
                    'bg-green-600 hover:bg-green-700 px-3 py-1 rounded text-sm';
                renderTemplate();
            });
            
            // Save changes
            document.getElementById('saveChanges').addEventListener('click', saveChanges);
            document.getElementById('saveChangesForm').addEventListener('click', saveChangesForm);
            document.getElementById('showVariables').addEventListener('click', showVariables);
            
            // Modal controls
            document.getElementById('cancelEdit').addEventListener('click', closeModal);
            document.getElementById('saveEdit').addEventListener('click', saveVariableEdit);
            
            // Close modal on outside click
            document.getElementById('editModal').addEventListener('click', function(e) {
                if (e.target === this) closeModal();
            });
        }
        
        function setupDragAndDrop() {
            // Make variables in panel draggable
            const variableItems = document.querySelectorAll('.variable-item');
            variableItems.forEach(item => {
                item.addEventListener('dragstart', function(e) {
                    e.dataTransfer.setData('text/plain', this.dataset.variable);
                    e.dataTransfer.effectAllowed = 'copy';
                    this.style.opacity = '0.5';
                });
                
                item.addEventListener('dragend', function(e) {
                    this.style.opacity = '1';
                });
                
                item.draggable = true;
            });
            
            // Make the entire preview container a drop zone
            const previewContainer = document.getElementById('previewContainer');
            previewContainer.addEventListener('dragover', function(e) {
                e.preventDefault();
                e.dataTransfer.dropEffect = 'copy';
                this.classList.add('drop-zone-active');
            });
            
            previewContainer.addEventListener('dragleave', function(e) {
                // Only remove if we're leaving the container entirely
                if (!this.contains(e.relatedTarget)) {
                    this.classList.remove('drop-zone-active');
                }
            });
            
            previewContainer.addEventListener('drop', function(e) {
                e.preventDefault();
                this.classList.remove('drop-zone-active');
                const variableName = e.dataTransfer.getData('text/plain');
                if (variableName) {
                    insertVariableAtPosition(variableName, e.clientX, e.clientY);
                }
            });
            
            // Edit variable buttons in panel
            document.querySelectorAll('.edit-variable').forEach(btn => {
                btn.addEventListener('click', function() {
                    editVariable(this.dataset.variable);
                });
            });
        }
        
        function setupVariableInteraction() {
            // Setup edit buttons for inline variables
            document.querySelectorAll('.edit-variable-inline').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    editVariable(this.dataset.variable);
                });
            });
            
            // Make template variables sortable
            document.querySelectorAll('.template-variable').forEach(variable => {
                variable.addEventListener('dragover', function(e) {
                    e.preventDefault();
                });
                
                variable.addEventListener('drop', function(e) {
                    e.preventDefault();
                    const droppedVariable = e.dataTransfer.getData('text/plain');
                    if (droppedVariable && droppedVariable !== this.dataset.variable) {
                        // Swap or insert variable
                        swapVariables(droppedVariable, this.dataset.variable);
                    }
                });
            });
        }
        
        function insertVariableAtPosition(variableName, x, y) {
            if (!editMode) {
                alert('Please enable Edit Mode first to drop variables');
                return;
            }
            
            // Find the element at the drop position
            const elementAtPosition = document.elementFromPoint(x, y);
            if (!elementAtPosition) return;
            
            // Create a new variable placeholder
            const variableContent = currentVariables[variableName] || 'New Variable Content';
            const variableHtml = '<div class="template-variable inline-block" data-variable="' + variableName + '">' +
                '<div class="variable-controls">' +
                    '<span class="text-xs text-gray-500">' + variableName + '</span>' +
                    '<button class="edit-variable-inline ml-2" data-variable="' + variableName + '">✏️</button>' +
                '</div>' +
                '<div class="variable-content">' + variableContent + '</div>' +
            '</div>';
            
            // Insert the variable at the position
            if (elementAtPosition.classList && elementAtPosition.classList.contains('template-variable')) {
                // Insert before this variable
                elementAtPosition.insertAdjacentHTML('beforebegin', variableHtml);
            } else {
                // Insert into the element
                elementAtPosition.insertAdjacentHTML('beforeend', variableHtml);
            }
            
            // Re-setup interactions
            setupVariableInteraction();
        }
        
        function editVariable(variableName) {
            document.getElementById('editVariableName').value = variableName;
            document.getElementById('editVariableContent').value = currentVariables[variableName] || '';
            document.getElementById('editModal').classList.add('show');
        }
        
        function closeModal() {
            document.getElementById('editModal').classList.remove('show');
        }
        
        function saveVariableEdit() {
            const variableName = document.getElementById('editVariableName').value;
            const variableContent = document.getElementById('editVariableContent').value;
            
            currentVariables[variableName] = variableContent;
            renderTemplate();
            closeModal();
        }
        
        function swapVariables(var1, var2) {
            // Simple swap for demonstration
            const temp = currentVariables[var1];
            currentVariables[var1] = currentVariables[var2];
            currentVariables[var2] = temp;
            renderTemplate();
        }
        
        function saveChanges() {
            // Show loading state
            const saveButton = document.getElementById('saveChanges');
            const originalText = saveButton.textContent;
            saveButton.textContent = 'Saving...';
            saveButton.disabled = true;
            
            // Save the current HTML structure (with drag and drop changes)
            let htmlToSave = document.getElementById('previewContainer').innerHTML;
            
            // Clean up the HTML by removing edit mode wrappers and restoring placeholders
            Object.keys(currentVariables).forEach(variableName => {
                // Find all instances of the variable content and replace with placeholder
                const variableContent = currentVariables[variableName];
                const placeholder = '{{' + variableName + '}}';
                
                // Replace the variable content with placeholder
                htmlToSave = htmlToSave.replace(new RegExp(variableContent.replace(/[.*+?^${}()|[\]\\]/g, '\\$&'), 'g'), placeholder);
            });
            
            // Remove any remaining edit mode wrapper divs
            htmlToSave = htmlToSave.replace(/<div class="template-variable" data-variable="[^"]*">/g, '');
            htmlToSave = htmlToSave.replace(/<div class="variable-controls">[^<]*<\/div>/g, '');
            htmlToSave = htmlToSave.replace(/<\/div><\/div>/g, '');
            htmlToSave = htmlToSave.replace(/<\/div>/g, '');
            
            console.log('Saving HTML:', htmlToSave);
            console.log('Saving variables:', currentVariables);
            
            // Get CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';
            if (!csrfToken) {
                alert('CSRF token not found. Please refresh the page and try again.');
                saveButton.textContent = originalText;
                saveButton.disabled = false;
                return;
            }
            
            // Send to server
            fetch(`{{ route('admin.templates.save-preview', $template) }}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    html_content: htmlToSave,
                    variables: currentVariables
                })
            })
            .then(response => {
                console.log('Response status:', response.status);
                console.log('Response headers:', response.headers);
                
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                
                // Get the response as text first to handle BOM issues
                return response.text().then(text => {
                    console.log('Raw response text:', text);
                    // Remove BOM character if present
                    const cleanText = text.replace(/^\uFEFF/, '');
                    try {
                        return JSON.parse(cleanText);
                    } catch (e) {
                        console.error('JSON parse error:', e);
                        console.error('Cleaned text:', cleanText);
                        throw new Error('Invalid JSON response from server');
                    }
                });
            })
            .then(data => {
                console.log('Server response:', data);
                if (data.success) {
                    showMessage('Template saved successfully!', 'success');
                } else {
                    showMessage('Error saving template: ' + (data.message || 'Unknown error'), 'error');
                }
            })
            .catch(error => {
                console.error('Fetch error:', error);
                showMessage('Error saving template: ' + error.message + '. Please check the console for details.', 'error');
            })
            .finally(() => {
                // Restore button state
                saveButton.textContent = originalText;
                saveButton.disabled = false;
            });
        }
        
        function saveChangesForm() {
            // Use form submission as fallback
            // Save the current HTML structure (with drag and drop changes)
            let htmlToSave = document.getElementById('previewContainer').innerHTML;
            
            // Clean up the HTML by removing edit mode wrappers and restoring placeholders
            Object.keys(currentVariables).forEach(variableName => {
                // Find all instances of the variable content and replace with placeholder
                const variableContent = currentVariables[variableName];
                const placeholder = '{{' + variableName + '}}';
                
                // Replace the variable content with placeholder
                htmlToSave = htmlToSave.replace(new RegExp(variableContent.replace(/[.*+?^${}()|[\]\\]/g, '\\$&'), 'g'), placeholder);
            });
            
            // Remove any remaining edit mode wrapper divs
            htmlToSave = htmlToSave.replace(/<div class="template-variable" data-variable="[^"]*">/g, '');
            htmlToSave = htmlToSave.replace(/<div class="variable-controls">[^<]*<\/div>/g, '');
            htmlToSave = htmlToSave.replace(/<\/div><\/div>/g, '');
            htmlToSave = htmlToSave.replace(/<\/div>/g, '');
            
            // Set form values
            document.getElementById('formHtmlContent').value = htmlToSave;
            document.getElementById('formVariables').value = JSON.stringify(currentVariables);
            
            // Submit form
            document.getElementById('saveForm').submit();
        }
        
        function showMessage(message, type) {
            // Create or update message element
            let messageEl = document.getElementById('dynamicMessage');
            if (!messageEl) {
                messageEl = document.createElement('div');
                messageEl.id = 'dynamicMessage';
                messageEl.className = 'fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg max-w-md';
                document.body.appendChild(messageEl);
            }
            
            // Set message content and styling
            messageEl.textContent = message;
            messageEl.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg max-w-md ${
                type === 'success' ? 'bg-green-100 text-green-800 border border-green-200' : 'bg-red-100 text-red-800 border border-red-200'
            }`;
            
            // Auto-hide after 3 seconds
            setTimeout(() => {
                if (messageEl) {
                    messageEl.remove();
                }
            }, 3000);
        }
        
        function showVariables() {
            console.log('Current variables:', currentVariables);
            alert('Current variables logged to console. Check F12 console for details.');
        }
    </script>
</body>
</html>
