<x-layouts.admin heading="Kategori Pertanyaan" eyebrow="Referensi Data">
    <x-slot:actions>
        <x-ui.button href="{{ route('admin.categories.create') }}" variant="teal" size="sm">
            Tambah Kategori
        </x-ui.button>
    </x-slot:actions>

    @if($categories->isEmpty())
        <x-ui.empty-state title="Belum ada kategori" description="Buat kategori pertanyaan untuk mengelompokkan instrumen evaluasi." />
    @else
        <div class="space-y-6">
            <x-ui.table :headers="['Nama Kategori', 'Deskripsi', 'Jumlah Soal', 'Aksi']">
                @foreach ($categories as $category)
                    <tr class="hover:bg-zinc-50/50 transition-colors">
                        <td class="whitespace-nowrap px-6 py-4 text-sm font-semibold text-zinc-950">{{ $category->name }}</td>
                        <td class="px-6 py-4 text-sm text-zinc-600 max-w-md truncate">{{ $category->description ?? '-' }}</td>
                        <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-bold text-zinc-950">{{ $category->questions_count }}</td>
                        <td class="whitespace-nowrap px-6 py-4 text-right">
                            <div class="flex justify-end gap-2">
                                <x-ui.button href="{{ route('admin.categories.edit', $category) }}" variant="secondary" size="sm">Edit</x-ui.button>
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <x-ui.button variant="danger" size="sm" :disabled="$category->questions_count > 0">
                                        Hapus
                                    </x-ui.button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </x-ui.table>

            <div class="mt-8">
                {{ $categories->links() }}
            </div>
        </div>
    @endif
</x-layouts.admin>
