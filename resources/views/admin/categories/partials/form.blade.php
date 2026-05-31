<div class="grid gap-1">
    <label for="name" class="font-mono text-[10px] uppercase tracking-wider text-zinc-500 font-bold">Nama Kategori</label>
    <input 
        type="text"
        id="name" 
        name="name" 
        value="{{ old('name', $category?->name) }}" 
        class="mt-1 block w-full" 
        required
    >
    <x-form-error name="name" />
</div>

<div class="grid gap-1 mt-2">
    <label for="description" class="font-mono text-[10px] uppercase tracking-wider text-zinc-500 font-bold">Deskripsi</label>
    <textarea 
        id="description" 
        name="description" 
        rows="3" 
        class="mt-1 block w-full"
    >{{ old('description', $category?->description) }}</textarea>
    <x-form-error name="description" />
</div>
