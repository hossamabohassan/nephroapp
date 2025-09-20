@php
    $pageTitle = 'Live Editor: ' . $topic->title;
    $pageDescription = 'WYSIWYG editing with vivatemplate styling';
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $pageTitle }} - {{ config('app.name', 'NephroCoach') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- CKEditor 5 -->
    <script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>

    <style>
        /* Editor overlay styles */
        .editor-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            background: rgba(30, 41, 59, 0.95);
            backdrop-filter: blur(10px);
            color: white;
            padding: 12px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #334155;
            transition: transform 0.3s ease;
        }
        
        .editor-overlay.hidden {
            transform: translateY(-100%);
        }
        
        .editor-button {
            background: #3b82f6;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 14px;
            cursor: pointer;
            margin-left: 12px;
            transition: background-color 0.2s;
        }
        
        .editor-button:hover {
            background: #2563eb;
        }
        
        .editor-button.secondary {
            background: #6b7280;
        }
        
        .editor-button.secondary:hover {
            background: #4b5563;
        }
        
        .status-indicator {
            display: inline-flex;
            align-items: center;
            font-size: 14px;
        }
        
        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            margin-right: 8px;
        }
        
        .status-saved { background-color: #10b981; }
        .status-saving { background-color: #f59e0b; animation: pulse 2s infinite; }
        .status-error { background-color: #ef4444; }
        
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        
        /* Make content editable styling */
        .editable-content {
            padding-top: 80px; /* Space for toolbar */
        }
        
        .editable-content[contenteditable="true"] {
            outline: 2px dashed #3b82f6;
            outline-offset: 4px;
            min-height: 200px;
        }
        
        .editable-content[contenteditable="true"]:focus {
            outline: 2px solid #3b82f6;
        }
        
        /* Hide non-essential elements in edit mode */
        .edit-mode .print-hide,
        .edit-mode nav,
        .edit-mode header {
            display: none !important;
        }
    </style>
</head>

<body class="edit-mode">
    <!-- Editor Toolbar -->
    <div class="editor-overlay" id="editorToolbar">
        <div class="flex items-center">
            <h1 class="text-lg font-semibold mr-4">{{ $topic->title }}</h1>
            <span class="text-sm text-slate-300">Vivatemplate Live Editor</span>
        </div>
        
        <div class="flex items-center">
            <div class="status-indicator" id="saveStatus">
                <div class="status-dot status-saved" id="statusDot"></div>
                <span id="statusText">All changes saved</span>
            </div>
            
            <button type="button" id="toggleEditBtn" class="editor-button">
                Start Editing
            </button>
            
            <button type="button" id="saveBtn" class="editor-button">
                Save Now
            </button>
            
            <button type="button" id="reloadBtn" class="editor-button secondary">
                Reload
            </button>
            
            <button type="button" id="previewBtn" class="editor-button secondary">
                Preview
            </button>
            
            <a href="{{ route('admin.topics.edit', $topic) }}" class="editor-button secondary">
                Advanced Editor
            </a>
            
            <a href="{{ route('admin.topics.index') }}" class="editor-button secondary">
                Back to Topics
            </a>
        </div>
    </div>

    <!-- Main Content - Vivatemplate -->
    <div class="editable-content" id="editableContent">
        {!! $rendered !!}
    </div>

    <!-- Preview Modal -->
    <div id="previewModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-xl shadow-2xl max-w-6xl w-full max-h-[90vh] overflow-hidden">
                <div class="flex items-center justify-between p-4 border-b border-slate-200">
                    <h3 class="text-lg font-semibold text-slate-900">Preview</h3>
                    <button type="button" id="closePreview" class="text-slate-400 hover:text-slate-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                <div class="p-6 overflow-y-auto max-h-[calc(90vh-120px)]">
                    <iframe id="previewFrame" class="w-full h-[700px] border-0 rounded-lg" src="about:blank"></iframe>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Initialize variables
        let isEditing = false;
        let saveTimeout;
        let lastSavedContent = '';
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        const topicId = {{ $topic->id }};
        const saveUrl = `{{ route('admin.topics.wysiwyg.update', $topic) }}`;

        // Elements
        const statusDot = document.getElementById('statusDot');
        const statusText = document.getElementById('statusText');
        const saveBtn = document.getElementById('saveBtn');
        const toggleEditBtn = document.getElementById('toggleEditBtn');
        const reloadBtn = document.getElementById('reloadBtn');
        const previewBtn = document.getElementById('previewBtn');
        const previewModal = document.getElementById('previewModal');
        const previewFrame = document.getElementById('previewFrame');
        const closePreview = document.getElementById('closePreview');
        const editableContent = document.getElementById('editableContent');

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            lastSavedContent = editableContent.innerHTML;
            setStatus('saved', 'All changes saved');
            console.log('Vivatemplate editor initialized');
            console.log('Topic ID:', topicId);
            console.log('Initial content length:', lastSavedContent.length);
            console.log('Has rendered_html?', {{ $topic->rendered_html ? 'true' : 'false' }});
            console.log('Rendered at:', '{{ $topic->rendered_at }}');
            console.log('Updated at:', '{{ $topic->updated_at }}');
        });

        // Status management
        function setStatus(type, message) {
            statusDot.className = `status-dot status-${type}`;
            statusText.textContent = message;
        }

        // Toggle edit mode
        toggleEditBtn.addEventListener('click', function() {
            isEditing = !isEditing;
            
            if (isEditing) {
                editableContent.contentEditable = true;
                editableContent.focus();
                toggleEditBtn.textContent = 'Stop Editing';
                toggleEditBtn.className = 'editor-button secondary';
                
                // Add input listener for auto-save
                editableContent.addEventListener('input', handleContentChange);
            } else {
                editableContent.contentEditable = false;
                toggleEditBtn.textContent = 'Start Editing';
                toggleEditBtn.className = 'editor-button';
                
                // Remove input listener
                editableContent.removeEventListener('input', handleContentChange);
                
                // Save any final changes
                saveContent();
            }
        });

        // Handle content changes
        function handleContentChange() {
            clearTimeout(saveTimeout);
            setStatus('saving', 'Saving...');
            
            // Auto-save after 2 seconds of inactivity
            saveTimeout = setTimeout(() => {
                saveContent();
            }, 2000);
        }

        // Save content function
        async function saveContent() {
            if (!isEditing && editableContent.innerHTML === lastSavedContent) {
                setStatus('saved', 'All changes saved');
                return;
            }

            const content = editableContent.innerHTML;
            
            // Don't save if content hasn't changed
            if (content === lastSavedContent) {
                setStatus('saved', 'All changes saved');
                return;
            }

            console.log('Saving content...');
            console.log('Content length:', content.length);
            console.log('Content preview:', content.substring(0, 200));

            setStatus('saving', 'Saving changes...');
            saveBtn.disabled = true;

            try {
                const response = await fetch(saveUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        content: content
                    })
                });

                const data = await response.json();

                if (response.ok) {
                    lastSavedContent = content;
                    setStatus('saved', `Saved ${data.updated_at}`);
                } else {
                    throw new Error(data.message || 'Save failed');
                }
            } catch (error) {
                console.error('Save error:', error);
                setStatus('error', 'Save failed - ' + error.message);
            } finally {
                saveBtn.disabled = false;
            }
        }

        // Manual save button
        saveBtn.addEventListener('click', saveContent);
        
        // Reload button for testing
        reloadBtn.addEventListener('click', () => {
            if (confirm('Reload the page? Any unsaved changes will be lost.')) {
                window.location.reload();
            }
        });

        // Preview functionality
        previewBtn.addEventListener('click', () => {
            const content = editableContent.innerHTML;
            
            // Create a clean preview without edit mode classes
            const cleanContent = content.replace(/contenteditable="[^"]*"/g, '');
            
            const htmlDoc = `
                <!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Preview - {{ $topic->title }}</title>
                </head>
                <body>
                    ${cleanContent}
                </body>
                </html>
            `;
            
            previewFrame.srcdoc = htmlDoc;
            previewModal.classList.remove('hidden');
        });

        // Close preview modal
        closePreview.addEventListener('click', () => {
            previewModal.classList.add('hidden');
        });

        previewModal.addEventListener('click', (e) => {
            if (e.target === previewModal) {
                previewModal.classList.add('hidden');
            }
        });

        // Keyboard shortcuts
        document.addEventListener('keydown', (e) => {
            // Ctrl+S or Cmd+S to save
            if ((e.ctrlKey || e.metaKey) && e.key === 's') {
                e.preventDefault();
                saveContent();
            }
            
            // Ctrl+E or Cmd+E to toggle edit mode
            if ((e.ctrlKey || e.metaKey) && e.key === 'e') {
                e.preventDefault();
                toggleEditBtn.click();
            }
            
            // Escape to close preview or stop editing
            if (e.key === 'Escape') {
                if (!previewModal.classList.contains('hidden')) {
                    previewModal.classList.add('hidden');
                } else if (isEditing) {
                    toggleEditBtn.click();
                }
            }
        });

        // Auto-save on page unload
        window.addEventListener('beforeunload', (e) => {
            if (isEditing && editableContent.innerHTML !== lastSavedContent) {
                e.preventDefault();
                e.returnValue = 'You have unsaved changes. Are you sure you want to leave?';
                return e.returnValue;
            }
        });

        // Save immediately on visibility change (tab switch)
        document.addEventListener('visibilitychange', () => {
            if (document.visibilityState === 'hidden' && isEditing) {
                saveContent();
            }
        });
    </script>
</body>
</html>
