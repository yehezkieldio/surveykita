<x-layouts.admin title="Periode Evaluasi - SurveyKita" heading="Periode Evaluasi">
    <x-table title="Daftar Periode" description="Durasi, semester, tahun akademik, dan status periode evaluasi." :count="$periods->total()" :headers="['Periode', 'Semester', 'Tanggal', 'Status', 'Form', 'Aksi']">
        <x-slot:toolbar><x-button :href="route('admin.periods.create')">Tambah Periode</x-button></x-slot:toolbar>
        @forelse ($periods as $period)
            <tr class="hover:bg-zinc-50">
                <td class="whitespace-nowrap px-4 py-3 font-semibold">{{ $period->name }}</td>
                <td class="whitespace-nowrap px-4 py-3 text-zinc-600">{{ $period->semester }} ({{ $period->academic_year }})</td>
                <td class="whitespace-nowrap px-4 py-3 font-mono text-xs text-zinc-600">{{ $period->start_date->format('d M Y') }} - {{ $period->end_date->format('d M Y') }}</td>
                <td class="px-4 py-3"><x-badge :variant="$period->is_active ? 'success' : 'neutral'">{{ $period->is_active ? 'Aktif' : 'Nonaktif' }}</x-badge></td>
                <td class="px-4 py-3 text-right font-mono text-sm text-zinc-700">{{ $period->evaluation_forms_count }}</td>
                <td class="px-4 py-3"><div class="flex justify-end gap-3"><a class="sk-link" href="{{ route('admin.periods.show', $period) }}">Detail</a><a class="sk-link" href="{{ route('admin.periods.edit', $period) }}">Edit</a><form method="POST" action="{{ route('admin.periods.destroy', $period) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus periode ini?')">@csrf @method('DELETE')<button class="sk-danger-link" type="submit">Hapus</button></form></div></td>
            </tr>
        @empty
            <tr><td class="px-4 py-10" colspan="6"><x-empty-state title="Belum ada periode" description="Periode digunakan untuk menjadwalkan kapan form evaluasi akademik dibuka." /></td></tr>
        @endforelse
        <x-slot:footer><x-pagination :paginator="$periods" /></x-slot:footer>
    </x-table>
</x-layouts.admin>
