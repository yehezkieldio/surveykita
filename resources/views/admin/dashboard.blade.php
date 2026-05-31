<x-layouts.admin title="Dashboard Admin - SurveyKita" heading="Dashboard Admin">
    <div class="grid gap-px border border-zinc-200 bg-zinc-200 md:grid-cols-2 xl:grid-cols-4">
        <x-summary-card label="Mahasiswa Terdaftar" value="{{ $studentCount }}" description="Total profil mahasiswa dalam sistem." class="border-0" />
        <x-summary-card label="Periode Aktif" value="{{ $activePeriodCount }}" description="Periode evaluasi yang sedang berjalan." class="border-0" />
        <x-summary-card label="Form Aktif" value="{{ $activeFormCount }}" description="Formulir yang dapat diisi mahasiswa." class="border-0" />
        <x-summary-card label="Total Respons" value="{{ $responseCount }}" description="Form evaluasi yang sudah dikirim." class="border-0" />
    </div>

    <x-card class="mt-8" heading="Instrumen Pertanyaan" subheading="Jumlah butir pertanyaan evaluasi berdasarkan kategori.">
        <div class="flex flex-col gap-6 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="font-display text-6xl font-semibold leading-none tracking-[-0.07em] text-zinc-950">{{ $questionCount }}</p>
                <p class="mt-3 text-sm leading-6 text-zinc-600">Pertanyaan Likert terdaftar.</p>
            </div>
            <x-button href="{{ route('admin.questions.index') }}" variant="secondary">Kelola Pertanyaan</x-button>
        </div>
    </x-card>
</x-layouts.admin>
