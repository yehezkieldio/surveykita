<x-layouts.student 
    :heading="Auth::user()->hasCompleteStudentProfile() ? 'Profil Mahasiswa' : 'Lengkapi Profil'" 
    :eyebrow="Auth::user()->hasCompleteStudentProfile() ? 'Identitas Akademik' : 'Langkah Awal'"
>
    <div class="grid gap-8 lg:grid-cols-[1fr_20rem]">
        <div class="space-y-8">
            <x-ui.card>
                <form method="POST" action="{{ route('student.profile.update') }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="space-y-1.5">
                        <label for="name" class="text-xs font-bold uppercase tracking-wider text-zinc-500">Nama Lengkap</label>
                        <input id="name" name="name" type="text" value="{{ old('name', $student?->name ?? Auth::user()->name) }}" required autofocus placeholder="Contoh: Ahmad Fauzi">
                        <x-ui.error name="name" />
                    </div>

                    <div class="grid gap-6 sm:grid-cols-2">
                        <div class="space-y-1.5">
                            <label for="nim" class="text-xs font-bold uppercase tracking-wider text-zinc-500">NIM (7 Digit)</label>
                            <input id="nim" name="nim" type="text" value="{{ old('nim', $student?->nim) }}" required placeholder="Contoh: 2101001">
                            <x-ui.error name="nim" />
                        </div>

                        <div class="space-y-1.5">
                            <label for="class_name" class="text-xs font-bold uppercase tracking-wider text-zinc-500">Kelas</label>
                            <input id="class_name" name="class_name" type="text" value="{{ old('class_name', $student?->class_name) }}" required placeholder="Contoh: TI-2A">
                            <x-ui.error name="class_name" />
                        </div>
                    </div>

                    @if(Auth::user()->hasCompleteStudentProfile())
                        <div class="grid gap-6 sm:grid-cols-2 pt-6 border-t border-zinc-100">
                            <div class="space-y-1">
                                <p class="text-xs font-bold uppercase tracking-wider text-zinc-400">Program Studi</p>
                                <p class="text-sm font-semibold text-zinc-950">{{ $student->study_program }}</p>
                            </div>
                            <div class="space-y-1">
                                <p class="text-xs font-bold uppercase tracking-wider text-zinc-400">Tahun Angkatan</p>
                                <p class="text-sm font-semibold text-zinc-950">{{ $student->enrollment_year }}</p>
                            </div>
                        </div>
                    @endif

                    <div class="pt-6 border-t border-zinc-100 flex justify-end">
                        <x-ui.button variant="teal" class="w-full sm:w-auto">
                            {{ Auth::user()->hasCompleteStudentProfile() ? 'Perbarui Profil' : 'Simpan Perubahan' }}
                        </x-ui.button>
                    </div>
                </form>
            </x-ui.card>
        </div>

        <aside class="space-y-6">
            <div class="rounded-lg border border-zinc-200 bg-white p-6">
                <h3 class="text-sm font-semibold text-zinc-950">Informasi Penting</h3>
                <div class="mt-4 space-y-4">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-zinc-400">Tentang NIM</p>
                        <p class="mt-2 text-sm leading-6 text-zinc-600">
                            NIM Anda digunakan untuk mengidentifikasi Program Studi, Tahun Angkatan, dan urutan pendaftaran secara otomatis.
                        </p>
                    </div>
                    <div class="pt-4 border-t border-zinc-100">
                        <p class="text-xs font-bold uppercase tracking-wider text-zinc-400">Normalisasi Kelas</p>
                        <p class="mt-2 text-sm leading-6 text-zinc-600">
                            Format nama kelas akan disesuaikan secara sistematis. Cukup masukkan nama kelas Anda saat ini.
                        </p>
                    </div>
                </div>
            </div>
        </aside>
    </div>
</x-layouts.student>
