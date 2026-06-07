<x-layouts.admin :heading="$form->title" eyebrow="Laporan Detail Evaluasi">
    <x-slot:actions>
        <div class="flex items-center gap-3">
            <x-ui.button href="{{ route('admin.results.export.excel', $form) }}" variant="secondary" size="sm">
                <svg class="mr-2 h-4 w-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m.75 12l3 3m0 0l3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                </svg>
                Excel
            </x-ui.button>
            <x-ui.button href="{{ route('admin.results.export.pdf', $form) }}" variant="secondary" size="sm">
                <svg class="mr-2 h-4 w-4 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                </svg>
                PDF
            </x-ui.button>
        </div>
    </x-slot:actions>

    {{-- Summary Metrics - Split into 2 and 3 --}}
    <div class="space-y-6 mb-12">
        <div class="grid gap-6 sm:grid-cols-2">
            <x-ui.card no-padding class="p-6">
                <p class="text-[10px] font-bold uppercase tracking-widest text-zinc-400">Total Responden</p>
                <div class="mt-2 flex items-baseline gap-1">
                    <span class="text-3xl font-bold tracking-tight text-zinc-950">{{ number_format($result['total_respondents']) }}</span>
                    <span class="text-xs font-medium text-zinc-500">Mahasiswa</span>
                </div>
            </x-ui.card>

            <x-ui.card no-padding class="p-6">
                <p class="text-[10px] font-bold uppercase tracking-widest text-zinc-400">Total Jawaban</p>
                <div class="mt-2 flex items-baseline gap-1">
                    <span class="text-3xl font-bold tracking-tight text-zinc-950">{{ number_format($result['total_answers']) }}</span>
                    <span class="text-xs font-medium text-zinc-500">Butir</span>
                </div>
            </x-ui.card>
        </div>

        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <x-ui.card no-padding class="p-6">
                <p class="text-[10px] font-bold uppercase tracking-widest text-zinc-400">Rata-rata Skor</p>
                <div class="mt-2 flex items-baseline gap-1">
                    <span class="text-3xl font-bold tracking-tight text-zinc-950">{{ number_format($result['average_score'], 2) }}</span>
                    <span class="text-xs font-medium text-zinc-500">/ 5.00</span>
                </div>
            </x-ui.card>

            <x-ui.card no-padding class="p-6">
                <p class="text-[10px] font-bold uppercase tracking-widest text-zinc-400">Persentase Kepuasan</p>
                <div class="mt-2 flex items-baseline gap-1">
                    <span class="text-3xl font-bold tracking-tight text-teal-600">{{ number_format($result['satisfaction_percentage'], 1) }}%</span>
                </div>
            </x-ui.card>

            <x-ui.card no-padding class="p-6">
                <p class="text-[10px] font-bold uppercase tracking-widest text-zinc-400">Kategori Kepuasan</p>
                <div class="mt-2 flex items-center">
                    @if($result['is_empty'])
                        <x-ui.badge variant="zinc">BELUM ADA DATA</x-ui.badge>
                    @else
                        @php
                            $badgeVariant = match(true) {
                                $result['satisfaction_percentage'] >= 80 => 'teal',
                                $result['satisfaction_percentage'] >= 60 => 'yellow',
                                default => 'red',
                            };
                        @endphp
                        <x-ui.badge :variant="$badgeVariant" class="text-sm px-3 py-1">{{ $result['satisfaction_category'] }}</x-ui.badge>
                    @endif
                </div>
            </x-ui.card>
        </div>
    </div>

    {{-- Filter & Detail Content --}}
    <div class="grid gap-8 lg:grid-cols-[1fr_20rem] xl:grid-cols-[1fr_24rem]">
        <div class="space-y-12">
            {{-- Charts --}}
            <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-1 xl:grid-cols-2">
                <x-ui.chart-panel 
                    heading="Rerata per Kategori" 
                    description="Perbandingan skor rata-rata untuk setiap kategori pertanyaan."
                    :chart="$charts['category_average']" 
                />
                <x-ui.chart-panel 
                    heading="Distribusi Skor Likert" 
                    description="Frekuensi pemilihan skor 1 sampai 5 oleh seluruh responden."
                    :chart="$charts['likert_distribution']" 
                />
            </div>

            {{-- Category Recap --}}
            <section>
                <h3 class="text-sm font-bold uppercase tracking-[0.2em] text-zinc-400 mb-6">Rekapitulasi Kategori</h3>
                <x-ui.table :headers="['Kategori', 'Total Jawaban', 'Rata-rata', 'Persentase', 'Status']">
                    @foreach ($result['average_score_per_category'] as $cat)
                        <tr>
                            <td class="px-6 py-4 text-sm font-semibold text-zinc-950">{{ $cat['category'] }}</td>
                            <td class="whitespace-nowrap px-6 py-4 text-right text-sm text-zinc-600">{{ number_format($cat['total_answers']) }}</td>
                            <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-bold text-zinc-900">{{ number_format($cat['average_score'], 2) }}</td>
                            <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-bold text-teal-600">{{ number_format($cat['satisfaction_percentage'], 1) }}%</td>
                            <td class="whitespace-nowrap px-6 py-4">
                                <x-ui.badge>{{ $cat['satisfaction_category'] }}</x-ui.badge>
                            </td>
                        </tr>
                    @endforeach
                </x-ui.table>
            </section>

            {{-- Question Recap --}}
            <section>
                <h3 class="text-sm font-bold uppercase tracking-[0.2em] text-zinc-400 mb-6">Analisis Butir Pertanyaan</h3>
                <x-ui.table :headers="['Pertanyaan', 'Kategori', 'Rerata', 'Kepuasan']">
                    @foreach ($result['average_score_per_question'] as $q)
                        <tr>
                            <td class="px-6 py-4 text-sm text-zinc-950 max-w-md">{{ $q['question_text'] }}</td>
                            <td class="whitespace-nowrap px-6 py-4 text-xs font-medium text-zinc-500">{{ $q['category'] }}</td>
                            <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-bold text-zinc-900">{{ number_format($q['average_score'], 2) }}</td>
                            <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-bold text-teal-600">{{ number_format($q['satisfaction_percentage'], 1) }}%</td>
                        </tr>
                    @endforeach
                </x-ui.table>
            </section>
        </div>

        <aside class="space-y-8">
            {{-- Category Filter --}}
            <x-ui.card title="Filter Kategori" description="Tampilkan data hanya untuk kategori tertentu.">
                <form action="{{ route('admin.results.show', $form) }}" method="GET" class="space-y-4">
                    <select name="category_id" class="w-full">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" @selected($selectedCategoryId == $category->id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    <div class="flex items-center justify-between gap-3">
                        <x-ui.button variant="teal" class="flex-1">Terapkan</x-ui.button>
                        <a href="{{ route('admin.results.show', $form) }}" class="text-xs font-semibold text-zinc-500 hover:text-zinc-950 transition-colors">Reset</a>
                    </div>
                </form>
            </x-ui.card>

            {{-- Numerical Distribution --}}
            <x-ui.card title="Distribusi Jawaban" description="Jumlah kemunculan setiap nilai skor.">
                <div class="space-y-4">
                    @foreach (array_reverse($result['likert_distribution'], true) as $score => $count)
                        @php
                            $width = $result['total_answers'] > 0 ? ($count / $result['total_answers']) * 100 : 0;
                            $labels = [1 => 'Sangat Tidak Puas', 2 => 'Tidak Puas', 3 => 'Cukup Puas', 4 => 'Puas', 5 => 'Sangat Puas'];
                        @endphp
                        <div class="space-y-1">
                            <div class="flex items-center justify-between text-[10px] font-bold uppercase tracking-widest">
                                <span class="text-zinc-500">Skor {{ $score }} ({{ $labels[$score] }})</span>
                                <span class="text-zinc-950">{{ $count }}</span>
                            </div>
                            <div class="h-2 w-full bg-zinc-100 rounded-full overflow-hidden">
                                <div class="h-full bg-teal-500 rounded-full" style="width: {{ $width }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </x-ui.card>

            {{-- Suggestions --}}
            <section>
                <div class="mb-4 flex items-center justify-between">
                    <h3 class="text-sm font-bold uppercase tracking-[0.2em] text-zinc-400">Saran & Masukan</h3>
                    <x-ui.badge variant="zinc">{{ count($result['suggestions']) }}</x-ui.badge>
                </div>
                
                @if(empty($result['suggestions']))
                    <x-ui.empty-state title="Belum ada saran" description="Mahasiswa belum memberikan masukan tertulis pada formulir ini." />
                @else
                    <div class="space-y-4">
                        @foreach ($result['suggestions'] as $suggestion)
                            <x-ui.card no-padding class="p-4 bg-zinc-50/50">
                                <div class="flex items-start justify-between mb-2">
                                    <span class="text-[10px] font-bold text-zinc-900 truncate">{{ $suggestion['student_name'] }}</span>
                                    <span class="text-[9px] font-medium text-zinc-400 whitespace-nowrap">{{ $suggestion['submitted_at']->translatedFormat('d/m/y') }}</span>
                                </div>
                                <p class="text-xs leading-relaxed text-zinc-600 italic">
                                    "{{ $suggestion['suggestion'] }}"
                                </p>
                            </x-ui.card>
                        @endforeach
                    </div>
                @endif
            </section>
        </aside>
    </div>
</x-layouts.admin>
