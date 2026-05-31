<x-layouts.student title="Evaluasi Aktif - SurveyKita" heading="Evaluasi Aktif" eyebrow="Daftar Kuesioner Akademik">
    <div class="grid gap-5">
        @forelse ($forms as $form)
            <article class="grid border border-zinc-200 bg-white lg:grid-cols-[minmax(0,1fr)_16rem]">
                <div class="p-6">
                    <div class="flex flex-wrap items-center gap-3">
                        <x-badge :variant="$form->submitted ? 'success' : 'neutral'">{{ $form->submitted ? 'Sudah Dikirim' : 'Belum Diisi' }}</x-badge>
                        <span class="text-sm text-zinc-500">{{ $form->evaluationPeriod->name }}</span>
                    </div>
                    <h2 class="mt-5 font-display text-3xl font-semibold leading-none tracking-[-0.06em] text-zinc-950">{{ $form->title }}</h2>
                    <p class="mt-4 max-w-3xl text-sm leading-6 text-zinc-600">{{ $form->description ?: 'Evaluasi kepuasan layanan akademik Universitas Mulia.' }}</p>
                </div>
                <div class="border-t border-zinc-200 bg-zinc-50 p-6 lg:border-l lg:border-t-0">
                    <p class="text-xs font-medium text-zinc-500">Kategori</p>
                    <p class="mt-2 text-sm font-semibold text-zinc-950">{{ ucwords(str_replace('_', ' ', $form->target_type)) }}</p>
                    <div class="mt-6 grid gap-2">
                        @if ($form->submitted)
                            <x-button variant="secondary" :href="route('student.evaluations.show', $form)">Lihat Detail</x-button>
                        @else
                            <x-button :href="route('student.evaluations.fill', $form)">Isi Sekarang</x-button>
                            <x-button variant="secondary" :href="route('student.evaluations.show', $form)">Pratinjau</x-button>
                        @endif
                    </div>
                </div>
            </article>
        @empty
            <x-empty-state title="Belum ada kuesioner aktif" description="Form evaluasi yang aktif pada periode berjalan akan tampil di halaman ini." />
        @endforelse
    </div>
</x-layouts.student>
