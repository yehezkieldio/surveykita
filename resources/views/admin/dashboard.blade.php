<x-layouts.admin heading="Dashboard Admin" eyebrow="Ringkasan Sistem">
    <x-slot:actions>
        <div class="flex items-center gap-3">
            <div class="hidden sm:flex flex-col items-end mr-4">
                <p class="text-[10px] font-bold uppercase tracking-widest text-zinc-400">Status Saat Ini</p>
                <p class="text-sm font-semibold text-zinc-950">
                    {{ $activePeriodCount > 0 ? 'Sistem Aktif' : 'Periode Tertutup' }}
                </p>
            </div>
            <x-ui.button href="{{ route('admin.periods.index') }}" variant="secondary" size="sm">
                Kelola Periode
            </x-ui.button>
            <x-ui.button href="{{ route('admin.results.index') }}" variant="teal" class="opacity-50 cursor-not-allowed" size="sm">
                Lihat Hasil
            </x-ui.button>
        </div>
    </x-slot:actions>

    {{-- 1. Opening Command Panel --}}
    <x-ui.card class="mb-8 border-teal-600/20 bg-teal-50/10">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <div class="max-w-2xl">
                <h2 class="text-lg font-bold text-zinc-950">Selamat Datang di Admin Console SurveyKita</h2>
                <p class="mt-2 text-sm leading-relaxed text-zinc-600">
                    Gunakan panel ini untuk memantau periode evaluasi yang sedang berjalan, mengelola instrumen pertanyaan, dan melihat respons mahasiswa secara real-time. Pastikan setiap formulir aktif telah memiliki pertanyaan yang memadai sebelum periode berakhir.
                </p>
            </div>
            <div class="flex flex-col gap-2 shrink-0 lg:text-right">
                <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-zinc-400">Tanggal Hari Ini</p>
                <p class="text-lg font-mono font-bold text-zinc-950">{{ now()->translatedFormat('d F Y') }}</p>
            </div>
        </div>
    </x-ui.card>

    {{-- 2. Metric Cards --}}
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 mb-12">
        <x-ui.card no-padding class="flex flex-col justify-center p-6 group transition-all hover:border-zinc-300">
            <p class="text-[10px] font-bold uppercase tracking-widest text-zinc-400">Mahasiswa</p>
            <div class="mt-2 flex items-baseline gap-1">
                <span class="text-3xl font-bold tracking-tight text-zinc-950">{{ number_format($studentCount) }}</span>
            </div>
            <p class="mt-1 text-[10px] text-zinc-500 font-medium">Total Terdaftar</p>
        </x-ui.card>

        <x-ui.card no-padding class="flex flex-col justify-center p-6 group transition-all hover:border-zinc-300 border-l-4 border-l-teal-500">
            <p class="text-[10px] font-bold uppercase tracking-widest text-zinc-400">Periode Aktif</p>
            <div class="mt-2 flex items-baseline gap-1">
                <span class="text-3xl font-bold tracking-tight text-zinc-950">{{ $activePeriodCount }}</span>
            </div>
            <p class="mt-1 text-[10px] text-zinc-500 font-medium">Sedang Berjalan</p>
        </x-ui.card>

        <x-ui.card no-padding class="flex flex-col justify-center p-6 group transition-all hover:border-zinc-300">
            <p class="text-[10px] font-bold uppercase tracking-widest text-zinc-400">Form Aktif</p>
            <div class="mt-2 flex items-baseline gap-1">
                <span class="text-3xl font-bold tracking-tight text-zinc-950">{{ $activeFormCount }}</span>
            </div>
            <p class="mt-1 text-[10px] text-zinc-500 font-medium">Instrumen Evaluasi</p>
        </x-ui.card>

        <x-ui.card no-padding class="flex flex-col justify-center p-6 group transition-all hover:border-zinc-300">
            <p class="text-[10px] font-bold uppercase tracking-widest text-zinc-400">Pertanyaan</p>
            <div class="mt-2 flex items-baseline gap-1">
                <span class="text-3xl font-bold tracking-tight text-zinc-950">{{ number_format($questionCount) }}</span>
            </div>
            <p class="mt-1 text-[10px] text-zinc-500 font-medium">Total Bank Soal</p>
        </x-ui.card>

        <x-ui.card no-padding class="flex flex-col justify-center p-6 group transition-all hover:border-zinc-300">
            <p class="text-[10px] font-bold uppercase tracking-widest text-zinc-400">Respons Masuk</p>
            <div class="mt-2 flex items-baseline gap-1">
                <span class="text-3xl font-bold tracking-tight text-zinc-950">{{ number_format($responseCount) }}</span>
            </div>
            <p class="mt-1 text-[10px] text-zinc-500 font-medium">Seluruh Periode</p>
        </x-ui.card>

        <x-ui.card no-padding class="flex flex-col justify-center p-6 group transition-all hover:border-zinc-300 bg-zinc-950 text-white border-none shadow-xl">
            <p class="text-[10px] font-bold uppercase tracking-widest text-zinc-500">Cakupan</p>
            <div class="mt-2 flex items-baseline gap-1">
                <span class="text-3xl font-bold tracking-tight">{{ $completionPercentage }}%</span>
            </div>
            <p class="mt-1 text-[10px] text-zinc-400 font-medium">Partisipasi Aktif</p>
        </x-ui.card>
    </div>

    <div class="grid gap-8 lg:grid-cols-3">
        <div class="lg:col-span-2 space-y-8">
            {{-- 3. Active Forms Overview --}}
            <section>
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-sm font-bold uppercase tracking-[0.2em] text-zinc-400">Ikhtisar Form Aktif</h3>
                    <x-ui.badge variant="zinc">{{ $activeForms->count() }} Formulir</x-ui.badge>
                </div>

                @if($activeForms->isEmpty())
                    <x-ui.empty-state title="Belum ada form aktif" description="Aktifkan form evaluasi melalui menu Periode untuk mulai mengumpulkan data." />
                @else
                    <div class="grid gap-4">
                        @foreach($activeForms as $form)
                            <div class="flex items-center justify-between p-4 border border-zinc-200 bg-white group hover:border-zinc-300 transition-all">
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2 mb-1">
                                        <x-ui.badge variant="teal" class="scale-90 origin-left">AKTIF</x-ui.badge>
                                        <span class="text-[10px] font-mono text-zinc-400 uppercase tracking-tighter">{{ $form->evaluationPeriod->name }}</span>
                                    </div>
                                    <h4 class="text-sm font-bold text-zinc-950 truncate">{{ $form->title }}</h4>
                                </div>
                                <div class="flex items-center gap-6 ml-4">
                                    <div class="text-right">
                                        <p class="text-[10px] font-bold uppercase text-zinc-400 tracking-widest">Soal</p>
                                        <p class="text-xs font-bold text-zinc-950">{{ $form->questions_count }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-[10px] font-bold uppercase text-zinc-400 tracking-widest">Respons</p>
                                        <p class="text-xs font-bold text-teal-600">{{ $form->responses_count }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </section>

            {{-- 5. Recent Responses --}}
            <section>
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-sm font-bold uppercase tracking-[0.2em] text-zinc-400">Respons Terbaru</h3>
                </div>

                @if($recentResponses->isEmpty())
                    <x-ui.empty-state title="Belum ada respons" description="Data respons akan muncul di sini segera setelah mahasiswa mengisi evaluasi." />
                @else
                    <div class="overflow-hidden border border-zinc-200 bg-white">
                        <table class="min-w-full divide-y divide-zinc-200">
                            <thead class="bg-zinc-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-[10px] font-bold uppercase tracking-widest text-zinc-500">Mahasiswa</th>
                                    <th class="px-6 py-3 text-left text-[10px] font-bold uppercase tracking-widest text-zinc-500">Formulir</th>
                                    <th class="px-6 py-3 text-right text-[10px] font-bold uppercase tracking-widest text-zinc-500">Waktu</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-zinc-100">
                                @foreach($recentResponses as $response)
                                    <tr class="hover:bg-zinc-50/50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-bold text-zinc-950">{{ $response->student->name }}</div>
                                            <div class="text-[10px] font-mono text-zinc-400">{{ $response->student->nim }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-xs font-semibold text-zinc-700">{{ $response->evaluationForm->title }}</div>
                                            <div class="text-[10px] text-zinc-400">{{ $response->evaluationForm->evaluationPeriod->name }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-xs text-zinc-500">
                                            {{ $response->submitted_at->diffForHumans() }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </section>
        </div>

        <aside class="space-y-8">
            {{-- 4. Attention Section --}}
            <section>
                <h3 class="text-sm font-bold uppercase tracking-[0.2em] text-zinc-400 mb-6">Pusat Perhatian</h3>
                <div class="space-y-4">
                    @if($formsWithoutQuestions->isNotEmpty())
                        @foreach($formsWithoutQuestions as $form)
                            <div class="p-4 border border-amber-200 bg-amber-50/30 rounded-none">
                                <div class="flex items-start gap-3">
                                    <svg class="h-5 w-5 text-amber-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                                    </svg>
                                    <div>
                                        <p class="text-xs font-bold text-amber-800 uppercase tracking-tight">Butuh Pertanyaan</p>
                                        <p class="mt-1 text-xs text-amber-700 leading-normal">
                                            Form <strong>{{ $form->title }}</strong> aktif tapi belum memiliki pertanyaan.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif

                    @if($activePeriodCount === 0)
                        <div class="p-4 border border-zinc-200 bg-white rounded-none">
                            <div class="flex items-start gap-3 text-zinc-400">
                                <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                                </svg>
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-tight">Info Operasional</p>
                                    <p class="mt-1 text-xs leading-normal">
                                        Tidak ada periode evaluasi yang aktif saat ini.
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($studentCount === 0)
                        <div class="p-4 border border-red-200 bg-red-50/30 rounded-none">
                            <div class="flex items-start gap-3">
                                <svg class="h-5 w-5 text-red-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                </svg>
                                <div>
                                    <p class="text-xs font-bold text-red-800 uppercase tracking-tight">Sistem Kosong</p>
                                    <p class="mt-1 text-xs text-red-700 leading-normal">
                                        Belum ada data mahasiswa terdaftar. Impor atau tambahkan mahasiswa.
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </section>

            {{-- 6. Admin Workflow Guide --}}
            <section class="p-6 bg-zinc-900 text-white rounded-none">
                <h3 class="text-xs font-bold uppercase tracking-[0.2em] text-zinc-500 mb-6">Alur Operasional</h3>
                <nav>
                    <ul class="space-y-6">
                        <li class="flex gap-4">
                            <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full border border-zinc-700 font-mono text-[10px] text-zinc-500 font-bold">01</span>
                            <div>
                                <p class="text-xs font-bold uppercase tracking-tight">Buka Periode</p>
                                <p class="mt-1 text-[10px] leading-normal text-zinc-400">Tentukan rentang waktu pengisian evaluasi mahasiswa.</p>
                            </div>
                        </li>
                        <li class="flex gap-4">
                            <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full border border-zinc-700 font-mono text-[10px] text-zinc-500 font-bold">02</span>
                            <div>
                                <p class="text-xs font-bold uppercase tracking-tight">Susun Form</p>
                                <p class="mt-1 text-[10px] leading-normal text-zinc-400">Buat formulir evaluasi untuk periode yang telah ditentukan.</p>
                            </div>
                        </li>
                        <li class="flex gap-4">
                            <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full border border-zinc-700 font-mono text-[10px] text-zinc-500 font-bold">03</span>
                            <div>
                                <p class="text-xs font-bold uppercase tracking-tight">Instrumen Soal</p>
                                <p class="mt-1 text-[10px] leading-normal text-zinc-400">Tambahkan kategori dan butir pertanyaan ke formulir.</p>
                            </div>
                        </li>
                        <li class="flex gap-4">
                            <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full border border-zinc-700 font-mono text-[10px] text-zinc-500 font-bold">04</span>
                            <div>
                                <p class="text-xs font-bold uppercase tracking-tight">Pantau & Ekspor</p>
                                <p class="mt-1 text-[10px] leading-normal text-zinc-400">Monitor partisipasi dan unduh laporan hasil evaluasi.</p>
                            </div>
                        </li>
                    </ul>
                </nav>
            </section>
        </aside>
    </div>
</x-layouts.admin>
