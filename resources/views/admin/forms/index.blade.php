<x-layouts.admin title="Form Evaluasi - SurveyKita" heading="Form Evaluasi">
    <x-table title="Daftar Form" description="Form evaluasi akademik, status publikasi, dan respons masuk." :count="$forms->total()" :headers="['Form', 'Periode', 'Target', 'Status', 'Respons', 'Aksi']">
        <x-slot:toolbar><x-button :href="route('admin.forms.create')">Tambah Form</x-button></x-slot:toolbar>
        @forelse ($forms as $form)
            <tr class="hover:bg-zinc-50">
                <td class="min-w-72 px-4 py-3"><p class="font-semibold">{{ $form->title }}</p><p class="mt-1 text-xs text-zinc-500">ID {{ $form->id }}</p></td>
                <td class="whitespace-nowrap px-4 py-3 text-zinc-600">{{ $form->evaluationPeriod->name }}</td>
                <td class="whitespace-nowrap px-4 py-3 text-zinc-600">{{ ucwords(str_replace('_', ' ', $form->target_type)) }}</td>
                <td class="px-4 py-3"><x-badge :variant="$form->is_active ? 'success' : 'neutral'">{{ $form->is_active ? 'Aktif' : 'Nonaktif' }}</x-badge></td>
                <td class="px-4 py-3 text-right font-mono text-sm text-zinc-700">{{ $form->responses_count }}</td>
                <td class="px-4 py-3"><div class="flex justify-end gap-3"><a class="sk-link" href="{{ route('admin.forms.show', $form) }}">Detail</a><a class="sk-link" href="{{ route('admin.forms.edit', $form) }}">Edit</a><form method="POST" action="{{ route('admin.forms.destroy', $form) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus form evaluasi ini?')">@csrf @method('DELETE')<button class="sk-danger-link" type="submit">Hapus</button></form></div></td>
            </tr>
        @empty
            <tr><td class="px-4 py-10" colspan="6"><x-empty-state title="Belum ada form evaluasi" description="Buat formulir evaluasi akademik baru untuk mulai mengumpulkan tanggapan mahasiswa." /></td></tr>
        @endforelse
        <x-slot:footer><x-pagination :paginator="$forms" /></x-slot:footer>
    </x-table>
</x-layouts.admin>
