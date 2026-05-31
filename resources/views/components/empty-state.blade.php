@props([
    'title' => 'Belum ada data',
    'description' => 'Data akan tampil setelah tersedia.',
])

<div {{ $attributes->merge(['class' => 'rounded-xl border border-dashed border-zinc-200 bg-white px-8 py-12 text-center']) }}>
    <h3 class="text-sm font-semibold text-zinc-950">{{ $title }}</h3>
    <p class="mx-auto mt-1.5 max-w-sm text-sm text-zinc-500 leading-relaxed">{{ $description }}</p>
</div>
