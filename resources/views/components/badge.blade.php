@props(['variant' => 'neutral'])

@php
    $variants = [
        'success' => 'border-emerald-200 bg-emerald-50 text-emerald-800',
        'warning' => 'border-amber-200 bg-amber-50 text-amber-800',
        'danger' => 'border-red-200 bg-red-50 text-red-800',
        'info' => 'border-blue-200 bg-blue-50 text-blue-800',
        'neutral' => 'border-zinc-200 bg-zinc-100 text-zinc-800',
    ];
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center border px-2 py-1 text-xs font-medium leading-none '.$variants[$variant]]) }}>
    {{ $slot }}
</span>
