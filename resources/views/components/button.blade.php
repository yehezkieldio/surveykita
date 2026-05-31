@props([
    'href' => null,
    'variant' => 'primary',
    'type' => 'button',
])

@php
    $variants = [
        'primary' => 'border-zinc-950 bg-zinc-950 text-white hover:bg-zinc-800 hover:border-zinc-800',
        'secondary' => 'border-zinc-300 bg-white text-zinc-950 hover:border-zinc-950 hover:bg-zinc-50',
        'danger' => 'border-red-700 bg-red-700 text-white hover:border-red-800 hover:bg-red-800',
    ];

    $class = 'inline-flex min-h-10 items-center justify-center border px-4 py-2 text-sm font-semibold leading-none tracking-[-0.01em] transition-colors active:translate-y-px disabled:pointer-events-none disabled:opacity-50 '.$variants[$variant];
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
