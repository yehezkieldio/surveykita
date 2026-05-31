@props([
    'href' => null,
    'variant' => 'primary',
    'type' => 'button',
])

@php
    $variants = [
        'primary' => 'border-teal-700 bg-teal-700 text-white hover:bg-teal-800',
        'secondary' => 'border-zinc-300 bg-white text-zinc-800 hover:bg-zinc-50',
        'danger' => 'border-red-700 bg-red-700 text-white hover:bg-red-800',
    ];

    $class = 'inline-flex min-h-10 items-center justify-center rounded-md border px-4 py-2 text-sm font-semibold transition '.$variants[$variant];
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
