@props([
    'headers' => [],
])

<div class="overflow-x-auto border border-zinc-200 bg-white">
    <table class="min-w-full divide-y divide-zinc-200 text-sm">
        @if ($headers)
            <thead class="bg-zinc-50">
                <tr>
                    @foreach ($headers as $header)
                        <th scope="col" @class([
                            'px-6 py-4 text-xs font-bold uppercase tracking-widest text-zinc-500',
                            'text-right' => str_contains(strtolower($header), 'aksi') || str_contains(strtolower($header), 'respons') || str_contains(strtolower($header), 'soal'),
                            'text-left' => !str_contains(strtolower($header), 'aksi') && !str_contains(strtolower($header), 'respons') && !str_contains(strtolower($header), 'soal'),
                        ])>
                            {{ $header }}
                        </th>
                    @endforeach
                </tr>
            </thead>
        @endif
        <tbody class="divide-y divide-zinc-100 bg-white">
            {{ $slot }}
        </tbody>
    </table>
</div>
