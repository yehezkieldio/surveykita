<x-layouts.admin heading="Detail Pertanyaan" eyebrow="Instrumen Evaluasi">
    <x-slot:actions>
        <div class="flex items-center justify-end gap-2 flex-wrap sm:flex-nowrap">
            <x-ui.button href="{{ route('admin.questions.index') }}" variant="ghost" size="sm">
                Kembali
            </x-ui.button>
            <x-ui.button href="{{ route('admin.questions.edit', $question) }}" variant="secondary" size="sm">
                Edit Pertanyaan
            </x-ui.button>
            <form action="{{ route('admin.questions.destroy', $question) }}" method="POST" class="inline-flex shrink-0" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pertanyaan ini?');">
                @csrf
                @method('DELETE')
                <x-ui.button variant="danger" size="sm" :disabled="$question->response_answers_count > 0">
                    Hapus
                </x-ui.button>
            </form>
        </div>
    </x-slot:actions>

    <div class="grid gap-8 xl:grid-cols-12">
        <section class="min-w-0 xl:col-span-8">
            <x-ui.card no-padding class="h-full overflow-hidden">
                <div class="border-b border-zinc-100 p-6 xl:p-7">
                    <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-zinc-400">Teks Pertanyaan</p>
                    <p class="mt-3 text-base font-semibold leading-8 tracking-tight text-zinc-950">
                        {{ $question->question_text }}
                    </p>
                </div>
                <div class="grid gap-0 sm:grid-cols-2">
                    <div class="border-b border-zinc-100 p-6 sm:border-r sm:border-b-0 xl:p-7">
                        <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-zinc-400">Formulir</p>
                        <p class="mt-2 text-base font-semibold leading-7 text-zinc-950">{{ $question->evaluationForm->title }}</p>
                    </div>
                    <div class="p-6 xl:p-7">
                        <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-zinc-400">Kategori</p>
                        <p class="mt-2 text-base font-semibold leading-7 text-zinc-950">{{ $question->category->name }}</p>
                    </div>
                </div>
            </x-ui.card>
        </section>

        <aside class="min-w-0 xl:col-span-4">
            <x-ui.card no-padding class="h-full overflow-hidden">
                <div class="border-b border-zinc-100 px-6 py-5 xl:px-7">
                    <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-zinc-400">Ringkasan Butir</p>
                    <p class="mt-2 text-lg font-semibold tracking-tight text-zinc-950">Urutan, kewajiban, dan jejak jawaban</p>
                </div>
                <div class="space-y-4 px-6 py-5 xl:px-7">
                    <div class="flex items-center justify-between gap-4 border-b border-zinc-100 pb-4">
                        <span class="text-xs font-medium text-zinc-500">Urutan</span>
                        <span class="font-mono text-sm font-semibold text-zinc-950">{{ $question->sort_order }}</span>
                    </div>
                    <div class="flex items-center justify-between gap-4 border-b border-zinc-100 pb-4">
                        <span class="text-xs font-medium text-zinc-500">Sifat</span>
                        <x-ui.badge :variant="$question->is_required ? 'teal' : 'zinc'">
                            {{ $question->is_required ? 'WAJIB' : 'OPSIONAL' }}
                        </x-ui.badge>
                    </div>
                    <div class="flex items-center justify-between gap-4">
                        <span class="text-xs font-medium text-zinc-500">Total Jawaban</span>
                        <span class="text-sm font-semibold text-zinc-950">{{ number_format($question->response_answers_count) }}</span>
                    </div>
                </div>
            </x-ui.card>
        </aside>

        <section class="min-w-0 xl:col-span-12">
            <x-ui.card no-padding class="overflow-hidden">
                <div class="grid gap-0 md:grid-cols-3">
                    <div class="border-b border-zinc-100 p-6 md:border-r md:border-b-0 xl:p-7">
                        <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-zinc-400">Periode Evaluasi</p>
                        <p class="mt-2 text-base font-semibold leading-7 text-zinc-950">{{ $question->evaluationForm->evaluationPeriod->name }}</p>
                    </div>
                    <div class="border-b border-zinc-100 p-6 md:border-r md:border-b-0 xl:p-7">
                        <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-zinc-400">Target Formulir</p>
                        <p class="mt-2 text-base font-semibold leading-7 text-zinc-950">{{ $question->evaluationForm->target_type }}</p>
                    </div>
                    <div class="p-6 xl:p-7">
                        <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-zinc-400">Navigasi Lanjutan</p>
                        <div class="mt-3 flex flex-wrap gap-2">
                            <x-ui.button href="{{ route('admin.forms.show', $question->evaluationForm) }}" variant="ghost" size="sm">
                                Detail Formulir
                            </x-ui.button>
                            <x-ui.button href="{{ route('admin.categories.show', $question->category) }}" variant="ghost" size="sm">
                                Detail Kategori
                            </x-ui.button>
                        </div>
                    </div>
                </div>
            </x-ui.card>
        </section>
    </div>
</x-layouts.admin>
