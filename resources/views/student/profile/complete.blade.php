<x-layouts.student title="Lengkapi Profil - SurveyKita" heading="Lengkapi Profil">
    <x-card heading="Profil Mahasiswa" subheading="NIM akan digunakan untuk mengisi program studi, tahun masuk, dan nomor urut secara otomatis.">
        <form method="POST" action="{{ route('student.profile.update') }}" class="grid gap-4">
            @csrf
            @method('PUT')

            <label class="grid gap-1 text-sm">
                <span class="font-medium">NIM</span>
                <input name="nim" value="{{ old('nim', $student?->nim) }}" class="rounded-md border-zinc-300" required>
                <x-form-error name="nim" />
            </label>

            <label class="grid gap-1 text-sm">
                <span class="font-medium">Nama Lengkap</span>
                <input name="name" value="{{ old('name', $student?->name ?? auth()->user()?->name) }}" class="rounded-md border-zinc-300" required>
                <x-form-error name="name" />
            </label>

            <label class="grid gap-1 text-sm">
                <span class="font-medium">Kelas</span>
                <input name="class_name" value="{{ old('class_name', $student?->class_name) }}" class="rounded-md border-zinc-300" required>
                <x-form-error name="class_name" />
            </label>

            <x-button type="submit">Simpan Profil</x-button>
        </form>
    </x-card>
</x-layouts.student>
