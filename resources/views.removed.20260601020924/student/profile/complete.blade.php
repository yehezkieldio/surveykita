<x-layouts.student title="Lengkapi Profil - SurveyKita" heading="Profil Akademik">
    <section class="grid gap-6 lg:grid-cols-[22rem_minmax(0,1fr)]">
        <div class="border border-zinc-200 bg-zinc-950 p-6 text-white">
            <p class="font-display text-4xl font-semibold leading-none tracking-[-0.06em]">Identitas menentukan akses evaluasi.</p>
            <p class="mt-4 text-sm leading-6 text-zinc-300">NIM dibaca untuk program studi dan angkatan. Kelas digunakan untuk segmentasi laporan akademik.</p>
        </div>
        <x-card heading="Data Mahasiswa" subheading="Pastikan data sesuai dengan identitas akademik Anda.">
            <form method="POST" action="{{ route('student.profile.update') }}" class="grid gap-5">
                @csrf
                @method('PUT')
                <div class="grid gap-5 sm:grid-cols-2">
                    <div class="sk-field"><label for="nim" class="sk-label">NIM</label><input type="text" id="nim" name="nim" value="{{ old('nim', $student?->nim) }}" required><x-form-error name="nim" /></div>
                    <div class="sk-field"><label for="class_name" class="sk-label">Kelas</label><input type="text" id="class_name" name="class_name" value="{{ old('class_name', $student?->class_name) }}" placeholder="Contoh: IFB6A" required><x-form-error name="class_name" /></div>
                </div>
                <div class="sk-field"><label for="name" class="sk-label">Nama Lengkap</label><input type="text" id="name" name="name" value="{{ old('name', $student?->name ?? auth()->user()?->name) }}" required><x-form-error name="name" /></div>
                <x-button type="submit">Simpan Profil</x-button>
            </form>
        </x-card>
    </section>
</x-layouts.student>
