<x-layouts.student title="{{ $form->title }} - SurveyKita" heading="{{ $form->title }}">
    <x-card heading="Form Evaluasi" subheading="{{ $form->evaluationPeriod->name }}">
        <p class="text-sm text-zinc-700">{{ $form->description }}</p>

        <div class="mt-4 space-y-3">
            @forelse ($form->questions as $question)
                <div class="rounded-md border border-zinc-200 p-3 text-sm">
                    <p class="font-medium text-zinc-950">{{ $question->sort_order }}. {{ $question->question_text }}</p>
                    <p class="mt-1 text-zinc-500">{{ $question->category->name }} · {{ $question->is_required ? 'Wajib' : 'Opsional' }}</p>
                </div>
            @empty
                <x-empty-state title="Pertanyaan belum tersedia" description="Admin belum menambahkan pertanyaan pada form ini." />
            @endforelse
        </div>
    </x-card>
</x-layouts.student>
