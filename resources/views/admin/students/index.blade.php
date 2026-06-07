<x-layouts.admin heading="Mahasiswa" eyebrow="Manajemen Data">
    <x-slot:actions>
        <x-ui.button href="{{ route('admin.students.create') }}" variant="teal" size="sm">
            Tambah Mahasiswa
        </x-ui.button>
    </x-slot:actions>

    @if($students->isEmpty())
        <x-ui.empty-state title="Belum ada data mahasiswa" description="Tambahkan mahasiswa secara manual atau impor data melalui menu aksi." />
    @else
        <div class="space-y-6">
            <x-ui.table :headers="['NIM', 'Nama', 'Email', 'Program Studi', 'Kelas', 'Respons', 'Aksi']">
                @foreach ($students as $student)
                    <tr class="hover:bg-zinc-50/50 transition-colors">
                        <td class="whitespace-nowrap px-6 py-4 font-mono text-xs font-bold text-zinc-900">{{ $student->nim }}</td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm font-semibold text-zinc-950">{{ $student->name }}</td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-zinc-600">{{ $student->user?->email ?? '-' }}</td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-zinc-600">{{ $student->study_program }}</td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-zinc-600">{{ $student->class_name }}</td>
                        <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-bold text-teal-600">{{ $student->responses_count }}</td>
                        <td class="whitespace-nowrap px-6 py-4 text-right">
                            <div class="flex justify-end gap-2">
                                <x-ui.button href="{{ route('admin.students.show', $student) }}" variant="ghost" size="sm">Detail</x-ui.button>
                                <x-ui.button href="{{ route('admin.students.edit', $student) }}" variant="secondary" size="sm">Edit</x-ui.button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </x-ui.table>

            <div class="mt-8">
                {{ $students->links() }}
            </div>
        </div>
    @endif
</x-layouts.admin>
