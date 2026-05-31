<x-layouts.admin title="Edit Periode - SurveyKita" heading="Edit Periode">
    <x-card>
        <form method="POST" action="{{ route('admin.periods.update', $period) }}" class="space-y-6">
            @csrf 
            @method('PUT') 
            @include('admin.periods.partials.form', ['period' => $period])
            <div class="flex gap-4 border-t border-zinc-100 pt-6">
                <x-button type="submit">Perbarui Periode</x-button>
                <x-button variant="secondary" :href="route('admin.periods.index')">Batal</x-button>
            </div>
        </form>
    </x-card>
</x-layouts.admin>
