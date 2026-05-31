@props(['heading' => null, 'subheading' => null])

<section {{ $attributes->merge(['class' => 'border border-zinc-200 bg-white']) }}>
    @if ($heading || $subheading)
        <div class="border-b border-zinc-200 px-6 py-5">
            @if ($heading)
                <h2 class="font-display text-lg font-semibold leading-tight tracking-[-0.03em] text-zinc-950">{{ $heading }}</h2>
            @endif

            @if ($subheading)
                <p class="mt-2 max-w-3xl text-sm leading-6 text-zinc-600">{{ $subheading }}</p>
            @endif
        </div>
    @endif

    <div class="p-6 text-zinc-950">
        {{ $slot }}
    </div>
</section>
