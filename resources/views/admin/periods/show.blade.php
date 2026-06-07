<x-layouts.admin heading="{{ $period->name }}" eyebrow="Detail Periode">
    <x-slot:actions>
        <x-ui.button href="{{ route('admin.periods.edit', $period) }}" variant="secondary" size="sm">
            Edit Periode
        </x-ui.button>
        <form action="{{ route('admin.periods.destroy', $period) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus periode ini?');">
            @csrf
            @method('DELETE')
            <x-ui.button variant="danger" size="sm" :disabled="$period->evaluation_forms_count > 0">
                Hapus
            </x-ui.button>
        </form>
    </x-slot:actions>

    <div class="grid gap-8 lg:grid-cols-[1fr_20rem]">
        <div class="space-y-8">
            <section>
                <h3 class="mb-4 text-sm font-bold uppercase tracking-[0.2em] text-zinc-400">Informasi Umum</h3>
                <x-ui.card no-padding>
                    <div class="grid divide-y divide-zinc-100 sm:grid-cols-2 sm:divide-x sm:divide-y-0">
                        <div class="p-6">
                            <p class="text-xs font-medium text-zinc-500">Semester</p>
                            <p class="mt-1 text-sm font-semibold text-zinc-950">{{ $period->semester }}</p>
                        </div>
                        <div class="p-6">
                            <p class="text-xs font-medium text-zinc-500">Tahun Akademik</p>
                            <p class="mt-1 text-sm font-semibold text-zinc-950">{{ $period->academic_year }}</p>
                        </div>
                        <div class="p-6">
                            <p class="text-xs font-medium text-zinc-500">Tanggal Mulai</p>
                            <p class="mt-1 text-sm font-semibold text-zinc-950">{{ $period->start_date->translatedFormat('d F Y') }}</p>
                        </div>
                        <div class="p-6">
                            <p class="text-xs font-medium text-zinc-500">Tanggal Selesai</p>
                            <p class="mt-1 text-sm font-semibold text-zinc-950">{{ $period->end_date->translatedFormat('d F Y') }}</p>
                        </div>
                    </div>
                </x-ui.card>
            </section>

            <section>
                <div class="mb-4 flex items-center justify-between">
                    <h3 class="text-sm font-bold uppercase tracking-[0.2em] text-zinc-400">Daftar Formulir</h3>
                    <x-ui.badge variant="zinc">{{ $period->evaluation_forms_count }} Formulir</x-ui.badge>
                </div>
                
                @if($period->evaluationForms->isEmpty())
                    <x-ui.empty-state title="Belum ada formulir" description="Periode ini belum memiliki instrumen formulir evaluasi.">
                        <x-ui.button href="{{ route('admin.forms.create', ['evaluation_period_id' => $period->id]) }}" variant="teal" size="sm">
                            Tambah Formulir
                        </x-ui.button>
                    </x-ui.empty-state>
                @else
                    <x-ui.table :headers="['Judul Formulir', 'Target', 'Status', 'Soal', 'Aksi']">
                        @foreach ($period->evaluationForms as $form)
                            <tr>
                                <td class="whitespace-nowrap px-6 py-4 text-sm font-semibold text-zinc-950">{{ $form->title }}</td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-zinc-600">{{ $form->target_type }}</td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm">
                                    <x-ui.badge :variant="$form->is_active ? 'teal' : 'zinc'">
                                        {{ $form->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </x-ui.badge>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-bold text-zinc-950">{{ $form->questions_count }}</td>
                                <td class="whitespace-nowrap px-6 py-4 text-right">
                                    <x-ui.button href="{{ route('admin.forms.show', $form) }}" variant="ghost" size="sm">Detail</x-ui.button>
                                </td>
                            </tr>
                        @endforeach
                    </x-ui.table>
                @endif
            </section>
        </div>

        <aside class="space-y-6">
            <div class="rounded-lg border border-zinc-200 bg-white p-6">
                <h3 class="text-sm font-semibold text-zinc-950">Status Operasional</h3>
                <div class="mt-4 space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-medium text-zinc-500">Status</span>
                        <x-ui.badge :variant="$period->is_active ? 'teal' : 'zinc'">
                            {{ $period->is_active ? 'AKTIF' : 'NONAKTIF' }}
                        </x-ui.badge>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-medium text-zinc-500">Sisa Waktu</span>
                        <span class="text-xs font-semibold text-zinc-950">
                            @if(now()->isBetween($period->start_date, $period->end_date))
                                {{ now()->diffInDays($period->end_date) }} Hari Lagi
                            @elseif(now()->isBefore($period->start_date))
                                Belum Dimulai
                            @else
                                Sudah Berakhir
                            @endif
                        </span>
                    </div>
                </div>
            </div>

            @if($period->evaluation_forms_count > 0)
                <div class="p-4 bg-amber-50 border border-amber-100 text-xs text-amber-800 leading-relaxed">
                    <strong>Catatan:</strong> Periode ini tidak dapat dihapus karena telah memiliki formulir evaluasi terkait.
                </div>
            @endif
        </aside>
    </div>
</x-layouts.admin>
