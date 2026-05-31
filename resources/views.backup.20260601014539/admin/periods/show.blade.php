<x-layouts.admin title="Detail Periode - SurveyKita" heading="Detail Periode">
    <div class="space-y-6">
        <div class="flex justify-between items-center border-b border-zinc-200 pb-5">
            <div>
                <p class="font-mono text-[10px] uppercase tracking-wider text-zinc-400">Rincian Periode Evaluasi Akademik</p>
            </div>
            <div class="flex gap-3">
                <x-button variant="secondary" :href="route('admin.periods.index')" class="!min-h-9 !py-1 text-xs">Kembali</x-button>
                <x-button :href="route('admin.periods.edit', $period)" class="!min-h-9 !py-1 text-xs">Edit</x-button>
            </div>
        </div>

        <x-card heading="{{ $period->name }}" subheading="Semester {{ $period->semester }} &bull; Tahun Akademik {{ $period->academic_year }}">
            <div class="grid gap-6 sm:grid-cols-3 mt-2">
                <div>
                    <p class="font-mono text-[10px] uppercase tracking-wider text-zinc-400">Tanggal Mulai & Selesai</p>
                    <p class="mt-1.5 text-sm font-bold text-zinc-900">{{ $period->start_date->format('d M Y') }} &mdash; {{ $period->end_date->format('d M Y') }}</p>
                </div>
                <div>
                    <p class="font-mono text-[10px] uppercase tracking-wider text-zinc-400">Status Publikasi</p>
                    <div class="mt-1.5">
                        <x-badge :variant="$period->is_active ? 'success' : 'neutral'">
                            {{ $period->is_active ? 'Aktif' : 'Nonaktif' }}
                        </x-badge>
                    </div>
                </div>
                <div>
                    <p class="font-mono text-[10px] uppercase tracking-wider text-zinc-400">Form Evaluasi</p>
                    <p class="mt-1.5 text-sm font-bold text-zinc-900">{{ $period->evaluation_forms_count }} form terkait</p>
                </div>
            </div>
        </x-card>
    </div>
</x-layouts.admin>
