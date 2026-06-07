<x-layouts.admin heading="Edit Pertanyaan" eyebrow="ID: {{ $question->id }}">
    <x-slot:actions>
        <x-ui.button href="{{ route('admin.questions.index') }}" variant="secondary" size="sm">
            Kembali
        </x-ui.button>
    </x-slot:actions>

    <div class="max-w-3xl">
        <x-ui.card>
            <form action="{{ route('admin.questions.update', $question) }}" method="POST">
                @csrf
                @method('PUT')
                @include('admin.questions.partials.form')

                <div class="mt-8 flex justify-end gap-3 border-t border-zinc-100 pt-6">
                    <x-ui.button href="{{ route('admin.questions.index') }}" variant="ghost">Batal</x-ui.button>
                    <x-ui.button variant="teal">Perbarui Pertanyaan</x-ui.button>
                </div>
            </form>
        </x-ui.card>
    </div>
</x-layouts.admin>
