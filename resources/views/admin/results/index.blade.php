<x-layouts.admin heading="Hasil Evaluasi" eyebrow="Laporan & Statistik">
    {{-- 1. Filter Panel --}}
    <x-ui.card class="mb-8 border-zinc-200 bg-zinc-50/50">
        <form action="{{ route('admin.results.index') }}" method="GET" class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4 lg:items-end">
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

            <div class="flex items-center gap-3">
                <x-ui.button variant="teal" class="flex-1">Terapkan Filter</x-ui.button>
                <a href="{{ route('admin.results.index') }}" class="text-xs font-semibold text-zinc-500 hover:text-zinc-950 transition-colors">Reset</a>
            </div>
        </form>
    </x-ui.card>

    @if($rows->isEmpty())
        <x-ui.empty-state title="Belum ada data evaluasi" description="Data hasil evaluasi akan muncul di sini setelah ada respons masuk pada periode aktif." />
    @else
        {{-- 3. Chart Section --}}
        <div class="grid gap-8 lg:grid-cols-2 mb-12">
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

        {{-- 2. Summary Table --}}
        <section>
            <div class="mb-6 flex items-center justify-between">
                <h3 class="text-sm font-bold uppercase tracking-[0.2em] text-zinc-400">Ringkasan Hasil per Form</h3>
                <x-ui.badge variant="zinc">{{ count($rows) }} Form</x-ui.badge>
            </div>

            <x-ui.table :headers="['Instrumen Evaluasi', 'Responden', 'Rata-rata Skor', 'Kepuasan', 'Kategori', 'Aksi']">
                @foreach ($rows as $row)
                    @php
                        $form = $row['form'];
                        $result = $row['result'];
                    @endphp
                    <tr class="hover:bg-zinc-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="text-sm font-bold text-zinc-950">{{ $form->title }}</div>
                            <div class="text-[10px] text-zinc-400 uppercase tracking-tighter">{{ $form->evaluationPeriod->name }}</div>
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm font-semibold text-zinc-950">
                            {{ number_format($result['total_respondents']) }}
                            <span class="text-[10px] font-normal text-zinc-400">mhs</span>
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm font-bold text-zinc-950">
                            {{ number_format($result['average_score'], 2) }}
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm font-bold text-teal-600">
                            {{ number_format($result['satisfaction_percentage'], 1) }}%
                        </td>
                        <td class="whitespace-nowrap px-6 py-4">
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
                        <td class="whitespace-nowrap px-6 py-4 text-right">
                            <x-ui.button href="{{ route('admin.results.show', $form) }}" variant="ghost" size="sm">
                                Detail Laporan
                            </x-ui.button>
                        </td>
                    </tr>
                @endforeach
            </x-ui.table>
        </section>
    @endif
</x-layouts.admin>
