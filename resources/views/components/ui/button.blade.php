@props(['variant' => 'primary', 'size' => 'md'])

@php
$baseClasses = 'inline-flex items-center justify-center font-medium transition-colors focus:outline-none disabled:opacity-50 disabled:pointer-events-none';

$variants = [
    'primary' => 'bg-zinc-950 text-white hover:bg-zinc-800',
    'secondary' => 'bg-white text-zinc-950 border border-zinc-200 hover:bg-zinc-50',
    'outline' => 'bg-transparent text-zinc-950 border border-zinc-900 hover:bg-zinc-950 hover:text-white',
    'ghost' => 'bg-transparent text-zinc-600 hover:bg-zinc-50 hover:text-zinc-950',
    'danger' => 'bg-red-600 text-white hover:bg-red-700',
    'teal' => 'bg-teal-600 text-white hover:bg-teal-700',
];

$sizes = [
    'sm' => 'px-3 py-1.5 text-xs',
    'md' => 'px-4 py-2.5 text-sm',
    'lg' => 'px-6 py-3 text-base',
];

$classes = $baseClasses . ' ' . ($variants[$variant] ?? $variants['primary']) . ' ' . ($sizes[$size] ?? $sizes['md']);
@endphp

@if($attributes->has('href'))
    <a {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button {{ $attributes->merge(['type' => 'submit', 'class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif
