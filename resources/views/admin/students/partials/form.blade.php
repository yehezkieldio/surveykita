<div class="space-y-6">
    <div class="space-y-1.5">
        <label for="name" class="text-xs font-bold uppercase tracking-wider text-zinc-500">Nama Lengkap</label>
        <input id="name" name="name" type="text" value="{{ old('name', ($student ?? null)?->name ?? ($student ?? null)?->user?->name) }}" required autofocus placeholder="Contoh: Ahmad Fauzi">
        <x-ui.error name="name" />
    </div>

    <div class="space-y-1.5">
        <label for="email" class="text-xs font-bold uppercase tracking-wider text-zinc-500">Email</label>
        <input id="email" name="email" type="email" value="{{ old('email', ($student ?? null)?->user?->email) }}" required placeholder="nama@mahasiswa.ac.id">
        <x-ui.error name="email" />
    </div>

    <div class="grid gap-6 sm:grid-cols-2">
        <div class="space-y-1.5">
            <label for="nim" class="text-xs font-bold uppercase tracking-wider text-zinc-500">NIM (7 Digit)</label>
            <input id="nim" name="nim" type="text" value="{{ old('nim', ($student ?? null)?->nim) }}" required placeholder="Contoh: 2101001">
            <x-ui.error name="nim" />
        </div>

        <div class="space-y-1.5">
            <label for="class_name" class="text-xs font-bold uppercase tracking-wider text-zinc-500">Kelas</label>
            <input id="class_name" name="class_name" type="text" value="{{ old('class_name', ($student ?? null)?->class_name) }}" required placeholder="Contoh: TI-2A">
            <x-ui.error name="class_name" />
        </div>
    </div>

    <div class="space-y-1.5">
        <label for="password" class="text-xs font-bold uppercase tracking-wider text-zinc-500">
            Kata Sandi {{ isset($student) ? '(Kosongkan jika tidak ingin mengubah)' : '' }}
        </label>
        <input id="password" name="password" type="password" {{ isset($student) ? '' : 'required' }} placeholder="••••••••">
        <x-ui.error name="password" />
    </div>
</div>
