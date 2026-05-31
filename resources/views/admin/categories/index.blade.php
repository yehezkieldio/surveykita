<x-layouts.admin title="Kategori Pertanyaan - SurveyKita" heading="Kategori Pertanyaan">
    <div class="mb-6 flex justify-between items-center border-b border-zinc-200 pb-5">
        <div>
            <p class="font-mono text-[10px] uppercase tracking-wider text-zinc-400">Pengelompokan Instrumen Pertanyaan</p>
        </div>
        <x-button :href="route('admin.categories.create')" class="!min-h-9 !py-1 text-xs">Tambah Kategori</x-button>
    </div>

    <x-table :headers="['Nama', 'Deskripsi', 'Jumlah Pertanyaan', 'Aksi']">
        @forelse ($categories as $category)
            <tr class="hover:bg-zinc-50/50 transition-colors duration-150">
                <td class="px-6 py-4 font-bold text-zinc-900">{{ $category->name }}</td>
                <td class="px-6 py-4 text-zinc-500 leading-relaxed max-w-xs truncate">{{ $category->description ?: '-' }}</td>
                <td class="px-6 py-4 font-mono text-zinc-500 font-bold">{{ $category->questions_count }}</td>
                <td class="px-6 py-4">
                    <div class="flex items-center gap-4 text-[10px] font-mono uppercase tracking-wider">
                        <a class="font-bold text-zinc-900 hover:underline" href="{{ route('admin.categories.edit', $category) }}">Edit</a>
                        <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="font-bold text-red-700 hover:underline" type="submit">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td class="px-6 py-12 text-center" colspan="4">
                    <x-empty-state title="Belum ada kategori" description="Kategori digunakan untuk mengelompokkan instrumen pertanyaan evaluasi." />
                </td>
            </tr>
        @endforelse
    </x-table>

    <x-pagination :paginator="$categories" />
</x-layouts.admin>
