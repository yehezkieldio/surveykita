<x-layouts.admin heading="{{ $form->title }}" eyebrow="Detail Formulir">
    <x-slot:actions>
        <div class="flex w-full flex-col gap-2 sm:w-auto sm:flex-row sm:flex-wrap sm:items-center sm:justify-end sm:gap-2 sm:flex-nowrap">
            <x-ui.button href="{{ route('admin.forms.index') }}" variant="ghost" size="sm" class="w-full sm:w-auto">
                Kembali
            </x-ui.button>
            <x-ui.button href="{{ route('admin.forms.edit', $form) }}" variant="secondary" size="sm" class="w-full sm:w-auto">
                Edit Formulir
            </x-ui.button>
            <form action="{{ route('admin.forms.destroy', $form) }}" method="POST" class="inline-flex w-full shrink-0 sm:w-auto" onsubmit="return confirm('Apakah Anda yakin ingin menghapus formulir ini?');">
                @csrf
                @method('DELETE')
                <x-ui.button variant="danger" size="sm" class="w-full sm:w-auto">
                    Hapus
                </x-ui.button>
            </form>
        </div>
    </x-slot:actions>

    <div class="grid gap-6 xl:grid-cols-12 xl:gap-8">
        <section class="min-w-0 xl:col-span-8">
            <x-ui.card no-padding class="h-full overflow-hidden">
                <div class="border-b border-zinc-100 p-6 xl:p-7">
                    <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-zinc-400">Deskripsi Formulir</p>
                    <p class="mt-3 text-sm leading-7 text-zinc-600">{{ $form->description }}</p>
                </div>
                <div class="grid gap-0 sm:grid-cols-2">
                    <div class="border-b border-zinc-100 p-6 sm:border-r sm:border-b-0 xl:p-7">
                        <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-zinc-400">Periode</p>
                        <p class="mt-2 text-base font-semibold leading-7 text-zinc-950">{{ $form->evaluationPeriod->name }}</p>
                    </div>
                    <div class="p-6 xl:p-7">
                        <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-zinc-400">Target</p>
                        <p class="mt-2 text-base font-semibold leading-7 text-zinc-950">{{ $form->target_type }}</p>
                    </div>
                </div>
            </x-ui.card>
        </section>

        <aside class="min-w-0 xl:col-span-4">
            <x-ui.card no-padding class="h-full overflow-hidden">
                <div class="border-b border-zinc-100 px-6 py-5 xl:px-7">
                    <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-zinc-400">Status Formulir</p>
                    <p class="mt-2 text-lg font-semibold tracking-tight text-zinc-950">Publikasi, partisipasi, dan beban instrumen</p>
                </div>
                <div class="space-y-4 px-6 py-5 xl:px-7">
                    <div class="flex items-center justify-between gap-4 border-b border-zinc-100 pb-4">
                        <span class="text-xs font-medium text-zinc-500">Status</span>
                        <x-ui.badge :variant="$form->is_active ? 'teal' : 'zinc'">
                            {{ $form->is_active ? 'AKTIF' : 'NONAKTIF' }}
                        </x-ui.badge>
                    </div>
                    <div class="flex items-center justify-between gap-4 border-b border-zinc-100 pb-4">
                        <span class="text-xs font-medium text-zinc-500">Total Respons</span>
                        <span class="text-sm font-semibold text-zinc-950">{{ number_format($form->responses_count) }}</span>
                    </div>
                    <div class="flex items-center justify-between gap-4">
                        <span class="text-xs font-medium text-zinc-500">Jumlah Pertanyaan</span>
                        <span class="text-sm font-semibold text-zinc-950">{{ $form->questions->count() }}</span>
                    </div>
                </div>
            </x-ui.card>
        </aside>

        <section class="min-w-0 xl:col-span-12">
            <div class="mb-4 grid gap-3 lg:grid-cols-[minmax(0,1fr)_auto] lg:items-start">
                <div>
                    <h3 class="text-sm font-bold uppercase tracking-[0.18em] text-zinc-400">Instrumen Pertanyaan</h3>
                    <p class="mt-1 text-sm leading-6 text-zinc-500">Susunan butir evaluasi dibentangkan penuh agar relasi antar kategori, urutan, dan kewajiban pertanyaan lebih cepat dipindai.</p>
                </div>
                <div class="flex flex-col gap-2 sm:flex-row sm:flex-wrap sm:items-center lg:justify-end">
                    <x-ui.badge variant="zinc">{{ $form->questions->count() }} Butir</x-ui.badge>
                    <x-ui.button href="{{ route('admin.questions.create', ['evaluation_form_id' => $form->id]) }}" variant="teal" size="sm" class="w-full sm:w-auto">
                        Tambah Pertanyaan
                    </x-ui.button>
                </div>
            </div>

            @if($form->questions->isEmpty())
                <x-ui.empty-state title="Belum ada pertanyaan" description="Formulir ini belum memiliki instrumen pertanyaan evaluasi." />
            @else
                @foreach ($form->questions->groupBy('category.name') as $categoryName => $questions)
                    <div class="mb-8 last:mb-0">
                        <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:flex-wrap sm:items-center sm:justify-between">
                            <div>
                                <h4 class="text-sm font-semibold tracking-tight text-zinc-950">{{ $categoryName }}</h4>
                                <p class="mt-1 text-sm text-zinc-500">{{ $questions->count() }} butir terhubung ke kategori ini.</p>
                            </div>
                            <x-ui.badge variant="zinc">{{ $questions->count() }} Butir</x-ui.badge>
                        </div>
                        <div class="space-y-4 md:hidden">
                            @foreach ($questions->sortBy('sort_order') as $question)
                                <x-ui.card class="p-5">
                                    <div class="space-y-4">
                                        <div class="flex items-start justify-between gap-4">
                                            <span class="shrink-0 font-mono text-xs font-bold text-zinc-400">{{ $question->sort_order }}</span>
                                            <x-ui.badge :variant="$question->is_required ? 'teal' : 'zinc'">
                                                {{ $question->is_required ? 'Wajib' : 'Opsional' }}
                                            </x-ui.badge>
                                        </div>
                                        <p class="text-sm leading-6 text-zinc-950">{{ $question->question_text }}</p>
                                        <x-ui.button href="{{ route('admin.questions.show', $question) }}" variant="ghost" size="sm" class="w-full">Detail</x-ui.button>
                                    </div>
                                </x-ui.card>
                            @endforeach
                        </div>

                        <div class="hidden md:block">
                            <x-ui.table :headers="['Urutan', 'Pertanyaan', 'Wajib', 'Aksi']">
                                @foreach ($questions->sortBy('sort_order') as $question)
                                    <tr>
                                        <td class="whitespace-nowrap px-5 py-5 align-top font-mono text-xs font-bold text-zinc-400">
                                            {{ $question->sort_order }}
                                        </td>
                                        <td class="min-w-[24rem] whitespace-normal px-5 py-5 align-top text-sm leading-7 text-zinc-950">
                                            {{ $question->question_text }}
                                        </td>
                                        <td class="whitespace-nowrap px-5 py-5 align-top text-sm">
                                            <x-ui.badge :variant="$question->is_required ? 'teal' : 'zinc'">
                                                {{ $question->is_required ? 'Wajib' : 'Opsional' }}
                                            </x-ui.badge>
                                        </td>
                                        <td class="whitespace-nowrap px-5 py-5 align-top text-right">
                                            <x-ui.button href="{{ route('admin.questions.show', $question) }}" variant="ghost" size="sm">
                                                Detail
                                            </x-ui.button>
                                        </td>
                                    </tr>
                                @endforeach
                            </x-ui.table>
                        </div>
                    </div>
                @endforeach
            @endif
        </section>
    </div>
</x-layouts.admin>
