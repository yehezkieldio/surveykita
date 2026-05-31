@props(['label', 'value', 'description' => null])

<div {{ $attributes->merge(['class' => 'border border-zinc-200 bg-white p-5']) }}>
    <p class="text-xs font-medium text-zinc-500">{{ $label }}</p>
    <p class="mt-4 font-display text-4xl font-semibold leading-none tracking-[-0.05em] text-zinc-950">{{ $value }}</p>
    @if ($description)
        <p class="mt-3 text-sm leading-6 text-zinc-600">{{ $description }}</p>
    @endif
</div>
