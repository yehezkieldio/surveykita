<x-layouts.admin title="Kategori Pertanyaan - SurveyKita" heading="Kategori Pertanyaan">
    <x-table title="Daftar Kategori" description="Pengelompokan instrumen pertanyaan evaluasi." :count="$categories->total()" :headers="['Kategori', 'Deskripsi', 'Pertanyaan', 'Aksi']">
        <x-slot:toolbar><x-button :href="route('admin.categories.create')">Tambah Kategori</x-button></x-slot:toolbar>
        @forelse ($categories as $category)
            <tr class="hover:bg-zinc-50">
                <td class="whitespace-nowrap px-4 py-3 font-semibold">{{ $category->name }}</td>
                <td class="max-w-xl truncate px-4 py-3 text-zinc-600">{{ $category->description ?: '-' }}</td>
                <td class="px-4 py-3 text-right font-mono text-sm text-zinc-700">{{ $category->questions_count }}</td>
                <td class="px-4 py-3"><div class="flex justify-end gap-3"><a class="sk-link" href="{{ route('admin.categories.edit', $category) }}">Edit</a><form method="POST" action="{{ route('admin.categories.destroy', $category) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">@csrf @method('DELETE')<button class="sk-danger-link" type="submit">Hapus</button></form></div></td>
            </tr>
        @empty
            <tr><td class="px-4 py-10" colspan="4"><x-empty-state title="Belum ada kategori" description="Kategori digunakan untuk mengelompokkan instrumen pertanyaan evaluasi." /></td></tr>
        @endforelse
        <x-slot:footer><x-pagination :paginator="$categories" /></x-slot:footer>
    </x-table>
</x-layouts.admin>
