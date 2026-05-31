<x-layouts.admin title="Tambah Mahasiswa - SurveyKita" heading="Tambah Mahasiswa">
    <x-card>
        <form method="POST" action="{{ route('admin.students.store') }}" class="grid gap-4">
            @csrf
            @include('admin.students.partials.form', ['student' => null])
            <div class="flex gap-2">
                <x-button type="submit">Simpan</x-button>
                <x-button variant="secondary" :href="route('admin.students.index')">Batal</x-button>
            </div>
        </form>
    </x-card>
</x-layouts.admin>
