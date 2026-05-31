<x-layouts.student title="Evaluasi Aktif - SurveyKita" heading="Evaluasi Aktif" eyebrow="Daftar Kuesioner Akademik">
    <div class="grid gap-6 md:grid-cols-2">
        @forelse ($forms as $form)
            <x-card heading="{{ $form->title }}" subheading="Periode: {{ $form->evaluationPeriod->name }} &bull; Kategori: {{ ucwords(str_replace('_', ' ', $form->target_type)) }}">
                <p class="text-xs text-zinc-500 leading-relaxed mt-2 line-clamp-2 min-h-8">{{ $form->description ?: 'Evaluasi kepuasan layanan akademik Universitas Mulia.' }}</p>
                <div class="mt-6 flex items-center gap-3">
                    @if ($form->submitted)
                        <x-badge variant="success">Sudah Dikirim</x-badge>
                        <x-button variant="secondary" :href="route('student.evaluations.show', $form)" class="!min-h-9 !py-1 text-xs">Lihat Detail</x-button>
                    @else
                        <x-button :href="route('student.evaluations.fill', $form)" class="!min-h-9 !py-1 text-xs">Mulai Isi</x-button>
                        <x-button variant="secondary" :href="route('student.evaluations.show', $form)" class="!min-h-9 !py-1 text-xs">Detail</x-button>
                    @endif
                </div>
            </x-card>
        @empty
            <div class="col-span-2">
                <x-empty-state
                    title="Belum ada kuesioner aktif"
                    description="Form evaluasi yang aktif pada periode berjalan akan tampil di halaman ini."
                />
            </div>
        @endforelse
    </div>
</x-layouts.student>
