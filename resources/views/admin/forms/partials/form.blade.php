<div class="space-y-6">
    <div class="space-y-1.5">
        <label for="evaluation_period_id" class="text-xs font-bold uppercase tracking-wider text-zinc-500">Periode Evaluasi</label>
        <select id="evaluation_period_id" name="evaluation_period_id" required autofocus>
            <option value="">Pilih Periode</option>
            @foreach($periods as $period)
                <option value="{{ $period->id }}" {{ old('evaluation_period_id', ($form ?? null)?->evaluation_period_id ?? request('evaluation_period_id')) == $period->id ? 'selected' : '' }}>
                    {{ $period->name }}
                </option>
            @endforeach
        </select>
        <x-ui.error name="evaluation_period_id" />
    </div>

    <div class="space-y-1.5">
        <label for="title" class="text-xs font-bold uppercase tracking-wider text-zinc-500">Judul Formulir</label>
        <input id="title" name="title" type="text" value="{{ old('title', ($form ?? null)?->title) }}" required placeholder="Contoh: Evaluasi Layanan Akademik">
        <x-ui.error name="title" />
    </div>

    <div class="space-y-1.5">
        <label for="description" class="text-xs font-bold uppercase tracking-wider text-zinc-500">Deskripsi</label>
        <textarea id="description" name="description" rows="3" required placeholder="Jelaskan tujuan formulir ini...">{{ old('description', ($form ?? null)?->description) }}</textarea>
        <x-ui.error name="description" />
    </div>

    <div class="space-y-1.5">
        <label for="target_type" class="text-xs font-bold uppercase tracking-wider text-zinc-500">Target Responden</label>
        <select id="target_type" name="target_type" required>
            <option value="layanan_akademik" {{ old('target_type', ($form ?? null)?->target_type) === 'layanan_akademik' ? 'selected' : '' }}>Layanan Akademik</option>
            <option value="pembelajaran" {{ old('target_type', ($form ?? null)?->target_type) === 'pembelajaran' ? 'selected' : '' }}>Pembelajaran</option>
            <option value="fasilitas" {{ old('target_type', ($form ?? null)?->target_type) === 'fasilitas' ? 'selected' : '' }}>Fasilitas</option>
            <option value="administrasi" {{ old('target_type', ($form ?? null)?->target_type) === 'administrasi' ? 'selected' : '' }}>Administrasi</option>
            <option value="kepuasan_umum" {{ old('target_type', ($form ?? null)?->target_type) === 'kepuasan_umum' ? 'selected' : '' }}>Kepuasan Umum</option>
        </select>
        <x-ui.error name="target_type" />
    </div>

    <div class="flex items-center">
        <input type="hidden" name="is_active" value="0">
        <input id="is_active" name="is_active" type="checkbox" value="1" {{ old('is_active', ($form ?? null)?->is_active ?? true) ? 'checked' : '' }}>
        <label for="is_active" class="ml-3 text-sm font-medium text-zinc-950 text-xs font-bold uppercase tracking-wider">Aktifkan Formulir Ini</label>
    </div>
    <x-ui.error name="is_active" />
</div>
