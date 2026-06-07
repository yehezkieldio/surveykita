<x-layouts.admin heading="Edit Formulir" eyebrow="{{ $form->title }}">
    <x-slot:actions>
        <x-ui.button href="{{ route('admin.forms.show', $form) }}" variant="secondary" size="sm">
            Kembali
        </x-ui.button>
    </x-slot:actions>

    <div class="max-w-3xl">
        <x-ui.card>
            <form action="{{ route('admin.forms.update', $form) }}" method="POST">
                @csrf
                @method('PUT')
                @include('admin.forms.partials.form')

                <div class="mt-8 flex justify-end gap-3 border-t border-zinc-100 pt-6">
                    <x-ui.button href="{{ route('admin.forms.show', $form) }}" variant="ghost">Batal</x-ui.button>
                    <x-ui.button variant="teal">Perbarui Formulir</x-ui.button>
                </div>
            </form>
        </x-ui.card>
    </div>
</x-layouts.admin>
