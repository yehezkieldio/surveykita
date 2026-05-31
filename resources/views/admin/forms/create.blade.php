<x-layouts.admin title="Tambah Form - SurveyKita" heading="Tambah Form Evaluasi">
    <x-card><form method="POST" action="{{ route('admin.forms.store') }}" class="grid gap-4">@csrf @include('admin.forms.partials.form', ['form' => null])<x-button type="submit">Simpan</x-button></form></x-card>
</x-layouts.admin>
