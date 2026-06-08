<x-layouts.student heading="Evaluasi Terkirim" eyebrow="Berhasil">
    <div class="flex flex-col items-center justify-center py-10 text-center sm:py-12">
        <div class="flex h-16 w-16 items-center justify-center rounded-full bg-teal-50 text-teal-600 sm:h-20 sm:w-20">
            <svg class="h-8 w-8 sm:h-10 sm:w-10" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        
        <h2 class="mt-6 font-display text-2xl font-bold tracking-tight text-zinc-950 sm:mt-8 sm:text-3xl">Terima Kasih!</h2>
        <p class="mt-3 max-w-md text-sm text-zinc-600 sm:mt-4 sm:text-base">
            Kontribusi Anda sangat berharga bagi kami. Evaluasi Anda telah berhasil disimpan dalam sistem.
        </p>

        <div class="mt-10 w-full max-w-lg sm:mt-12">
            <x-ui.card class="p-5 text-left sm:p-6">
                <div class="space-y-4">
                    <div class="flex items-start justify-between gap-4 border-b border-zinc-100 py-2">
                        <span class="text-xs font-medium uppercase tracking-wider text-zinc-500">Formulir</span>
                        <span class="text-right text-sm font-semibold text-zinc-950">{{ $response->evaluationForm->title }}</span>
                    </div>
                    <div class="flex items-start justify-between gap-4 border-b border-zinc-100 py-2">
                        <span class="text-xs font-medium uppercase tracking-wider text-zinc-500">Periode</span>
                        <span class="text-right text-sm text-zinc-950">{{ $response->evaluationForm->evaluationPeriod->name }}</span>
                    </div>
                    <div class="flex items-start justify-between gap-4 py-2">
                        <span class="text-xs font-medium uppercase tracking-wider text-zinc-500">Waktu Kirim</span>
                        <span class="text-right text-sm text-zinc-950">{{ $response->submitted_at->translatedFormat('d F Y, H:i') }}</span>
                    </div>
                </div>
            </x-ui.card>
        </div>

        <div class="mt-10 flex w-full max-w-lg flex-col gap-3 sm:mt-12 sm:flex-row sm:items-center sm:gap-4">
            <x-ui.button href="{{ route('student.evaluations.index') }}" variant="teal" class="w-full px-8 sm:w-auto">
                Isi Evaluasi Lain
            </x-ui.button>
            <x-ui.button href="{{ route('student.submissions.index') }}" variant="secondary" class="w-full sm:w-auto">
                Lihat Riwayat Saya
            </x-ui.button>
        </div>
    </div>
</x-layouts.student>
