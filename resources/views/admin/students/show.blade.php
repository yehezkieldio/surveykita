<x-layouts.admin heading="{{ $student->name }}" eyebrow="{{ $student->nim }}">
    <x-slot:actions>
        <div class="flex w-full flex-col gap-2 sm:w-auto sm:flex-row sm:flex-wrap sm:items-center sm:justify-end sm:gap-2 sm:flex-nowrap">
            <x-ui.button href="{{ route('admin.students.index') }}" variant="ghost" size="sm" class="w-full sm:w-auto">
                Kembali
            </x-ui.button>
            <x-ui.button href="{{ route('admin.students.edit', $student) }}" variant="secondary" size="sm" class="w-full sm:w-auto">
                Edit Mahasiswa
            </x-ui.button>
            <form action="{{ route('admin.students.destroy', $student) }}" method="POST" class="inline-flex w-full shrink-0 sm:w-auto" onsubmit="return confirm('Apakah Anda yakin ingin menghapus mahasiswa ini?');">
                @csrf
                @method('DELETE')
                <x-ui.button variant="danger" size="sm" class="w-full sm:w-auto">
                    Hapus
                </x-ui.button>
            </form>
        </div>
    </x-slot:actions>

    <div class="grid gap-6 xl:grid-cols-12 xl:gap-8">
        <section class="min-w-0 xl:col-span-8">
            <x-ui.card no-padding class="h-full overflow-hidden">
                <div class="grid sm:grid-cols-2">
                    <div class="border-b border-zinc-100 p-6 sm:border-r sm:border-b-0 xl:p-7">
                        <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-zinc-400">Program Studi</p>
                        <p class="mt-2 text-base font-semibold leading-7 tracking-tight text-zinc-950">{{ $student->study_program }}</p>
                    </div>
                    <div class="border-b border-zinc-100 p-6 sm:border-b-0 xl:p-7">
                        <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-zinc-400">Angkatan</p>
                        <p class="mt-2 text-base font-semibold leading-7 tracking-tight text-zinc-950">{{ $student->enrollment_year }}</p>
                    </div>
                </div>
                <div class="grid border-t border-zinc-100 sm:grid-cols-[minmax(0,0.8fr)_minmax(0,1.2fr)]">
                    <div class="border-b border-zinc-100 p-6 sm:border-r sm:border-b-0 xl:p-7">
                        <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-zinc-400">Kelas</p>
                        <p class="mt-2 text-base font-semibold leading-7 tracking-tight text-zinc-950">{{ $student->class_name }}</p>
                    </div>
                    <div class="p-6 xl:p-7">
                        <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-zinc-400">Email</p>
                        <p class="mt-2 break-all text-[0.95rem] font-semibold leading-7 tracking-tight text-zinc-950">{{ $student->user?->email }}</p>
                    </div>
                </div>
            </x-ui.card>
        </section>

        <aside class="min-w-0 xl:col-span-4">
            <x-ui.card no-padding class="h-full overflow-hidden">
                <div class="border-b border-zinc-100 px-6 py-5 xl:px-7">
                    <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-zinc-400">Status Akun</p>
                    <p class="mt-2 text-lg font-semibold tracking-tight text-zinc-950">Akses dan jejak pendaftaran</p>
                </div>
                <div class="space-y-4 px-6 py-5 xl:px-7">
                    <div class="flex items-center justify-between gap-4 border-b border-zinc-100 pb-4">
                        <span class="text-xs font-medium text-zinc-500">Role</span>
                        <x-ui.badge variant="teal" class="truncate">{{ $student->user?->role }}</x-ui.badge>
                    </div>
                    <div class="flex items-center justify-between gap-4 border-b border-zinc-100 pb-4">
                        <span class="text-xs font-medium text-zinc-500">Terdaftar Pada</span>
                        <span class="text-sm font-semibold text-zinc-950">{{ $student->created_at->translatedFormat('d M Y') }}</span>
                    </div>
                    @if($student->user?->email_verified_at)
                        <div class="flex items-center justify-between gap-4">
                            <span class="text-xs font-medium text-zinc-500">Verifikasi Email</span>
                            <x-ui.badge variant="zinc">TERVERIFIKASI</x-ui.badge>
                        </div>
                    @endif
                </div>
            </x-ui.card>
        </aside>

        <section class="min-w-0 xl:col-span-12">
            <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:flex-wrap sm:items-center sm:justify-between">
                <div>
                    <h3 class="text-sm font-bold uppercase tracking-[0.18em] text-zinc-400">Riwayat Respons</h3>
                    <p class="mt-1 text-sm leading-6 text-zinc-500">Daftar formulir yang pernah diisi mahasiswa beserta periode dan waktu pengirimannya.</p>
                </div>
                <x-ui.badge variant="zinc">{{ $student->responses->count() }} Respons</x-ui.badge>
            </div>

            @if($student->responses->isEmpty())
                <x-ui.empty-state title="Belum ada respons" description="Mahasiswa ini belum pernah mengisi formulir evaluasi apapun." />
            @else
                <div class="space-y-4 md:hidden">
                    @foreach ($student->responses as $response)
                        <x-ui.card class="p-5">
                            <div class="space-y-4">
                                <div>
                                    <p class="text-sm font-semibold leading-6 text-zinc-950">{{ $response->evaluationForm->title }}</p>
                                    <p class="mt-1 text-xs text-zinc-500">{{ $response->evaluationForm->evaluationPeriod->name }}</p>
                                </div>
                                <div class="border-t border-zinc-100 pt-4">
                                    <p class="text-[10px] font-bold uppercase tracking-[0.16em] text-zinc-400">Tanggal Kirim</p>
                                    <p class="mt-1 text-sm text-zinc-600">{{ $response->submitted_at->translatedFormat('d M Y, H:i') }}</p>
                                </div>
                            </div>
                        </x-ui.card>
                    @endforeach
                </div>

                <div class="hidden md:block">
                    <x-ui.table :headers="['Formulir', 'Periode', 'Tanggal Kirim']">
                        @foreach ($student->responses as $response)
                            <tr>
                                <td class="min-w-[22rem] whitespace-normal px-5 py-5 text-sm font-semibold leading-7 text-zinc-950">{{ $response->evaluationForm->title }}</td>
                                <td class="whitespace-normal px-5 py-5 text-sm leading-7 text-zinc-600">{{ $response->evaluationForm->evaluationPeriod->name }}</td>
                                <td class="whitespace-nowrap px-5 py-5 text-sm leading-7 text-zinc-600">{{ $response->submitted_at->translatedFormat('d M Y, H:i') }}</td>
                            </tr>
                        @endforeach
                    </x-ui.table>
                </div>
            @endif
        </section>
    </div>
</x-layouts.admin>
