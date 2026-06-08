<x-layouts.admin heading="Edit Formulir" eyebrow="{{ $form->title }}">
    <x-slot:actions>
        <x-ui.button href="{{ route('admin.forms.index') }}" variant="secondary" size="sm" class="w-full sm:w-auto">
            Kembali
        </x-ui.button>
    </x-slot:actions>

    <div class="max-w-3xl">
        <x-ui.card class="p-5 sm:p-6">
            <form action="{{ route('admin.forms.update', $form) }}" method="POST">
                @csrf
                @method('PUT')
                @include('admin.forms.partials.form')

                <div class="mt-8 flex flex-col gap-3 border-t border-zinc-100 pt-6 sm:flex-row sm:justify-end">
                    <x-ui.button href="{{ route('admin.forms.index') }}" variant="ghost" class="w-full sm:w-auto">Batal</x-ui.button>
                    <x-ui.button variant="teal" class="w-full sm:w-auto">Perbarui Formulir</x-ui.button>
                </div>
            </form>
        </x-ui.card>
    </div>
</x-layouts.admin>
