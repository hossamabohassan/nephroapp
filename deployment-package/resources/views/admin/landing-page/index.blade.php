@php
    $pageTitle = 'Landing Page Editor';
    $pageDescription = 'Edit the full HTML content of your landing page';
@endphp

<x-admin-layout :page-title="$pageTitle" :page-description="$pageDescription">
    
    <div class="space-y-6">
        <!-- Header with Actions -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Landing Page Editor</h1>
                <p class="text-slate-600 mt-1">Edit the complete HTML content of your landing page at <code class="bg-slate-100 px-2 py-1 rounded text-sm">/</code></p>
                <div class="mt-2 text-sm text-slate-500">
                    <p><strong>Note:</strong> This editor supports both pure HTML and Blade template syntax (curly braces and @directives).</p>
                    <p>If you see raw Blade syntax on your site, the content will be automatically rendered when saved.</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <button type="button" id="previewBtn" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    Preview
                </button>
                <form method="POST" action="{{ route('admin.landing-page.reset') }}" class="inline" onsubmit="return confirm('Are you sure you want to reset to the original file content? This will overwrite any unsaved changes.')">
                    @csrf
                    <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        Reset to Original
                    </button>
                </form>
            </div>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <p class="text-green-800 font-medium">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-red-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div>
                        <p class="text-red-800 font-medium">Please fix the following errors:</p>
                        <ul class="text-red-700 text-sm mt-1 list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <!-- Editor Form -->
        <form method="POST" action="{{ route('admin.landing-page.update') }}" class="space-y-6">
            @csrf
            
            <!-- Editor Options -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                <h3 class="text-lg font-semibold text-slate-900 mb-4">Editor Options</h3>
                <div class="flex items-center gap-4">
                    <label class="flex items-center">
                        <input type="checkbox" name="update_file" value="1" class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                        <span class="ml-2 text-sm text-slate-700">Also update the actual blade file (creates backup)</span>
                    </label>
                </div>
            </div>

            <!-- HTML Editor -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-200">
                <div class="border-b border-slate-200 p-4">
                    <h3 class="text-lg font-semibold text-slate-900">HTML Content</h3>
                    <p class="text-sm text-slate-600 mt-1">Edit the complete HTML content of your landing page. This will be served at the root URL (/).</p>
                </div>
                
                <div class="p-4">
                    <textarea 
                        name="html_content" 
                        id="htmlEditor" 
                        rows="30" 
                        class="w-full font-mono text-sm border border-slate-300 rounded-lg p-4 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none"
                        placeholder="Enter your HTML content here..."
                    >{{ old('html_content', $htmlContent) }}</textarea>
                </div>
            </div>

            <!-- Save Button -->
            <div class="flex justify-end">
                <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-medium">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Save Changes
                </button>
            </div>
        </form>
    </div>

    <!-- Preview Modal -->
    <div id="previewModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-xl shadow-2xl w-full max-w-6xl h-[90vh] flex flex-col">
                <div class="flex items-center justify-between p-4 border-b border-slate-200">
                    <h3 class="text-lg font-semibold text-slate-900">Landing Page Preview</h3>
                    <button type="button" id="closePreview" class="text-slate-400 hover:text-slate-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                <div class="flex-1 overflow-hidden">
                    <iframe id="previewFrame" class="w-full h-full border-0" src="about:blank"></iframe>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const previewBtn = document.getElementById('previewBtn');
            const previewModal = document.getElementById('previewModal');
            const closePreview = document.getElementById('closePreview');
            const previewFrame = document.getElementById('previewFrame');
            const htmlEditor = document.getElementById('htmlEditor');

            // Preview functionality
            previewBtn.addEventListener('click', function() {
                const htmlContent = htmlEditor.value;
                
                // Create a preview URL with the HTML content
                const previewUrl = '{{ route("admin.landing-page.preview") }}';
                
                // Show modal
                previewModal.classList.remove('hidden');
                
                // Set iframe content
                const iframeDoc = previewFrame.contentDocument || previewFrame.contentWindow.document;
                iframeDoc.open();
                iframeDoc.write(htmlContent);
                iframeDoc.close();
            });

            // Close preview modal
            closePreview.addEventListener('click', function() {
                previewModal.classList.add('hidden');
            });

            // Close modal when clicking outside
            previewModal.addEventListener('click', function(e) {
                if (e.target === previewModal) {
                    previewModal.classList.add('hidden');
                }
            });

            // Auto-resize textarea
            htmlEditor.addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = Math.max(600, this.scrollHeight) + 'px';
            });

            // Initial resize
            htmlEditor.style.height = Math.max(600, htmlEditor.scrollHeight) + 'px';
        });
    </script>
    @endpush
</x-admin-layout>
