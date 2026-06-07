@props(['variant' => 'primary', 'size' => 'md'])

@php
$baseClasses = 'inline-flex items-center justify-center font-medium transition-colors focus:outline-none disabled:opacity-50 disabled:pointer-events-none';

$variants = [
    'primary' => 'bg-zinc-950 text-white hover:bg-black shadow-md active:translate-y-[1px] border border-zinc-950 opacity-100',
    'secondary' => 'bg-white text-zinc-950 border border-zinc-300 hover:bg-zinc-50 shadow-sm opacity-100',
    'outline' => 'bg-transparent text-zinc-950 border-2 border-zinc-950 hover:bg-zinc-950 hover:text-white opacity-100',
    'ghost' => 'bg-transparent text-zinc-600 hover:bg-zinc-50 hover:text-zinc-950 opacity-100',
    'danger' => 'bg-red-700 text-white hover:bg-red-800 shadow-md active:translate-y-[1px] border border-red-800 opacity-100',
    'teal' => 'bg-teal-900 text-white hover:bg-teal-800 shadow-md active:translate-y-[1px] border border-teal-700 opacity-100',
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
