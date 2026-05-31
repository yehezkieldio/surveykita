@props(['label', 'value', 'description' => null])

<div {{ $attributes->merge(['class' => 'rounded-md border border-zinc-200 bg-white p-4 shadow-sm']) }}>
    <p class="text-sm font-medium text-zinc-500">{{ $label }}</p>
    <p class="mt-2 text-2xl font-semibold text-zinc-950">{{ $value }}</p>
    @if ($description)
        <p class="mt-1 text-sm text-zinc-600">{{ $description }}</p>
    @endif
</div>
