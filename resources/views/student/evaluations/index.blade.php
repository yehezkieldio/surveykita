<x-layouts.student heading="Evaluasi Aktif" eyebrow="Daftar Formulir">
    @if ($forms->isEmpty())
        <x-ui.empty-state 
            title="Tidak ada evaluasi aktif" 
            description="Saat ini belum ada formulir evaluasi yang perlu Anda isi. Silakan periksa kembali nanti."
        />
    @else
        <div class="grid gap-6">
            @foreach ($forms as $form)
                <x-ui.card class="group transition-all hover:border-zinc-300">
                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-6">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-3">
                                <x-ui.badge :variant="$form->submitted ? 'zinc' : 'teal'">
                                    {{ $form->submitted ? 'Sudah dikirim' : 'Belum diisi' }}
                                </x-ui.badge>
                                <span class="text-xs font-medium text-zinc-400">Periode: {{ $form->evaluationPeriod->name }}</span>
                            </div>
                            <h3 class="text-xl font-bold tracking-tight text-zinc-950 group-hover:text-teal-600 transition-colors">
                                {{ $form->title }}
                            </h3>
                            <p class="mt-2 text-sm leading-relaxed text-zinc-600 max-w-2xl">
                                {{ $form->description }}
                            </p>
                        </div>
                        <div class="flex flex-col sm:items-end gap-3 sm:shrink-0">
                            @if ($form->submitted)
                                <x-ui.button href="{{ route('student.evaluations.show', $form) }}" variant="secondary">
                                    Lihat Detail
                                </x-ui.button>
                            @else
                                <x-ui.button href="{{ route('student.evaluations.fill', $form) }}" variant="teal">
                                    Isi Evaluasi
                                </x-ui.button>
                                <x-ui.button href="{{ route('student.evaluations.show', $form) }}" variant="ghost" size="sm">
                                    Detail Form
                                </x-ui.button>
                            @endif
                        </div>
                    </div>
                </x-ui.card>
            @endforeach
        </div>
    @endif
</x-layouts.student>
