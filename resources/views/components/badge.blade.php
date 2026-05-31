@props(['variant' => 'neutral'])

@php
    $variants = [
        'success' => 'bg-emerald-100 text-emerald-800',
        'warning' => 'bg-amber-100 text-amber-900',
        'danger' => 'bg-red-100 text-red-800',
        'info' => 'bg-teal-100 text-teal-800',
        'neutral' => 'bg-zinc-100 text-zinc-700',
    ];
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center rounded px-2 py-1 text-xs font-semibold '.$variants[$variant]]) }}>
    {{ $slot }}
</span>
