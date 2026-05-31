<x-layouts.admin title="Form Evaluasi - SurveyKita" heading="Form Evaluasi">
    <div class="sk-pagehead"><p class="sk-pagehead-copy">Kelola formulir evaluasi akademik, periode, target responden, dan status publikasi.</p><x-button :href="route('admin.forms.create')">Tambah Form</x-button></div>
    <x-table :headers="['Judul Form', 'Periode', 'Target', 'Status', 'Respons', 'Aksi']">
        @forelse ($forms as $form)
            <tr class="hover:bg-zinc-50"><td class="px-5 py-4 font-semibold">{{ $form->title }}</td><td class="px-5 py-4 text-zinc-600">{{ $form->evaluationPeriod->name }}</td><td class="px-5 py-4 text-zinc-600">{{ ucwords(str_replace('_', ' ', $form->target_type)) }}</td><td class="px-5 py-4"><x-badge :variant="$form->is_active ? 'success' : 'neutral'">{{ $form->is_active ? 'Aktif' : 'Nonaktif' }}</x-badge></td><td class="px-5 py-4 font-mono text-sm text-zinc-700">{{ $form->responses_count }}</td><td class="px-5 py-4"><div class="sk-link-row"><a class="sk-link" href="{{ route('admin.forms.show', $form) }}">Detail</a><a class="sk-link" href="{{ route('admin.forms.edit', $form) }}">Edit</a><form method="POST" action="{{ route('admin.forms.destroy', $form) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus form evaluasi ini?')">@csrf @method('DELETE')<button class="sk-danger-link" type="submit">Hapus</button></form></div></td></tr>
        @empty
            <tr><td class="px-5 py-10" colspan="6"><x-empty-state title="Belum ada form evaluasi" description="Buat formulir evaluasi akademik baru untuk mulai mengumpulkan tanggapan mahasiswa." /></td></tr>
        @endforelse
    </x-table>
    <x-pagination :paginator="$forms" />
</x-layouts.admin>
