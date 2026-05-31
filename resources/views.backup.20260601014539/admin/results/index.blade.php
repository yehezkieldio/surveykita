<x-layouts.admin title="Hasil Evaluasi - SurveyKita" heading="Hasil Evaluasi" eyebrow="Rekap Akademik">
    <x-card class="mb-6" heading="Filter Laporan" subheading="Saring hasil evaluasi berdasarkan periode, form, dan kategori pertanyaan.">
        <form method="GET" action="{{ route('admin.results.index') }}" class="grid gap-4 sm:grid-cols-4 mt-2">
            <select name="period_id" class="block w-full text-xs">
                <option value="">Semua periode</option>
                @foreach ($periods as $period)
                    <option value="{{ $period->id }}" @selected($selectedPeriodId === $period->id)>{{ $period->name }}</option>
                @endforeach
            </select>
            <select name="form_id" class="block w-full text-xs">
                <option value="">Semua form</option>
                @foreach ($allForms as $form)
                    <option value="{{ $form->id }}" @selected($selectedFormId === $form->id)>{{ $form->title }}</option>
                @endforeach
            </select>
            <select name="category_id" class="block w-full text-xs">
                <option value="">Semua kategori</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected($selectedCategoryId === $category->id)>{{ $category->name }}</option>
                @endforeach
            </select>
            <x-button type="submit" class="!min-h-9 !py-1 text-xs">Saring Data</x-button>
        </form>
    </x-card>

    @if ($rows->isNotEmpty())
        <div class="mb-6 grid gap-6 xl:grid-cols-2">
            <x-chart-panel heading="Persentase Kepuasan per Form" :chart="$charts['overall_satisfaction']" />
            <x-chart-panel heading="Jumlah Responden per Form" :chart="$charts['respondent_count']" />
        </div>
    @endif

    <div class="grid gap-6">
        @forelse ($rows as $row)
            <x-card heading="{{ $row['form']->title }}" subheading="Periode: {{ $row['form']->evaluationPeriod->name }} &bull; Target Responden: {{ ucwords(str_replace('_', ' ', $row['form']->target_type)) }}">
                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4 mt-2">
                    <x-summary-card label="Total Responden" :value="$row['result']['total_respondents']" />
                    <x-summary-card label="Rata-rata Skor" :value="$row['result']['average_score']" />
                    <x-summary-card label="Tingkat Kepuasan" value="{{ $row['result']['satisfaction_percentage'] }}%" />
                    <x-summary-card label="Kategori Mutu" :value="$row['result']['satisfaction_category']" />
                </div>
                <div class="mt-6 flex justify-start">
                    <x-button :href="route('admin.results.show', $row['form'])" class="!min-h-9 !py-1 text-xs">Detail Analisis & Cetak</x-button>
                </div>
            </x-card>
        @empty
            <x-empty-state
                title="Belum ada hasil evaluasi"
                description="Ringkasan hasil akan tampil setelah form, pertanyaan, dan respons evaluasi tersedia."
            />
        @endforelse
    </div>

    @if ($rows->isNotEmpty())
        @push('scripts')
            @apexchartsScripts
            @foreach ($charts as $chart)
                {!! $chart->script() !!}
            @endforeach
        @endpush
    @endif
</x-layouts.admin>
