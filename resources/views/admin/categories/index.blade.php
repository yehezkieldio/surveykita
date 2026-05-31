<x-layouts.admin title="Kategori Pertanyaan - SurveyKita" heading="Kategori Pertanyaan">
    <div class="sk-pagehead">
        <p class="sk-pagehead-copy">Kelola pengelompokan instrumen pertanyaan evaluasi.</p>
        <x-button :href="route('admin.categories.create')">Tambah Kategori</x-button>
    </div>
    <x-table :headers="['Nama', 'Deskripsi', 'Jumlah Pertanyaan', 'Aksi']">
        @forelse ($categories as $category)
            <tr class="hover:bg-zinc-50">
                <td class="px-5 py-4 font-semibold">{{ $category->name }}</td>
                <td class="max-w-sm truncate px-5 py-4 text-zinc-600">{{ $category->description ?: '-' }}</td>
                <td class="px-5 py-4 font-mono text-sm text-zinc-700">{{ $category->questions_count }}</td>
                <td class="px-5 py-4"><div class="sk-link-row"><a class="sk-link" href="{{ route('admin.categories.edit', $category) }}">Edit</a><form method="POST" action="{{ route('admin.categories.destroy', $category) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">@csrf @method('DELETE')<button class="sk-danger-link" type="submit">Hapus</button></form></div></td>
            </tr>
        @empty
            <tr><td class="px-5 py-10" colspan="4"><x-empty-state title="Belum ada kategori" description="Kategori digunakan untuk mengelompokkan instrumen pertanyaan evaluasi." /></td></tr>
        @endforelse
    </x-table>
    <x-pagination :paginator="$categories" />
</x-layouts.admin>
