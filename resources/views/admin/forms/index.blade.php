<x-layouts.admin heading="Form Evaluasi" eyebrow="Instrumen Survei">
    <x-slot:actions>
        <x-ui.button href="{{ route('admin.forms.create') }}" variant="teal" size="sm">
            Tambah Formulir
        </x-ui.button>
    </x-slot:actions>

    @if($forms->isEmpty())
        <x-ui.empty-state title="Belum ada formulir evaluasi" description="Buat formulir evaluasi untuk mendefinisikan instrumen yang akan diisi oleh mahasiswa." />
    @else
        <div class="space-y-6">
            <x-ui.table :headers="['Judul Formulir', 'Periode', 'Target', 'Status', 'Soal', 'Respons', 'Aksi']">
                @foreach ($forms as $form)
                    <tr class="hover:bg-zinc-50/50 transition-colors">
                        <td class="whitespace-nowrap px-6 py-4">
                            <div class="text-sm font-semibold text-zinc-950">{{ $form->title }}</div>
                            <div class="text-[10px] text-zinc-400 max-w-[200px] truncate">{{ $form->description }}</div>
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-zinc-600">{{ $form->evaluationPeriod->name }}</td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-zinc-600">{{ $form->target_type }}</td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm">
                            <x-ui.badge :variant="$form->is_active ? 'teal' : 'zinc'">
                                {{ $form->is_active ? 'Aktif' : 'Nonaktif' }}
                            </x-ui.badge>
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-bold text-zinc-950">{{ $form->questions_count }}</td>
                        <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-bold text-teal-600">{{ $form->responses_count }}</td>
                        <td class="whitespace-nowrap px-6 py-4 text-right">
                            <div class="flex justify-end gap-2">
                                <x-ui.button href="{{ route('admin.forms.show', $form) }}" variant="ghost" size="sm">Detail</x-ui.button>
                                <x-ui.button href="{{ route('admin.forms.edit', $form) }}" variant="secondary" size="sm">Edit</x-ui.button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </x-ui.table>

            <div class="mt-8">
                {{ $forms->links() }}
            </div>
        </div>
    @endif
</x-layouts.admin>
