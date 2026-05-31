@props(['heading' => null, 'subheading' => null])

<section {{ $attributes->merge(['class' => 'rounded-xl border border-zinc-200 bg-white p-6 shadow-sm']) }}>
    @if ($heading || $subheading)
        <div class="flex flex-col space-y-1.5 pb-6">
            @if ($heading)
                <h2 class="font-semibold leading-none tracking-tight text-zinc-950 text-base">{{ $heading }}</h2>
            @endif

            @if ($subheading)
                <p class="text-sm text-zinc-500 leading-relaxed">{{ $subheading }}</p>
            @endif
        </div>
    @endif

    <div class="text-zinc-950">
        {{ $slot }}
    </div>
</section>
