@props(['heading' => null, 'subheading' => null])

<section {{ $attributes->merge(['class' => 'rounded-none border border-zinc-200 bg-white p-6 shadow-none transition-all duration-300']) }}>
    @if ($heading || $subheading)
        <div class="mb-6 border-b border-zinc-100 pb-4">
            @if ($heading)
                <h2 class="text-sm font-bold uppercase tracking-wider text-zinc-900">{{ $heading }}</h2>
            @endif

            @if ($subheading)
                <p class="mt-1 text-xs text-zinc-500 leading-relaxed">{{ $subheading }}</p>
            @endif
        </div>
    @endif

    {{ $slot }}
</section>
