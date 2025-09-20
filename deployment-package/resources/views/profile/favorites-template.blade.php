{{-- This view is used when a template is assigned to the favorites page --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Alpine.js for template interactivity -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    @if($template && $rendered)
        <style>
            {!! $css ?? '' !!}
        </style>
    @endif
</head>
<body class="font-sans antialiased">
    @if($template && $rendered)
        <div class="dynamic-template">
            {!! $rendered !!}
        </div>
        
        @if($js)
            <script>
                {!! $js !!}
            </script>
        @endif
    @else
        <div class="p-4 bg-red-100 text-red-700 rounded">
            Template not found or could not be rendered.
        </div>
    @endif

{{-- Include any additional scripts needed for the favorites functionality --}}
@push('scripts')
<script>
    // Get CSRF token
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    async function toggleFavorite(topicId) {
        try {
            const response = await fetch(`/api/user/topics/${topicId}/favorite`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
            });

            if (response.ok) {
                // Reload the page to update the list
                window.location.reload();
            } else {
                throw new Error('Failed to toggle favorite');
            }
        } catch (error) {
            console.error('Error toggling favorite:', error);
            alert('Failed to update favorite status');
        }
    }

    async function toggleCompleted(topicId) {
        try {
            const response = await fetch(`/api/user/topics/${topicId}/completed`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
            });

            if (response.ok) {
                const data = await response.json();
                alert(data.message);
                // Optionally reload to update other UI elements
            } else {
                throw new Error('Failed to toggle completed');
            }
        } catch (error) {
            console.error('Error toggling completed:', error);
            alert('Failed to update completed status');
        }
    }
</script>
@endpush
