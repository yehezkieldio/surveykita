@props([
    'headers' => [],
])

<div class="border border-zinc-200 bg-white">
    <div class="overflow-x-auto overflow-y-hidden scrollbar-thin scrollbar-thumb-zinc-200 scrollbar-track-transparent">
        <table class="w-full divide-y divide-zinc-200 text-sm">
            @if ($headers)
                <thead class="bg-zinc-50">
                    <tr>
                        @foreach ($headers as $header)
                            @php
                                $lowerHeader = strtolower($header);
                                $isNumeric = str_contains($lowerHeader, 'aksi') || 
                                             str_contains($lowerHeader, 'respons') || 
                                             str_contains($lowerHeader, 'soal') || 
                                             str_contains($lowerHeader, 'form') ||
                                             str_contains($lowerHeader, 'jumlah') ||
                                             $lowerHeader === 'no';
                            @endphp
                            <th scope="col" @class([
                                'px-4 py-3 text-xs font-bold uppercase tracking-widest text-zinc-500 whitespace-nowrap',
                                'text-right' => $isNumeric,
                                'text-left' => !$isNumeric,
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
</div>
