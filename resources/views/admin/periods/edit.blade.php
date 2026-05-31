<x-layouts.admin title="Edit Periode - SurveyKita" heading="Edit Periode">
    <x-card><form method="POST" action="{{ route('admin.periods.update', $period) }}" class="grid gap-4">@csrf @method('PUT') @include('admin.periods.partials.form', ['period' => $period])<x-button type="submit">Perbarui</x-button></form></x-card>
</x-layouts.admin>
