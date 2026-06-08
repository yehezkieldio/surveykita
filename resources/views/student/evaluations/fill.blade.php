<x-layouts.student :heading="$form->title" eyebrow="Pengisian Evaluasi">
    <form method="POST" action="{{ route('student.evaluations.submit', $form) }}" class="space-y-10 sm:space-y-12">
        @csrf

        @php
            $categories = $form->questions->groupBy('category.name');
            $questionNumber = 1;
        @endphp

        <x-ui.error name="form" class="mb-6 p-4 bg-red-50 border border-red-100 rounded-none text-sm text-red-600" />

        @foreach ($categories as $categoryName => $questions)
            <section class="animate-reveal" style="animation-delay: {{ $loop->index * 100 }}ms">
                <div class="mb-5 flex items-center gap-4 sm:mb-6">
                    <h2 class="text-xs font-bold uppercase tracking-[0.2em] text-zinc-400">{{ $categoryName }}</h2>
                    <div class="h-px flex-1 bg-zinc-100"></div>
                </div>

                <div class="space-y-7 sm:space-y-8">
                    @foreach ($questions as $question)
                        <div class="space-y-4">
                            <div class="flex items-start gap-4">
                                <span class="flex h-6 w-6 shrink-0 items-center justify-center font-mono text-xs font-bold text-zinc-400 border border-zinc-200">
                                    {{ str_pad($questionNumber++, 2, '0', STR_PAD_LEFT) }}
                                </span>
                                <p class="text-sm font-medium leading-relaxed text-zinc-950 sm:text-base">
                                    {{ $question->question_text }}
                                    @if($question->is_required)
                                        <span class="text-red-500">*</span>
                                    @endif
                                </p>
                            </div>

                            <div class="pl-0 sm:pl-10">
                                <div class="grid grid-cols-5 gap-1.5 sm:gap-4">
                                    @foreach([
                                        1 => 'Sangat Tidak Puas',
                                        2 => 'Tidak Puas',
                                        3 => 'Cukup Puas',
                                        4 => 'Puas',
                                        5 => 'Sangat Puas'
                                    ] as $value => $label)
                                        <label class="group relative flex cursor-pointer flex-col items-center gap-1.5 sm:gap-2">
                                            <input type="radio"
                                                   name="answers[{{ $question->id }}]"
                                                   value="{{ $value }}"
                                                   class="peer sr-only"
                                                   @required($question->is_required)
                                                   @checked(old("answers.{$question->id}") == $value)>

                                            <div class="flex h-11 w-full items-center justify-center border border-zinc-200 bg-white transition-all group-hover:border-zinc-400 peer-checked:border-teal-600 peer-checked:bg-teal-50 peer-checked:text-teal-700 sm:h-12">
                                                <span class="text-xs font-bold sm:text-sm">{{ $value }}</span>
                                            </div>
                                            <span class="text-center text-[9px] leading-tight text-zinc-500 sm:text-[10px] sm:font-medium">
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

        <section class="animate-reveal border-t border-zinc-200 pt-10 sm:pt-12" style="animation-delay: {{ $categories->count() * 100 }}ms">
            <div class="mb-5 sm:mb-6">
                <h2 class="text-xs font-bold uppercase tracking-[0.2em] text-zinc-400">Saran & Masukan</h2>
            </div>

            <div class="space-y-4">
                <div class="relative">
                    <textarea id="suggestion"
                              name="suggestion"
                              rows="6"
                              placeholder="Tuliskan masukan konstruktif Anda untuk membantu kami meningkatkan kualitas layanan..."
                              class="block w-full resize-none border-zinc-200 bg-white px-4 py-4 text-sm outline-none transition-all focus:border-teal-600 focus:ring-4 focus:ring-teal-500/5">{{ old('suggestion') }}</textarea>
                </div>
                <x-ui.error name="suggestion" />
            </div>

            <div class="mt-10 flex flex-col gap-4 border-t border-zinc-200 pt-6 sm:mt-12 sm:flex-row sm:items-center sm:justify-between sm:gap-6 sm:pt-8">
                <div class="sm:block">
                    <p class="text-xs text-zinc-500 leading-relaxed max-w-sm">
                        Pastikan semua pertanyaan bertanda <span class="text-red-500">*</span> telah diisi sebelum mengirimkan evaluasi.
                    </p>
                </div>
                <div class="flex w-full flex-col gap-3 sm:w-auto sm:flex-row sm:items-center sm:gap-4">
                    <x-ui.button href="{{ route('student.evaluations.show', $form) }}" variant="ghost" class="w-full sm:w-auto">
                        Batal
                    </x-ui.button>
                    <x-ui.button variant="teal" class="w-full px-8 sm:w-auto">
                        Kirim Evaluasi
                    </x-ui.button>
                </div>
            </div>
        </section>
    </form>
</x-layouts.student>
