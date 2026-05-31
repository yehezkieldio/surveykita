<x-layouts.admin title="Mahasiswa - SurveyKita" heading="Data Mahasiswa">
    <div class="mb-4">
        <x-button :href="route('admin.students.create')">Tambah Mahasiswa</x-button>
    </div>

    <x-card>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="border-b text-zinc-600">
                    <tr><th class="py-2">NIM</th><th>Nama</th><th>Prodi</th><th>Kelas</th><th>Respons</th><th class="text-right">Aksi</th></tr>
                </thead>
                <tbody class="divide-y">
                    @forelse ($students as $student)
                        <tr>
                            <td class="py-3">{{ $student->nim }}</td>
                            <td>{{ $student->name }}<br><span class="text-xs text-zinc-500">{{ $student->user->email }}</span></td>
                            <td>{{ $student->study_program }}</td>
                            <td>{{ $student->class_name }}</td>
                            <td>{{ $student->responses_count }}</td>
                            <td class="space-x-2 text-right">
                                <a class="text-teal-700" href="{{ route('admin.students.show', $student) }}">Detail</a>
                                <a class="text-teal-700" href="{{ route('admin.students.edit', $student) }}">Edit</a>
                                <form class="inline" method="POST" action="{{ route('admin.students.destroy', $student) }}">
                                    @csrf @method('DELETE')
                                    <button class="text-red-700" type="submit">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td class="py-6 text-center text-zinc-500" colspan="6">Belum ada data mahasiswa.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <x-pagination :paginator="$students" />
    </x-card>
</x-layouts.admin>
