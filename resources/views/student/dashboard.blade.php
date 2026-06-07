<x-layouts.student heading="Dashboard Mahasiswa" eyebrow="Halo, {{ Auth::user()->name }}">
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        <x-ui.card class="relative overflow-hidden group">
            <div class="absolute right-0 top-0 -mr-4 -mt-4 h-24 w-24 rounded-full bg-zinc-50 transition-transform group-hover:scale-110"></div>
            <p class="text-xs font-bold uppercase tracking-widest text-zinc-400">Profil Saya</p>
            <div class="mt-4 flex items-baseline gap-2">
                <span @class([
                    'text-2xl font-bold tracking-tight',
                    'text-teal-600' => $profileComplete,
                    'text-red-600' => !$profileComplete,
                ])>
                    {{ $profileComplete ? 'Lengkap' : 'Belum Lengkap' }}
                </span>
            </div>
            <p class="mt-1 text-xs text-zinc-500">Status identitas akademik</p>
        </x-ui.card>

        <x-ui.card class="relative overflow-hidden group">
            <div class="absolute right-0 top-0 -mr-4 -mt-4 h-24 w-24 rounded-full bg-zinc-50 transition-transform group-hover:scale-110"></div>
            <p class="text-xs font-bold uppercase tracking-widest text-zinc-400">Evaluasi Aktif</p>
            <div class="mt-4 flex items-baseline gap-2">
                <span class="text-4xl font-bold tracking-tight text-zinc-950">{{ $activeFormCount }}</span>
                <span class="text-sm font-medium text-zinc-500">Formulir</span>
            </div>
            <p class="mt-1 text-xs text-zinc-500">Tersedia untuk diisi sekarang</p>
        </x-ui.card>

        <x-ui.card class="relative overflow-hidden group">
            <div class="absolute right-0 top-0 -mr-4 -mt-4 h-24 w-24 rounded-full bg-zinc-50 transition-transform group-hover:scale-110"></div>
            <p class="text-xs font-bold uppercase tracking-widest text-zinc-400">Total Pengisian</p>
            <div class="mt-4 flex items-baseline gap-2">
                <span class="text-4xl font-bold tracking-tight text-zinc-950">{{ $submissionCount }}</span>
                <span class="text-sm font-medium text-zinc-500">Selesai</span>
            </div>
            <p class="mt-1 text-xs text-zinc-500">Riwayat partisipasi Anda</p>
        </x-ui.card>
    </div>

    <div class="mt-12">
        <h3 class="text-sm font-bold uppercase tracking-[0.2em] text-zinc-400 mb-6">Tindakan Selanjutnya</h3>

        <div class="grid gap-6">
            @if (!$profileComplete)
                <x-ui.card class="border-red-100 bg-red-50/30">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <h4 class="font-semibold text-zinc-950">Lengkapi profil Anda</h4>
                            <p class="mt-1 text-sm text-zinc-600">Anda harus melengkapi NIM dan data akademik sebelum dapat mengisi evaluasi.</p>
                        </div>
                        <x-ui.button href="{{ route('student.profile.complete') }}" variant="danger">
                            Lengkapi Sekarang
                        </x-ui.button>
                    </div>
                </x-ui.card>
            @elseif ($activeFormCount > 0)
                <x-ui.card class="border-teal-100 bg-teal-50/30">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <h4 class="font-semibold text-zinc-950">Evaluasi aktif tersedia</h4>
                            <p class="mt-1 text-sm text-zinc-600">Ada {{ $activeFormCount }} formulir evaluasi aktif yang bisa Anda akses saat ini.</p>
                        </div>
                        <x-ui.button href="{{ route('student.evaluations.index') }}" variant="teal">
                            Lihat Evaluasi
                        </x-ui.button>
                    </div>
                </x-ui.card>
            @else
                <x-ui.card>
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <h4 class="font-semibold text-zinc-950">Belum ada evaluasi baru</h4>
                            <p class="mt-1 text-sm text-zinc-600">Terima kasih telah berpartisipasi. Semua evaluasi saat ini telah selesai atau belum dibuka.</p>
                        </div>
                        <x-ui.button href="{{ route('student.submissions.index') }}" variant="secondary">
                            Lihat Riwayat
                        </x-ui.button>
                    </div>
                </x-ui.card>
            @endif
        </div>
    </div>

    <div class="mt-12 grid gap-8 lg:grid-cols-2">
        <div>
            <h3 class="text-sm font-bold uppercase tracking-[0.2em] text-zinc-400 mb-6">Aktivitas Saya</h3>
            <div class="divide-y divide-zinc-200 border-t border-zinc-200">
                <a href="{{ route('student.evaluations.index') }}" class="group flex items-center justify-between py-4 transition-colors hover:bg-zinc-50/50">
                    <div class="flex items-center gap-4">
                        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-zinc-100 text-zinc-500 group-hover:bg-zinc-950 group-hover:text-white transition-colors">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .415.162.798.425 1.081.263.283.646.445 1.075.445.429 0 .812-.162 1.095-.445.283-.283.445-.666.445-1.081 0-.231-.035-.454-.1-.664m-5.801 0A22.509 22.509 0 0112 2.25c2.768 0 5.36.495 7.75 1.392m-7.75 0a22.509 22.509 0 00-7.75 1.392" /></svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-zinc-950">Evaluasi Tersedia</p>
                            <p class="text-xs text-zinc-500">Lihat daftar formulir yang aktif</p>
                        </div>
                    </div>
                    <svg class="h-5 w-5 text-zinc-300 group-hover:text-zinc-950 transition-colors" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" /></svg>
                </a>
                <a href="{{ route('student.submissions.index') }}" class="group flex items-center justify-between py-4 transition-colors hover:bg-zinc-50/50">
                    <div class="flex items-center gap-4">
                        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-zinc-100 text-zinc-500 group-hover:bg-zinc-950 group-hover:text-white transition-colors">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-zinc-950">Riwayat Pengisian</p>
                            <p class="text-xs text-zinc-500">Lihat kembali evaluasi yang telah Anda kirim</p>
                        </div>
                    </div>
                    <svg class="h-5 w-5 text-zinc-300 group-hover:text-zinc-950 transition-colors" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" /></svg>
                </a>
            </div>
        </div>
        
        <div class="rounded-lg border border-zinc-200 bg-white p-6">
            <h3 class="text-sm font-semibold text-zinc-950">Status Akademik</h3>
            <div class="mt-6 space-y-4">
                <div class="flex items-center justify-between py-2 border-b border-zinc-100">
                    <span class="text-xs font-medium text-zinc-500">NIM</span>
                    <span class="text-sm font-mono text-zinc-950">{{ Auth::user()->student?->nim ?? '-' }}</span>
                </div>
                <div class="flex items-center justify-between py-2 border-b border-zinc-100">
                    <span class="text-xs font-medium text-zinc-500">Program Studi</span>
                    <span class="text-sm text-zinc-950">{{ Auth::user()->student?->study_program ?? '-' }}</span>
                </div>
                <div class="flex items-center justify-between py-2">
                    <span class="text-xs font-medium text-zinc-500">Kelas</span>
                    <span class="text-sm text-zinc-950">{{ Auth::user()->student?->class_name ?? '-' }}</span>
                </div>
            </div>
        </div>
    </div>
</x-layouts.student>
