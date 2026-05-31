@props([
    'title' => 'Belum ada data',
    'description' => 'Data akan tampil setelah tersedia.',
])

<div {{ $attributes->merge(['class' => 'border border-dashed border-zinc-300 bg-zinc-50 px-8 py-12 text-center']) }}>
    <h3 class="font-display text-lg font-semibold tracking-[-0.03em] text-zinc-950">{{ $title }}</h3>
    <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-zinc-600">{{ $description }}</p>
</div>
