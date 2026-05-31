<x-layouts.admin title="Tambah Form - SurveyKita" heading="Tambah Form Evaluasi">
    <x-card>
        <form method="POST" action="{{ route('admin.forms.store') }}" class="space-y-6">
            @csrf 
            @include('admin.forms.partials.form', ['form' => null])
            <div class="flex gap-4 border-t border-zinc-100 pt-6">
                <x-button type="submit">Simpan Form</x-button>
                <x-button variant="secondary" :href="route('admin.forms.index')">Batal</x-button>
            </div>
        </form>
    </x-card>
</x-layouts.admin>
