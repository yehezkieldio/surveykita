@props([
    'headers' => [],
    'title' => null,
    'description' => null,
    'count' => null,
])

<section {{ $attributes->merge(['class' => 'border border-zinc-200 bg-white']) }}>
    @if ($title || $description || $count !== null || isset($toolbar))
        <div class="flex flex-col gap-4 border-b border-zinc-200 bg-white p-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                @if ($title)
                    <h2 class="font-display text-2xl font-semibold leading-none tracking-[-0.05em] text-zinc-950">{{ $title }}</h2>
                @endif
                @if ($description)
                    <p class="mt-2 max-w-3xl text-sm leading-6 text-zinc-600">{{ $description }}</p>
                @endif
            </div>
            <div class="flex flex-wrap items-center gap-2">
                @if ($count !== null)
                    <span class="border border-zinc-200 bg-zinc-50 px-3 py-2 text-sm font-medium text-zinc-700">{{ $count }} data</span>
                @endif
                @isset($toolbar)
                    {{ $toolbar }}
                @endisset
            </div>
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full table-auto text-sm">
            @if ($headers)
                <thead class="bg-zinc-50">
                    <tr class="border-b border-zinc-200">
                        @foreach ($headers as $header)
                            <th scope="col" class="whitespace-nowrap px-4 py-3 text-left text-xs font-semibold leading-none text-zinc-500">{{ $header }}</th>
                        @endforeach
                    </tr>
                </thead>
            @endif

            <tbody class="divide-y divide-zinc-200 text-zinc-950">
                {{ $slot }}
            </tbody>
        </table>
    </div>

    @isset($footer)
        <div class="border-t border-zinc-200 bg-zinc-50 px-4 py-3">
            {{ $footer }}
        </div>
    @endisset
</section>
