<x-layouts.admin title="Dashboard Admin - SurveyKita" heading="Dashboard Admin">
    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
        <x-card heading="Mahasiswa" subheading="{{ $studentCount }} profil mahasiswa terdaftar." />
        <x-card heading="Periode Aktif" subheading="{{ $activePeriodCount }} periode sedang aktif." />
        <x-card heading="Form Aktif" subheading="{{ $activeFormCount }} form evaluasi aktif." />
        <x-card heading="Respons" subheading="{{ $responseCount }} respons evaluasi masuk." />
    </div>

    <x-card class="mt-4" heading="Pertanyaan Evaluasi" subheading="{{ $questionCount }} pertanyaan Likert tersedia untuk form evaluasi." />
</x-layouts.admin>
