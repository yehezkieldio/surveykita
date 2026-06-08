<x-layouts.admin heading="{{ $period->name }}" eyebrow="Detail Periode">
    <x-slot:actions>
        <div class="flex w-full flex-col gap-2 sm:w-auto sm:flex-row sm:flex-wrap sm:items-center sm:justify-end sm:gap-2 sm:flex-nowrap">
            <x-ui.button href="{{ route('admin.periods.index') }}" variant="ghost" size="sm" class="w-full sm:w-auto">
                Kembali
            </x-ui.button>
            <x-ui.button href="{{ route('admin.periods.edit', $period) }}" variant="secondary" size="sm" class="w-full sm:w-auto">
                Edit Periode
            </x-ui.button>
            <form action="{{ route('admin.periods.destroy', $period) }}" method="POST" class="inline-flex w-full shrink-0 sm:w-auto" onsubmit="return confirm('Apakah Anda yakin ingin menghapus periode ini?');">
                @csrf
                @method('DELETE')
                <x-ui.button variant="danger" size="sm" class="w-full sm:w-auto">
                    Hapus
                </x-ui.button>
            </form>
        </div>
    </x-slot:actions>

    <div class="grid gap-6 xl:grid-cols-12 xl:gap-8">
        <section class="min-w-0 xl:col-span-8">
            <x-ui.card no-padding class="h-full overflow-hidden">
                <div class="grid gap-0 sm:grid-cols-2">
                    <div class="border-b border-zinc-100 p-6 sm:border-r sm:border-b-0 xl:p-7">
                        <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-zinc-400">Semester</p>
                        <p class="mt-2 text-lg font-semibold leading-8 tracking-tight text-zinc-950">{{ $period->semester }}</p>
                    </div>
                    <div class="border-b border-zinc-100 p-6 sm:border-b-0 xl:p-7">
                        <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-zinc-400">Tahun Akademik</p>
                        <p class="mt-2 text-lg font-semibold leading-8 tracking-tight text-zinc-950">{{ $period->academic_year }}</p>
                    </div>
                </div>
                <div class="grid gap-0 border-t border-zinc-100 sm:grid-cols-2">
                    <div class="border-b border-zinc-100 p-6 sm:border-r sm:border-b-0 xl:p-7">
                        <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-zinc-400">Tanggal Mulai</p>
                        <p class="mt-2 text-base font-semibold leading-7 text-zinc-950">{{ $period->start_date->translatedFormat('d F Y') }}</p>
                    </div>
                    <div class="p-6 xl:p-7">
                        <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-zinc-400">Tanggal Selesai</p>
                        <p class="mt-2 text-base font-semibold leading-7 text-zinc-950">{{ $period->end_date->translatedFormat('d F Y') }}</p>
                    </div>
                </div>
            </x-ui.card>
        </section>

        <aside class="min-w-0 xl:col-span-4">
            <x-ui.card no-padding class="h-full overflow-hidden">
                <div class="border-b border-zinc-100 px-6 py-5 xl:px-7">
                    <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-zinc-400">Ringkasan Operasional</p>
                    <p class="mt-2 text-lg font-semibold tracking-tight text-zinc-950">Status, durasi, dan kepadatan formulir</p>
                </div>
                <div class="space-y-4 px-6 py-5 xl:px-7">
                    <div class="flex items-center justify-between gap-4 border-b border-zinc-100 pb-4">
                        <span class="text-xs font-medium text-zinc-500">Status</span>
                        <x-ui.badge :variant="$period->is_active ? 'teal' : 'zinc'">
                            {{ $period->is_active ? 'AKTIF' : 'NONAKTIF' }}
                        </x-ui.badge>
                    </div>
                    <div class="flex items-center justify-between gap-4 border-b border-zinc-100 pb-4">
                        <span class="text-xs font-medium text-zinc-500">Formulir</span>
                        <span class="text-sm font-semibold text-zinc-950">{{ number_format($period->evaluation_forms_count) }}</span>
                    </div>
                    <div class="flex items-center justify-between gap-4">
                        <span class="text-xs font-medium text-zinc-500">Posisi Waktu</span>
                        <span class="text-right text-sm font-semibold leading-6 text-zinc-950">
                            @if(now()->isBetween($period->start_date, $period->end_date))
                                {{ now()->diffInDays($period->end_date) }} hari lagi
                            @elseif(now()->isBefore($period->start_date))
                                Belum dimulai
                            @else
                                Sudah berakhir
                            @endif
                        </span>
                    </div>
                </div>
            </x-ui.card>
        </aside>

        <section class="min-w-0 xl:col-span-12">
            <div class="mb-4 grid gap-3 lg:grid-cols-[minmax(0,1fr)_auto] lg:items-start">
                <div>
                    <h3 class="text-sm font-bold uppercase tracking-[0.18em] text-zinc-400">Formulir Dalam Periode</h3>
                    <p class="mt-1 text-sm leading-6 text-zinc-500">Seluruh instrumen evaluasi yang tercatat pada periode ini ditampilkan dalam satu bidang penuh agar relasi periode ke formulir terbaca cepat.</p>
                </div>
                <div class="flex flex-col gap-2 sm:flex-row sm:flex-wrap sm:items-center lg:justify-end">
                    <x-ui.badge variant="zinc">{{ $period->evaluation_forms_count }} Formulir</x-ui.badge>
                    <x-ui.button href="{{ route('admin.forms.create', ['evaluation_period_id' => $period->id]) }}" variant="teal" size="sm" class="w-full sm:w-auto">
                        Tambah Formulir
                    </x-ui.button>
                </div>
            </div>

            @if($period->evaluationForms->isEmpty())
                <x-ui.empty-state title="Belum ada formulir" description="Periode ini belum memiliki instrumen formulir evaluasi." />
            @else
                <div class="space-y-4 md:hidden">
                    @foreach ($period->evaluationForms as $form)
                        <x-ui.card class="p-5">
                            <div class="space-y-4">
                                <div>
                                    <p class="text-sm font-semibold leading-6 text-zinc-950">{{ $form->title }}</p>
                                    <p class="mt-1 text-xs text-zinc-500">{{ $form->target_type }}</p>
                                </div>
                                <div class="flex items-center justify-between gap-4 border-t border-zinc-100 pt-4">
                                    <x-ui.badge :variant="$form->is_active ? 'teal' : 'zinc'">
                                        {{ $form->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </x-ui.badge>
                                    <span class="text-sm font-bold text-zinc-950">{{ $form->questions_count }} soal</span>
                                </div>
                                <x-ui.button href="{{ route('admin.forms.show', $form) }}" variant="ghost" size="sm" class="w-full">Detail</x-ui.button>
                            </div>
                        </x-ui.card>
                    @endforeach
                </div>

                <div class="hidden md:block">
                    <x-ui.table :headers="['Judul Formulir', 'Target', 'Status', 'Soal', 'Aksi']">
                        @foreach ($period->evaluationForms as $form)
                            <tr>
                                <td class="min-w-[22rem] whitespace-normal px-5 py-5 align-top text-sm font-semibold leading-7 text-zinc-950">
                                    {{ $form->title }}
                                </td>
                                <td class="whitespace-normal px-5 py-5 align-top text-sm leading-7 text-zinc-600">
                                    {{ $form->target_type }}
                                </td>
                                <td class="whitespace-nowrap px-5 py-5 align-top text-sm">
                                    <x-ui.badge :variant="$form->is_active ? 'teal' : 'zinc'">
                                        {{ $form->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </x-ui.badge>
                                </td>
                                <td class="whitespace-nowrap px-5 py-5 align-top text-right text-sm font-bold text-zinc-950">
                                    {{ $form->questions_count }}
                                </td>
                                <td class="whitespace-nowrap px-5 py-5 align-top text-right">
                                    <x-ui.button href="{{ route('admin.forms.show', $form) }}" variant="ghost" size="sm">
                                        Detail
                                    </x-ui.button>
                                </td>
                            </tr>
                        @endforeach
                    </x-ui.table>
                </div>
            @endif
        </section>
    </div>
</x-layouts.admin>
