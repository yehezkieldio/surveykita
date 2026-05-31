<x-layouts.admin title="Periode Evaluasi - SurveyKita" heading="Periode Evaluasi">
    <div class="mb-6 flex justify-between items-center border-b border-zinc-200 pb-5">
        <div>
            <p class="font-mono text-[10px] uppercase tracking-wider text-zinc-400">Pengaturan Durasi & Status Evaluasi</p>
        </div>
        <x-button :href="route('admin.periods.create')" class="!min-h-9 !py-1 text-xs">Tambah Periode</x-button>
    </div>

    <x-table :headers="['Nama Periode', 'Semester & Tahun', 'Rentang Tanggal', 'Status', 'Jumlah Form', 'Aksi']">
        @forelse ($periods as $period)
            <tr class="hover:bg-zinc-50/50 transition-colors duration-150">
                <td class="px-6 py-4 font-bold text-zinc-900">{{ $period->name }}</td>
                <td class="px-6 py-4 text-zinc-500 font-mono text-[11px] uppercase tracking-wider">
                    {{ $period->semester }} ({{ $period->academic_year }})
                </td>
                <td class="px-6 py-4 text-zinc-500 font-mono text-[11px]">
                    {{ $period->start_date->format('d M Y') }} &mdash; {{ $period->end_date->format('d M Y') }}
                </td>
                <td class="px-6 py-4">
                    <x-badge :variant="$period->is_active ? 'success' : 'neutral'">
                        {{ $period->is_active ? 'Aktif' : 'Nonaktif' }}
                    </x-badge>
                </td>
                <td class="px-6 py-4 font-mono text-zinc-500 font-bold">{{ $period->evaluation_forms_count }}</td>
                <td class="px-6 py-4">
                    <div class="flex items-center gap-4 text-[10px] font-mono uppercase tracking-wider">
                        <a class="font-bold text-zinc-900 hover:underline" href="{{ route('admin.periods.show', $period) }}">Detail</a>
                        <a class="font-bold text-zinc-900 hover:underline" href="{{ route('admin.periods.edit', $period) }}">Edit</a>
                        <form method="POST" action="{{ route('admin.periods.destroy', $period) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus periode ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="font-bold text-red-700 hover:underline" type="submit">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td class="px-6 py-12 text-center" colspan="6">
                    <x-empty-state title="Belum ada periode" description="Periode digunakan untuk menjadwalkan kapan form evaluasi akademik dibuka." />
                </td>
            </tr>
        @endforelse
    </x-table>

    <x-pagination :paginator="$periods" />
</x-layouts.admin>
