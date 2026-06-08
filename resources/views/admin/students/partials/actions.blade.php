<div class="flex justify-end gap-2">
    <x-ui.button href="{{ route('admin.students.show', $student) }}" variant="ghost" size="sm">Detail</x-ui.button>
    <x-ui.button href="{{ route('admin.students.edit', $student) }}" variant="secondary" size="sm">Edit</x-ui.button>
    <form action="{{ route('admin.students.destroy', $student) }}" method="POST" class="inline-flex" onsubmit="return confirm('Apakah Anda yakin ingin menghapus mahasiswa ini?');">
        @csrf
        @method('DELETE')
        <x-ui.button variant="danger" size="sm">Hapus</x-ui.button>
    </form>
</div>
