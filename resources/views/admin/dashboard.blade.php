<x-layouts.admin heading="{{ auth()->user()->name }}" eyebrow="Selamat datang kembali">
    <x-slot:actions>
        <div class="flex items-center gap-3">
            <x-ui.button href="{{ route('admin.results.index') }}" variant="teal" size="sm">
                Lihat Hasil Evaluasi
            </x-ui.button>
        </div>
    </x-slot:actions>

    {{-- 1. Metric Cards - Split into 3 per row --}}
    <div class="space-y-6 mb-12">
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <x-ui.card no-padding class="flex flex-col justify-center p-6 group transition-all hover:border-zinc-300">
                <p class="text-[10px] font-bold uppercase tracking-widest text-zinc-400">Total Mahasiswa</p>
                <div class="mt-2 flex items-baseline gap-1">
                    <span class="text-3xl font-bold tracking-tight text-zinc-950">{{ number_format($studentCount) }}</span>
                </div>
                <p class="mt-1 text-[10px] text-zinc-500 font-medium">Mahasiswa Terdaftar</p>
            </x-ui.card>

            <x-ui.card no-padding class="flex flex-col justify-center p-6 group transition-all hover:border-zinc-300">
                <p class="text-[10px] font-bold uppercase tracking-widest text-zinc-400">Periode Aktif</p>
                <div class="mt-2 flex items-baseline gap-1">
                    <span class="text-3xl font-bold tracking-tight text-zinc-950">{{ $activePeriodCount }}</span>
                </div>
                <p class="mt-1 text-[10px] text-zinc-500 font-medium">Sedang Berjalan</p>
            </x-ui.card>

            <x-ui.card no-padding class="flex flex-col justify-center p-6 group transition-all hover:border-zinc-300">
                <p class="text-[10px] font-bold uppercase tracking-widest text-zinc-400">Cakupan Partisipasi</p>
                <div class="mt-2 flex items-baseline gap-1">
                    <span class="text-3xl font-bold tracking-tight text-zinc-950">{{ $completionPercentage }}%</span>
                </div>
                <p class="mt-1 text-[10px] text-zinc-500 font-medium">Mahasiswa Aktif Mengisi</p>
            </x-ui.card>
        </div>

        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <x-ui.card no-padding class="flex flex-col justify-center p-6 group transition-all hover:border-zinc-300">
                <p class="text-[10px] font-bold uppercase tracking-widest text-zinc-400">Form Aktif</p>
                <div class="mt-2 flex items-baseline gap-1">
                    <span class="text-3xl font-bold tracking-tight text-zinc-950">{{ $activeFormCount }}</span>
                </div>
                <p class="mt-1 text-[10px] text-zinc-500 font-medium">Instrumen Evaluasi</p>
            </x-ui.card>

            <x-ui.card no-padding class="flex flex-col justify-center p-6 group transition-all hover:border-zinc-300">
                <p class="text-[10px] font-bold uppercase tracking-widest text-zinc-400">Total Bank Soal</p>
                <div class="mt-2 flex items-baseline gap-1">
                    <span class="text-3xl font-bold tracking-tight text-zinc-950">{{ number_format($questionCount) }}</span>
                </div>
                <p class="mt-1 text-[10px] text-zinc-500 font-medium">Pertanyaan Tersedia</p>
            </x-ui.card>

            <x-ui.card no-padding class="flex flex-col justify-center p-6 group transition-all hover:border-zinc-300">
                <p class="text-[10px] font-bold uppercase tracking-widest text-zinc-400">Respons Terkumpul</p>
                <div class="mt-2 flex items-baseline gap-1">
                    <span class="text-3xl font-bold tracking-tight text-zinc-950">{{ number_format($responseCount) }}</span>
                </div>
                <p class="mt-1 text-[10px] text-zinc-500 font-medium">Seluruh Periode</p>
            </x-ui.card>
        </div>
    </div>

    {{-- 2. Data Tables - Full Width Layout --}}
    <div class="space-y-12">
        {{-- Active Forms Overview --}}
        <section>
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-sm font-bold uppercase tracking-[0.2em] text-zinc-400">Rangkuman Form Aktif</h3>
                <x-ui.badge variant="zinc">{{ $activeForms->count() }} Formulir Aktif</x-ui.badge>
            </div>

            @if($activeForms->isEmpty())
                <x-ui.empty-state title="Belum ada form aktif" description="Aktifkan form evaluasi melalui menu Periode untuk mulai mengumpulkan data." />
            @else
                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach($activeForms as $form)
                        <div class="flex flex-col justify-between p-6 border border-zinc-200 bg-white group hover:border-zinc-300 transition-all">
                            <div class="mb-4">
                                <x-ui.badge variant="teal" class="mb-2">AKTIF</x-ui.badge>
                                <p class="text-[10px] font-mono text-zinc-400 uppercase tracking-tighter mb-2 mt-1">{{ $form->evaluationPeriod->name }}</p>
                                <h4 class="text-base font-bold text-zinc-950">{{ $form->title }}</h4>
                            </div>
                            <div class="flex items-center justify-between pt-4 border-t border-zinc-50">
                                <div class="text-left">
                                    <p class="text-[10px] font-bold uppercase text-zinc-400 tracking-widest">Soal</p>
                                    <p class="text-sm font-bold text-zinc-950">{{ $form->questions_count }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-[10px] font-bold uppercase text-zinc-400 tracking-widest">Respons</p>
                                    <p class="text-sm font-bold text-teal-700">{{ $form->responses_count }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </section>

        {{-- Recent Responses --}}
        <section>
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-sm font-bold uppercase tracking-[0.2em] text-zinc-400">Respons Terbaru</h3>
                <x-ui.button href="{{ route('admin.results.index') }}" variant="ghost" size="sm">Lihat Semua</x-ui.button>
            </div>

            @if($recentResponses->isEmpty())
                <x-ui.empty-state title="Belum ada respons" description="Data respons akan muncul di sini segera setelah mahasiswa mengisi evaluasi." />
            @else
                <x-ui.table :headers="['Mahasiswa', 'Formulir', 'Waktu Pengiriman']">
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
                </x-ui.table>
            @endif
        </section>
    </div>
</x-layouts.admin>
