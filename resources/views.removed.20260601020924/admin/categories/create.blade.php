<x-layouts.admin title="Tambah Kategori - SurveyKita" heading="Tambah Kategori">
    <x-card>
        <form method="POST" action="{{ route('admin.categories.store') }}" class="grid gap-6">
            @csrf
            @include('admin.categories.partials.form', ['category' => null])
            <div class="sk-actions"><x-button type="submit">Simpan Kategori</x-button><x-button variant="secondary" :href="route('admin.categories.index')">Batal</x-button></div>
        </form>
    </x-card>
</x-layouts.admin>
