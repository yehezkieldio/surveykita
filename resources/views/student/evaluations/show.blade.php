<x-layouts.student :heading="$form->title" eyebrow="Detail Formulir">
    <div class="grid gap-8 lg:grid-cols-[1fr_20rem]">
        <div class="space-y-8">
            <x-ui.card>
                <div class="prose prose-zinc prose-sm max-w-none">
                    <p class="text-sm leading-relaxed text-zinc-600">
                        {{ $form->description }}
                    </p>
                </div>

                <div class="mt-8 border-t border-zinc-100 pt-8">
                    <h3 class="text-sm font-bold uppercase tracking-[0.2em] text-zinc-400 mb-6">Ringkasan Pertanyaan</h3>
                    
                    <div class="space-y-4">
                        @php
                            $categories = $form->questions->groupBy('category.name');
                        @endphp

                        @foreach ($categories as $categoryName => $questions)
                            <div class="flex items-center justify-between py-2 border-b border-zinc-100">
                                <span class="text-sm font-medium text-zinc-950">{{ $categoryName }}</span>
                                <x-ui.badge>{{ $questions->count() }} Pertanyaan</x-ui.badge>
                            </div>
                        @endforeach

                        <div class="flex items-center justify-between py-4 mt-2">
                            <span class="text-sm font-bold text-zinc-950">Total Pertanyaan</span>
                            <span class="text-sm font-bold text-zinc-950">{{ $form->questions->count() }}</span>
                        </div>
                    </div>
                </div>
            </x-ui.card>

            <div class="flex flex-col sm:flex-row gap-4">
                @if ($form->canBeFilledBy(Auth::user()->student))
                    <x-ui.button href="{{ route('student.evaluations.fill', $form) }}" variant="teal" class="flex-1 sm:flex-none">
                        Mulai Isi Evaluasi
                    </x-ui.button>
                @endif
                <x-ui.button href="{{ route('student.evaluations.index') }}" variant="secondary" class="flex-1 sm:flex-none">
                    Kembali ke Daftar
                </x-ui.button>
            </div>
        </div>

        <aside class="space-y-6">
            <div class="rounded-lg border border-zinc-200 bg-white p-6">
                <h3 class="text-sm font-semibold text-zinc-950">Informasi Periode</h3>
                <div class="mt-4 space-y-4">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-zinc-400">Nama Periode</p>
                        <p class="mt-1 text-sm font-medium text-zinc-950">{{ $form->evaluationPeriod->name }}</p>
                    </div>
                    <div class="pt-4 border-t border-zinc-100">
                        <p class="text-xs font-bold uppercase tracking-wider text-zinc-400">Batas Pengisian</p>
                        <p class="mt-1 text-sm font-medium text-zinc-950">
                            {{ $form->evaluationPeriod->end_date->translatedFormat('d F Y') }}
                        </p>
                    </div>
                </div>
            </div>
        </aside>
    </div>
</x-layouts.student>
