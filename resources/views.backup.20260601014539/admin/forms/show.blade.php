<x-layouts.admin title="Detail Form - SurveyKita" heading="Detail Form Evaluasi">
    <div class="space-y-6">
        <div class="flex justify-between items-center border-b border-zinc-200 pb-5">
            <div>
                <p class="font-mono text-[10px] uppercase tracking-wider text-zinc-400">Rincian Form Evaluasi Akademik</p>
            </div>
            <div class="flex gap-3">
                <x-button variant="secondary" :href="route('admin.forms.index')" class="!min-h-9 !py-1 text-xs">Kembali</x-button>
                <x-button :href="route('admin.forms.edit', $form)" class="!min-h-9 !py-1 text-xs">Edit</x-button>
            </div>
        </div>

        <x-card heading="{{ $form->title }}" subheading="Tersambung ke: {{ $form->evaluationPeriod->name }}">
            @if ($form->description)
                <div class="mt-4 border-b border-zinc-100 pb-6">
                    <p class="font-mono text-[10px] uppercase tracking-wider text-zinc-400">Deskripsi Form</p>
                    <p class="mt-2 text-sm text-zinc-600 leading-relaxed max-w-2xl">{{ $form->description }}</p>
                </div>
            @endif

            <div class="grid gap-6 sm:grid-cols-3 mt-6">
                <div>
                    <p class="font-mono text-[10px] uppercase tracking-wider text-zinc-400">Target Responden</p>
                    <p class="mt-1.5 text-sm font-bold text-zinc-900 uppercase tracking-wide">{{ $form->target_type }}</p>
                </div>
                <div>
                    <p class="font-mono text-[10px] uppercase tracking-wider text-zinc-400">Status Form</p>
                    <div class="mt-1.5">
                        <x-badge :variant="$form->is_active ? 'success' : 'neutral'">
                            {{ $form->is_active ? 'Aktif' : 'Nonaktif' }}
                        </x-badge>
                    </div>
                </div>
                <div>
                    <p class="font-mono text-[10px] uppercase tracking-wider text-zinc-400">Jumlah Tanggapan</p>
                    <p class="mt-1.5 text-sm font-bold text-zinc-900">{{ $form->responses_count }} respons masuk</p>
                </div>
            </div>
        </x-card>
    </div>
</x-layouts.admin>
