@props(['headers' => []])

<div {{ $attributes->merge(['class' => 'overflow-hidden rounded-none border border-zinc-200 bg-white shadow-none']) }}>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-zinc-200 text-xs">
            @if ($headers)
                <thead class="bg-[#FBFBFA]">
                    <tr>
                        @foreach ($headers as $header)
                            <th scope="col" class="px-6 py-4.5 text-left font-mono uppercase tracking-wider text-zinc-500 font-bold border-b border-zinc-200">{{ $header }}</th>
                        @endforeach
                    </tr>
                </thead>
            @endif

            <tbody class="divide-y divide-zinc-100">
                {{ $slot }}
            </tbody>
        </table>
    </div>
</div>
