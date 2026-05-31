<x-layouts.admin title="Edit Mahasiswa - SurveyKita" heading="Edit Mahasiswa">
    <x-card>
        <form method="POST" action="{{ route('admin.students.update', $student) }}" class="grid gap-4">
            @csrf @method('PUT')
            @include('admin.students.partials.form', ['student' => $student])
            <div class="flex gap-2">
                <x-button type="submit">Perbarui</x-button>
                <x-button variant="secondary" :href="route('admin.students.show', $student)">Batal</x-button>
            </div>
        </form>
    </x-card>
</x-layouts.admin>
