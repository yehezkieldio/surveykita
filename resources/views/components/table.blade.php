@props(['headers' => []])

<div {{ $attributes->merge(['class' => 'border border-zinc-200 bg-white']) }}>
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            @if ($headers)
                <thead>
                    <tr class="border-b border-zinc-200">
                        @foreach ($headers as $header)
                            <th scope="col" class="px-5 py-3 text-left text-xs font-medium leading-none text-zinc-500">{{ $header }}</th>
                        @endforeach
                    </tr>
                </thead>
            @endif

            <tbody class="divide-y divide-zinc-200 text-zinc-950">
                {{ $slot }}
            </tbody>
        </table>
    </div>
</div>
