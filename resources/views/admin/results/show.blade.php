<x-layouts.admin title="Detail Hasil Evaluasi - SurveyKita" heading="{{ $form->title }}" eyebrow="{{ $form->evaluationPeriod->name }}">
    <div class="space-y-6">
        <x-card class="!p-4">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <form method="GET" action="{{ route('admin.results.show', $form) }}" class="flex flex-wrap gap-3">
                    <select name="category_id" class="rounded-none border border-zinc-200 bg-white px-3 py-1.5 text-xs text-zinc-950 focus:border-zinc-950 focus:ring-1 focus:ring-zinc-950 focus:outline-none">
                        <option value="">Semua kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected($selectedCategoryId === $category->id)>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <x-button type="submit" class="!min-h-8 !py-1 text-xs">Filter</x-button>
                </form>

                <div class="flex flex-wrap gap-2">
                    <x-button :href="route('admin.results.export.pdf', $form)" variant="secondary" class="!min-h-8 !py-1 text-xs">Unduh PDF</x-button>
                    <x-button :href="route('admin.results.export.excel', $form)" variant="secondary" class="!min-h-8 !py-1 text-xs">Unduh Excel</x-button>
                </div>
            </div>
        </x-card>

        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            <x-summary-card label="Total Responden" :value="$result['total_respondents']" />
            <x-summary-card label="Rata-rata Skor" :value="$result['average_score']" />
            <x-summary-card label="Persentase Kepuasan" value="{{ $result['satisfaction_percentage'] }}%" />
            <x-summary-card label="Kategori Kepuasan" :value="$result['satisfaction_category']" />
        </div>

        @if ($result['is_empty'])
            <x-empty-state title="Belum Ada Respon" description="Rincian tetap ditampilkan dengan nilai nol agar laporan aman dibuka." />
        @endif

        <div class="grid gap-6 xl:grid-cols-2">
            <x-chart-panel heading="Rata-rata Skor per Kategori" :chart="$charts['category_average']" />
            <x-chart-panel heading="Distribusi Skor Likert" :chart="$charts['likert_distribution']" />
        </div>

        <div class="grid gap-6 xl:grid-cols-2">
            <x-card heading="Rekap Kategori" subheading="Skor rata-rata berdasarkan kategori pertanyaan.">
                <div class="overflow-x-auto mt-2">
                    <table class="w-full text-left text-xs divide-y divide-zinc-200">
                        <thead class="bg-[#FBFBFA] font-mono uppercase tracking-wider text-zinc-500 font-bold">
                            <tr>
                                <th class="px-4 py-3 border-b border-zinc-200">Kategori</th>
                                <th class="px-4 py-3 border-b border-zinc-200">Jawaban</th>
                                <th class="px-4 py-3 border-b border-zinc-200">Rata-rata</th>
                                <th class="px-4 py-3 border-b border-zinc-200">Kepuasan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-100">
                            @foreach ($result['average_score_per_category'] as $row)
                                <tr class="hover:bg-zinc-50/50 transition-colors duration-150">
                                    <td class="px-4 py-3 font-bold text-zinc-900">{{ $row['category'] }}</td>
                                    <td class="px-4 py-3 font-mono text-zinc-500">{{ $row['total_answers'] }}</td>
                                    <td class="px-4 py-3 font-mono font-bold text-zinc-900">{{ $row['average_score'] }}</td>
                                    <td class="px-4 py-3">
                                        <x-badge variant="{{ str_contains(strtolower($row['satisfaction_category']), 'puas') ? 'success' : 'neutral' }}">
                                            {{ $row['satisfaction_category'] }}
                                        </x-badge>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </x-card>

            <x-card heading="Distribusi Skala Likert" subheading="Frekuensi skor jawaban dari skala 1 sampai 5.">
                <div class="grid grid-cols-5 gap-3 mt-4">
                    @foreach ($result['likert_distribution'] as $score => $count)
                        <div class="rounded-none border border-zinc-200 p-4 bg-white text-center hover:border-zinc-300 transition-all duration-300">
                            <p class="font-mono text-xs uppercase tracking-wider text-zinc-400">Skor {{ $score }}</p>
                            <p class="mt-2 text-2xl font-extrabold tracking-tight text-zinc-900">{{ $count }}</p>
                        </div>
                    @endforeach
                </div>
            </x-card>
        </div>

        <x-card heading="Rekap Detail Pertanyaan" subheading="Analisis tingkat kepuasan per butir pertanyaan.">
            <div class="overflow-x-auto mt-2">
                <table class="w-full text-left text-xs divide-y divide-zinc-200">
                    <thead class="bg-[#FBFBFA] font-mono uppercase tracking-wider text-zinc-500 font-bold">
                        <tr>
                            <th class="px-4 py-3 border-b border-zinc-200">Pertanyaan</th>
                            <th class="px-4 py-3 border-b border-zinc-200">Kategori</th>
                            <th class="px-4 py-3 border-b border-zinc-200">Jawaban</th>
                            <th class="px-4 py-3 border-b border-zinc-200">Rata-rata</th>
                            <th class="px-4 py-3 border-b border-zinc-200">Kepuasan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100">
                        @foreach ($result['average_score_per_question'] as $row)
                            <tr class="hover:bg-zinc-50/50 transition-colors duration-150">
                                <td class="px-4 py-3.5 font-medium text-zinc-900 max-w-sm leading-relaxed">{{ $row['question_text'] }}</td>
                                <td class="px-4 py-3.5 text-zinc-500 font-mono text-[11px]">{{ $row['category'] }}</td>
                                <td class="px-4 py-3.5 font-mono text-zinc-500">{{ $row['total_answers'] }}</td>
                                <td class="px-4 py-3.5 font-mono font-bold text-zinc-900">{{ $row['average_score'] }}</td>
                                <td class="px-4 py-3.5">
                                    <x-badge variant="{{ str_contains(strtolower($row['satisfaction_category']), 'puas') ? 'success' : 'neutral' }}">
                                        {{ $row['satisfaction_category'] }}
                                    </x-badge>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-card>

        <x-card heading="Saran & Feedback Mahasiswa" subheading="Umpan balik tertulis yang disampaikan responden.">
            <div class="divide-y divide-zinc-100 mt-2">
                @forelse ($result['suggestions'] as $suggestion)
                    <div class="py-4 text-xs">
                        <div class="flex items-center justify-between mb-1.5">
                            <span class="font-bold text-zinc-900">{{ $suggestion['student_name'] }}</span>
                            <span class="font-mono text-[10px] text-zinc-400">Responden</span>
                        </div>
                        <p class="text-zinc-600 leading-relaxed max-w-3xl">{{ $suggestion['suggestion'] }}</p>
                    </div>
                @empty
                    <p class="py-6 text-center text-xs font-mono text-zinc-400 uppercase tracking-wider">Belum ada saran atau umpan balik.</p>
                @endforelse
            </div>
        </x-card>
    </div>

    @push('scripts')
        @apexchartsScripts
        @foreach ($charts as $chart)
            {!! $chart->script() !!}
        @endforeach
    @endpush
</x-layouts.admin>
