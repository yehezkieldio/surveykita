<x-layouts.admin title="Edit Pertanyaan - SurveyKita" heading="Edit Pertanyaan">
    <x-card>
        <form method="POST" action="{{ route('admin.questions.update', $question) }}" class="space-y-6">
            @csrf 
            @method('PUT') 
            @include('admin.questions.partials.form', ['question' => $question])
            <div class="flex gap-4 border-t border-zinc-100 pt-6">
                <x-button type="submit">Perbarui Pertanyaan</x-button>
                <x-button variant="secondary" :href="route('admin.questions.index')">Batal</x-button>
            </div>
        </form>
    </x-card>
</x-layouts.admin>
