@props(['headers' => []])

<div {{ $attributes->merge(['class' => 'overflow-hidden rounded-lg border border-zinc-200 bg-white shadow-sm']) }}>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-zinc-200 text-sm">
            @if ($headers)
                <thead class="bg-zinc-50/75">
                    <tr>
                        @foreach ($headers as $header)
                            <th scope="col" class="px-6 py-3.5 text-left font-medium text-zinc-500 text-xs tracking-tight border-b border-zinc-200">{{ $header }}</th>
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
