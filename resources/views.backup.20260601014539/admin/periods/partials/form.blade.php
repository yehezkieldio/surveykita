<div class="grid gap-5">
    <div class="grid gap-1">
        <label for="name" class="font-mono text-[10px] uppercase tracking-wider text-zinc-500 font-bold">Nama Periode</label>
        <input 
            type="text"
            id="name" 
            name="name" 
            value="{{ old('name', $period?->name) }}" 
            class="mt-1 block w-full" 
            required
        >
        <x-form-error name="name" />
    </div>

    <div class="grid gap-4 sm:grid-cols-2">
        <div class="grid gap-1">
            <label for="semester" class="font-mono text-[10px] uppercase tracking-wider text-zinc-500 font-bold">Semester</label>
            <input 
                type="text"
                id="semester" 
                name="semester" 
                value="{{ old('semester', $period?->semester) }}" 
                class="mt-1 block w-full" 
                placeholder="Ganjil / Genap"
                required
            >
            <x-form-error name="semester" />
        </div>

        <div class="grid gap-1">
            <label for="academic_year" class="font-mono text-[10px] uppercase tracking-wider text-zinc-500 font-bold">Tahun Akademik</label>
            <input 
                type="text"
                id="academic_year" 
                name="academic_year" 
                value="{{ old('academic_year', $period?->academic_year) }}" 
                class="mt-1 block w-full" 
                placeholder="2025/2026"
                required
            >
            <x-form-error name="academic_year" />
        </div>
    </div>

    <div class="grid gap-4 sm:grid-cols-2">
        <div class="grid gap-1">
            <label for="start_date" class="font-mono text-[10px] uppercase tracking-wider text-zinc-500 font-bold">Tanggal Mulai</label>
            <input 
                type="date"
                id="start_date" 
                name="start_date" 
                value="{{ old('start_date', $period?->start_date?->toDateString()) }}" 
                class="mt-1 block w-full" 
                required
            >
            <x-form-error name="start_date" />
        </div>

        <div class="grid gap-1">
            <label for="end_date" class="font-mono text-[10px] uppercase tracking-wider text-zinc-500 font-bold">Tanggal Selesai</label>
            <input 
                type="date"
                id="end_date" 
                name="end_date" 
                value="{{ old('end_date', $period?->end_date?->toDateString()) }}" 
                class="mt-1 block w-full" 
                required
            >
            <x-form-error name="end_date" />
        </div>
    </div>

    <div class="flex items-center gap-2 mt-2">
        <input type="hidden" name="is_active" value="0">
        <input 
            id="is_active" 
            name="is_active" 
            type="checkbox" 
            value="1" 
            @checked(old('is_active', $period?->is_active ?? true)) 
            class="rounded border-zinc-300 text-zinc-950 focus:ring-zinc-950 focus:ring-offset-0"
        >
        <label for="is_active" class="font-mono text-[10px] uppercase tracking-wider text-zinc-500 font-bold">Aktifkan periode ini</label>
    </div>
</div>
