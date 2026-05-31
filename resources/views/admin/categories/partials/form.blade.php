<div class="grid gap-1">
    <label for="name" class="font-mono text-[10px] uppercase tracking-wider text-zinc-500 font-bold">Nama Kategori</label>
    <input 
        id="name" 
        name="name" 
        value="{{ old('name', $category?->name) }}" 
        class="mt-1 block w-full rounded-none border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-950 focus:border-zinc-950 focus:ring-1 focus:ring-zinc-950 focus:outline-none" 
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
        class="mt-1 block w-full rounded-none border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-950 focus:border-zinc-950 focus:ring-1 focus:ring-zinc-950 focus:outline-none"
    >{{ old('description', $category?->description) }}</textarea>
    <x-form-error name="description" />
</div>
