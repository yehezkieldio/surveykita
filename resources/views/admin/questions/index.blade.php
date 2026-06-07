<x-layouts.admin heading="Pertanyaan Evaluasi" eyebrow="Bank Soal">
    <x-slot:actions>
        <x-ui.button href="{{ route('admin.questions.create') }}" variant="teal" size="sm">
            Tambah Pertanyaan
        </x-ui.button>
    </x-slot:actions>

    @if($questions->isEmpty())
        <x-ui.empty-state title="Belum ada pertanyaan" description="Buat pertanyaan evaluasi dan hubungkan ke formulir yang tersedia." />
    @else
        <div class="space-y-6">
            <x-ui.table :headers="['Formulir', 'Kategori', 'No', 'Teks Pertanyaan', 'Wajib', 'Aksi']">
                @foreach ($questions as $question)
                    <tr class="hover:bg-zinc-50/50 transition-colors">
                        <td class="px-6 py-4 text-xs font-semibold text-zinc-600 max-w-[150px] truncate">{{ $question->evaluationForm->title }}</td>
                        <td class="whitespace-nowrap px-6 py-4 text-xs font-medium text-zinc-500">{{ $question->category->name }}</td>
                        <td class="whitespace-nowrap px-6 py-4 font-mono text-xs font-bold text-zinc-400">{{ $question->sort_order }}</td>
                        <td class="px-6 py-4 text-sm text-zinc-950 max-w-md truncate">{{ $question->question_text }}</td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm">
                            <x-ui.badge :variant="$question->is_required ? 'teal' : 'zinc'">
                                {{ $question->is_required ? 'Wajib' : 'Opsional' }}
                            </x-ui.badge>
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 text-right">
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
                        </td>
                    </tr>
                @endforeach
            </x-ui.table>

            <div class="mt-8">
                {{ $questions->links() }}
            </div>
        </div>
    @endif
</x-layouts.admin>
