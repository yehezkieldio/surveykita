<x-layouts.student heading="Riwayat Pengisian" eyebrow="Partisipasi Anda">
    @if ($responses->isEmpty())
        <x-ui.empty-state 
            title="Belum ada riwayat pengisian" 
            description="Anda belum pernah mengirimkan formulir evaluasi. Selesaikan pengisian formulir aktif untuk melihat riwayat di sini."
        >
            <x-ui.button href="{{ route('student.evaluations.index') }}" variant="teal">
                Lihat Evaluasi Aktif
            </x-ui.button>
        </x-ui.empty-state>
    @else
        <div class="space-y-6">
            {{-- Desktop Table --}}
            <div class="hidden overflow-hidden border border-zinc-200 bg-white md:block">
                <table class="min-w-full divide-y divide-zinc-200">
                    <thead class="bg-zinc-50">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold uppercase tracking-widest text-zinc-500">Formulir & Periode</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold uppercase tracking-widest text-zinc-500">Waktu Pengiriman</th>
                            <th scope="col" class="px-6 py-4 text-right text-xs font-bold uppercase tracking-widest text-zinc-500">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100 bg-white">
                        @foreach ($responses as $response)
                            <tr class="group transition-colors hover:bg-zinc-50/50">
                                <td class="whitespace-nowrap px-6 py-5">
                                    <div class="flex flex-col">
                                        <span class="text-sm font-semibold text-zinc-950">{{ $response->evaluationForm->title }}</span>
                                        <span class="text-xs text-zinc-500 mt-0.5">{{ $response->evaluationForm->evaluationPeriod->name }}</span>
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-6 py-5 text-sm text-zinc-600">
                                    {{ $response->submitted_at->translatedFormat('d M Y, H:i') }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-5 text-right">
                                    <x-ui.button href="{{ route('student.submissions.success', $response) }}" variant="ghost" size="sm">
                                        Detail
                                    </x-ui.button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Mobile Cards --}}
            <div class="space-y-4 md:hidden">
                @foreach ($responses as $response)
                    <x-ui.card class="relative p-5 sm:p-6">
                        <div class="mb-4 flex items-start justify-between gap-4">
                            <div class="min-w-0 space-y-1">
                                <p class="text-xs font-bold uppercase tracking-widest text-zinc-400">
                                    {{ $response->evaluationForm->evaluationPeriod->name }}
                                </p>
                                <h4 class="text-base font-bold text-zinc-950">{{ $response->evaluationForm->title }}</h4>
                            </div>
                        </div>
                        <div class="flex items-center justify-between border-t border-zinc-100 pt-4">
                            <span class="text-xs text-zinc-500">{{ $response->submitted_at->translatedFormat('d M Y, H:i') }}</span>
                            <a href="{{ route('student.submissions.success', $response) }}" class="text-xs font-bold text-teal-600 uppercase tracking-widest">Detail</a>
                        </div>
                    </x-ui.card>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $responses->links() }}
            </div>
        </div>
    @endif
</x-layouts.student>
