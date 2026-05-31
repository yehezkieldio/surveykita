<x-layouts.student title="Riwayat Pengisian - SurveyKita" heading="Riwayat Pengisian">
    <x-card>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="border-b text-zinc-600"><tr><th class="py-2">Form</th><th>Periode</th><th>Dikirim</th><th class="text-right">Aksi</th></tr></thead>
                <tbody class="divide-y">
                    @forelse ($responses as $response)
                        <tr>
                            <td class="py-3">{{ $response->evaluationForm->title }}</td>
                            <td>{{ $response->evaluationForm->evaluationPeriod->name }}</td>
                            <td>{{ $response->submitted_at->format('d/m/Y H:i') }}</td>
                            <td class="text-right"><a class="text-teal-700" href="{{ route('student.submissions.success', $response) }}">Detail</a></td>
                        </tr>
                    @empty
                        <tr><td class="py-6 text-center text-zinc-500" colspan="4">Belum ada riwayat pengisian.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($responses)
            <x-pagination :paginator="$responses" />
        @endif
    </x-card>
</x-layouts.student>
