<x-layouts.admin title="Pertanyaan Evaluasi - SurveyKita" heading="Pertanyaan Evaluasi">
    <div class="mb-4">
        <x-button :href="route('admin.questions.create')">Tambah Pertanyaan</x-button>
    </div>

    <x-card>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="border-b text-zinc-600">
                    <tr>
                        <th class="py-2">Pertanyaan</th>
                        <th>Form</th>
                        <th>Kategori</th>
                        <th>Urutan</th>
                        <th>Wajib</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse ($questions as $question)
                        <tr>
                            <td class="max-w-md py-3 font-medium text-zinc-950">{{ $question->question_text }}</td>
                            <td>{{ $question->evaluationForm->title }}</td>
                            <td>{{ $question->category->name }}</td>
                            <td>{{ $question->sort_order }}</td>
                            <td>
                                <x-badge variant="{{ $question->is_required ? 'success' : 'neutral' }}">
                                    {{ $question->is_required ? 'Ya' : 'Tidak' }}
                                </x-badge>
                            </td>
                            <td class="text-right">
                                <div class="flex justify-end gap-3">
                                    <a class="font-medium text-teal-700" href="{{ route('admin.questions.edit', $question) }}">Edit</a>
                                    <form method="POST" action="{{ route('admin.questions.destroy', $question) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="font-medium text-red-700" type="submit">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="py-6 text-center text-zinc-500" colspan="6">Belum ada pertanyaan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <x-pagination :paginator="$questions" />
    </x-card>
</x-layouts.admin>
