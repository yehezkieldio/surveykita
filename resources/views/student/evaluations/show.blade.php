<x-layouts.student title="{{ $form->title }} - SurveyKita" heading="Pratinjau Kuesioner" eyebrow="{{ $form->evaluationPeriod->name }}">
    <section class="border border-zinc-200 bg-white">
        <div class="grid gap-px bg-zinc-200 lg:grid-cols-[minmax(0,1fr)_18rem]">
            <div class="bg-white p-6 sm:p-8">
                <x-badge :variant="$form->submitted ? 'success' : 'neutral'">{{ $form->submitted ? 'Respons sudah terkirim' : 'Siap diisi' }}</x-badge>
                <h2 class="mt-5 font-display text-4xl font-semibold leading-none tracking-[-0.06em] text-zinc-950">{{ $form->title }}</h2>
                @if ($form->description)
                    <p class="mt-5 max-w-3xl text-sm leading-6 text-zinc-600">{{ $form->description }}</p>
                @endif
            </div>
            <div class="bg-zinc-50 p-6">
                <p class="text-xs font-medium text-zinc-500">Target Responden</p>
                <p class="mt-2 text-sm font-semibold">{{ ucwords(str_replace('_', ' ', $form->target_type)) }}</p>
                <div class="mt-6 grid gap-2">
                    <x-button variant="secondary" :href="route('student.evaluations.index')">Kembali</x-button>
                    @if (!$form->submitted)
                        <x-button :href="route('student.evaluations.fill', $form)">Mulai Isi</x-button>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <section class="mt-8">
        <div class="mb-4 flex items-end justify-between border-b border-zinc-200 pb-4">
            <h2 class="font-display text-3xl font-semibold tracking-[-0.06em]">Pertanyaan</h2>
            <p class="text-sm text-zinc-500">{{ $form->questions->count() }} butir</p>
        </div>

        <div class="grid gap-px border border-zinc-200 bg-zinc-200">
            @forelse ($form->questions as $question)
                <div class="grid bg-white p-5 sm:grid-cols-[3rem_minmax(0,1fr)] sm:gap-5">
                    <span class="font-mono text-sm text-zinc-500">{{ $question->sort_order }}</span>
                    <div>
                        <p class="font-medium leading-6 text-zinc-950">{{ $question->question_text }}</p>
                        <p class="mt-2 text-sm text-zinc-500">{{ $question->category->name }}. {{ $question->is_required ? 'Wajib' : 'Opsional' }}</p>
                    </div>
                </div>
            @empty
                <div class="bg-white p-6"><x-empty-state title="Pertanyaan belum tersedia" description="Admin belum menambahkan butir pertanyaan pada form kuesioner ini." /></div>
            @endforelse
        </div>
    </section>
</x-layouts.student>
