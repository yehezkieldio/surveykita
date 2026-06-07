<x-layouts.admin heading="Periode Evaluasi" eyebrow="Pengaturan Waktu">
    <x-slot:actions>
        <x-ui.button href="{{ route('admin.periods.create') }}" variant="teal" size="sm">
            Tambah Periode
        </x-ui.button>
    </x-slot:actions>

    @if($periods->isEmpty())
        <x-ui.empty-state title="Belum ada periode evaluasi" description="Buat periode evaluasi untuk mulai mendefinisikan jadwal pengisian survei." />
    @else
        <div class="space-y-6">
            <x-ui.table :headers="['Nama Periode', 'Semester', 'Tahun Akademik', 'Rentang Waktu', 'Status', 'Form', 'Aksi']">
                @foreach ($periods as $period)
                    <tr class="hover:bg-zinc-50/50 transition-colors">
                        <td class="whitespace-nowrap px-6 py-4 text-sm font-semibold text-zinc-950">{{ $period->name }}</td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-zinc-600">{{ $period->semester }}</td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-zinc-600">{{ $period->academic_year }}</td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-zinc-600">
                            <span class="text-xs font-medium">{{ $period->start_date->translatedFormat('d/m/y') }}</span>
                            <span class="mx-1 text-zinc-300">-</span>
                            <span class="text-xs font-medium">{{ $period->end_date->translatedFormat('d/m/y') }}</span>
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm">
                            <x-ui.badge :variant="$period->is_active ? 'teal' : 'zinc'">
                                {{ $period->is_active ? 'Aktif' : 'Nonaktif' }}
                            </x-ui.badge>
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-bold text-zinc-950">{{ $period->evaluation_forms_count }}</td>
                        <td class="whitespace-nowrap px-6 py-4 text-right">
                            <div class="flex justify-end gap-2">
                                <x-ui.button href="{{ route('admin.periods.show', $period) }}" variant="ghost" size="sm">Detail</x-ui.button>
                                <x-ui.button href="{{ route('admin.periods.edit', $period) }}" variant="secondary" size="sm">Edit</x-ui.button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </x-ui.table>

            <div class="mt-8">
                {{ $periods->links() }}
            </div>
        </div>
    @endif
</x-layouts.admin>
