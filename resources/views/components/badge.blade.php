@props(['variant' => 'neutral'])

@php
    $variants = [
        'success' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
        'warning' => 'bg-amber-50 text-amber-700 border-amber-200',
        'danger' => 'bg-red-50 text-red-700 border-red-200',
        'info' => 'bg-blue-50 text-blue-700 border-blue-200',
        'neutral' => 'bg-zinc-100 text-zinc-800 border-zinc-200',
    ];
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-medium transition-all duration-200 '.$variants[$variant]]) }}>
    {{ $slot }}
</span>
