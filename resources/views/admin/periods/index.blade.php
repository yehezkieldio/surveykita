<x-layouts.admin title="Periode Evaluasi - SurveyKita" heading="Periode Evaluasi">
    <div class="mb-4"><x-button :href="route('admin.periods.create')">Tambah Periode</x-button></div>
    <x-card>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="border-b text-zinc-600"><tr><th class="py-2">Nama</th><th>Semester</th><th>Rentang</th><th>Status</th><th>Form</th><th class="text-right">Aksi</th></tr></thead>
                <tbody class="divide-y">
                    @forelse ($periods as $period)
                        <tr>
                            <td class="py-3">{{ $period->name }}</td><td>{{ $period->semester }} {{ $period->academic_year }}</td>
                            <td>{{ $period->start_date->format('d/m/Y') }} - {{ $period->end_date->format('d/m/Y') }}</td>
                            <td>{{ $period->is_active ? 'Aktif' : 'Nonaktif' }}</td><td>{{ $period->evaluation_forms_count }}</td>
                            <td class="space-x-2 text-right">
                                <a class="text-teal-700" href="{{ route('admin.periods.show', $period) }}">Detail</a>
                                <a class="text-teal-700" href="{{ route('admin.periods.edit', $period) }}">Edit</a>
                                <form class="inline" method="POST" action="{{ route('admin.periods.destroy', $period) }}">@csrf @method('DELETE')<button class="text-red-700" type="submit">Hapus</button></form>
                            </td>
                        </tr>
                    @empty
                        <tr><td class="py-6 text-center text-zinc-500" colspan="6">Belum ada periode.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <x-pagination :paginator="$periods" />
    </x-card>
</x-layouts.admin>
