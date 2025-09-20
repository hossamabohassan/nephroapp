@php
    $pageTitle = 'Page Content';
    $pageDescription = 'Manage dynamic text content across your website';
@endphp

<x-admin-layout :page-title="$pageTitle" :page-description="$pageDescription">
    
    <form method="POST" action="{{ route('admin.content.update') }}" class="space-y-8">
        @csrf

        @foreach($groupedSections as $groupName => $sections)
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                <div class="border-b border-slate-200 pb-4 mb-6">
                    <h3 class="text-lg font-semibold text-slate-900 capitalize">
                        {{ str_replace('_', ' ', $groupName) }} Content
                    </h3>
                    <p class="text-sm text-slate-600 mt-1">
                        @switch($groupName)
                            @case('general')
                                Site-wide content that appears across multiple pages
                                @break
                            @case('homepage')
                                Content specific to the homepage hero section
                                @break
                            @case('contact')
                                Contact information and communication details
                                @break
                            @default
                                Content for the {{ $groupName }} section
                        @endswitch
                    </p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    @foreach($sections as $section)
                        <div class="space-y-2">
                            <label for="content_{{ $section['key'] }}" class="block text-sm font-medium text-slate-700">
                                {{ $section['title'] }}
                                @if(isset($section['updated_at']))
                                    <span class="text-xs text-slate-500 font-normal ml-2">
                                        Updated {{ $section['updated_at']->diffForHumans() }}
                                    </span>
                                @endif
                            </label>
                            
                            @if($section['description'])
                                <p class="text-xs text-slate-500">{{ $section['description'] }}</p>
                            @endif

                            @switch($section['type'])
                                @case('textarea')
                                    <textarea 
                                        id="content_{{ $section['key'] }}" 
                                        name="content[{{ $section['key'] }}]" 
                                        rows="3"
                                        class="block w-full px-3 py-2 border border-slate-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('content.'.$section['key']) border-red-300 @enderror"
                                        placeholder="{{ $section['value'] }}">{{ old('content.'.$section['key'], $section['value']) }}</textarea>
                                    @break
                                
                                @case('email')
                                    <input 
                                        type="email" 
                                        id="content_{{ $section['key'] }}" 
                                        name="content[{{ $section['key'] }}]" 
                                        value="{{ old('content.'.$section['key'], $section['value']) }}"
                                        class="block w-full px-3 py-2 border border-slate-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('content.'.$section['key']) border-red-300 @enderror"
                                        placeholder="{{ $section['value'] }}">
                                    @break
                                
                                @default
                                    <input 
                                        type="text" 
                                        id="content_{{ $section['key'] }}" 
                                        name="content[{{ $section['key'] }}]" 
                                        value="{{ old('content.'.$section['key'], $section['value']) }}"
                                        class="block w-full px-3 py-2 border border-slate-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('content.'.$section['key']) border-red-300 @enderror"
                                        placeholder="{{ $section['value'] }}">
                            @endswitch

                            @error('content.'.$section['key'])
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach

        <!-- Action Buttons -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-sm text-slate-600">Changes are applied immediately across your website</span>
                    </div>
                </div>
                
                <div class="flex items-center space-x-3">
                    <a href="{{ route('topics.index') }}" target="_blank" class="inline-flex items-center px-4 py-2 border border-slate-300 rounded-lg text-sm font-medium text-slate-700 bg-white hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                        Preview Site
                    </a>
                    
                    <button type="submit" class="inline-flex items-center px-6 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Save All Changes
                    </button>
                </div>
            </div>
        </div>
    </form>

    <!-- Content Usage Examples -->
    <div class="bg-blue-50 rounded-xl border border-blue-200 p-6">
        <div class="flex items-start">
            <svg class="w-6 h-6 text-blue-600 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                <h4 class="text-sm font-semibold text-blue-900 mb-2">How to Use Dynamic Content</h4>
                <div class="text-sm text-blue-800 space-y-2">
                    <p>• <strong>Site Name</strong> appears in the header and browser title</p>
                    <p>• <strong>Hero Content</strong> is displayed on the homepage banner</p>
                    <p>• <strong>Contact Email</strong> is used in footers and contact forms</p>
                    <p>• Content is cached for performance - changes may take a few minutes to appear</p>
                </div>
            </div>
        </div>
    </div>

</x-admin-layout>
