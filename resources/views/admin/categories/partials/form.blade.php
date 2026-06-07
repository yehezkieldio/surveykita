<div class="space-y-6">
    <div class="space-y-1.5">
        <label for="name" class="text-xs font-bold uppercase tracking-wider text-zinc-500">Nama Kategori</label>
        <input id="name" name="name" type="text" value="{{ old('name', ($category ?? null)?->name) }}" required autofocus placeholder="Contoh: Sarana & Prasarana">
        <x-ui.error name="name" />
    </div>

    <div class="space-y-1.5">
        <label for="description" class="text-xs font-bold uppercase tracking-wider text-zinc-500">Deskripsi (Opsional)</label>
        <textarea id="description" name="description" rows="3" placeholder="Jelaskan cakupan kategori ini...">{{ old('description', ($category ?? null)?->description) }}</textarea>
        <x-ui.error name="description" />
    </div>
</div>
