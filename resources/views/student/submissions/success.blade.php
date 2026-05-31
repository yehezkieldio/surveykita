<x-layouts.student title="Evaluasi Terkirim - SurveyKita" heading="Evaluasi Terkirim" eyebrow="Respons Sukses Diterima">
    <x-card heading="Terima Kasih atas Partisipasi Anda" subheading="Respons kuesioner Anda telah resmi tercatat di dalam sistem akademik.">
        <div class="mt-4 border-t border-zinc-100 pt-6">
            <div class="grid gap-6 sm:grid-cols-2 md:grid-cols-3">
                <div>
                    <p class="font-mono text-[10px] uppercase tracking-wider text-zinc-400">Judul Kuesioner</p>
                    <p class="mt-1.5 text-sm font-bold text-zinc-900">{{ $response->evaluationForm->title }}</p>
                </div>
                <div>
                    <p class="font-mono text-[10px] uppercase tracking-wider text-zinc-400">Periode Evaluasi</p>
                    <p class="mt-1.5 text-sm font-bold text-zinc-900">{{ $response->evaluationForm->evaluationPeriod->name }}</p>
                </div>
                <div>
                    <p class="font-mono text-[10px] uppercase tracking-wider text-zinc-400">Tanggal Pengiriman</p>
                    <p class="mt-1.5 text-sm font-bold text-zinc-900 font-mono">{{ $response->submitted_at->format('d M Y H:i') }} WIB</p>
                </div>
            </div>

            <p class="mt-8 text-xs text-zinc-500 leading-relaxed max-w-xl">
                Suara dan evaluasi Anda sangat berharga bagi peningkatan mutu layanan akademik dan fasilitas pembelajaran di Universitas Mulia. Seluruh data identitas Anda dilindungi dan dianonimkan untuk menjaga objektivitas hasil penilaian.
            </p>
        </div>

        <div class="mt-8 flex gap-4 border-t border-zinc-100 pt-6">
            <x-button :href="route('student.evaluations.index')" class="!min-h-9 !py-1 text-xs">Isi Evaluasi Lain</x-button>
            <x-button variant="secondary" :href="route('student.submissions.index')" class="!min-h-9 !py-1 text-xs">Lihat Riwayat</x-button>
        </div>
    </x-card>
</x-layouts.student>
