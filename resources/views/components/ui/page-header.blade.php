@props(['title', 'eyebrow' => null])

<header class="mb-10 animate-reveal">
    @if($eyebrow)
        <p class="mb-2 text-xs font-bold uppercase tracking-[0.2em] text-zinc-500">{{ $eyebrow }}</p>
    @endif
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <h1 class="font-display text-3xl font-bold tracking-tight text-zinc-950 sm:text-4xl leading-tight">
            {{ $title }}
        </h1>
        @isset($actions)
            <div class="flex items-center gap-3">
                {{ $actions }}
            </div>
        @endisset
    </div>
</header>
