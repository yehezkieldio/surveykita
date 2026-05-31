<x-layouts.student title="Riwayat Pengisian - SurveyKita" heading="Riwayat Pengisian" eyebrow="Riwayat Aktivitas Anda">
    <x-table :headers="['Form Evaluasi', 'Periode', 'Tanggal Kirim', 'Aksi']">
        @forelse ($responses as $response)
            <tr class="hover:bg-zinc-50/50 transition-colors duration-150">
                <td class="px-6 py-4 font-bold text-zinc-900">{{ $response->evaluationForm->title }}</td>
                <td class="px-6 py-4 text-zinc-500 font-mono text-[11px]">{{ $response->evaluationForm->evaluationPeriod->name }}</td>
                <td class="px-6 py-4 text-zinc-500 font-mono text-[11px]">{{ $response->submitted_at->format('d M Y H:i') }}</td>
                <td class="px-6 py-4">
                    <div class="flex items-center text-[10px] font-mono uppercase tracking-wider">
                        <a class="font-bold text-zinc-900 hover:underline" href="{{ route('student.submissions.success', $response) }}">Lihat Detail</a>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td class="px-6 py-12 text-center" colspan="4">
                    <x-empty-state title="Belum ada riwayat" description="Kuesioner evaluasi yang berhasil Anda isi dan kirim akan tercatat di sini." />
                </td>
            </tr>
        @endforelse
    </x-table>

    @if ($responses)
        <x-pagination :paginator="$responses" />
    @endif
</x-layouts.student>
