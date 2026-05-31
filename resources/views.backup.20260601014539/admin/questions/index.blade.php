<x-layouts.admin title="Pertanyaan Evaluasi - SurveyKita" heading="Pertanyaan Evaluasi">
    <div class="mb-6 flex justify-between items-center border-b border-zinc-200 pb-5">
        <div>
            <p class="font-mono text-[10px] uppercase tracking-wider text-zinc-400">Pengelolaan Butir Pertanyaan Likert</p>
        </div>
        <x-button :href="route('admin.questions.create')" class="!min-h-9 !py-1 text-xs">Tambah Pertanyaan</x-button>
    </div>

    <x-table :headers="['Butir Pertanyaan', 'Form Evaluasi', 'Kategori', 'Urutan', 'Status Wajib', 'Aksi']">
        @forelse ($questions as $question)
            <tr class="hover:bg-zinc-50/50 transition-colors duration-150">
                <td class="px-6 py-4 font-bold text-zinc-900 max-w-md leading-relaxed">{{ $question->question_text }}</td>
                <td class="px-6 py-4 text-zinc-500 text-[11px] font-mono">{{ $question->evaluationForm->title }}</td>
                <td class="px-6 py-4 text-zinc-500 text-[11px] font-mono">{{ $question->category->name }}</td>
                <td class="px-6 py-4 font-mono text-zinc-500 font-bold">{{ $question->sort_order }}</td>
                <td class="px-6 py-4">
                    <x-badge :variant="$question->is_required ? 'success' : 'neutral'">
                        {{ $question->is_required ? 'Wajib' : 'Opsional' }}
                    </x-badge>
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center gap-4 text-[10px] font-mono uppercase tracking-wider">
                        <a class="font-bold text-zinc-900 hover:underline" href="{{ route('admin.questions.edit', $question) }}">Edit</a>
                        <form method="POST" action="{{ route('admin.questions.destroy', $question) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pertanyaan ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="font-bold text-red-700 hover:underline" type="submit">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td class="px-6 py-12 text-center" colspan="6">
                    <x-empty-state title="Belum ada pertanyaan" description="Tambahkan instrumen pertanyaan Likert untuk dimasukkan ke dalam form evaluasi." />
                </td>
            </tr>
        @endforelse
    </x-table>

    <x-pagination :paginator="$questions" />
</x-layouts.admin>
