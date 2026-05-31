<x-layouts.student title="Evaluasi Aktif - SurveyKita" heading="Evaluasi Aktif">
    <div class="grid gap-4 md:grid-cols-2">
        @forelse ($forms as $form)
            <x-card heading="{{ $form->title }}" subheading="{{ $form->evaluationPeriod->name }}">
                <p class="text-sm text-zinc-600">{{ $form->description }}</p>
                <div class="mt-4 flex items-center gap-2">
                    @if ($form->submitted)
                        <x-badge>Sudah dikirim</x-badge>
                        <x-button variant="secondary" :href="route('student.evaluations.show', $form)">Detail</x-button>
                    @else
                        <x-button :href="route('student.evaluations.fill', $form)">Isi Evaluasi</x-button>
                        <x-button variant="secondary" :href="route('student.evaluations.show', $form)">Detail</x-button>
                    @endif
                </div>
            </x-card>
        @empty
            <x-empty-state
                title="Belum ada evaluasi aktif"
                description="Form evaluasi yang aktif pada periode berjalan akan tampil di halaman ini."
            />
        @endforelse
    </div>
</x-layouts.student>
