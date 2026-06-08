<x-layouts.student heading="Evaluasi Aktif" eyebrow="Daftar Formulir">
    @if ($forms->isEmpty())
        <x-ui.empty-state 
            title="Tidak ada evaluasi aktif" 
            description="Saat ini belum ada formulir evaluasi yang perlu Anda isi. Silakan periksa kembali nanti."
        />
    @else
        <div class="grid gap-6">
            @foreach ($forms as $form)
                <x-ui.card class="group p-5 transition-all hover:border-zinc-300 sm:p-6">
                    <div class="flex flex-col gap-5 sm:flex-row sm:items-start sm:justify-between sm:gap-6">
                        <div class="flex-1">
                            <div class="mb-3 flex flex-col gap-2 sm:flex-row sm:items-center sm:gap-3">
                                <x-ui.badge :variant="$form->submitted ? 'zinc' : 'teal'">
                                    {{ $form->submitted ? 'Sudah dikirim' : 'Belum diisi' }}
                                </x-ui.badge>
                                <span class="text-xs font-medium text-zinc-400">Periode: {{ $form->evaluationPeriod->name }}</span>
                            </div>
                            <h3 class="text-lg font-bold tracking-tight text-zinc-950 transition-colors group-hover:text-teal-600 sm:text-xl">
                                {{ $form->title }}
                            </h3>
                            <p class="mt-2 max-w-2xl text-sm leading-relaxed text-zinc-600">
                                {{ $form->description }}
                            </p>
                        </div>
                        <div class="flex flex-col gap-3 sm:shrink-0 sm:items-end">
                            @if ($form->submitted)
                                <x-ui.button href="{{ route('student.evaluations.show', $form) }}" variant="secondary" class="w-full sm:w-auto">
                                    Lihat Detail
                                </x-ui.button>
                            @else
                                <x-ui.button href="{{ route('student.evaluations.fill', $form) }}" variant="teal" class="w-full sm:w-auto">
                                    Isi Evaluasi
                                </x-ui.button>
                                <x-ui.button href="{{ route('student.evaluations.show', $form) }}" variant="ghost" size="sm" class="w-full sm:w-auto">
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
