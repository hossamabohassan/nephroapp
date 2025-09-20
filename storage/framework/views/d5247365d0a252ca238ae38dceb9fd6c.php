<?php
    $pageTitle = 'Live Editor: ' . $topic->title;
    $pageDescription = 'WYSIWYG editing with live preview';
?>

<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e($pageTitle); ?> - <?php echo e(config('app.name', 'NephroCoach')); ?></title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>

    <!-- CKEditor 5 (Free alternative to TinyMCE) -->
    <script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
        }
        
        .editor-container {
            height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        .editor-toolbar {
            background: #1e293b;
            color: white;
            padding: 12px 20px;
            display: flex;
            align-items: center;
            justify-content: between;
            border-bottom: 1px solid #334155;
            flex-shrink: 0;
        }
        
        .editor-content {
            flex: 1;
            overflow: hidden;
        }
        
        .status-indicator {
            display: inline-flex;
            align-items: center;
            font-size: 14px;
            margin-left: auto;
        }
        
        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            margin-right: 8px;
        }
        
        .status-saved {
            background-color: #10b981;
        }
        
        .status-saving {
            background-color: #f59e0b;
            animation: pulse 2s infinite;
        }
        
        .status-error {
            background-color: #ef4444;
        }
        
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
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
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
        
        /* CKEditor content styling to match vivatemplate */
        .ck-editor__editable {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.6;
            font-size: 16px;
            color: #1f2937;
            padding: 2rem !important;
            min-height: calc(100vh - 160px) !important;
        }
        
        .ck-editor__editable h1 {
            font-size: 2.25rem;
            font-weight: 700;
            color: #111827;
            margin-top: 2rem;
            margin-bottom: 1rem;
            border-bottom: 2px solid #e5e7eb;
            padding-bottom: 0.5rem;
        }
        
        .ck-editor__editable h2 {
            font-size: 1.875rem;
            font-weight: 600;
            color: #1f2937;
            margin-top: 1.5rem;
            margin-bottom: 0.75rem;
            background: linear-gradient(90deg, #3b82f6, #1d4ed8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .ck-editor__editable h3 {
            font-size: 1.5rem;
            font-weight: 600;
            color: #374151;
            margin-top: 1.25rem;
            margin-bottom: 0.5rem;
        }
        
        .ck-editor__editable p {
            margin-bottom: 1rem;
            text-align: justify;
        }
        
        .ck-editor__editable ul, .ck-editor__editable ol {
            margin-bottom: 1rem;
            padding-left: 1.5rem;
        }
        
        .ck-editor__editable li {
            margin-bottom: 0.25rem;
        }
        
        .ck-editor__editable blockquote {
            border-left: 4px solid #3b82f6;
            padding-left: 1rem;
            margin: 1.5rem 0;
            font-style: italic;
            color: #6b7280;
            background: #f8fafc;
            border-radius: 0 0.5rem 0.5rem 0;
            padding: 1rem;
        }
        
        .ck-editor__editable table {
            border-collapse: collapse;
            width: 100%;
            margin: 1.5rem 0;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            overflow: hidden;
        }
        
        .ck-editor__editable th, .ck-editor__editable td {
            border: 1px solid #e5e7eb;
            padding: 0.75rem;
            text-align: left;
        }
        
        .ck-editor__editable th {
            background-color: #f9fafb;
            font-weight: 600;
            color: #374151;
        }
        
        .ck-editor__editable strong {
            font-weight: 600;
            color: #111827;
        }
        
        .ck-editor__editable em {
            color: #6b7280;
        }
        
        /* Override CKEditor toolbar styling */
        .ck.ck-toolbar {
            border-bottom: 1px solid #e5e7eb !important;
            padding: 0.75rem !important;
            background: #f8fafc !important;
        }
        
        .ck.ck-button {
            margin: 0 2px !important;
        }
    </style>
</head>

<body>
    <div class="editor-container">
        <!-- Toolbar -->
        <div class="editor-toolbar">
            <div class="flex items-center">
                <h1 class="text-lg font-semibold mr-4"><?php echo e($topic->title); ?></h1>
                <span class="text-sm text-slate-300">Live WYSIWYG Editor</span>
            </div>
            
            <div class="flex items-center ml-auto">
                <div class="status-indicator" id="saveStatus">
                    <div class="status-dot status-saved" id="statusDot"></div>
                    <span id="statusText">All changes saved</span>
                </div>
                
                <button type="button" id="clearBtn" class="editor-button secondary">
                    Clear & Start Fresh
                </button>
                
                <button type="button" id="extractTextBtn" class="editor-button secondary">
                    Extract Text Only
                </button>
                
                <button type="button" id="previewBtn" class="editor-button secondary">
                    Preview
                </button>
                
                <a href="<?php echo e(route('admin.topics.edit', $topic)); ?>" class="editor-button secondary">
                    Advanced Editor
                </a>
                
                <a href="<?php echo e(route('admin.topics.index')); ?>" class="editor-button secondary">
                    Back to Topics
                </a>
                
                <button type="button" id="saveBtn" class="editor-button">
                    Save Now
                </button>
            </div>
        </div>

        <!-- Editor Content -->
        <div class="editor-content">
            <div id="wysiwygEditor"><?php echo $rendered; ?></div>
        </div>
        
    </div>

    <!-- Preview Modal -->
    <div id="previewModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-hidden">
                <div class="flex items-center justify-between p-4 border-b border-slate-200">
                    <h3 class="text-lg font-semibold text-slate-900">Preview</h3>
                    <button type="button" id="closePreview" class="text-slate-400 hover:text-slate-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                <div class="p-6 overflow-y-auto max-h-[calc(90vh-120px)]">
                    <iframe id="previewFrame" class="w-full h-[600px] border-0 rounded-lg" src="about:blank"></iframe>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Initialize variables
        let editor;
        let saveTimeout;
        let lastSavedContent = '';
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        const topicId = <?php echo e($topic->id); ?>;
        const saveUrl = `<?php echo e(route('admin.topics.wysiwyg.update', $topic)); ?>`;

        // Status elements
        const statusDot = document.getElementById('statusDot');
        const statusText = document.getElementById('statusText');
        const saveBtn = document.getElementById('saveBtn');
        const clearBtn = document.getElementById('clearBtn');
        const extractTextBtn = document.getElementById('extractTextBtn');
        const previewBtn = document.getElementById('previewBtn');
        const previewModal = document.getElementById('previewModal');
        const previewFrame = document.getElementById('previewFrame');
        const closePreview = document.getElementById('closePreview');

        // Initialize CKEditor 5
        ClassicEditor
            .create(document.querySelector('#wysiwygEditor'), {
                toolbar: {
                    items: [
                        'undo', 'redo',
                        '|', 'heading',
                        '|', 'bold', 'italic', 'underline',
                        '|', 'link', 'insertTable',
                        '|', 'bulletedList', 'numberedList',
                        '|', 'outdent', 'indent',
                        '|', 'blockQuote',
                        '|', 'removeFormat'
                    ]
                },
                heading: {
                    options: [
                        { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                        { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                        { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                        { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
                        { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' }
                    ]
                },
                table: {
                    contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells']
                }
            })
            .then(ckEditor => {
                editor = ckEditor;
                
                const content = editor.getData();
                lastSavedContent = content;
                setStatus('saved', 'All changes saved');

                // Auto-save on content change
                editor.model.document.on('change:data', () => {
                    clearTimeout(saveTimeout);
                    setStatus('saving', 'Saving...');
                    
                    // Auto-save after 2 seconds of inactivity
                    saveTimeout = setTimeout(() => {
                        saveContent();
                    }, 2000);
                });
            })
            .catch(error => {
                console.error('CKEditor initialization failed:', error);
                setStatus('error', 'Editor failed to initialize: ' + error.message);
            });

        // Status management
        function setStatus(type, message) {
            statusDot.className = `status-dot status-${type}`;
            statusText.textContent = message;
        }

        // Save content function
        async function saveContent() {
            
            if (!editor) {
                console.error('No editor in saveContent');
                alert('Error: No editor found in saveContent');
                return;
            }
            
            const content = editor.getData();
            
            // Don't save if content hasn't changed
            if (content === lastSavedContent) {
                setStatus('saved', 'All changes saved');
                return;
            }

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
                    console.log('Save successful');
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
        saveBtn.addEventListener('click', () => {
            saveContent();
        });

        // Clear button functionality
        clearBtn.addEventListener('click', () => {
            if (confirm('Are you sure you want to clear all content and start fresh? This cannot be undone.')) {
                if (editor) {
                    const freshContent = `
                        <h1><?php echo e($topic->title); ?></h1>
                        <p>Start writing your content here...</p>
                        <h2>Section Heading</h2>
                        <p>Add your content in this section.</p>
                        <ul>
                            <li>You can create lists</li>
                            <li>Add bullet points</li>
                            <li>Organize your content</li>
                        </ul>
                        <p>Use the toolbar above to format your text, add images, tables, and more.</p>
                    `;
                    
                    editor.setData(freshContent);
                    setStatus('saving', 'Clearing content...');
                    setTimeout(() => {
                        saveContent();
                    }, 500);
                } else {
                    setStatus('error', 'Editor not found');
                }
            }
        });

        // Extract text only - simple and effective
        extractTextBtn.addEventListener('click', () => {
            if (!editor) {
                setStatus('error', 'Editor not found');
                return;
            }
            
            if (confirm('This will extract only the readable text and remove all HTML formatting. Continue?')) {
                const currentContent = editor.getData();
                
                // Create a temporary div to extract text
                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = currentContent;
                
                // Get pure text content
                let textContent = tempDiv.textContent || tempDiv.innerText || '';
                
                // Clean up the text
                textContent = textContent.replace(/\s+/g, ' ').trim();
                
                // Split into meaningful chunks and create simple structure
                const sentences = textContent.split(/[.!?]+/).filter(s => s.trim().length > 10);
                
                let cleanContent = `<h1><?php echo e($topic->title); ?></h1>\n\n`;
                
                // Group sentences into paragraphs (every 2-3 sentences)
                for (let i = 0; i < sentences.length; i += 2) {
                    const paragraph = sentences.slice(i, i + 2).join('. ').trim();
                    if (paragraph.length > 0) {
                        cleanContent += `<p>${paragraph}.</p>\n\n`;
                    }
                }
                
                // If no meaningful content was extracted, provide template
                if (cleanContent.length < 100) {
                    cleanContent = `
                        <h1><?php echo e($topic->title); ?></h1>
                        <p>The original content was too complex to extract automatically.</p>
                        <p>Please start writing your content here...</p>
                        <h2>Section Heading</h2>
                        <p>Add your content in this section.</p>
                        <ul>
                            <li>You can create lists</li>
                            <li>Add bullet points</li>
                            <li>Format text using the toolbar</li>
                        </ul>
                    `;
                }
                
                editor.setData(cleanContent);
                setStatus('saving', 'Extracting text content...');
                
                setTimeout(() => {
                    saveContent();
                }, 500);
            }
        });

        // Preview functionality
        previewBtn.addEventListener('click', () => {
            if (!editor) return;
            
            const content = editor.getData();
            const htmlDoc = `
                <!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Preview</title>
                    <style>
                        body { 
                            font-family: Inter, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; 
                            line-height: 1.6; 
                            max-width: 800px; 
                            margin: 0 auto; 
                            padding: 2rem;
                            color: #1f2937;
                        }
                        h1, h2, h3, h4, h5, h6 { 
                            color: #111827; 
                            font-weight: 600; 
                            margin-top: 2rem; 
                            margin-bottom: 0.75rem; 
                        }
                        h1 { font-size: 2.25rem; }
                        h2 { font-size: 1.875rem; }
                        h3 { font-size: 1.5rem; }
                        h4 { font-size: 1.25rem; }
                        p { margin-bottom: 1rem; }
                        ul, ol { margin-bottom: 1rem; padding-left: 2rem; }
                        blockquote { 
                            border-left: 4px solid #3b82f6; 
                            padding-left: 1rem; 
                            margin: 1.5rem 0; 
                            font-style: italic; 
                            color: #6b7280; 
                        }
                        table { 
                            border-collapse: collapse; 
                            width: 100%; 
                            margin: 1.5rem 0; 
                            border: 1px solid #e5e7eb;
                        }
                        th, td { 
                            border: 1px solid #e5e7eb; 
                            padding: 0.75rem; 
                            text-align: left; 
                        }
                        th { 
                            background-color: #f9fafb; 
                            font-weight: 600; 
                        }
                        pre { 
                            background-color: #f3f4f6; 
                            border-radius: 0.5rem; 
                            padding: 1rem; 
                            overflow-x: auto; 
                            font-family: Monaco, Courier, monospace; 
                        }
                        code { 
                            background-color: #f3f4f6; 
                            padding: 0.125rem 0.25rem; 
                            border-radius: 0.25rem; 
                            font-family: Monaco, Courier, monospace; 
                            font-size: 0.875em; 
                        }
                        img { 
                            max-width: 100%; 
                            height: auto; 
                            border-radius: 0.5rem; 
                        }
                    </style>
                </head>
                <body>
                    ${content}
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
            
            // Escape to close preview
            if (e.key === 'Escape' && !previewModal.classList.contains('hidden')) {
                previewModal.classList.add('hidden');
            }
        });

        // Auto-save on page unload
        window.addEventListener('beforeunload', (e) => {
            if (editor && editor.getData() !== lastSavedContent) {
                e.preventDefault();
                e.returnValue = 'You have unsaved changes. Are you sure you want to leave?';
                return e.returnValue;
            }
        });

        // Save immediately on visibility change (tab switch)
        document.addEventListener('visibilitychange', () => {
            if (document.visibilityState === 'hidden' && editor) {
                saveContent();
            }
        });
    </script>
</body>
</html>
<?php /**PATH /homepages/38/d4299336130/htdocs/nephroapp/resources/views/admin/topics/wysiwyg.blade.php ENDPATH**/ ?>