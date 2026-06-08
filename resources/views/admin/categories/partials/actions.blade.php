<div class="flex justify-end gap-2">
    <x-ui.button href="{{ route('admin.categories.show', $category) }}" variant="ghost" size="sm">Detail</x-ui.button>
    <x-ui.button href="{{ route('admin.categories.edit', $category) }}" variant="secondary" size="sm">Edit</x-ui.button>
    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');">
        @csrf
        @method('DELETE')
        <x-ui.button variant="danger" size="sm" :disabled="$category->questions()->exists()">
            Hapus
        </x-ui.button>
    </form>
</div>
