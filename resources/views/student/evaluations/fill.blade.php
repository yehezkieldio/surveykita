<x-layouts.student title="{{ $form->title }} - SurveyKita" heading="{{ $form->title }}">
    <x-card heading="Skala Likert" subheading="1 Sangat Tidak Puas, 5 Sangat Puas">
        <form method="POST" action="{{ route('student.evaluations.submit', $form) }}" class="space-y-5">
            @csrf

            @foreach ($form->questions as $question)
                <fieldset class="rounded-md border border-zinc-200 p-4">
                    <legend class="text-sm font-semibold text-zinc-950">{{ $question->sort_order }}. {{ $question->question_text }}</legend>
                    <p class="mt-1 text-xs text-zinc-500">{{ $question->category->name }}</p>
                    <div class="mt-3 grid gap-2 sm:grid-cols-5">
                        @foreach ([1 => 'Sangat Tidak Puas', 2 => 'Tidak Puas', 3 => 'Cukup Puas', 4 => 'Puas', 5 => 'Sangat Puas'] as $score => $label)
                            <label class="flex items-center gap-2 rounded-md border border-zinc-200 px-3 py-2 text-sm">
                                <input type="radio" name="answers[{{ $question->id }}]" value="{{ $score }}" @checked((string) old('answers.'.$question->id) === (string) $score)>
                                <span>{{ $score }} - {{ $label }}</span>
                            </label>
                        @endforeach
                    </div>
                    <x-form-error name="answers.{{ $question->id }}" />
                </fieldset>
            @endforeach

            <label class="grid gap-1 text-sm">
                <span class="font-medium">Saran atau komentar</span>
                <textarea name="suggestion" class="rounded-md border-zinc-300">{{ old('suggestion') }}</textarea>
                <x-form-error name="suggestion" />
            </label>

            <x-form-error name="form" />
            <x-button type="submit">Kirim Evaluasi</x-button>
        </form>
    </x-card>
</x-layouts.student>
