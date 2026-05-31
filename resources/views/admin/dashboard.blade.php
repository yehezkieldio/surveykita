<x-layouts.admin title="Dashboard Admin - SurveyKita" heading="Dashboard Admin">
    <section class="grid gap-px border border-zinc-200 bg-zinc-200 md:grid-cols-2 xl:grid-cols-4">
        <x-summary-card label="Mahasiswa" value="{{ $studentCount }}" description="Profil terdaftar." class="border-0" />
        <x-summary-card label="Periode Aktif" value="{{ $activePeriodCount }}" description="Sedang berjalan." class="border-0" />
        <x-summary-card label="Form Aktif" value="{{ $activeFormCount }}" description="Dapat diisi." class="border-0" />
        <x-summary-card label="Respons" value="{{ $responseCount }}" description="Terkumpul." class="border-0" />
    </section>

    <section class="mt-6 grid gap-6 xl:grid-cols-[minmax(0,1fr)_24rem]">
        <div class="border border-zinc-200 bg-white p-6">
            <p class="font-display text-5xl font-semibold leading-none tracking-[-0.07em] text-zinc-950">Operasikan evaluasi dari data utama.</p>
            <p class="mt-4 max-w-2xl text-sm leading-6 text-zinc-600">Mulai dari periode, susun form, masukkan pertanyaan, lalu baca hasil evaluasi dalam laporan.</p>
            <div class="mt-6 flex flex-wrap gap-2">
                <x-button href="{{ route('admin.periods.index') }}" variant="secondary">Periode</x-button>
                <x-button href="{{ route('admin.forms.index') }}" variant="secondary">Form</x-button>
                <x-button href="{{ route('admin.results.index') }}">Hasil</x-button>
            </div>
        </div>
        <div class="grid gap-px border border-zinc-200 bg-zinc-200">
            <div class="bg-white p-5"><p class="text-xs font-medium text-zinc-500">Instrumen Pertanyaan</p><p class="mt-3 font-display text-6xl font-semibold leading-none tracking-[-0.07em]">{{ $questionCount }}</p></div>
            <div class="bg-white p-5"><x-button href="{{ route('admin.questions.index') }}" class="w-full" variant="secondary">Kelola Pertanyaan</x-button></div>
        </div>
    </section>
</x-layouts.admin>
