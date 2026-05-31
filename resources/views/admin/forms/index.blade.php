<x-layouts.admin title="Form Evaluasi - SurveyKita" heading="Form Evaluasi">
    <div class="mb-4"><x-button :href="route('admin.forms.create')">Tambah Form</x-button></div>
    <x-card>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="border-b text-zinc-600"><tr><th class="py-2">Judul</th><th>Periode</th><th>Target</th><th>Status</th><th>Respons</th><th class="text-right">Aksi</th></tr></thead>
                <tbody class="divide-y">
                    @forelse ($forms as $form)
                        <tr>
                            <td class="py-3">{{ $form->title }}</td><td>{{ $form->evaluationPeriod->name }}</td><td>{{ $form->target_type }}</td><td>{{ $form->is_active ? 'Aktif' : 'Nonaktif' }}</td><td>{{ $form->responses_count }}</td>
                            <td class="space-x-2 text-right"><a class="text-teal-700" href="{{ route('admin.forms.show', $form) }}">Detail</a><a class="text-teal-700" href="{{ route('admin.forms.edit', $form) }}">Edit</a><form class="inline" method="POST" action="{{ route('admin.forms.destroy', $form) }}">@csrf @method('DELETE')<button class="text-red-700" type="submit">Hapus</button></form></td>
                        </tr>
                    @empty
                        <tr><td class="py-6 text-center text-zinc-500" colspan="6">Belum ada form evaluasi.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <x-pagination :paginator="$forms" />
    </x-card>
</x-layouts.admin>
