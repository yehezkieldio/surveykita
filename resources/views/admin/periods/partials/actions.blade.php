<div class="flex min-w-28 flex-col items-stretch gap-2 sm:min-w-0 sm:flex-row sm:justify-end">
    <x-ui.button href="{{ route('admin.periods.show', $period) }}" variant="ghost" size="sm">Detail</x-ui.button>
    <x-ui.button href="{{ route('admin.periods.edit', $period) }}" variant="secondary" size="sm">Edit</x-ui.button>
    <form action="{{ route('admin.periods.destroy', $period) }}" method="POST" class="inline-flex" onsubmit="return confirm('Apakah Anda yakin ingin menghapus periode ini?');">
        @csrf
        @method('DELETE')
        <x-ui.button variant="danger" size="sm">Hapus</x-ui.button>
    </form>
</div>
