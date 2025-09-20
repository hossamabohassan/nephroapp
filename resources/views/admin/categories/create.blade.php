@php
    $pageTitle = 'Create Category';
    $pageDescription = 'Add a new content category';
@endphp

<x-admin-layout :page-title="$pageTitle" :page-description="$pageDescription">
    
    <div class="max-w-2xl">
        <form method="POST" action="{{ route('admin.categories.store') }}" class="space-y-6">
            @csrf

            <!-- Category Name -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                <h3 class="text-lg font-semibold text-slate-900 mb-4">Basic Information</h3>
                
                <div class="space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-slate-700 mb-2">Category Name</label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="{{ old('name') }}"
                               class="block w-full px-3 py-2 border border-slate-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('name') border-red-300 @enderror"
                               placeholder="e.g., Renal Transplant"
                               required>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="slug" class="block text-sm font-medium text-slate-700 mb-2">
                            URL Slug 
                            <span class="text-slate-500 font-normal">(optional - auto-generated from name)</span>
                        </label>
                        <input type="text" 
                               id="slug" 
                               name="slug" 
                               value="{{ old('slug') }}"
                               class="block w-full px-3 py-2 border border-slate-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('slug') border-red-300 @enderror"
                               placeholder="e.g., renal-transplant"
                               pattern="[a-z0-9-]+"
                               title="Only lowercase letters, numbers, and hyphens allowed">
                        @error('slug')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-slate-500">Used in URLs. Leave blank to auto-generate from name.</p>
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-slate-700 mb-2">
                            Description 
                            <span class="text-slate-500 font-normal">(optional)</span>
                        </label>
                        <textarea id="description" 
                                  name="description" 
                                  rows="3"
                                  class="block w-full px-3 py-2 border border-slate-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('description') border-red-300 @enderror"
                                  placeholder="Brief description of this category...">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-slate-500">Maximum 500 characters.</p>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-between">
                <a href="{{ route('admin.categories.index') }}" class="inline-flex items-center px-4 py-2 border border-slate-300 rounded-lg text-sm font-medium text-slate-700 bg-white hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to Categories
                </a>
                
                <div class="flex items-center space-x-3">
                    <button type="submit" class="inline-flex items-center px-6 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Create Category
                    </button>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const nameInput = document.getElementById('name');
            const slugInput = document.getElementById('slug');
            
            // Auto-generate slug from name if slug is empty
            nameInput.addEventListener('input', function() {
                if (slugInput.value === '') {
                    const slug = this.value
                        .toLowerCase()
                        .trim()
                        .replace(/[^a-z0-9\s-]/g, '') // Remove special characters
                        .replace(/\s+/g, '-') // Replace spaces with hyphens
                        .replace(/-+/g, '-') // Replace multiple hyphens with single
                        .replace(/^-|-$/g, ''); // Remove leading/trailing hyphens
                    
                    slugInput.value = slug;
                }
            });
            
            // Validate slug input
            slugInput.addEventListener('input', function() {
                this.value = this.value
                    .toLowerCase()
                    .replace(/[^a-z0-9-]/g, '') // Only allow lowercase letters, numbers, and hyphens
                    .replace(/-+/g, '-') // Replace multiple hyphens with single
                    .replace(/^-|-$/g, ''); // Remove leading/trailing hyphens
            });
        });
    </script>
    @endpush

</x-admin-layout>
