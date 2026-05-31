<x-layouts.admin title="Detail Form - SurveyKita" heading="Detail Form Evaluasi">
    <x-card heading="{{ $form->title }}" subheading="{{ $form->evaluationPeriod->name }}">
        <p class="text-sm text-zinc-700">{{ $form->description }}</p>
        <p class="mt-2 text-sm text-zinc-700">{{ $form->target_type }} · {{ $form->is_active ? 'Aktif' : 'Nonaktif' }} · {{ $form->responses_count }} respons</p>
        <div class="mt-4 flex gap-2"><x-button :href="route('admin.forms.edit', $form)">Edit</x-button><x-button variant="secondary" :href="route('admin.forms.index')">Kembali</x-button></div>
    </x-card>
</x-layouts.admin>
