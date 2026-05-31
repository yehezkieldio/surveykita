<x-layouts.admin title="Edit Pertanyaan - SurveyKita" heading="Edit Pertanyaan">
    <x-card><form method="POST" action="{{ route('admin.questions.update', $question) }}" class="grid gap-4">@csrf @method('PUT') @include('admin.questions.partials.form', ['question' => $question])<x-button type="submit">Perbarui</x-button></form></x-card>
</x-layouts.admin>
