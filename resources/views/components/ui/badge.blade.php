@props(['variant' => 'zinc'])

@php
$variants = [
    'zinc' => 'bg-zinc-100 text-zinc-700',
    'teal' => 'bg-teal-50 text-teal-700 border border-teal-100',
    'red' => 'bg-red-50 text-red-700 border border-red-100',
    'yellow' => 'bg-yellow-50 text-yellow-700 border border-yellow-100',
];

$classes = 'inline-flex items-center px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider' . ' ' . ($variants[$variant] ?? $variants['zinc']);
@endphp

<span {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</span>
