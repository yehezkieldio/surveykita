@props(['title' => 'Tidak ada data', 'description' => null])

<div {{ $attributes->merge(['class' => 'flex flex-col items-center justify-center py-10 text-center sm:py-12']) }}>
    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-zinc-100 text-zinc-400">
        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m6 4.125l2.25 2.25m0 0l2.25 2.25M12 13.875l2.25-2.25M12 13.875l-2.25 2.25M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
        </svg>
    </div>
    <h3 class="mt-4 text-sm font-semibold text-zinc-950">{{ $title }}</h3>
    @if($description)
        <p class="mt-1 max-w-xl text-sm text-zinc-500">{{ $description }}</p>
    @endif
    @if($slot->isNotEmpty())
        <div class="mt-6 w-full sm:w-auto">
            {{ $slot }}
        </div>
    @endif
</div>
