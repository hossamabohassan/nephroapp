@php
    use Illuminate\Support\Arr;
    use Illuminate\Support\Str;

    $data = $payload['sections'] ?? [];
    $ignored = [
        'TOPIC',
        'SUBTITLE',
        'CHIP_1',
        'CHIP_2',
        'CHIP_3',
        'OPENING_PARAGRAPH_HTML_SAFE',
    ];
@endphp

<section class="space-y-8">
    <header class="space-y-3">
        <p class="text-sm font-semibold text-indigo-600 uppercase tracking-wide">{{ $topic->slug }}</p>
        <h1 class="text-3xl font-bold text-gray-900">{{ $payload['title'] ?? $topic->title }}</h1>
        @if (!empty($payload['subtitle']))
            <p class="text-lg text-gray-600">{{ $payload['subtitle'] }}</p>
        @endif
        <div class="flex flex-wrap gap-2">
            @foreach ($payload['chips'] ?? [] as $chip)
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-indigo-100 text-indigo-800">
                    {{ $chip }}
                </span>
            @endforeach
        </div>
    </header>

    @if (!empty($payload['summary']))
        <div class="prose max-w-none">
            {!! $payload['summary'] !!}
        </div>
    @endif

    @foreach ($data as $key => $value)
        @continue(in_array($key, $ignored, true))
        @php
            $title = Str::of($key)->replace('_', ' ')->lower()->ucfirst();
            $title = Str::of($title)->replace(' html safe', '')->replace(' html', '');
        @endphp
        <section class="space-y-3">
            <h2 class="text-2xl font-semibold text-gray-800">{{ $title }}</h2>

            @if (is_array($value))
                <ul class="list-disc ms-5 space-y-2">
                    @foreach ($value as $item)
                        @if (is_array($item) && (isset($item['q']) || isset($item['a'])))
                            <li class="space-y-1">
                                @if (!empty($item['q']))
                                    <p class="font-medium text-gray-900">{{ $item['q'] }}</p>
                                @endif
                                @if (!empty($item['a']))
                                    <p class="text-gray-600">{{ $item['a'] }}</p>
                                @endif
                            </li>
                        @else
                            <li class="text-gray-700">{!! is_string($item) ? nl2br(e($item)) : json_encode($item, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</li>
                        @endif
                    @endforeach
                </ul>
            @elseif (is_string($value) && Str::contains($key, ['HTML']))
                <div class="prose max-w-none">
                    {!! $value !!}
                </div>
            @else
                <p class="text-gray-700">{!! nl2br(e($value)) !!}</p>
            @endif
        </section>
    @endforeach
</section>
