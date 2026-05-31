<x-layouts.admin title="Detail Form - SurveyKita" heading="Detail Form Evaluasi">
    <div class="sk-pagehead"><p class="sk-pagehead-copy">Rincian formulir evaluasi akademik.</p><div class="flex gap-2"><x-button variant="secondary" :href="route('admin.forms.index')">Kembali</x-button><x-button :href="route('admin.forms.edit', $form)">Edit</x-button></div></div>
    <x-card heading="{{ $form->title }}" subheading="Tersambung ke {{ $form->evaluationPeriod->name }}">
        @if ($form->description)<p class="mb-6 max-w-3xl border-b border-zinc-200 pb-6 text-sm leading-6 text-zinc-600">{{ $form->description }}</p>@endif
        <div class="sk-meta-grid"><div class="sk-meta-cell"><p class="sk-meta-label">Target Responden</p><p class="sk-meta-value">{{ ucwords(str_replace('_', ' ', $form->target_type)) }}</p></div><div class="sk-meta-cell"><p class="sk-meta-label">Status Form</p><div class="mt-2"><x-badge :variant="$form->is_active ? 'success' : 'neutral'">{{ $form->is_active ? 'Aktif' : 'Nonaktif' }}</x-badge></div></div><div class="sk-meta-cell"><p class="sk-meta-label">Jumlah Tanggapan</p><p class="sk-meta-value">{{ $form->responses_count }} respons masuk</p></div></div>
    </x-card>
</x-layouts.admin>
