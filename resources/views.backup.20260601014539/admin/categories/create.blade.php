<x-layouts.admin title="Tambah Kategori - SurveyKita" heading="Tambah Kategori">
    <x-card><form method="POST" action="{{ route('admin.categories.store') }}" class="grid gap-4">@csrf @include('admin.categories.partials.form', ['category' => null])<x-button type="submit">Simpan</x-button></form></x-card>
</x-layouts.admin>
