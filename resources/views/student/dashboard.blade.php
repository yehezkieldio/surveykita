<x-layouts.student title="Dashboard Mahasiswa - SurveyKita" heading="Dashboard Mahasiswa">
    <div class="grid gap-6 md:grid-cols-3">
        <x-summary-card 
            label="Profil Mahasiswa" 
            value="{{ $profileComplete ? 'LENGKAP' : 'BELUM LENGKAP' }}" 
            description="NIM dan Program Studi Anda wajib diisi sebelum mengisi evaluasi." 
        />
        <x-summary-card 
            label="Evaluasi Tersedia" 
            value="{{ $activeFormCount }}" 
            description="Jumlah form evaluasi aktif yang perlu Anda respon." 
        />
        <x-summary-card 
            label="Evaluasi Terkirim" 
            value="{{ $submissionCount }}" 
            description="Jumlah form evaluasi yang telah Anda submit." 
        />
    </div>

    <div class="mt-8 flex gap-4">
        <x-button :href="route('student.evaluations.index')">Mulai Evaluasi</x-button>
        <x-button variant="secondary" :href="route('student.submissions.index')">Riwayat Pengisian</x-button>
    </div>
</x-layouts.student>
