<x-layouts.admin title="Detail Mahasiswa - SurveyKita" heading="Detail Mahasiswa">
    <div class="space-y-6">
        <div class="flex justify-between items-center border-b border-zinc-200 pb-5">
            <div>
                <p class="font-mono text-[10px] uppercase tracking-wider text-zinc-400">Rincian Profil Akademik Mahasiswa</p>
            </div>
            <div class="flex gap-3">
                <x-button variant="secondary" :href="route('admin.students.index')" class="!min-h-9 !py-1 text-xs">Kembali</x-button>
                <x-button :href="route('admin.students.edit', $student)" class="!min-h-9 !py-1 text-xs">Edit</x-button>
            </div>
        </div>

        <x-card heading="{{ $student->name }}" subheading="NIM: {{ $student->nim }} &bull; Program Studi {{ $student->study_program }}">
            <div class="grid gap-6 sm:grid-cols-2 md:grid-cols-4 mt-2">
                <div>
                    <p class="font-mono text-[10px] uppercase tracking-wider text-zinc-400">Akun Email</p>
                    <p class="mt-1.5 text-sm font-bold text-zinc-900 font-mono">{{ $student->user->email }}</p>
                </div>
                <div>
                    <p class="font-mono text-[10px] uppercase tracking-wider text-zinc-400">Kelas</p>
                    <p class="mt-1.5 text-sm font-bold text-zinc-900 font-mono">{{ $student->class_name }}</p>
                </div>
                <div>
                    <p class="font-mono text-[10px] uppercase tracking-wider text-zinc-400">Angkatan</p>
                    <p class="mt-1.5 text-sm font-bold text-zinc-900 font-mono">{{ $student->enrollment_year }}</p>
                </div>
                <div>
                    <p class="font-mono text-[10px] uppercase tracking-wider text-zinc-400">Evaluasi Tersubmit</p>
                    <p class="mt-1.5 text-sm font-bold text-zinc-900 font-mono">{{ $student->responses->count() }} respons</p>
                </div>
            </div>
        </x-card>
    </div>
</x-layouts.admin>
