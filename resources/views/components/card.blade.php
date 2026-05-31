@props(['heading' => null, 'subheading' => null])

<section {{ $attributes->merge(['class' => 'rounded-md border border-zinc-200 bg-white p-5 shadow-sm']) }}>
    @if ($heading || $subheading)
        <div class="mb-4">
            @if ($heading)
                <h2 class="text-base font-semibold text-zinc-950">{{ $heading }}</h2>
            @endif

            @if ($subheading)
                <p class="mt-1 text-sm text-zinc-600">{{ $subheading }}</p>
            @endif
        </div>
    @endif

    {{ $slot }}
</section>
