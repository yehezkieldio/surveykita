<x-layouts.admin title="Form Evaluasi - SurveyKita" heading="Form Evaluasi">
    <div class="mb-6 flex justify-between items-center border-b border-zinc-200 pb-5">
        <div>
            <p class="font-mono text-[10px] uppercase tracking-wider text-zinc-400">Pengelolaan Formulir Evaluasi Akademik</p>
        </div>
        <x-button :href="route('admin.forms.create')" class="!min-h-9 !py-1 text-xs">Tambah Form</x-button>
    </div>

    <x-table :headers="['Judul Form', 'Periode', 'Target Responden', 'Status', 'Respons', 'Aksi']">
        @forelse ($forms as $form)
            <tr class="hover:bg-zinc-50/50 transition-colors duration-150">
                <td class="px-6 py-4 font-bold text-zinc-900">{{ $form->title }}</td>
                <td class="px-6 py-4 text-zinc-500 font-mono text-[11px]">{{ $form->evaluationPeriod->name }}</td>
                <td class="px-6 py-4 text-zinc-500 font-mono text-[11px] uppercase tracking-wider">{{ $form->target_type }}</td>
                <td class="px-6 py-4">
                    <x-badge :variant="$form->is_active ? 'success' : 'neutral'">
                        {{ $form->is_active ? 'Aktif' : 'Nonaktif' }}
                    </x-badge>
                </td>
                <td class="px-6 py-4 font-mono text-zinc-500 font-bold">{{ $form->responses_count }}</td>
                <td class="px-6 py-4">
                    <div class="flex items-center gap-4 text-[10px] font-mono uppercase tracking-wider">
                        <a class="font-bold text-zinc-900 hover:underline" href="{{ route('admin.forms.show', $form) }}">Detail</a>
                        <a class="font-bold text-zinc-900 hover:underline" href="{{ route('admin.forms.edit', $form) }}">Edit</a>
                        <form method="POST" action="{{ route('admin.forms.destroy', $form) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus form evaluasi ini?')">
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
                    <x-empty-state title="Belum ada form evaluasi" description="Buat formulir evaluasi akademik baru untuk mulai mengumpulkan tanggapan mahasiswa." />
                </td>
            </tr>
        @endforelse
    </x-table>

    <x-pagination :paginator="$forms" />
</x-layouts.admin>
