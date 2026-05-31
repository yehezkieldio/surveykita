<x-layouts.student title="Lengkapi Profil - SurveyKita" heading="Lengkapi Profil">
    <x-card heading="Profil Mahasiswa" subheading="NIM akan digunakan untuk menentukan program studi, angkatan, dan data identitas Anda secara otomatis dalam sistem.">
        <form method="POST" action="{{ route('student.profile.update') }}" class="grid gap-5">
            @csrf
            @method('PUT')

            <div class="grid gap-1">
                <label for="nim" class="font-mono text-[10px] uppercase tracking-wider text-zinc-500 font-bold">NIM (Nomor Induk Mahasiswa)</label>
                <input 
                    id="nim" 
                    name="nim" 
                    value="{{ old('nim', $student?->nim) }}" 
                    class="mt-1 block w-full rounded-none border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-950 focus:border-zinc-950 focus:ring-1 focus:ring-zinc-950 focus:outline-none" 
                    required
                >
                <x-form-error name="nim" />
            </div>

            <div class="grid gap-1">
                <label for="name" class="font-mono text-[10px] uppercase tracking-wider text-zinc-500 font-bold">Nama Lengkap</label>
                <input 
                    id="name" 
                    name="name" 
                    value="{{ old('name', $student?->name ?? auth()->user()?->name) }}" 
                    class="mt-1 block w-full rounded-none border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-950 focus:border-zinc-950 focus:ring-1 focus:ring-zinc-950 focus:outline-none" 
                    required
                >
                <x-form-error name="name" />
            </div>

            <div class="grid gap-1">
                <label for="class_name" class="font-mono text-[10px] uppercase tracking-wider text-zinc-500 font-bold">Kelas</label>
                <input 
                    id="class_name" 
                    name="class_name" 
                    value="{{ old('class_name', $student?->class_name) }}" 
                    class="mt-1 block w-full rounded-none border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-950 focus:border-zinc-950 focus:ring-1 focus:ring-zinc-950 focus:outline-none" 
                    placeholder="Contoh: 1A, 2B"
                    required
                >
                <x-form-error name="class_name" />
            </div>

            <x-button type="submit" class="w-full mt-2">Simpan Profil</x-button>
        </form>
    </x-card>
</x-layouts.student>
