<x-layouts.student title="{{ $form->title }} - SurveyKita" heading="Isi Kuesioner" eyebrow="{{ $form->evaluationPeriod->name }}">
    <section class="mb-8 grid gap-px border border-zinc-200 bg-zinc-200 lg:grid-cols-[minmax(0,1fr)_20rem]">
        <div class="bg-white p-6 sm:p-8">
            <h2 class="font-display text-4xl font-semibold leading-none tracking-[-0.06em]">{{ $form->title }}</h2>
            <p class="mt-5 max-w-3xl text-sm leading-6 text-zinc-600">Pilih satu nilai untuk setiap pertanyaan. Skala bergerak dari sangat tidak puas sampai sangat puas.</p>
        </div>
        <div class="bg-zinc-50 p-6">
            <p class="text-xs font-medium text-zinc-500">Skala</p>
            <div class="mt-4 grid gap-2 text-sm text-zinc-700">
                <p><span class="font-mono font-semibold text-zinc-950">1</span> Sangat Tidak Puas</p>
                <p><span class="font-mono font-semibold text-zinc-950">3</span> Cukup Puas</p>
                <p><span class="font-mono font-semibold text-zinc-950">5</span> Sangat Puas</p>
            </div>
        </div>
    </section>

    <form method="POST" action="{{ route('student.evaluations.submit', $form) }}" class="grid gap-5">
        @csrf
        @foreach ($form->questions as $question)
            <section class="border border-zinc-200 bg-white">
                <div class="grid gap-px bg-zinc-200 lg:grid-cols-[minmax(0,1fr)_28rem]">
                    <div class="bg-white p-5">
                        <div class="flex gap-4">
                            <span class="font-mono text-sm text-zinc-500">{{ $question->sort_order }}</span>
                            <div>
                                <p class="font-medium leading-6 text-zinc-950">{{ $question->question_text }}</p>
                                <p class="mt-2 text-sm text-zinc-500">{{ $question->category->name }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-5 gap-px bg-zinc-200">
                        @foreach ([1 => 'Sangat Tidak Puas', 2 => 'Tidak Puas', 3 => 'Cukup Puas', 4 => 'Puas', 5 => 'Sangat Puas'] as $score => $label)
                            <label class="group flex min-h-24 cursor-pointer flex-col justify-between bg-white p-3 text-sm transition-colors hover:bg-zinc-50">
                                <input type="radio" name="answers[{{ $question->id }}]" value="{{ $score }}" @checked((string) old('answers.'.$question->id) === (string) $score) required class="sr-only peer">
                                <span class="font-display text-3xl font-semibold leading-none tracking-[-0.06em] text-zinc-400 peer-checked:text-zinc-950">{{ $score }}</span>
                                <span class="text-xs leading-4 text-zinc-500 peer-checked:font-semibold peer-checked:text-zinc-950">{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
                <x-form-error name="answers.{{ $question->id }}" class="px-5 pb-5" />
            </section>
        @endforeach

        <section class="border border-zinc-200 bg-white p-5">
            <div class="sk-field">
                <label for="suggestion" class="sk-label">Saran atau Umpan Balik Tambahan (Opsional)</label>
                <textarea id="suggestion" name="suggestion" rows="4" placeholder="Tuliskan saran atau komentar konstruktif Anda di sini.">{{ old('suggestion') }}</textarea>
                <x-form-error name="suggestion" />
            </div>
        </section>

        <x-form-error name="form" />
        <div class="sk-actions sticky bottom-0 bg-zinc-50 py-4">
            <x-button type="submit">Kirim Evaluasi</x-button>
            <x-button variant="secondary" :href="route('student.evaluations.index')">Batal</x-button>
        </div>
    </form>
</x-layouts.student>
