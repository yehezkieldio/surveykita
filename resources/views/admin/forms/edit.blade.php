<x-layouts.admin title="Edit Form - SurveyKita" heading="Edit Form Evaluasi">
    <x-card>
        <form method="POST" action="{{ route('admin.forms.update', $form) }}" class="space-y-6">
            @csrf 
            @method('PUT') 
            @include('admin.forms.partials.form', ['form' => $form])
            <div class="flex gap-4 border-t border-zinc-100 pt-6">
                <x-button type="submit">Perbarui Form</x-button>
                <x-button variant="secondary" :href="route('admin.forms.index')">Batal</x-button>
            </div>
        </form>
    </x-card>
</x-layouts.admin>
