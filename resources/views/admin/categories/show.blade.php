<x-layouts.admin heading="{{ $category->name }}" eyebrow="Detail Kategori">
    <x-slot:actions>
        <div class="flex items-center justify-end gap-2 flex-wrap sm:flex-nowrap">
            <x-ui.button href="{{ route('admin.categories.index') }}" variant="ghost" size="sm">
                Kembali
            </x-ui.button>
            <x-ui.button href="{{ route('admin.categories.edit', $category) }}" variant="secondary" size="sm">
                Edit Kategori
            </x-ui.button>
            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline-flex shrink-0" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');">
                @csrf
                @method('DELETE')
                <x-ui.button variant="danger" size="sm" :disabled="$category->questions_count > 0">
                    Hapus
                </x-ui.button>
            </form>
        </div>
    </x-slot:actions>

    <div class="grid gap-8 xl:grid-cols-12">
        <section class="min-w-0 xl:col-span-8">
            <x-ui.card no-padding class="h-full overflow-hidden">
                <div class="border-b border-zinc-100 p-6 xl:p-7">
                    <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-zinc-400">Deskripsi Kategori</p>
                    <p class="mt-3 text-sm leading-7 text-zinc-600">
                        {{ $category->description ?: 'Belum ada deskripsi tambahan untuk kategori ini.' }}
                    </p>
                </div>
                <div class="grid gap-0 sm:grid-cols-2">
                    <div class="border-b border-zinc-100 p-6 sm:border-r sm:border-b-0 xl:p-7">
                        <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-zinc-400">Nama</p>
                        <p class="mt-2 text-lg font-semibold leading-8 tracking-tight text-zinc-950">{{ $category->name }}</p>
                    </div>
                    <div class="p-6 xl:p-7">
                        <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-zinc-400">Slug Sistem</p>
                        <p class="mt-2 break-all font-mono text-sm font-semibold leading-7 text-zinc-950">{{ \Illuminate\Support\Str::slug($category->name, '_') }}</p>
                    </div>
                </div>
            </x-ui.card>
        </section>

        <aside class="min-w-0 xl:col-span-4">
            <x-ui.card no-padding class="h-full overflow-hidden">
                <div class="border-b border-zinc-100 px-6 py-5 xl:px-7">
                    <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-zinc-400">Pemakaian Kategori</p>
                    <p class="mt-2 text-lg font-semibold tracking-tight text-zinc-950">Intensitas penggunaan dalam bank pertanyaan</p>
                </div>
                <div class="space-y-4 px-6 py-5 xl:px-7">
                    <div class="flex items-center justify-between gap-4 border-b border-zinc-100 pb-4">
                        <span class="text-xs font-medium text-zinc-500">Jumlah Pertanyaan</span>
                        <span class="text-sm font-semibold text-zinc-950">{{ number_format($category->questions_count) }}</span>
                    </div>
                    <div class="flex items-center justify-between gap-4">
                        <span class="text-xs font-medium text-zinc-500">Status Hapus</span>
                        <x-ui.badge :variant="$category->questions_count > 0 ? 'zinc' : 'teal'">
                            {{ $category->questions_count > 0 ? 'TERKUNCI' : 'AMAN' }}
                        </x-ui.badge>
                    </div>
                </div>
            </x-ui.card>
        </aside>

        <section class="min-w-0 xl:col-span-12">
            <div class="mb-4 grid gap-3 lg:grid-cols-[minmax(0,1fr)_auto] lg:items-start">
                <div>
                    <h3 class="text-sm font-bold uppercase tracking-[0.18em] text-zinc-400">Pertanyaan Dalam Kategori</h3>
                    <p class="mt-1 text-sm leading-6 text-zinc-500">Seluruh pertanyaan yang menggunakan kategori ini direntangkan penuh agar keterhubungan ke formulir dan periode terbaca tanpa berpindah konteks.</p>
                </div>
                <div class="flex flex-wrap items-center gap-2 lg:justify-end">
                    <x-ui.badge variant="zinc">{{ $category->questions_count }} Pertanyaan</x-ui.badge>
                    <x-ui.button href="{{ route('admin.questions.create') }}" variant="teal" size="sm">
                        Tambah Pertanyaan
                    </x-ui.button>
                </div>
            </div>

            @if($category->questions->isEmpty())
                <x-ui.empty-state title="Belum ada pertanyaan" description="Kategori ini belum digunakan pada pertanyaan evaluasi mana pun." />
            @else
                <x-ui.table :headers="['Pertanyaan', 'Formulir', 'Periode', 'Urutan', 'Aksi']">
                    @foreach ($category->questions->sortBy([
                        fn ($left, $right) => strcmp($left->evaluationForm->title, $right->evaluationForm->title),
                        fn ($left, $right) => $left->sort_order <=> $right->sort_order,
                    ]) as $question)
                        <tr>
                            <td class="min-w-[28rem] px-5 py-5 align-top text-sm leading-7 text-zinc-950 whitespace-normal">
                                {{ $question->question_text }}
                            </td>
                            <td class="min-w-[16rem] px-5 py-5 align-top text-sm font-semibold leading-7 text-zinc-950 whitespace-normal">
                                {{ $question->evaluationForm->title }}
                            </td>
                            <td class="px-5 py-5 align-top text-sm leading-7 text-zinc-600 whitespace-normal">
                                {{ $question->evaluationForm->evaluationPeriod->name }}
                            </td>
                            <td class="whitespace-nowrap px-5 py-5 align-top text-right font-mono text-xs font-bold text-zinc-400">
                                {{ $question->sort_order }}
                            </td>
                            <td class="whitespace-nowrap px-5 py-5 text-right align-top">
                                <div class="flex justify-end gap-2">
                                    <x-ui.button href="{{ route('admin.questions.show', $question) }}" variant="ghost" size="sm">
                                        Detail
                                    </x-ui.button>
                                    <x-ui.button href="{{ route('admin.questions.edit', $question) }}" variant="secondary" size="sm">
                                        Edit
                                    </x-ui.button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </x-ui.table>
            @endif
        </section>
    </div>
</x-layouts.admin>
