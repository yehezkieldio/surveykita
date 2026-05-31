<x-layouts.admin title="Kategori Pertanyaan - SurveyKita" heading="Kategori Pertanyaan">
    <div class="mb-4"><x-button :href="route('admin.categories.create')">Tambah Kategori</x-button></div>
    <x-card>
        <table class="w-full text-left text-sm">
            <thead class="border-b text-zinc-600"><tr><th class="py-2">Nama</th><th>Deskripsi</th><th>Pertanyaan</th><th class="text-right">Aksi</th></tr></thead>
            <tbody class="divide-y">@forelse ($categories as $category)<tr><td class="py-3">{{ $category->name }}</td><td>{{ $category->description }}</td><td>{{ $category->questions_count }}</td><td class="space-x-2 text-right"><a class="text-teal-700" href="{{ route('admin.categories.edit', $category) }}">Edit</a><form class="inline" method="POST" action="{{ route('admin.categories.destroy', $category) }}">@csrf @method('DELETE')<button class="text-red-700" type="submit">Hapus</button></form></td></tr>@empty<tr><td class="py-6 text-center text-zinc-500" colspan="4">Belum ada kategori.</td></tr>@endforelse</tbody>
        </table>
        <x-pagination :paginator="$categories" />
    </x-card>
</x-layouts.admin>
