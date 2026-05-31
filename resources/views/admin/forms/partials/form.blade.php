<div class="grid gap-5">
    <div class="grid gap-1">
        <label for="evaluation_period_id" class="font-mono text-[10px] uppercase tracking-wider text-zinc-500 font-bold">Periode Evaluasi</label>
        <select 
            id="evaluation_period_id" 
            name="evaluation_period_id" 
            class="mt-1 block w-full rounded-none border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-950 focus:border-zinc-950 focus:ring-1 focus:ring-zinc-950 focus:outline-none" 
            required
        >
            @foreach ($periods as $period)
                <option value="{{ $period->id }}" @selected((int) old('evaluation_period_id', $form?->evaluation_period_id) === $period->id)>{{ $period->name }}</option>
            @endforeach
        </select>
        <x-form-error name="evaluation_period_id" />
    </div>

    <div class="grid gap-1">
        <label for="title" class="font-mono text-[10px] uppercase tracking-wider text-zinc-500 font-bold">Judul Formulir</label>
        <input 
            id="title" 
            name="title" 
            value="{{ old('title', $form?->title) }}" 
            class="mt-1 block w-full rounded-none border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-950 focus:border-zinc-950 focus:ring-1 focus:ring-zinc-950 focus:outline-none" 
            required
        >
        <x-form-error name="title" />
    </div>

    <div class="grid gap-1">
        <label for="description" class="font-mono text-[10px] uppercase tracking-wider text-zinc-500 font-bold">Deskripsi</label>
        <textarea 
            id="description" 
            name="description" 
            rows="3" 
            class="mt-1 block w-full rounded-none border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-950 focus:border-zinc-950 focus:ring-1 focus:ring-zinc-950 focus:outline-none"
        >{{ old('description', $form?->description) }}</textarea>
        <x-form-error name="description" />
    </div>

    <div class="grid gap-1">
        <label for="target_type" class="font-mono text-[10px] uppercase tracking-wider text-zinc-500 font-bold">Target Responden / Kategori Layanan</label>
        <select 
            id="target_type" 
            name="target_type" 
            class="mt-1 block w-full rounded-none border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-950 focus:border-zinc-950 focus:ring-1 focus:ring-zinc-950 focus:outline-none" 
            required
        >
            @foreach (['layanan_akademik','pembelajaran','fasilitas','administrasi','kepuasan_umum'] as $target)
                <option value="{{ $target }}" @selected(old('target_type', $form?->target_type) === $target)>{{ ucwords(str_replace('_', ' ', $target)) }}</option>
            @endforeach
        </select>
        <x-form-error name="target_type" />
    </div>

    <div class="flex items-center gap-2 mt-2">
        <input type="hidden" name="is_active" value="0">
        <input 
            id="is_active" 
            name="is_active" 
            type="checkbox" 
            value="1" 
            @checked(old('is_active', $form?->is_active ?? true)) 
            class="rounded-none border-zinc-300 text-zinc-950 focus:ring-zinc-950 focus:ring-offset-0"
        >
        <label for="is_active" class="font-mono text-[10px] uppercase tracking-wider text-zinc-500 font-bold">Aktifkan formulir ini</label>
    </div>
</div>
