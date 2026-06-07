<x-layouts.admin heading="Tambah Periode" eyebrow="Periode Evaluasi">
    <x-slot:actions>
        <x-ui.button href="{{ route('admin.periods.index') }}" variant="secondary" size="sm">
            Kembali
        </x-ui.button>
    </x-slot:actions>

    <div class="max-w-3xl">
        <x-ui.card>
            <form action="{{ route('admin.periods.store') }}" method="POST">
                @csrf
                @include('admin.periods.partials.form')

                <div class="mt-8 flex justify-end gap-3 border-t border-zinc-100 pt-6">
                    <x-ui.button href="{{ route('admin.periods.index') }}" variant="ghost">Batal</x-ui.button>
                    <x-ui.button variant="teal">Simpan Periode</x-ui.button>
                </div>
            </form>
        </x-ui.card>
    </div>
</x-layouts.admin>
