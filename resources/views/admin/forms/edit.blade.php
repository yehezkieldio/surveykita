<x-layouts.admin title="Edit Form - SurveyKita" heading="Edit Form Evaluasi">
    <x-card><form method="POST" action="{{ route('admin.forms.update', $form) }}" class="grid gap-4">@csrf @method('PUT') @include('admin.forms.partials.form', ['form' => $form])<x-button type="submit">Perbarui</x-button></form></x-card>
</x-layouts.admin>
