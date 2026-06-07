<x-layouts.admin heading="Tambah Kategori" eyebrow="Kategori Pertanyaan">
    <x-slot:actions>
        <x-ui.button href="{{ route('admin.categories.index') }}" variant="secondary" size="sm">
            Kembali
        </x-ui.button>
    </x-slot:actions>

    <div class="max-w-3xl">
        <x-ui.card>
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf
                @include('admin.categories.partials.form')

                <div class="mt-8 flex justify-end gap-3 border-t border-zinc-100 pt-6">
                    <x-ui.button href="{{ route('admin.categories.index') }}" variant="ghost">Batal</x-ui.button>
                    <x-ui.button variant="teal">Simpan Kategori</x-ui.button>
                </div>
            </form>
        </x-ui.card>
    </div>
</x-layouts.admin>
