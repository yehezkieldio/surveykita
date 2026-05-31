<label class="grid gap-1 text-sm">
    <span class="font-medium">Nama</span>
    <input name="name" value="{{ old('name', $student?->name) }}" class="rounded-md border-zinc-300" required>
    <x-form-error name="name" />
</label>
<label class="grid gap-1 text-sm">
    <span class="font-medium">Email</span>
    <input name="email" type="email" value="{{ old('email', $student?->user?->email) }}" class="rounded-md border-zinc-300" required>
    <x-form-error name="email" />
</label>
<label class="grid gap-1 text-sm">
    <span class="font-medium">NIM</span>
    <input name="nim" value="{{ old('nim', $student?->nim) }}" class="rounded-md border-zinc-300" required>
    <x-form-error name="nim" />
</label>
<label class="grid gap-1 text-sm">
    <span class="font-medium">Kelas</span>
    <input name="class_name" value="{{ old('class_name', $student?->class_name) }}" class="rounded-md border-zinc-300" required>
    <x-form-error name="class_name" />
</label>
<label class="grid gap-1 text-sm">
    <span class="font-medium">Password {{ $student ? '(kosongkan jika tidak diubah)' : '' }}</span>
    <input name="password" type="password" class="rounded-md border-zinc-300" {{ $student ? '' : 'required' }}>
    <x-form-error name="password" />
</label>
