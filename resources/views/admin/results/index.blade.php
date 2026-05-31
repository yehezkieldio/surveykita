<x-layouts.admin title="Hasil Evaluasi - SurveyKita" heading="Hasil Evaluasi" eyebrow="Rekap Akademik">
    <x-card class="mb-4">
        <form method="GET" action="{{ route('admin.results.index') }}" class="grid gap-3 md:grid-cols-4">
            <select name="period_id" class="rounded-md border-zinc-300">
                <option value="">Semua periode</option>
                @foreach ($periods as $period)
                    <option value="{{ $period->id }}" @selected($selectedPeriodId === $period->id)>{{ $period->name }}</option>
                @endforeach
            </select>
            <select name="form_id" class="rounded-md border-zinc-300">
                <option value="">Semua form</option>
                @foreach ($allForms as $form)
                    <option value="{{ $form->id }}" @selected($selectedFormId === $form->id)>{{ $form->title }}</option>
                @endforeach
            </select>
            <select name="category_id" class="rounded-md border-zinc-300">
                <option value="">Semua kategori</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected($selectedCategoryId === $category->id)>{{ $category->name }}</option>
                @endforeach
            </select>
            <x-button type="submit">Filter</x-button>
        </form>
    </x-card>

    @if ($rows->isNotEmpty())
        <div class="mb-4 grid gap-4 xl:grid-cols-2">
            <x-chart-panel heading="Persentase Kepuasan per Form" :chart="$charts['overall_satisfaction']" />
            <x-chart-panel heading="Jumlah Responden per Form" :chart="$charts['respondent_count']" />
        </div>
    @endif

    <div class="grid gap-4">
        @forelse ($rows as $row)
            <x-card heading="{{ $row['form']->title }}" subheading="{{ $row['form']->evaluationPeriod->name }}">
                <div class="grid gap-3 md:grid-cols-4">
                    <x-summary-card label="Responden" :value="$row['result']['total_respondents']" />
                    <x-summary-card label="Rata-rata" :value="$row['result']['average_score']" />
                    <x-summary-card label="Persentase" value="{{ $row['result']['satisfaction_percentage'] }}%" />
                    <x-summary-card label="Kategori" :value="$row['result']['satisfaction_category']" />
                </div>
                <div class="mt-4">
                    <x-button :href="route('admin.results.show', $row['form'])">Detail Hasil</x-button>
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
