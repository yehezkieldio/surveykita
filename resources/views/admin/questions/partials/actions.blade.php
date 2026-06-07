<div class="flex justify-end gap-2">
    <x-ui.button href="{{ route('admin.questions.edit', $question) }}" variant="secondary" size="sm">Edit</x-ui.button>
    <form action="{{ route('admin.questions.destroy', $question) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pertanyaan ini?');">
        @csrf
        @method('DELETE')
        <x-ui.button variant="danger" size="sm" :disabled="$question->responseAnswers()->exists()">
            Hapus
        </x-ui.button>
    </form>
</div>
