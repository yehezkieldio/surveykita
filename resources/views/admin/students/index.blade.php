<x-layouts.admin title="Mahasiswa - SurveyKita" heading="Data Mahasiswa">
    <x-table title="Daftar Mahasiswa" description="Profil akademik dan akun mahasiswa yang dapat mengisi evaluasi." :count="$students->total()" :headers="['NIM', 'Mahasiswa', 'Program Studi', 'Kelas', 'Respons', 'Aksi']">
        <x-slot:toolbar><x-button :href="route('admin.students.create')">Tambah Mahasiswa</x-button></x-slot:toolbar>
        @forelse ($students as $student)
            <tr class="hover:bg-zinc-50">
                <td class="whitespace-nowrap px-4 py-3 font-mono text-sm text-zinc-700">{{ $student->nim }}</td>
                <td class="min-w-72 px-4 py-3"><p class="font-semibold">{{ $student->name }}</p><p class="mt-1 text-sm text-zinc-500">{{ $student->user->email }}</p></td>
                <td class="whitespace-nowrap px-4 py-3 text-zinc-600">{{ $student->study_program }}</td>
                <td class="whitespace-nowrap px-4 py-3 font-mono text-sm text-zinc-700">{{ $student->class_name }}</td>
                <td class="px-4 py-3 text-right font-mono text-sm text-zinc-700">{{ $student->responses_count }}</td>
                <td class="px-4 py-3"><div class="flex justify-end gap-3"><a class="sk-link" href="{{ route('admin.students.show', $student) }}">Detail</a><a class="sk-link" href="{{ route('admin.students.edit', $student) }}">Edit</a><form method="POST" action="{{ route('admin.students.destroy', $student) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus mahasiswa ini?')">@csrf @method('DELETE')<button class="sk-danger-link" type="submit">Hapus</button></form></div></td>
            </tr>
        @empty
            <tr><td class="px-4 py-10" colspan="6"><x-empty-state title="Belum ada data mahasiswa" description="Data profil mahasiswa Universitas Mulia belum dimasukkan ke dalam sistem." /></td></tr>
        @endforelse
        <x-slot:footer><x-pagination :paginator="$students" /></x-slot:footer>
    </x-table>
</x-layouts.admin>
