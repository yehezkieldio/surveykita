<x-layouts.admin title="Pertanyaan Evaluasi - SurveyKita" heading="Pertanyaan Evaluasi">
    <x-table title="Bank Pertanyaan" description="Butir pertanyaan Likert dan keterkaitannya dengan form serta kategori." :count="$questions->total()" :headers="['Pertanyaan', 'Form', 'Kategori', 'Urutan', 'Status', 'Aksi']">
        <x-slot:toolbar><x-button :href="route('admin.questions.create')">Tambah Pertanyaan</x-button></x-slot:toolbar>
        @forelse ($questions as $question)
            <tr class="hover:bg-zinc-50">
                <td class="min-w-96 px-4 py-3 font-medium leading-6">{{ $question->question_text }}</td>
                <td class="min-w-64 px-4 py-3 text-zinc-600">{{ $question->evaluationForm->title }}</td>
                <td class="whitespace-nowrap px-4 py-3 text-zinc-600">{{ $question->category->name }}</td>
                <td class="px-4 py-3 text-right font-mono text-sm text-zinc-700">{{ $question->sort_order }}</td>
                <td class="px-4 py-3"><x-badge :variant="$question->is_required ? 'success' : 'neutral'">{{ $question->is_required ? 'Wajib' : 'Opsional' }}</x-badge></td>
                <td class="px-4 py-3"><div class="flex justify-end gap-3"><a class="sk-link" href="{{ route('admin.questions.edit', $question) }}">Edit</a><form method="POST" action="{{ route('admin.questions.destroy', $question) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pertanyaan ini?')">@csrf @method('DELETE')<button class="sk-danger-link" type="submit">Hapus</button></form></div></td>
            </tr>
        @empty
            <tr><td class="px-4 py-10" colspan="6"><x-empty-state title="Belum ada pertanyaan" description="Tambahkan instrumen pertanyaan Likert untuk dimasukkan ke dalam form evaluasi." /></td></tr>
        @endforelse
        <x-slot:footer><x-pagination :paginator="$questions" /></x-slot:footer>
    </x-table>
</x-layouts.admin>
