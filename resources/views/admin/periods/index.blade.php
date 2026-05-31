<x-layouts.admin title="Periode Evaluasi - SurveyKita" heading="Periode Evaluasi">
    <div class="sk-pagehead"><p class="sk-pagehead-copy">Atur durasi, semester, tahun akademik, dan status periode evaluasi.</p><x-button :href="route('admin.periods.create')">Tambah Periode</x-button></div>
    <x-table :headers="['Nama Periode', 'Semester & Tahun', 'Rentang Tanggal', 'Status', 'Jumlah Form', 'Aksi']">
        @forelse ($periods as $period)
            <tr class="hover:bg-zinc-50"><td class="px-5 py-4 font-semibold">{{ $period->name }}</td><td class="px-5 py-4 text-zinc-600">{{ $period->semester }} ({{ $period->academic_year }})</td><td class="px-5 py-4 text-zinc-600">{{ $period->start_date->format('d M Y') }} - {{ $period->end_date->format('d M Y') }}</td><td class="px-5 py-4"><x-badge :variant="$period->is_active ? 'success' : 'neutral'">{{ $period->is_active ? 'Aktif' : 'Nonaktif' }}</x-badge></td><td class="px-5 py-4 font-mono text-sm text-zinc-700">{{ $period->evaluation_forms_count }}</td><td class="px-5 py-4"><div class="sk-link-row"><a class="sk-link" href="{{ route('admin.periods.show', $period) }}">Detail</a><a class="sk-link" href="{{ route('admin.periods.edit', $period) }}">Edit</a><form method="POST" action="{{ route('admin.periods.destroy', $period) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus periode ini?')">@csrf @method('DELETE')<button class="sk-danger-link" type="submit">Hapus</button></form></div></td></tr>
        @empty
            <tr><td class="px-5 py-10" colspan="6"><x-empty-state title="Belum ada periode" description="Periode digunakan untuk menjadwalkan kapan form evaluasi akademik dibuka." /></td></tr>
        @endforelse
    </x-table><x-pagination :paginator="$periods" />
</x-layouts.admin>
