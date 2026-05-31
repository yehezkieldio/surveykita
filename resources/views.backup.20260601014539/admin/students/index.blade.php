<x-layouts.admin title="Mahasiswa - SurveyKita" heading="Data Mahasiswa">
    <div class="mb-6 flex justify-between items-center border-b border-zinc-200 pb-5">
        <div>
            <p class="font-mono text-[10px] uppercase tracking-wider text-zinc-400">Pengelolaan Profil & Akun Mahasiswa</p>
        </div>
        <x-button :href="route('admin.students.create')" class="!min-h-9 !py-1 text-xs">Tambah Mahasiswa</x-button>
    </div>

    <x-table :headers="['NIM', 'Nama & Akun Email', 'Program Studi', 'Kelas', 'Respons', 'Aksi']">
        @forelse ($students as $student)
            <tr class="hover:bg-zinc-50/50 transition-colors duration-150">
                <td class="px-6 py-4 font-mono text-[11px] font-bold text-zinc-900">{{ $student->nim }}</td>
                <td class="px-6 py-4">
                    <span class="font-bold text-zinc-900">{{ $student->name }}</span>
                    <span class="block font-mono text-[10px] text-zinc-400 mt-0.5">{{ $student->user->email }}</span>
                </td>
                <td class="px-6 py-4 text-zinc-500 font-mono text-[11px] uppercase tracking-wider">{{ $student->study_program }}</td>
                <td class="px-6 py-4 text-zinc-500 font-mono text-[11px]">{{ $student->class_name }}</td>
                <td class="px-6 py-4 font-mono text-zinc-500 font-bold">{{ $student->responses_count }}</td>
                <td class="px-6 py-4">
                    <div class="flex items-center gap-4 text-[10px] font-mono uppercase tracking-wider">
                        <a class="font-bold text-zinc-900 hover:underline" href="{{ route('admin.students.show', $student) }}">Detail</a>
                        <a class="font-bold text-zinc-900 hover:underline" href="{{ route('admin.students.edit', $student) }}">Edit</a>
                        <form method="POST" action="{{ route('admin.students.destroy', $student) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus mahasiswa ini?')">
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
                    <x-empty-state title="Belum ada data mahasiswa" description="Data profil mahasiswa Universitas Mulia belum dimasukkan ke dalam sistem." />
                </td>
            </tr>
        @endforelse
    </x-table>

    <x-pagination :paginator="$students" />
</x-layouts.admin>
