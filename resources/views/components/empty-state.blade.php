@props([
    'title' => 'Belum ada data',
    'description' => 'Data akan tampil setelah tersedia.',
])

<div {{ $attributes->merge(['class' => 'rounded-md border border-dashed border-zinc-300 bg-white px-6 py-10 text-center']) }}>
    <h2 class="text-base font-semibold text-zinc-950">{{ $title }}</h2>
    <p class="mx-auto mt-2 max-w-xl text-sm text-zinc-600">{{ $description }}</p>
</div>
