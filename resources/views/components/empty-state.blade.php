@props([
    'title' => 'Belum ada data',
    'description' => 'Data akan tampil setelah tersedia.',
])

<div {{ $attributes->merge(['class' => 'rounded-none border border-dashed border-zinc-300 bg-white px-8 py-14 text-center']) }}>
    <h2 class="font-mono text-xs uppercase tracking-wider text-zinc-400 font-bold">{{ $title }}</h2>
    <p class="mx-auto mt-2 max-w-md text-xs text-zinc-500 leading-relaxed">{{ $description }}</p>
</div>
