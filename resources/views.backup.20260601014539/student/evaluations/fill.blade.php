<x-layouts.student title="{{ $form->title }} - SurveyKita" heading="Isi Kuesioner" eyebrow="{{ $form->evaluationPeriod->name }}">
    <div class="space-y-6">
        <div class="border-b border-zinc-200 pb-5">
            <h2 class="text-lg font-bold text-zinc-900 uppercase tracking-tight">{{ $form->title }}</h2>
            <p class="mt-2 text-xs text-zinc-500 leading-relaxed max-w-2xl">
                Keterangan Skala Penilaian: 1 &bull; Sangat Tidak Puas, 2 &bull; Tidak Puas, 3 &bull; Cukup Puas, 4 &bull; Puas, 5 &bull; Sangat Puas.
            </p>
        </div>

        <form method="POST" action="{{ route('student.evaluations.submit', $form) }}" class="space-y-6">
            @csrf

            @foreach ($form->questions as $question)
                <div class="rounded-xl border border-zinc-200 bg-white p-6 shadow-sm transition-all duration-300 hover:border-zinc-300 animate-reveal">
                    <div class="flex items-start gap-4">
                        <span class="font-mono text-xs font-bold text-zinc-500 bg-zinc-100 w-6 h-6 flex items-center justify-center rounded-md">{{ $question->sort_order }}</span>
                        <div class="flex-1">
                            <p class="text-sm font-semibold text-zinc-900 leading-relaxed">{{ $question->question_text }}</p>
                            <p class="mt-1 font-mono text-[9px] uppercase tracking-wider text-zinc-400">Kategori: {{ $question->category->name }}</p>
                        </div>
                    </div>

                    <div class="mt-4 grid gap-3 sm:grid-cols-5">
                        @foreach ([1 => 'Sangat Tidak Puas', 2 => 'Tidak Puas', 3 => 'Cukup Puas', 4 => 'Puas', 5 => 'Sangat Puas'] as $score => $label)
                            <label class="flex items-center gap-3 rounded-md bg-zinc-50 px-4 py-2.5 text-xs text-zinc-700 hover:bg-zinc-100 cursor-pointer transition-all duration-200 select-none">
                                <input 
                                    type="radio" 
                                    name="answers[{{ $question->id }}]" 
                                    value="{{ $score }}" 
                                    @checked((string) old('answers.'.$question->id) === (string) $score)
                                    class="border-zinc-300 text-zinc-900 focus:ring-zinc-900 focus:ring-offset-0"
                                    required
                                >
                                <span class="font-mono font-bold">{{ $score }} <span class="font-sans font-medium text-[10px] text-zinc-400 block sm:inline sm:ml-1">&mdash; {{ $label }}</span></span>
                            </label>
                        @endforeach
                    </div>
                    <x-form-error name="answers.{{ $question->id }}" />
                </div>
            @endforeach

            <div class="rounded-xl border border-zinc-200 bg-white p-6 shadow-sm">
                <div class="grid gap-2">
                    <label for="suggestion" class="font-mono text-[10px] uppercase tracking-wider text-zinc-500 font-bold">Saran atau Umpan Balik Tambahan (Opsional)</label>
                    <textarea 
                        id="suggestion"
                        name="suggestion" 
                        rows="4" 
                        class="mt-1 block w-full"
                        placeholder="Tuliskan saran atau komentar konstruktif Anda di sini..."
                    >{{ old('suggestion') }}</textarea>
                    <x-form-error name="suggestion" />
                </div>
            </div>

            <x-form-error name="form" />

            <div class="flex gap-4">
                <x-button type="submit">Kirim Evaluasi</x-button>
                <x-button variant="secondary" :href="route('student.evaluations.index')">Batal</x-button>
            </div>
        </form>
    </div>
</x-layouts.student>
