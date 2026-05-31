<x-layouts.admin title="Edit Kategori - SurveyKita" heading="Edit Kategori">
    <x-card>
        <form method="POST" action="{{ route('admin.categories.update', $category) }}" class="grid gap-6">
            @csrf @method('PUT')
            @include('admin.categories.partials.form', ['category' => $category])
            <div class="sk-actions"><x-button type="submit">Perbarui Kategori</x-button><x-button variant="secondary" :href="route('admin.categories.index')">Batal</x-button></div>
        </form>
    </x-card>
</x-layouts.admin>
