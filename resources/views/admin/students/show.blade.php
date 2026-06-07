<x-layouts.admin heading="{{ $student->name }}" eyebrow="{{ $student->nim }}">
    <x-slot:actions>
        <x-ui.button href="{{ route('admin.students.edit', $student) }}" variant="secondary" size="sm">
            Edit Mahasiswa
        </x-ui.button>
        <form action="{{ route('admin.students.destroy', $student) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus mahasiswa ini?');">
            @csrf
            @method('DELETE')
            <x-ui.button variant="danger" size="sm" :disabled="$student->responses()->exists()">
                Hapus
            </x-ui.button>
        </form>
    </x-slot:actions>

    <div class="grid gap-8 lg:grid-cols-[1fr_20rem] xl:grid-cols-[1fr_24rem]">
        <div class="space-y-8 min-w-0"> {{-- Add min-w-0 to allow content to shrink/scroll --}}
            <section>
                <h3 class="mb-4 text-sm font-bold uppercase tracking-[0.2em] text-zinc-400">Informasi Akademik</h3>
                <x-ui.card no-padding class="overflow-hidden">
                    <div class="grid divide-y divide-zinc-100 sm:grid-cols-2 sm:divide-x sm:divide-y-0">
                        <div class="p-6">
                            <p class="text-[10px] font-bold uppercase tracking-widest text-zinc-400">Program Studi</p>
                            <p class="mt-1 text-sm font-semibold text-zinc-950">{{ $student->study_program }}</p>
                        </div>
                        <div class="p-6">
                            <p class="text-[10px] font-bold uppercase tracking-widest text-zinc-400">Angkatan</p>
                            <p class="mt-1 text-sm font-semibold text-zinc-950">{{ $student->enrollment_year }}</p>
                        </div>
                        <div class="p-6">
                            <p class="text-[10px] font-bold uppercase tracking-widest text-zinc-400">Kelas</p>
                            <p class="mt-1 text-sm font-semibold text-zinc-950">{{ $student->class_name }}</p>
                        </div>
                        <div class="p-6">
                            <p class="text-[10px] font-bold uppercase tracking-widest text-zinc-400">Email</p>
                            <p class="mt-1 text-sm font-semibold text-zinc-950 truncate">{{ $student->user?->email }}</p>
                        </div>
                    </div>
                </x-ui.card>
            </section>

            <section>
                <div class="mb-4 flex items-center justify-between">
                    <h3 class="text-sm font-bold uppercase tracking-[0.2em] text-zinc-400">Riwayat Respons</h3>
                    <x-ui.badge variant="zinc">{{ $student->responses->count() }} Respons</x-ui.badge>
                </div>
                
                @if($student->responses->isEmpty())
                    <x-ui.empty-state title="Belum ada respons" description="Mahasiswa ini belum pernah mengisi formulir evaluasi apapun." />
                @else
                    <x-ui.table :headers="['Formulir', 'Periode', 'Tanggal Kirim']">
                        @foreach ($student->responses as $response)
                            <tr>
                                <td class="px-4 py-4 text-sm font-semibold text-zinc-950 min-w-[200px] whitespace-normal">{{ $response->evaluationForm->title }}</td>
                                <td class="whitespace-nowrap px-4 py-4 text-sm text-zinc-600">{{ $response->evaluationForm->evaluationPeriod->name }}</td>
                                <td class="whitespace-nowrap px-4 py-4 text-sm text-zinc-600">{{ $response->submitted_at->translatedFormat('d M Y, H:i') }}</td>
                            </tr>
                        @endforeach
                    </x-ui.table>
                @endif
            </section>
        </div>

        <aside class="space-y-6 min-w-0">
            <div class="rounded-lg border border-zinc-200 bg-white p-6 overflow-hidden">
                <h3 class="text-sm font-semibold text-zinc-950">Status Akun</h3>
                <div class="mt-4 space-y-4">
                    <div class="flex items-center justify-between gap-4">
                        <span class="text-xs font-medium text-zinc-500 whitespace-nowrap">Role</span>
                        <x-ui.badge variant="teal" class="truncate">{{ $student->user?->role }}</x-ui.badge>
                    </div>
                    <div class="flex items-center justify-between gap-4">
                        <span class="text-xs font-medium text-zinc-500 whitespace-nowrap">Terdaftar Pada</span>
                        <span class="text-xs font-semibold text-zinc-950 whitespace-nowrap">{{ $student->created_at->translatedFormat('d M Y') }}</span>
                    </div>
                    @if($student->user?->email_verified_at)
                        <div class="flex items-center justify-between gap-4">
                            <span class="text-xs font-medium text-zinc-500 whitespace-nowrap">Verifikasi Email</span>
                            <x-ui.badge variant="zinc">TERVERIFIKASI</x-ui.badge>
                        </div>
                    @endif
                </div>
            </div>

            @if($student->responses()->exists())
                <div class="p-4 bg-amber-50 border border-amber-100 text-xs text-amber-800 leading-relaxed">
                    <strong>Catatan:</strong> Mahasiswa ini tidak dapat dihapus karena telah berkontribusi dalam pengisian evaluasi.
                </div>
            @endif
        </aside>
    </div>
</x-layouts.admin>
