<x-layouts.student title="Dashboard Mahasiswa - SurveyKita" heading="Beranda Evaluasi">
    <section class="grid gap-6 lg:grid-cols-[minmax(0,1.25fr)_minmax(22rem,0.75fr)]">
        <div class="border border-zinc-200 bg-white p-6 sm:p-8">
            <p class="max-w-3xl font-display text-4xl font-semibold leading-[0.98] tracking-[-0.06em] text-zinc-950 md:text-5xl">
                Selesaikan evaluasi akademik tanpa menebak langkah berikutnya.
            </p>
            <p class="mt-5 max-w-2xl text-sm leading-6 text-zinc-600">
                Mulai dari profil, masuk ke daftar evaluasi aktif, lalu cek riwayat pengisian setelah respons terkirim.
            </p>
            <div class="mt-8 flex flex-col gap-2 sm:flex-row">
                <x-button :href="route('student.evaluations.index')">Buka Evaluasi</x-button>
                <x-button variant="secondary" :href="route('student.submissions.index')">Lihat Riwayat</x-button>
            </div>
        </div>

        <div class="grid gap-px border border-zinc-200 bg-zinc-200">
            <div class="bg-white p-5">
                <p class="text-xs font-medium text-zinc-500">Profil</p>
                <p class="mt-3 font-display text-3xl font-semibold tracking-[-0.06em] text-zinc-950">{{ $profileComplete ? 'Lengkap' : 'Belum lengkap' }}</p>
                <p class="mt-2 text-sm leading-6 text-zinc-600">NIM dan kelas menjadi syarat sebelum mengisi evaluasi.</p>
            </div>
            <div class="grid grid-cols-2 gap-px bg-zinc-200">
                <div class="bg-white p-5">
                    <p class="text-xs font-medium text-zinc-500">Tersedia</p>
                    <p class="mt-3 font-display text-5xl font-semibold leading-none tracking-[-0.07em]">{{ $activeFormCount }}</p>
                </div>
                <div class="bg-white p-5">
                    <p class="text-xs font-medium text-zinc-500">Terkirim</p>
                    <p class="mt-3 font-display text-5xl font-semibold leading-none tracking-[-0.07em]">{{ $submissionCount }}</p>
                </div>
            </div>
        </div>
    </section>

    <section class="mt-8 grid gap-px border border-zinc-200 bg-zinc-200 lg:grid-cols-3">
        <div class="bg-zinc-950 p-6 text-white">
            <p class="font-display text-4xl font-semibold tracking-[-0.06em]">Alur</p>
            <p class="mt-3 text-sm leading-6 text-zinc-300">Urutan kerja dibuat eksplisit agar tidak terasa seperti dashboard kosong.</p>
        </div>
        <div class="bg-white p-6">
            <p class="text-xs font-medium text-zinc-500">Pertama</p>
            <p class="mt-3 text-lg font-semibold">Lengkapi profil</p>
            <p class="mt-2 text-sm leading-6 text-zinc-600">Pastikan NIM, nama, dan kelas sudah valid sebelum evaluasi dibuka.</p>
        </div>
        <div class="bg-white p-6">
            <p class="text-xs font-medium text-zinc-500">Berikutnya</p>
            <p class="mt-3 text-lg font-semibold">Kirim evaluasi</p>
            <p class="mt-2 text-sm leading-6 text-zinc-600">Pilih form aktif, isi skala Likert, lalu simpan respons Anda.</p>
        </div>
    </section>
</x-layouts.student>
