<x-layouts.admin :heading="$form->title" eyebrow="Hasil Evaluasi">
    <x-slot:actions>
        <div class="flex items-center justify-end gap-2 flex-wrap sm:flex-nowrap">
            <x-ui.button href="{{ route('admin.results.index') }}" variant="ghost" size="sm">
                Kembali
            </x-ui.button>
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

    @php
        $satisfactionBadgeVariant = match (true) {
            $result['is_empty'] => 'zinc',
            $result['satisfaction_percentage'] >= 80 => 'teal',
            $result['satisfaction_percentage'] >= 60 => 'yellow',
            default => 'red',
        };

        $topQuestion = collect($result['average_score_per_question'])
            ->filter(fn (array $question): bool => $question['total_answers'] > 0)
            ->sortByDesc('average_score')
            ->first();
    @endphp

    <div class="grid gap-8 xl:grid-cols-12">
        <section class="min-w-0 xl:col-span-8">
            <x-ui.card no-padding class="h-full overflow-hidden">
                <div class="border-b border-zinc-100 p-6 xl:p-7">
                    <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-zinc-400">Ringkasan Formulir</p>
                    <p class="mt-3 max-w-3xl text-sm leading-7 text-zinc-600">
                        {{ $form->description ?: 'Halaman ini merangkum performa formulir, distribusi jawaban, dan butir pertanyaan dengan fokus pada kualitas respons yang sudah terkumpul.' }}
                    </p>
                </div>
                <div class="grid gap-0 sm:grid-cols-2 xl:grid-cols-3">
                    <div class="border-b border-zinc-100 p-6 sm:border-r xl:p-7">
                        <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-zinc-400">Periode</p>
                        <p class="mt-2 text-base font-semibold leading-7 text-zinc-950">{{ $form->evaluationPeriod->name }}</p>
                    </div>
                    <div class="border-b border-zinc-100 p-6 xl:border-l xl:border-r xl:border-b-0 xl:p-7 sm:border-b xl:sm:border-b-0">
                        <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-zinc-400">Target</p>
                        <p class="mt-2 text-base font-semibold leading-7 text-zinc-950">{{ $form->target_type }}</p>
                    </div>
                    <div class="p-6 sm:col-span-2 xl:col-span-1 xl:p-7">
                        <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-zinc-400">Fokus Analisis</p>
                        <div class="mt-2 flex flex-wrap items-center gap-2">
                            <x-ui.badge :variant="$selectedCategoryId ? 'teal' : 'zinc'">
                                {{ $result['category_filter']['name'] ?? 'Semua Kategori' }}
                            </x-ui.badge>
                            <span class="text-sm font-medium text-zinc-500">
                                {{ count($result['average_score_per_question']) }} butir diproses
                            </span>
                        </div>
                    </div>
                </div>
            </x-ui.card>
        </section>

        <aside class="min-w-0 xl:col-span-4">
            <x-ui.card no-padding class="h-full overflow-hidden">
                <div class="border-b border-zinc-100 px-6 py-5 xl:px-7">
                    <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-zinc-400">Kontrol Analisis</p>
                    <p class="mt-2 text-lg font-semibold tracking-tight text-zinc-950">Filter kategori dan status evaluasi</p>
                </div>
                <div class="space-y-5 px-6 py-5 xl:px-7">
                    <form action="{{ route('admin.results.show', $form) }}" method="GET" class="space-y-4">
                        <div class="space-y-1.5">
                            <label for="category_id" class="text-[10px] font-bold uppercase tracking-[0.18em] text-zinc-400">Kategori</label>
                            <select id="category_id" name="category_id" class="w-full">
                                <option value="">Semua Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" @selected($selectedCategoryId == $category->id)>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex items-center gap-3">
                            <x-ui.button variant="teal" class="flex-1">Terapkan</x-ui.button>
                            <a href="{{ route('admin.results.show', $form) }}" class="text-xs font-semibold text-zinc-500 transition-colors hover:text-zinc-950">Reset</a>
                        </div>
                    </form>

                    <div class="space-y-4 border-t border-zinc-100 pt-5">
                        <div class="flex items-center justify-between gap-4 border-b border-zinc-100 pb-4">
                            <span class="text-xs font-medium text-zinc-500">Status</span>
                            <x-ui.badge :variant="$satisfactionBadgeVariant">
                                {{ $result['satisfaction_category'] }}
                            </x-ui.badge>
                        </div>
                        <div class="flex items-center justify-between gap-4">
                            <span class="text-xs font-medium text-zinc-500">Saran Masuk</span>
                            <span class="text-sm font-semibold text-zinc-950">{{ number_format(count($result['suggestions'])) }}</span>
                        </div>
                    </div>
                </div>
            </x-ui.card>
        </aside>

        <section class="min-w-0 xl:col-span-12">
            <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                <x-ui.card no-padding class="overflow-hidden p-6">
                    <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-zinc-400">Total Responden</p>
                    <div class="mt-3 flex items-end justify-between gap-4">
                        <span class="text-3xl font-bold tracking-tight text-zinc-950">{{ number_format($result['total_respondents']) }}</span>
                        <span class="text-xs font-medium text-zinc-500">mahasiswa</span>
                    </div>
                </x-ui.card>
                <x-ui.card no-padding class="overflow-hidden p-6">
                    <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-zinc-400">Total Jawaban</p>
                    <div class="mt-3 flex items-end justify-between gap-4">
                        <span class="text-3xl font-bold tracking-tight text-zinc-950">{{ number_format($result['total_answers']) }}</span>
                        <span class="text-xs font-medium text-zinc-500">butir</span>
                    </div>
                </x-ui.card>
                <x-ui.card no-padding class="overflow-hidden p-6">
                    <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-zinc-400">Rata-rata Skor</p>
                    <div class="mt-3 flex items-end justify-between gap-4">
                        <span class="text-3xl font-bold tracking-tight text-zinc-950">{{ number_format($result['average_score'], 2) }}</span>
                        <span class="text-xs font-medium text-zinc-500">dari 5.00</span>
                    </div>
                </x-ui.card>
                <x-ui.card no-padding class="overflow-hidden p-6">
                    <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-zinc-400">Persentase Kepuasan</p>
                    <div class="mt-3 flex items-end justify-between gap-4">
                        <span class="text-3xl font-bold tracking-tight {{ $result['is_empty'] ? 'text-zinc-950' : 'text-teal-600' }}">{{ number_format($result['satisfaction_percentage'], 1) }}%</span>
                        <x-ui.badge :variant="$satisfactionBadgeVariant">{{ $result['is_empty'] ? 'BELUM ADA DATA' : 'TERBACA' }}</x-ui.badge>
                    </div>
                </x-ui.card>
            </div>
        </section>

        <section class="min-w-0 xl:col-span-12">
            <div class="grid gap-8 xl:grid-cols-2">
                <x-ui.chart-panel 
                    heading="Rerata per Kategori"
                    description="Perbandingan skor rata-rata untuk setiap kategori pertanyaan dalam formulir ini."
                    :chart="$charts['category_average']"
                />
                <x-ui.chart-panel 
                    heading="Distribusi Skor Likert"
                    description="Sebaran skor 1 sampai 5 untuk membaca kecenderungan kepuasan responden."
                    :chart="$charts['likert_distribution']"
                />
            </div>
        </section>

        <section class="min-w-0 xl:col-span-12">
            <div class="mb-4 grid gap-3 lg:grid-cols-[minmax(0,1fr)_auto] lg:items-start">
                <div>
                    <h3 class="text-sm font-bold uppercase tracking-[0.18em] text-zinc-400">Rekapitulasi Kategori</h3>
                    <p class="mt-1 text-sm leading-6 text-zinc-500">Analisis kategori dibuat penuh agar pola kekuatan dan kelemahan instrumen tidak tersembunyi di kolom sempit.</p>
                </div>
                <div class="flex flex-wrap items-center gap-2 lg:justify-end">
                    <x-ui.badge variant="zinc">{{ count($result['average_score_per_category']) }} Kategori</x-ui.badge>
                    @if($result['category_filter'])
                        <x-ui.badge variant="teal">{{ $result['category_filter']['name'] }}</x-ui.badge>
                    @endif
                </div>
            </div>

            @if(empty($result['average_score_per_category']))
                <x-ui.empty-state title="Belum ada rekap kategori" description="Tidak ada kategori yang dapat dihitung untuk formulir atau filter yang sedang dipilih." />
            @else
                <x-ui.table :headers="['Kategori', 'Total Jawaban', 'Rata-rata', 'Persentase', 'Status']">
                    @foreach ($result['average_score_per_category'] as $categoryRow)
                        @php
                            $rowBadgeVariant = match (true) {
                                $categoryRow['total_answers'] === 0 => 'zinc',
                                $categoryRow['satisfaction_percentage'] >= 80 => 'teal',
                                $categoryRow['satisfaction_percentage'] >= 60 => 'yellow',
                                default => 'red',
                            };
                        @endphp
                        <tr>
                            <td class="px-5 py-5 align-top text-sm font-semibold leading-7 text-zinc-950 whitespace-normal">{{ $categoryRow['category'] }}</td>
                            <td class="whitespace-nowrap px-5 py-5 align-top text-right text-sm text-zinc-600">{{ number_format($categoryRow['total_answers']) }}</td>
                            <td class="whitespace-nowrap px-5 py-5 align-top text-right text-sm font-bold text-zinc-950">{{ number_format($categoryRow['average_score'], 2) }}</td>
                            <td class="whitespace-nowrap px-5 py-5 align-top text-right text-sm font-bold {{ $categoryRow['total_answers'] === 0 ? 'text-zinc-500' : 'text-teal-600' }}">{{ number_format($categoryRow['satisfaction_percentage'], 1) }}%</td>
                            <td class="whitespace-nowrap px-5 py-5 align-top">
                                <x-ui.badge :variant="$rowBadgeVariant">{{ $categoryRow['satisfaction_category'] }}</x-ui.badge>
                            </td>
                        </tr>
                    @endforeach
                </x-ui.table>
            @endif
        </section>

        <section class="min-w-0 xl:col-span-12">
            <div class="mb-4 grid gap-3 lg:grid-cols-[minmax(0,1fr)_auto] lg:items-start">
                <div>
                    <h3 class="text-sm font-bold uppercase tracking-[0.18em] text-zinc-400">Analisis Butir Pertanyaan</h3>
                    <p class="mt-1 text-sm leading-6 text-zinc-500">Butir pertanyaan diprioritaskan sebagai bidang penuh karena di sinilah admin membaca mutu instrumen secara konkret, bukan sekadar total angka.</p>
                </div>
                <div class="flex flex-wrap items-center gap-2 lg:justify-end">
                    <x-ui.badge variant="zinc">{{ count($result['average_score_per_question']) }} Butir</x-ui.badge>
                    @if($topQuestion)
                        <x-ui.badge variant="teal">Tertinggi {{ number_format($topQuestion['average_score'], 2) }}</x-ui.badge>
                    @endif
                </div>
            </div>

            @if(empty($result['average_score_per_question']))
                <x-ui.empty-state title="Belum ada analisis pertanyaan" description="Tidak ada butir pertanyaan yang dapat dihitung untuk formulir atau filter yang dipilih." />
            @else
                <x-ui.table :headers="['Pertanyaan', 'Kategori', 'Jawaban', 'Rata-rata', 'Kepuasan']">
                    @foreach ($result['average_score_per_question'] as $questionRow)
                        <tr>
                            <td class="min-w-[28rem] px-5 py-5 align-top text-sm leading-7 text-zinc-950 whitespace-normal">{{ $questionRow['question_text'] }}</td>
                            <td class="whitespace-nowrap px-5 py-5 align-top text-xs font-semibold uppercase tracking-[0.14em] text-zinc-500">{{ $questionRow['category'] }}</td>
                            <td class="whitespace-nowrap px-5 py-5 align-top text-right text-sm text-zinc-600">{{ number_format($questionRow['total_answers']) }}</td>
                            <td class="whitespace-nowrap px-5 py-5 align-top text-right text-sm font-bold text-zinc-950">{{ number_format($questionRow['average_score'], 2) }}</td>
                            <td class="whitespace-nowrap px-5 py-5 align-top text-right text-sm font-bold {{ $questionRow['total_answers'] === 0 ? 'text-zinc-500' : 'text-teal-600' }}">{{ number_format($questionRow['satisfaction_percentage'], 1) }}%</td>
                        </tr>
                    @endforeach
                </x-ui.table>
            @endif
        </section>

        <section class="min-w-0 xl:col-span-12">
            <div class="mb-4 grid gap-3 lg:grid-cols-[minmax(0,1fr)_auto] lg:items-start">
                <div>
                    <h3 class="text-sm font-bold uppercase tracking-[0.18em] text-zinc-400">Saran dan Masukan</h3>
                    <p class="mt-1 text-sm leading-6 text-zinc-500">Masukan tertulis dipisahkan dari tabel analitik agar admin bisa membaca nada respons tanpa kehilangan konteks kuantitatif di atasnya.</p>
                </div>
                <div class="flex flex-wrap items-center gap-2 lg:justify-end">
                    <x-ui.badge variant="zinc">{{ count($result['suggestions']) }} Masukan</x-ui.badge>
                </div>
            </div>

            @if(empty($result['suggestions']))
                <x-ui.empty-state title="Belum ada saran" description="Mahasiswa belum memberikan masukan tertulis pada formulir ini." />
            @else
                <div class="grid gap-4 lg:grid-cols-2 2xl:grid-cols-3">
                    @foreach ($result['suggestions'] as $suggestion)
                        <x-ui.card no-padding class="h-full overflow-hidden">
                            <div class="border-b border-zinc-100 px-5 py-4">
                                <div class="flex items-start justify-between gap-4">
                                    <div class="min-w-0">
                                        <p class="truncate text-sm font-semibold text-zinc-950">{{ $suggestion['student_name'] ?: 'Mahasiswa tanpa nama' }}</p>
                                        <p class="mt-1 text-[10px] font-bold uppercase tracking-[0.18em] text-zinc-400">Respons #{{ $suggestion['response_id'] }}</p>
                                    </div>
                                    <span class="whitespace-nowrap text-[10px] font-semibold uppercase tracking-[0.18em] text-zinc-400">{{ $suggestion['submitted_at']->translatedFormat('d M Y') }}</span>
                                </div>
                            </div>
                            <div class="px-5 py-4">
                                <p class="text-sm leading-7 text-zinc-600">{{ $suggestion['suggestion'] }}</p>
                            </div>
                        </x-ui.card>
                    @endforeach
                </div>
            @endif
        </section>
    </div>
</x-layouts.admin>
