<x-layouts.admin title="Tambah Pertanyaan - SurveyKita" heading="Tambah Pertanyaan">
    <x-card>
        <form method="POST" action="{{ route('admin.questions.store') }}" class="space-y-6">
            @csrf 
            @include('admin.questions.partials.form', ['question' => null])
            <div class="flex gap-4 border-t border-zinc-100 pt-6">
                <x-button type="submit">Simpan Pertanyaan</x-button>
                <x-button variant="secondary" :href="route('admin.questions.index')">Batal</x-button>
            </div>
        </form>
    </x-card>
</x-layouts.admin>
