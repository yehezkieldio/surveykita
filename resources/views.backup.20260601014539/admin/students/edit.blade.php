<x-layouts.admin title="Edit Mahasiswa - SurveyKita" heading="Edit Mahasiswa">
    <x-card>
        <form method="POST" action="{{ route('admin.students.update', $student) }}" class="space-y-6">
            @csrf @method('PUT')
            @include('admin.students.partials.form', ['student' => $student])
            <div class="flex gap-4 border-t border-zinc-100 pt-6">
                <x-button type="submit">Perbarui Mahasiswa</x-button>
                <x-button variant="secondary" :href="route('admin.students.show', $student)">Batal</x-button>
            </div>
        </form>
    </x-card>
</x-layouts.admin>
