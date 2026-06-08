<div class="space-y-5 sm:space-y-6">
    <div class="space-y-1.5">
        <label for="name" class="text-xs font-bold uppercase tracking-wider text-zinc-500">Nama Periode</label>
        <input id="name" name="name" type="text" value="{{ old('name', ($period ?? null)?->name) }}" required autofocus placeholder="Contoh: Genap 2025/2026">
        <x-ui.error name="name" />
    </div>

    <div class="grid gap-6 sm:grid-cols-2">
        <div class="space-y-1.5">
            <label for="semester" class="text-xs font-bold uppercase tracking-wider text-zinc-500">Semester</label>
            <select id="semester" name="semester" required>
                <option value="Ganjil" {{ old('semester', ($period ?? null)?->semester) === 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                <option value="Genap" {{ old('semester', ($period ?? null)?->semester) === 'Genap' ? 'selected' : '' }}>Genap</option>
                <option value="Antara" {{ old('semester', ($period ?? null)?->semester) === 'Antara' ? 'selected' : '' }}>Antara</option>
            </select>
            <x-ui.error name="semester" />
        </div>

        <div class="space-y-1.5">
            <label for="academic_year" class="text-xs font-bold uppercase tracking-wider text-zinc-500">Tahun Akademik</label>
            <input id="academic_year" name="academic_year" type="text" value="{{ old('academic_year', ($period ?? null)?->academic_year) }}" required placeholder="Contoh: 2025/2026">
            <x-ui.error name="academic_year" />
        </div>
    </div>

    <div class="grid gap-6 sm:grid-cols-2">
        <div class="space-y-1.5">
            <label for="start_date" class="text-xs font-bold uppercase tracking-wider text-zinc-500">Tanggal Mulai</label>
            <input id="start_date" name="start_date" type="date" value="{{ old('start_date', ($period ?? null)?->start_date?->format('Y-m-d')) }}" required>
            <x-ui.error name="start_date" />
        </div>

        <div class="space-y-1.5">
            <label for="end_date" class="text-xs font-bold uppercase tracking-wider text-zinc-500">Tanggal Selesai</label>
            <input id="end_date" name="end_date" type="date" value="{{ old('end_date', ($period ?? null)?->end_date?->format('Y-m-d')) }}" required>
            <x-ui.error name="end_date" />
        </div>
    </div>

    <div class="flex items-start">
        <input type="hidden" name="is_active" value="0">
        <input id="is_active" name="is_active" type="checkbox" value="1" {{ old('is_active', ($period ?? null)?->is_active) ? 'checked' : '' }}>
        <label for="is_active" class="ml-3 text-xs font-bold uppercase tracking-wider text-zinc-950">Aktifkan Periode Ini</label>
    </div>
    <x-ui.error name="is_active" />
</div>
