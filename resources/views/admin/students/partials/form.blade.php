<div class="grid gap-5">
    <div class="grid gap-1">
        <label for="name" class="font-mono text-[10px] uppercase tracking-wider text-zinc-500 font-bold">Nama Mahasiswa</label>
        <input 
            type="text"
            id="name" 
            name="name" 
            value="{{ old('name', $student?->name) }}" 
            class="mt-1 block w-full" 
            required
        >
        <x-form-error name="name" />
    </div>

    <div class="grid gap-1">
        <label for="email" class="font-mono text-[10px] uppercase tracking-wider text-zinc-500 font-bold">Email</label>
        <input 
            type="email"
            id="email" 
            name="email" 
            value="{{ old('email', $student?->user?->email) }}" 
            class="mt-1 block w-full" 
            required
        >
        <x-form-error name="email" />
    </div>

    <div class="grid gap-4 sm:grid-cols-2">
        <div class="grid gap-1">
            <label for="nim" class="font-mono text-[10px] uppercase tracking-wider text-zinc-500 font-bold">NIM (Nomor Induk Mahasiswa)</label>
            <input 
                type="text"
                id="nim" 
                name="nim" 
                value="{{ old('nim', $student?->nim) }}" 
                class="mt-1 block w-full" 
                required
            >
            <x-form-error name="nim" />
        </div>

        <div class="grid gap-1">
            <label for="class_name" class="font-mono text-[10px] uppercase tracking-wider text-zinc-500 font-bold">Kelas</label>
            <input 
                type="text"
                id="class_name" 
                name="class_name" 
                value="{{ old('class_name', $student?->class_name) }}" 
                class="mt-1 block w-full" 
                placeholder="Contoh: 1A, 2B"
                required
            >
            <x-form-error name="class_name" />
        </div>
    </div>

    <div class="grid gap-1">
        <label for="password" class="font-mono text-[10px] uppercase tracking-wider text-zinc-500 font-bold">Kata Sandi {{ $student ? '(kosongkan jika tidak diubah)' : '' }}</label>
        <input 
            type="password"
            id="password" 
            name="password" 
            class="mt-1 block w-full" 
            {{ $student ? '' : 'required' }}
        >
        <x-form-error name="password" />
    </div>
</div>
