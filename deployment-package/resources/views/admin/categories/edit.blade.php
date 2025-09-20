@php
    $pageTitle = 'Edit Category';
    $pageDescription = 'Update category information';
@endphp

<x-admin-layout :page-title="$pageTitle" :page-description="$pageDescription">
    
    <div class="max-w-2xl">
        <form method="POST" action="{{ route('admin.categories.update', $category) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Category Information -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                <h3 class="text-lg font-semibold text-slate-900 mb-4">Category Information</h3>
                
                <div class="space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-slate-700 mb-2">Category Name</label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="{{ old('name', $category->name) }}"
                               class="block w-full px-3 py-2 border border-slate-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('name') border-red-300 @enderror"
                               required>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="slug" class="block text-sm font-medium text-slate-700 mb-2">
                            URL Slug 
                            <span class="text-slate-500 font-normal">(auto-updated from name)</span>
                        </label>
                        <input type="text" 
                               id="slug" 
                               name="slug" 
                               value="{{ old('slug', $category->slug) }}"
                               class="block w-full px-3 py-2 border border-slate-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('slug') border-red-300 @enderror"
                               pattern="[a-z0-9-]+"
                               title="Only lowercase letters, numbers, and hyphens allowed">
                        @error('slug')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
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
                                  placeholder="Brief description of this category...">{{ old('description', $category->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Category Stats -->
            <div class="bg-slate-50 rounded-xl border border-slate-200 p-6">
                <h4 class="text-sm font-semibold text-slate-900 mb-3">Category Statistics</h4>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="text-slate-600">Topics:</span>
                        <span class="font-medium text-slate-900">{{ $category->topics()->count() }}</span>
                    </div>
                    <div>
                        <span class="text-slate-600">Created:</span>
                        <span class="font-medium text-slate-900">{{ $category->created_at->format('M d, Y') }}</span>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-between">
                <a href="{{ route('admin.categories.index') }}" class="inline-flex items-center px-4 py-2 border border-slate-300 rounded-lg text-sm font-medium text-slate-700 bg-white hover:bg-slate-50 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to Categories
                </a>
                
                <div class="flex items-center space-x-3">
                    @if($category->topics()->count() === 0)
                        <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this category?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Delete Category
                            </button>
                        </form>
                    @endif
                    
                    <button type="submit" class="inline-flex items-center px-6 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Update Category
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
            
            // Auto-update slug from name
            nameInput.addEventListener('input', function() {
                const slug = this.value
                    .toLowerCase()
                    .trim()
                    .replace(/[^a-z0-9\s-]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-')
                    .replace(/^-|-$/g, '');
                
                slugInput.value = slug;
            });
            
            // Validate slug input
            slugInput.addEventListener('input', function() {
                this.value = this.value
                    .toLowerCase()
                    .replace(/[^a-z0-9-]/g, '')
                    .replace(/-+/g, '-')
                    .replace(/^-|-$/g, '');
            });
        });
    </script>
    @endpush

</x-admin-layout>
