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
                                             str_contains($lowerHeader, 'jumlah') ||
                                             str_contains($lowerHeader, 'skor') ||
                                             str_contains($lowerHeader, 'rata-rata') ||
                                             str_contains($lowerHeader, 'rerata') ||
                                             str_contains($lowerHeader, 'persentase') ||
                                             str_contains($lowerHeader, 'waktu') ||
                                             str_contains($lowerHeader, 'tanggal') ||
                                             $lowerHeader === 'no' ||
                                             $lowerHeader === 'form';
                            @endphp
                            <th scope="col" @class([
                                'px-3 py-3 text-xs font-bold uppercase tracking-widest text-zinc-500 whitespace-nowrap sm:px-4',
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
