@if($template && $rendered)
    <style>
        {!! $rendered['css'] !!}
    </style>
    
    <div class="dynamic-template">
        {!! $rendered['html'] !!}
    </div>
    
    @if($rendered['js'])
        <script>
            {!! $rendered['js'] !!}
        </script>
    @endif
@else
    <div class="p-4 bg-red-100 text-red-700 rounded">
        Template not found or could not be rendered.
    </div>
@endif