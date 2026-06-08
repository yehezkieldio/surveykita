<x-layouts.admin heading="Hasil Evaluasi" eyebrow="Laporan & Statistik">
    <x-ui.card class="mb-8 border-zinc-200 bg-zinc-50/50 p-5 sm:p-6">
        <form action="{{ route('admin.results.index') }}" method="GET" class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4 lg:items-end">
            <div class="space-y-1.5">
                <label for="period_id" class="text-[10px] font-bold uppercase tracking-widest text-zinc-500">Periode</label>
                <select id="period_id" name="period_id" class="w-full">
                    <option value="">Semua Periode</option>
                    @foreach($periods as $period)
                        <option value="{{ $period->id }}" @selected($selectedPeriodId == $period->id)>
                            {{ $period->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="space-y-1.5">
                <label for="form_id" class="text-[10px] font-bold uppercase tracking-widest text-zinc-500">Formulir</label>
                <select id="form_id" name="form_id" class="w-full">
                    <option value="">Semua Formulir</option>
                    @foreach($allForms as $form)
                        <option value="{{ $form->id }}" @selected($selectedFormId == $form->id)>
                            {{ $form->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="space-y-1.5">
                <label for="category_id" class="text-[10px] font-bold uppercase tracking-widest text-zinc-500">Kategori Soal</label>
                <select id="category_id" name="category_id" class="w-full">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" @selected($selectedCategoryId == $category->id)>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                <x-ui.button variant="teal" class="w-full sm:flex-1">Terapkan Filter</x-ui.button>
                <a href="{{ route('admin.results.index') }}" class="text-xs font-semibold text-zinc-500 hover:text-zinc-950 transition-colors">Reset</a>
            </div>
        </form>
    </x-ui.card>

    @if($rows->isEmpty())
        <x-ui.empty-state title="Belum ada data evaluasi" description="Data hasil evaluasi akan muncul di sini setelah ada respons masuk pada periode aktif." />
    @else
        <div class="mb-12 grid gap-6 lg:grid-cols-2 lg:gap-8">
            <x-ui.chart-panel 
                heading="Kepuasan Keseluruhan" 
                description="Persentase kepuasan rata-rata untuk setiap instrumen evaluasi."
                :chart="$charts['overall_satisfaction']" 
            />
            <x-ui.chart-panel 
                heading="Partisipasi Responden" 
                description="Jumlah mahasiswa yang telah mengisi setiap instrumen evaluasi."
                :chart="$charts['respondent_count']" 
            />
        </div>

        <section>
            <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <h3 class="text-sm font-bold uppercase tracking-[0.2em] text-zinc-400">Ringkasan Hasil per Form</h3>
                <x-ui.badge variant="zinc">{{ count($rows) }} Form</x-ui.badge>
            </div>

            <div class="space-y-4 md:hidden">
                @foreach ($rows as $row)
                    @php
                        $form = $row['form'];
                        $result = $row['result'];
                        $badgeVariant = $result['is_empty']
                            ? 'zinc'
                            : match(true) {
                                $result['satisfaction_percentage'] >= 80 => 'teal',
                                $result['satisfaction_percentage'] >= 60 => 'yellow',
                                default => 'red',
                            };
                    @endphp
                    <x-ui.card class="p-5">
                        <div class="space-y-4">
                            <div>
                                <p class="text-sm font-bold text-zinc-950">{{ $form->title }}</p>
                                <p class="mt-1 text-[10px] uppercase tracking-tighter text-zinc-400">{{ $form->evaluationPeriod->name }}</p>
                            </div>
                            <div class="grid grid-cols-2 gap-3 border-t border-zinc-100 pt-4">
                                <div>
                                    <p class="text-[10px] font-bold uppercase tracking-[0.16em] text-zinc-400">Responden</p>
                                    <p class="mt-1 text-sm font-semibold text-zinc-950">{{ number_format($result['total_respondents']) }}</p>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold uppercase tracking-[0.16em] text-zinc-400">Rata-rata</p>
                                    <p class="mt-1 text-sm font-bold text-zinc-950">{{ number_format($result['average_score'], 2) }}</p>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold uppercase tracking-[0.16em] text-zinc-400">Kepuasan</p>
                                    <p class="mt-1 text-sm font-bold text-teal-600">{{ number_format($result['satisfaction_percentage'], 1) }}%</p>
                                </div>
                                <div class="flex items-end">
                                    <x-ui.badge :variant="$badgeVariant">{{ $result['satisfaction_category'] }}</x-ui.badge>
                                </div>
                            </div>
                            <div class="flex flex-col gap-2 border-t border-zinc-100 pt-4">
                                <x-ui.button href="{{ route('admin.results.show', $form) }}" variant="secondary" size="sm" class="w-full">
                                    Detail
                                </x-ui.button>
                                <div class="grid grid-cols-2 gap-2">
                                    <x-ui.button href="{{ route('admin.results.export.excel', $form) }}" variant="ghost" size="sm" class="w-full">
                                        Excel
                                    </x-ui.button>
                                    <x-ui.button href="{{ route('admin.results.export.pdf', $form) }}" variant="ghost" size="sm" class="w-full">
                                        PDF
                                    </x-ui.button>
                                </div>
                            </div>
                        </div>
                    </x-ui.card>
                @endforeach
            </div>

            <div class="hidden md:block">
                <x-ui.table :headers="['Instrumen Evaluasi', 'Responden', 'Rata-rata Skor', 'Kepuasan', 'Kategori', 'Aksi']">
                    @foreach ($rows as $row)
                        @php
                            $form = $row['form'];
                            $result = $row['result'];
                        @endphp
                        <tr class="transition-colors hover:bg-zinc-50/50">
                            <td class="min-w-[200px] whitespace-normal px-4 py-4">
                                <div class="text-sm font-bold text-zinc-950">{{ $form->title }}</div>
                                <div class="text-[10px] uppercase tracking-tighter text-zinc-400">{{ $form->evaluationPeriod->name }}</div>
                            </td>
                            <td class="whitespace-nowrap px-4 py-4 text-right text-sm font-semibold text-zinc-950">
                                {{ number_format($result['total_respondents']) }}
                                <span class="text-[10px] font-normal text-zinc-400">mhs</span>
                            </td>
                            <td class="whitespace-nowrap px-4 py-4 text-right text-sm font-bold text-zinc-950">
                                {{ number_format($result['average_score'], 2) }}
                            </td>
                            <td class="whitespace-nowrap px-4 py-4 text-right text-sm font-bold text-teal-600">
                                {{ number_format($result['satisfaction_percentage'], 1) }}%
                            </td>
                            <td class="whitespace-nowrap px-4 py-4">
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
                                    <x-ui.badge :variant="$badgeVariant">{{ $result['satisfaction_category'] }}</x-ui.badge>
                                @endif
                            </td>
                            <td class="whitespace-nowrap px-4 py-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <x-ui.button href="{{ route('admin.results.export.excel', $form) }}" variant="ghost" size="sm">
                                        <svg class="h-4 w-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m.75 12l3 3m0 0l3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                        </svg>
                                    </x-ui.button>
                                    <x-ui.button href="{{ route('admin.results.export.pdf', $form) }}" variant="ghost" size="sm">
                                        <svg class="h-4 w-4 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                        </svg>
                                    </x-ui.button>
                                    <x-ui.button href="{{ route('admin.results.show', $form) }}" variant="secondary" size="sm">
                                        Detail
                                    </x-ui.button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </x-ui.table>
            </div>
        </section>
    @endif
</x-layouts.admin>
