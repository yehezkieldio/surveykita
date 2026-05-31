<x-layouts.admin title="Tambah Periode - SurveyKita" heading="Tambah Periode">
    <x-card><form method="POST" action="{{ route('admin.periods.store') }}" class="grid gap-4">@csrf @include('admin.periods.partials.form', ['period' => null])<x-button type="submit">Simpan</x-button></form></x-card>
</x-layouts.admin>
