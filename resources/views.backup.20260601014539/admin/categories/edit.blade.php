<x-layouts.admin title="Edit Kategori - SurveyKita" heading="Edit Kategori">
    <x-card><form method="POST" action="{{ route('admin.categories.update', $category) }}" class="grid gap-4">@csrf @method('PUT') @include('admin.categories.partials.form', ['category' => $category])<x-button type="submit">Perbarui</x-button></form></x-card>
</x-layouts.admin>
