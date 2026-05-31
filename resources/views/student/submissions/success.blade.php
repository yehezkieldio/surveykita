<x-layouts.student title="Evaluasi Terkirim - SurveyKita" heading="Evaluasi Terkirim">
    <x-card heading="Terima kasih" subheading="{{ $response->evaluationForm->title }}">
        <p class="text-sm text-zinc-700">Evaluasi untuk periode {{ $response->evaluationForm->evaluationPeriod->name }} berhasil dikirim pada {{ $response->submitted_at->format('d/m/Y H:i') }}.</p>
        <div class="mt-4 flex gap-2">
            <x-button :href="route('student.evaluations.index')">Evaluasi Aktif</x-button>
            <x-button variant="secondary" :href="route('student.submissions.index')">Riwayat</x-button>
        </div>
    </x-card>
</x-layouts.student>
