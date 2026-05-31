<x-layouts.student title="Evaluasi Terkirim - SurveyKita" heading="Evaluasi Terkirim" eyebrow="Respons diterima">
    <section class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_20rem]">
        <div class="border border-zinc-200 bg-white p-6 sm:p-8">
            <x-badge variant="success">Terkirim</x-badge>
            <h2 class="mt-5 font-display text-5xl font-semibold leading-none tracking-[-0.07em] text-zinc-950">Terima kasih.</h2>
            <p class="mt-5 max-w-2xl text-sm leading-6 text-zinc-600">Respons Anda tercatat untuk peningkatan mutu layanan akademik dan fasilitas pembelajaran di Universitas Mulia.</p>
            <div class="sk-actions mt-8"><x-button :href="route('student.evaluations.index')">Isi Evaluasi Lain</x-button><x-button variant="secondary" :href="route('student.submissions.index')">Lihat Riwayat</x-button></div>
        </div>
        <div class="grid gap-px border border-zinc-200 bg-zinc-200">
            <div class="bg-white p-5"><p class="text-xs font-medium text-zinc-500">Judul Kuesioner</p><p class="mt-2 text-sm font-semibold leading-6">{{ $response->evaluationForm->title }}</p></div>
            <div class="bg-white p-5"><p class="text-xs font-medium text-zinc-500">Periode Evaluasi</p><p class="mt-2 text-sm font-semibold leading-6">{{ $response->evaluationForm->evaluationPeriod->name }}</p></div>
            <div class="bg-white p-5"><p class="text-xs font-medium text-zinc-500">Tanggal Pengiriman</p><p class="mt-2 font-mono text-sm text-zinc-700">{{ $response->submitted_at->format('d M Y H:i') }} WIB</p></div>
        </div>
    </section>
</x-layouts.student>
