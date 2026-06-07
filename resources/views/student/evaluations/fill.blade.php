<x-layouts.student :heading="$form->title" eyebrow="Pengisian Evaluasi">
    <form method="POST" action="{{ route('student.evaluations.submit', $form) }}" class="space-y-12">
        @csrf

        @php
            $categories = $form->questions->groupBy('category.name');
            $questionNumber = 1;
        @endphp

        <x-ui.error name="form" class="mb-6 p-4 bg-red-50 border border-red-100 rounded-none text-sm text-red-600" />

        @foreach ($categories as $categoryName => $questions)
            <section class="animate-reveal" style="animation-delay: {{ $loop->index * 100 }}ms">
                <div class="mb-6 flex items-center gap-4">
                    <h2 class="text-xs font-bold uppercase tracking-[0.2em] text-zinc-400">{{ $categoryName }}</h2>
                    <div class="h-px flex-1 bg-zinc-100"></div>
                </div>

                <div class="space-y-8">
                    @foreach ($questions as $question)
                        <div class="space-y-4">
                            <div class="flex items-start gap-4">
                                <span class="flex h-6 w-6 shrink-0 items-center justify-center font-mono text-xs font-bold text-zinc-400 border border-zinc-200">
                                    {{ str_pad($questionNumber++, 2, '0', STR_PAD_LEFT) }}
                                </span>
                                <p class="text-base font-medium leading-relaxed text-zinc-950">
                                    {{ $question->question_text }}
                                    @if($question->is_required)
                                        <span class="text-red-500">*</span>
                                    @endif
                                </p>
                            </div>

                            <div class="pl-10">
                                <div class="grid grid-cols-5 gap-2 sm:gap-4">
                                    @foreach([
                                        1 => 'Sangat Tidak Puas',
                                        2 => 'Tidak Puas',
                                        3 => 'Cukup Puas',
                                        4 => 'Puas',
                                        5 => 'Sangat Puas'
                                    ] as $value => $label)
                                        <label class="group relative flex cursor-pointer flex-col items-center gap-2">
                                            <input type="radio" 
                                                   name="answers[{{ $question->id }}]" 
                                                   value="{{ $value }}" 
                                                   class="peer sr-only"
                                                   @required($question->is_required)
                                                   @checked(old("answers.{$question->id}") == $value)>
                                            
                                            <div class="flex h-12 w-full items-center justify-center border border-zinc-200 bg-white transition-all group-hover:border-zinc-400 peer-checked:border-teal-600 peer-checked:bg-teal-50 peer-checked:text-teal-700">
                                                <span class="text-sm font-bold">{{ $value }}</span>
                                            </div>
                                            <span class="hidden text-center text-[10px] font-medium leading-tight text-zinc-500 sm:block">
                                                {{ $label }}
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                                <x-ui.error name="answers.{{ $question->id }}" />
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endforeach

        <section class="animate-reveal border-t border-zinc-200 pt-12" style="animation-delay: {{ $categories->count() * 100 }}ms">
            <div class="mb-6">
                <h2 class="text-xs font-bold uppercase tracking-[0.2em] text-zinc-400">Saran & Masukan</h2>
            </div>
            
            <x-ui.card>
                <div class="space-y-1.5">
                    <label for="suggestion" class="text-xs font-bold uppercase tracking-wider text-zinc-500">Saran untuk Program Studi / Institusi (Opsional)</label>
                    <textarea id="suggestion" 
                              name="suggestion" 
                              rows="5" 
                              placeholder="Tuliskan saran atau masukan Anda di sini..."
                              class="block w-full border-zinc-300 bg-white px-3 py-2 text-sm focus:border-zinc-950 focus:ring-0">{{ old('suggestion') }}</textarea>
                    <x-ui.error name="suggestion" />
                </div>
            </x-ui.card>

            <div class="mt-12 flex items-center justify-between gap-6 border-t border-zinc-200 pt-8">
                <div class="hidden sm:block">
                    <p class="text-xs text-zinc-500 leading-relaxed max-w-sm">
                        Pastikan semua pertanyaan bertanda <span class="text-red-500">*</span> telah diisi sebelum mengirimkan evaluasi.
                    </p>
                </div>
                <div class="flex items-center gap-4 w-full sm:w-auto">
                    <x-ui.button href="{{ route('student.evaluations.show', $form) }}" variant="ghost" class="flex-1 sm:flex-none">
                        Batal
                    </x-ui.button>
                    <x-ui.button variant="teal" class="flex-1 sm:flex-none px-8">
                        Kirim Evaluasi
                    </x-ui.button>
                </div>
            </div>
        </section>
    </form>
</x-layouts.student>
