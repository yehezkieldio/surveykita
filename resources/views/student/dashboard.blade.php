<x-layouts.student title="Dashboard Mahasiswa - SurveyKita" heading="Dashboard Mahasiswa">
    <div class="grid gap-4 md:grid-cols-3">
        <x-card heading="Profil" subheading="{{ $profileComplete ? 'Lengkap' : 'Belum lengkap' }}" />
        <x-card heading="Evaluasi Aktif" subheading="{{ $activeFormCount }} form tersedia." />
        <x-card heading="Riwayat" subheading="{{ $submissionCount }} form sudah dikirim." />
    </div>

    <div class="mt-4 flex gap-2">
        <x-button :href="route('student.evaluations.index')">Lihat Evaluasi</x-button>
        <x-button variant="secondary" :href="route('student.submissions.index')">Riwayat</x-button>
    </div>
</x-layouts.student>
