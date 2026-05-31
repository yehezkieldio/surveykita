@props([
    'href' => null,
    'variant' => 'primary',
    'type' => 'button',
])

@php
    $variants = [
        'primary' => 'border-transparent bg-zinc-900 text-zinc-50 hover:bg-zinc-900/90 shadow',
        'secondary' => 'border-zinc-200 bg-white text-zinc-900 hover:bg-zinc-50 shadow-sm',
        'danger' => 'border-transparent bg-red-600 text-white hover:bg-red-600/90 shadow-sm',
    ];

    $class = 'inline-flex h-9 items-center justify-center rounded-md border px-4 py-2 text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-zinc-950 disabled:pointer-events-none disabled:opacity-50 '.$variants[$variant];
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $class]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $class]) }}>
        {{ $slot }}
    </button>
@endif
