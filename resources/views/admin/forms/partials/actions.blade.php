<div class="flex justify-end gap-2">
    <x-ui.button href="{{ route('admin.forms.show', $form) }}" variant="ghost" size="sm">Detail</x-ui.button>
    <x-ui.button href="{{ route('admin.forms.edit', $form) }}" variant="secondary" size="sm">Edit</x-ui.button>
    <form action="{{ route('admin.forms.destroy', $form) }}" method="POST" class="inline-flex" onsubmit="return confirm('Apakah Anda yakin ingin menghapus formulir ini?');">
        @csrf
        @method('DELETE')
        <x-ui.button variant="danger" size="sm">Hapus</x-ui.button>
    </form>
</div>
