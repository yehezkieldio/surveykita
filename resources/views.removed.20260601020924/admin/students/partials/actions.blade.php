<div class="flex justify-end gap-3">
    <a class="sk-link" href="{{ route('admin.students.show', $student) }}">Detail</a>
    <a class="sk-link" href="{{ route('admin.students.edit', $student) }}">Edit</a>
    <form method="POST" action="{{ route('admin.students.destroy', $student) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus mahasiswa ini?')">
        @csrf
        @method('DELETE')
        <button class="sk-danger-link" type="submit">Hapus</button>
    </form>
</div>
