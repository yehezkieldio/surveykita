<div class="flex min-w-28 flex-col items-stretch gap-2 sm:min-w-0 sm:flex-row sm:justify-end">
    <x-ui.button href="{{ route('admin.questions.show', $question) }}" variant="ghost" size="sm">Detail</x-ui.button>
    <x-ui.button href="{{ route('admin.questions.edit', $question) }}" variant="secondary" size="sm">Edit</x-ui.button>
    <form action="{{ route('admin.questions.destroy', $question) }}" method="POST" class="inline-flex" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pertanyaan ini?');">
        @csrf
        @method('DELETE')
        <x-ui.button variant="danger" size="sm">
            Hapus
        </x-ui.button>
    </form>
</div>
