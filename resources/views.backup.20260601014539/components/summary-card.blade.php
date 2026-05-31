@props(['label', 'value', 'description' => null])

<div {{ $attributes->merge(['class' => 'rounded-xl border border-zinc-200 bg-white p-6 shadow-sm']) }}>
    <p class="text-sm font-medium text-zinc-500">{{ $label }}</p>
    <p class="mt-2 text-3xl font-bold tracking-tight text-zinc-950 leading-none">{{ $value }}</p>
    @if ($description)
        <p class="mt-1.5 text-xs text-zinc-500 leading-relaxed">{{ $description }}</p>
    @endif
</div>
