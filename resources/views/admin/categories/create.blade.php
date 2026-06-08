<x-layouts.admin heading="Tambah Kategori" eyebrow="Kategori Pertanyaan">
    <x-slot:actions>
        <x-ui.button href="{{ route('admin.categories.index') }}" variant="secondary" size="sm" class="w-full sm:w-auto">
            Kembali
        </x-ui.button>
    </x-slot:actions>

    <div class="max-w-3xl">
        <x-ui.card class="p-5 sm:p-6">
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf
                @include('admin.categories.partials.form')

                <div class="mt-8 flex flex-col gap-3 border-t border-zinc-100 pt-6 sm:flex-row sm:justify-end">
                    <x-ui.button href="{{ route('admin.categories.index') }}" variant="ghost" class="w-full sm:w-auto">Batal</x-ui.button>
                    <x-ui.button variant="teal" class="w-full sm:w-auto">Simpan Kategori</x-ui.button>
                </div>
            </form>
        </x-ui.card>
    </div>
</x-layouts.admin>
