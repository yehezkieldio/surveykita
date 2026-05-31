<div class="sk-field">
    <label for="name" class="sk-label">Nama Kategori</label>
    <input type="text" id="name" name="name" value="{{ old('name', $category?->name) }}" required>
    <x-form-error name="name" />
</div>
<div class="sk-field">
    <label for="description" class="sk-label">Deskripsi</label>
    <textarea id="description" name="description" rows="4">{{ old('description', $category?->description) }}</textarea>
    <x-form-error name="description" />
</div>
