<div class="grid gap-5">
    <div class="grid gap-1">
        <label for="name" class="font-mono text-[10px] uppercase tracking-wider text-zinc-500 font-bold">Nama Mahasiswa</label>
        <input 
            id="name" 
            name="name" 
            value="{{ old('name', $student?->name) }}" 
            class="mt-1 block w-full rounded-none border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-950 focus:border-zinc-950 focus:ring-1 focus:ring-zinc-950 focus:outline-none" 
            required
        >
        <x-form-error name="name" />
    </div>

    <div class="grid gap-1">
        <label for="email" class="font-mono text-[10px] uppercase tracking-wider text-zinc-500 font-bold">Email</label>
        <input 
            id="email" 
            name="email" 
            type="email" 
            value="{{ old('email', $student?->user?->email) }}" 
            class="mt-1 block w-full rounded-none border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-950 focus:border-zinc-950 focus:ring-1 focus:ring-zinc-950 focus:outline-none" 
            required
        >
        <x-form-error name="email" />
    </div>

    <div class="grid gap-4 sm:grid-cols-2">
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
    </div>

    <div class="grid gap-1">
        <label for="password" class="font-mono text-[10px] uppercase tracking-wider text-zinc-500 font-bold">Kata Sandi {{ $student ? '(kosongkan jika tidak diubah)' : '' }}</label>
        <input 
            id="password" 
            name="password" 
            type="password" 
            class="mt-1 block w-full rounded-none border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-950 focus:border-zinc-950 focus:ring-1 focus:ring-zinc-950 focus:outline-none" 
            {{ $student ? '' : 'required' }}
        >
        <x-form-error name="password" />
    </div>
</div>
