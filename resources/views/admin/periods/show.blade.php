<x-layouts.admin title="Detail Periode - SurveyKita" heading="Detail Periode">
    <x-card heading="{{ $period->name }}" subheading="{{ $period->semester }} {{ $period->academic_year }}">
        <p class="text-sm text-zinc-700">{{ $period->start_date->format('d/m/Y') }} - {{ $period->end_date->format('d/m/Y') }} · {{ $period->is_active ? 'Aktif' : 'Nonaktif' }} · {{ $period->evaluation_forms_count }} form</p>
        <div class="mt-4 flex gap-2"><x-button :href="route('admin.periods.edit', $period)">Edit</x-button><x-button variant="secondary" :href="route('admin.periods.index')">Kembali</x-button></div>
    </x-card>
</x-layouts.admin>
