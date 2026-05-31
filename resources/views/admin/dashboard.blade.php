<x-layouts.admin title="Dashboard Admin - SurveyKita" heading="Dashboard Admin">
    <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
        <x-summary-card label="Mahasiswa Terdaftar" value="{{ $studentCount }}" description="Total profil mahasiswa dalam sistem." />
        <x-summary-card label="Periode Aktif" value="{{ $activePeriodCount }}" description="Jumlah periode evaluasi berjalan." />
        <x-summary-card label="Form Evaluasi Aktif" value="{{ $activeFormCount }}" description="Formulir evaluasi yang dapat diisi." />
        <x-summary-card label="Total Respons" value="{{ $responseCount }}" description="Form evaluasi yang telah disubmit." />
    </div>

    <div class="mt-6">
        <x-card heading="Instrumen Pertanyaan" subheading="Jumlah instrumen pertanyaan evaluasi berdasarkan kategori.">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <p class="text-4xl font-extrabold tracking-tight text-zinc-900 leading-none">{{ $questionCount }}</p>
                    <p class="mt-2 text-xs font-mono uppercase tracking-wider text-zinc-400">Pertanyaan Likert Terdaftar</p>
                </div>
                <div>
                    <x-button href="{{ route('admin.questions.index') }}" variant="secondary" class="!py-1.5 !px-3 text-xs">Keluar Kelola Pertanyaan</x-button>
                </div>
            </div>
        </x-card>
    </div>
</x-layouts.admin>
