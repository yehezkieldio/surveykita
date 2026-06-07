<x-layouts.student heading="Evaluasi Terkirim" eyebrow="Berhasil">
    <div class="flex flex-col items-center justify-center py-12 text-center">
        <div class="flex h-20 w-20 items-center justify-center rounded-full bg-teal-50 text-teal-600">
            <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        
        <h2 class="mt-8 font-display text-3xl font-bold tracking-tight text-zinc-950">Terima Kasih!</h2>
        <p class="mt-4 text-base text-zinc-600 max-w-md">
            Kontribusi Anda sangat berharga bagi kami. Evaluasi Anda telah berhasil disimpan dalam sistem.
        </p>

        <div class="mt-12 w-full max-w-lg">
            <x-ui.card class="text-left">
                <div class="space-y-4">
                    <div class="flex items-center justify-between py-2 border-b border-zinc-100">
                        <span class="text-xs font-medium text-zinc-500 uppercase tracking-wider">Formulir</span>
                        <span class="text-sm font-semibold text-zinc-950">{{ $response->evaluationForm->title }}</span>
                    </div>
                    <div class="flex items-center justify-between py-2 border-b border-zinc-100">
                        <span class="text-xs font-medium text-zinc-500 uppercase tracking-wider">Periode</span>
                        <span class="text-sm text-zinc-950">{{ $response->evaluationForm->evaluationPeriod->name }}</span>
                    </div>
                    <div class="flex items-center justify-between py-2">
                        <span class="text-xs font-medium text-zinc-500 uppercase tracking-wider">Waktu Kirim</span>
                        <span class="text-sm text-zinc-950">{{ $response->submitted_at->translatedFormat('d F Y, H:i') }}</span>
                    </div>
                </div>
            </x-ui.card>
        </div>

        <div class="mt-12 flex flex-col sm:flex-row items-center gap-4">
            <x-ui.button href="{{ route('student.evaluations.index') }}" variant="teal" class="w-full sm:w-auto px-8">
                Isi Evaluasi Lain
            </x-ui.button>
            <x-ui.button href="{{ route('student.submissions.index') }}" variant="secondary" class="w-full sm:w-auto">
                Lihat Riwayat Saya
            </x-ui.button>
        </div>
    </div>
</x-layouts.student>
