<x-layouts.admin title="Tambah Mahasiswa - SurveyKita" heading="Tambah Mahasiswa">
    <x-card>
        <form method="POST" action="{{ route('admin.students.store') }}" class="space-y-6">
            @csrf
            @include('admin.students.partials.form', ['student' => null])
            <div class="flex gap-4 border-t border-zinc-100 pt-6">
                <x-button type="submit">Simpan Mahasiswa</x-button>
                <x-button variant="secondary" :href="route('admin.students.index')">Batal</x-button>
            </div>
        </form>
    </x-card>
</x-layouts.admin>
