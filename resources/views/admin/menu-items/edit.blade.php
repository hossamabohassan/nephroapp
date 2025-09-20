@php
    $pageTitle = 'Edit Menu Item';
    $pageDescription = 'Update "' . $menuItem->title . '"';
@endphp

<x-admin-layout :page-title="$pageTitle" :page-description="$pageDescription">
    
    <!-- Header -->
    <div class="flex items-center mb-6">
        <a href="{{ route('admin.menu-items.index') }}" class="mr-4 text-slate-600 hover:text-slate-900 transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <h1 class="text-3xl font-bold text-slate-900">Edit Menu Item</h1>
            <p class="text-slate-600 mt-1">Update "{{ $menuItem->title }}"</p>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <form action="{{ route('admin.menu-items.update', $menuItem) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            @include('admin.menu-items.form', ['menuItem' => $menuItem])
        </form>
    </div>

</x-admin-layout>
