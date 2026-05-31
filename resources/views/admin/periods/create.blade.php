<x-layouts.admin title="Tambah Periode - SurveyKita" heading="Tambah Periode">
    <x-card>
        <form method="POST" action="{{ route('admin.periods.store') }}" class="space-y-6">
            @csrf 
            @include('admin.periods.partials.form', ['period' => null])
            <div class="flex gap-4 border-t border-zinc-100 pt-6">
                <x-button type="submit">Simpan Periode</x-button>
                <x-button variant="secondary" :href="route('admin.periods.index')">Batal</x-button>
            </div>
        </form>
    </x-card>
</x-layouts.admin>
