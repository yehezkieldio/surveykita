<x-layouts.admin title="Tambah Pertanyaan - SurveyKita" heading="Tambah Pertanyaan">
    <x-card><form method="POST" action="{{ route('admin.questions.store') }}" class="grid gap-4">@csrf @include('admin.questions.partials.form', ['question' => null])<x-button type="submit">Simpan</x-button></form></x-card>
</x-layouts.admin>
