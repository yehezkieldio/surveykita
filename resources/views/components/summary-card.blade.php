@props(['label', 'value', 'description' => null])

<div {{ $attributes->merge(['class' => 'rounded-none border border-zinc-200 bg-white p-6 shadow-none transition-all duration-300 hover:border-zinc-300']) }}>
    <p class="font-mono text-[10px] uppercase tracking-wider text-zinc-400 font-bold">{{ $label }}</p>
    <p class="mt-3 text-3xl font-extrabold tracking-tight text-zinc-900 leading-none">{{ $value }}</p>
    @if ($description)
        <p class="mt-2 text-xs text-zinc-500 leading-relaxed">{{ $description }}</p>
    @endif
</div>
