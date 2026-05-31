@props([
    'href' => null,
    'variant' => 'primary',
    'type' => 'button',
])

@php
    $variants = [
        'primary' => 'border-zinc-950 bg-zinc-950 text-white hover:bg-zinc-900 active:scale-[0.98]',
        'secondary' => 'border-zinc-200 bg-white text-zinc-800 hover:bg-zinc-50 active:scale-[0.98]',
        'danger' => 'border-[#9F2F2D] bg-[#9F2F2D] text-white hover:bg-[#852725] active:scale-[0.98]',
    ];

    $class = 'inline-flex min-h-10 items-center justify-center rounded-none border px-4 py-2 text-xs font-mono uppercase tracking-wider transition-all duration-200 ease-spring '.$variants[$variant];
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
