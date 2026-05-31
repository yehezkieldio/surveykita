<x-layouts.student title="Riwayat Pengisian - SurveyKita" heading="Riwayat Pengisian" eyebrow="Respons yang sudah dikirim">
    <x-table :headers="['Form Evaluasi', 'Periode', 'Tanggal Kirim', 'Aksi']">
        @forelse ($responses as $response)
            <tr class="hover:bg-zinc-50">
                <td class="px-5 py-5"><p class="font-semibold">{{ $response->evaluationForm->title }}</p><p class="mt-1 text-sm text-zinc-500">Respons tersimpan dan dapat dibuka kembali.</p></td>
                <td class="px-5 py-5 text-zinc-600">{{ $response->evaluationForm->evaluationPeriod->name }}</td>
                <td class="px-5 py-5 font-mono text-sm text-zinc-700">{{ $response->submitted_at->format('d M Y H:i') }}</td>
                <td class="px-5 py-5"><a class="sk-link" href="{{ route('student.submissions.success', $response) }}">Lihat Detail</a></td>
            </tr>
        @empty
            <tr><td class="px-5 py-10" colspan="4"><x-empty-state title="Belum ada riwayat" description="Kuesioner evaluasi yang berhasil Anda isi dan kirim akan tercatat di sini." /></td></tr>
        @endforelse
    </x-table>
    @if ($responses)<x-pagination :paginator="$responses" />@endif
</x-layouts.student>
