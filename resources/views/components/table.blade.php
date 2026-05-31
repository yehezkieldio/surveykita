@props(['headers' => []])

<div {{ $attributes->merge(['class' => 'overflow-hidden rounded-md border border-zinc-200 bg-white']) }}>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-zinc-200 text-sm">
            @if ($headers)
                <thead class="bg-zinc-50">
                    <tr>
                        @foreach ($headers as $header)
                            <th scope="col" class="px-4 py-3 text-left font-semibold text-zinc-700">{{ $header }}</th>
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
