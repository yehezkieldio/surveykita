<x-layouts.admin title="Detail Hasil Evaluasi - SurveyKita" heading="{{ $form->title }}" eyebrow="{{ $form->evaluationPeriod->name }}">
    <x-card class="mb-4">
        <form method="GET" action="{{ route('admin.results.show', $form) }}" class="flex flex-wrap gap-3">
            <select name="category_id" class="rounded-md border-zinc-300">
                <option value="">Semua kategori</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected($selectedCategoryId === $category->id)>{{ $category->name }}</option>
                @endforeach
            </select>
            <x-button type="submit">Filter</x-button>
        </form>
    </x-card>

    <div class="grid gap-3 md:grid-cols-4">
        <x-summary-card label="Total Responden" :value="$result['total_respondents']" />
        <x-summary-card label="Rata-rata Skor" :value="$result['average_score']" />
        <x-summary-card label="Persentase Kepuasan" value="{{ $result['satisfaction_percentage'] }}%" />
        <x-summary-card label="Kategori Kepuasan" :value="$result['satisfaction_category']" />
    </div>

    @if ($result['is_empty'])
        <x-empty-state class="mt-4" title="Belum Ada Respon" description="Rincian tetap ditampilkan dengan nilai nol agar laporan aman dibuka." />
    @endif

    <div class="mt-4 grid gap-4 xl:grid-cols-2">
        <x-card heading="Rekap Kategori">
            <table class="w-full text-left text-sm">
                <thead class="border-b text-zinc-600"><tr><th class="py-2">Kategori</th><th>Jawaban</th><th>Rata-rata</th><th>Kepuasan</th></tr></thead>
                <tbody class="divide-y">@foreach ($result['average_score_per_category'] as $row)<tr><td class="py-2">{{ $row['category'] }}</td><td>{{ $row['total_answers'] }}</td><td>{{ $row['average_score'] }}</td><td>{{ $row['satisfaction_category'] }}</td></tr>@endforeach</tbody>
            </table>
        </x-card>

        <x-card heading="Distribusi Likert">
            <div class="grid grid-cols-5 gap-2 text-center text-sm">
                @foreach ($result['likert_distribution'] as $score => $count)
                    <div class="rounded-md border border-zinc-200 p-3"><p class="font-semibold">{{ $score }}</p><p>{{ $count }}</p></div>
                @endforeach
            </div>
        </x-card>
    </div>

    <x-card class="mt-4" heading="Rekap Pertanyaan">
        <table class="w-full text-left text-sm">
            <thead class="border-b text-zinc-600"><tr><th class="py-2">Pertanyaan</th><th>Kategori</th><th>Jawaban</th><th>Rata-rata</th><th>Kepuasan</th></tr></thead>
            <tbody class="divide-y">@foreach ($result['average_score_per_question'] as $row)<tr><td class="py-2">{{ $row['question_text'] }}</td><td>{{ $row['category'] }}</td><td>{{ $row['total_answers'] }}</td><td>{{ $row['average_score'] }}</td><td>{{ $row['satisfaction_category'] }}</td></tr>@endforeach</tbody>
        </table>
    </x-card>

    <x-card class="mt-4" heading="Saran Mahasiswa">
        @forelse ($result['suggestions'] as $suggestion)
            <div class="border-b border-zinc-100 py-3 text-sm last:border-b-0">
                <p class="font-medium text-zinc-950">{{ $suggestion['student_name'] }}</p>
                <p class="text-zinc-700">{{ $suggestion['suggestion'] }}</p>
            </div>
        @empty
            <p class="text-sm text-zinc-500">Belum ada saran mahasiswa.</p>
        @endforelse
    </x-card>
</x-layouts.admin>
