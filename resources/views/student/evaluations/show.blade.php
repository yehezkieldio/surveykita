<x-layouts.student title="{{ $form->title }} - SurveyKita" heading="Pratinjau Kuesioner" eyebrow="{{ $form->evaluationPeriod->name }}">
    <div class="space-y-6">
        <x-card heading="{{ $form->title }}" subheading="Target Responden: {{ ucwords(str_replace('_', ' ', $form->target_type)) }}">
            @if ($form->description)
                <p class="text-xs text-zinc-500 leading-relaxed border-b border-zinc-100 pb-4 mb-4">{{ $form->description }}</p>
            @endif

            <div class="flex items-center justify-between">
                <div class="flex gap-2">
                    <x-button variant="secondary" :href="route('student.evaluations.index')" class="!min-h-9 !py-1 text-xs">Kembali</x-button>
                    @if (!$form->submitted)
                        <x-button :href="route('student.evaluations.fill', $form)" class="!min-h-9 !py-1 text-xs">Mulai Isi Evaluasi</x-button>
                    @else
                        <x-badge variant="success">Sudah Mengirim Respons</x-badge>
                    @endif
                </div>
            </div>
        </x-card>

        <div class="space-y-4">
            <h3 class="font-mono text-[10px] uppercase tracking-wider text-zinc-400 font-bold px-2">Daftar Pertanyaan ({{ $form->questions->count() }})</h3>
            
            @forelse ($form->questions as $question)
                <div class="rounded-xl border border-zinc-200 p-5 bg-white shadow-sm transition-all duration-300 hover:border-zinc-300 flex items-start gap-4 animate-reveal">
                    <span class="font-mono text-xs font-bold text-zinc-500 bg-zinc-100 w-6 h-6 flex items-center justify-center rounded-md">{{ $question->sort_order }}</span>
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-zinc-900 leading-relaxed">{{ $question->question_text }}</p>
                        <div class="mt-2 flex items-center gap-3 text-[9px] font-mono uppercase tracking-wider text-zinc-400">
                            <span>Kategori: {{ $question->category->name }}</span>
                            <span>&bull;</span>
                            <span class="{{ $question->is_required ? 'text-[#9F2F2D]' : 'text-zinc-400' }}">{{ $question->is_required ? 'Wajib' : 'Opsional' }}</span>
                        </div>
                    </div>
                </div>
            @empty
                <x-empty-state title="Pertanyaan belum tersedia" description="Admin belum menambahkan butir pertanyaan pada form kuesioner ini." />
            @endforelse
        </div>
    </div>
</x-layouts.student>
