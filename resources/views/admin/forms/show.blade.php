<x-layouts.admin heading="{{ $form->title }}" eyebrow="Detail Formulir">
    <x-slot:actions>
        <x-ui.button href="{{ route('admin.forms.edit', $form) }}" variant="secondary" size="sm">
            Edit Formulir
        </x-ui.button>
        <form action="{{ route('admin.forms.destroy', $form) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus formulir ini?');">
            @csrf
            @method('DELETE')
            <x-ui.button variant="danger" size="sm" :disabled="$form->responses_count > 0 || $form->questions->isNotEmpty()">
                Hapus
            </x-ui.button>
        </form>
    </x-slot:actions>

    <div class="grid gap-8 lg:grid-cols-[1fr_20rem]">
        <div class="space-y-8">
            <section>
                <h3 class="mb-4 text-sm font-bold uppercase tracking-[0.2em] text-zinc-400">Informasi Formulir</h3>
                <x-ui.card>
                    <div class="prose prose-zinc prose-sm max-w-none">
                        <p class="text-sm leading-relaxed text-zinc-600">
                            {{ $form->description }}
                        </p>
                    </div>

                    <div class="mt-8 grid divide-y divide-zinc-100 border-t border-zinc-100 sm:grid-cols-2 sm:divide-x sm:divide-y-0">
                        <div class="py-4 sm:pr-4">
                            <p class="text-xs font-medium text-zinc-500">Periode</p>
                            <p class="mt-1 text-sm font-semibold text-zinc-950">{{ $form->evaluationPeriod->name }}</p>
                        </div>
                        <div class="py-4 sm:pl-4">
                            <p class="text-xs font-medium text-zinc-500">Target</p>
                            <p class="mt-1 text-sm font-semibold text-zinc-950">{{ $form->target_type }}</p>
                        </div>
                    </div>
                </x-ui.card>
            </section>

            <section>
                <div class="mb-4 flex items-center justify-between">
                    <h3 class="text-sm font-bold uppercase tracking-[0.2em] text-zinc-400">Instrumen Pertanyaan</h3>
                    <x-ui.button href="{{ route('admin.questions.create', ['evaluation_form_id' => $form->id]) }}" variant="teal" size="sm">
                        Tambah Pertanyaan
                    </x-ui.button>
                </div>
                
                @if($form->questions->isEmpty())
                    <x-ui.empty-state title="Belum ada pertanyaan" description="Formulir ini belum memiliki instrumen pertanyaan evaluasi." />
                @else
                    @foreach ($form->questions->groupBy('category.name') as $categoryName => $questions)
                        <div class="mb-8 last:mb-0">
                            <div class="mb-4 flex items-center gap-4">
                                <h4 class="text-xs font-bold uppercase tracking-widest text-zinc-400">{{ $categoryName }}</h4>
                                <div class="h-px flex-1 bg-zinc-100"></div>
                            </div>
                            <x-ui.table :headers="['No', 'Pertanyaan', 'Wajib', 'Aksi']">
                                @foreach ($questions->sortBy('sort_order') as $question)
                                    <tr>
                                        <td class="whitespace-nowrap px-6 py-4 font-mono text-xs font-bold text-zinc-400">{{ $question->sort_order }}</td>
                                        <td class="px-6 py-4 text-sm text-zinc-950">{{ $question->question_text }}</td>
                                        <td class="whitespace-nowrap px-6 py-4 text-sm">
                                            <x-ui.badge :variant="$question->is_required ? 'teal' : 'zinc'">
                                                {{ $question->is_required ? 'Wajib' : 'Opsional' }}
                                            </x-ui.badge>
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4 text-right">
                                            <div class="flex justify-end gap-2">
                                                <x-ui.button href="{{ route('admin.questions.edit', $question) }}" variant="ghost" size="sm">Edit</x-ui.button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </x-ui.table>
                        </div>
                    @endforeach
                @endif
            </section>
        </div>

        <aside class="space-y-6">
            <div class="rounded-lg border border-zinc-200 bg-white p-6">
                <h3 class="text-sm font-semibold text-zinc-950">Statistik Respons</h3>
                <div class="mt-4 space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-medium text-zinc-500">Status</span>
                        <x-ui.badge :variant="$form->is_active ? 'teal' : 'zinc'">
                            {{ $form->is_active ? 'AKTIF' : 'NONAKTIF' }}
                        </x-ui.badge>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-medium text-zinc-500">Total Respons</span>
                        <span class="text-sm font-bold text-teal-600">{{ number_format($form->responses_count) }}</span>
                    </div>
                </div>
            </div>

            @if($form->responses_count > 0 || $form->questions->isNotEmpty())
                <div class="p-4 bg-amber-50 border border-amber-100 text-xs text-amber-800 leading-relaxed">
                    <strong>Catatan:</strong> Formulir tidak dapat dihapus karena telah memiliki instrumen pertanyaan atau data respons.
                </div>
            @endif
        </aside>
    </div>
</x-layouts.admin>
