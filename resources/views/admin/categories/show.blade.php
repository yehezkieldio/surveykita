<x-layouts.admin heading="{{ $category->name }}" eyebrow="Detail Kategori">
    <x-slot:actions>
        <div class="flex w-full flex-col gap-2 sm:w-auto sm:flex-row sm:flex-wrap sm:items-center sm:justify-end sm:gap-2 sm:flex-nowrap">
            <x-ui.button href="{{ route('admin.categories.index') }}" variant="ghost" size="sm" class="w-full sm:w-auto">
                Kembali
            </x-ui.button>
            <x-ui.button href="{{ route('admin.categories.edit', $category) }}" variant="secondary" size="sm" class="w-full sm:w-auto">
                Edit Kategori
            </x-ui.button>
            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline-flex w-full shrink-0 sm:w-auto" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');">
                @csrf
                @method('DELETE')
                <x-ui.button variant="danger" size="sm" class="w-full sm:w-auto">
                    Hapus
                </x-ui.button>
            </form>
        </div>
    </x-slot:actions>

    <div class="grid gap-6 xl:grid-cols-12 xl:gap-8">
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
                            {{ $category->questions_count > 0 ? 'BERISI' : 'KOSONG' }}
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
                <div class="flex flex-col gap-2 sm:flex-row sm:flex-wrap sm:items-center lg:justify-end">
                    <x-ui.badge variant="zinc">{{ $category->questions_count }} Pertanyaan</x-ui.badge>
                    <x-ui.button href="{{ route('admin.questions.create') }}" variant="teal" size="sm" class="w-full sm:w-auto">
                        Tambah Pertanyaan
                    </x-ui.button>
                </div>
            </div>

            @if($category->questions->isEmpty())
                <x-ui.empty-state title="Belum ada pertanyaan" description="Kategori ini belum digunakan pada pertanyaan evaluasi mana pun." />
            @else
                <div class="space-y-4 md:hidden">
                    @foreach ($category->questions->sortBy([
                        fn ($left, $right) => strcmp($left->evaluationForm->title, $right->evaluationForm->title),
                        fn ($left, $right) => $left->sort_order <=> $right->sort_order,
                    ]) as $question)
                        <x-ui.card class="p-5">
                            <div class="space-y-4">
                                <div>
                                    <p class="text-sm leading-6 text-zinc-950">{{ $question->question_text }}</p>
                                    <p class="mt-1 text-xs font-semibold text-zinc-700">{{ $question->evaluationForm->title }}</p>
                                    <p class="mt-1 text-xs text-zinc-500">{{ $question->evaluationForm->evaluationPeriod->name }}</p>
                                </div>
                                <div class="flex items-center justify-between gap-4 border-t border-zinc-100 pt-4">
                                    <span class="font-mono text-xs font-bold text-zinc-400">{{ $question->sort_order }}</span>
                                    <div class="flex gap-2">
                                        <x-ui.button href="{{ route('admin.questions.show', $question) }}" variant="ghost" size="sm">
                                            Detail
                                        </x-ui.button>
                                        <x-ui.button href="{{ route('admin.questions.edit', $question) }}" variant="secondary" size="sm">
                                            Edit
                                        </x-ui.button>
                                    </div>
                                </div>
                            </div>
                        </x-ui.card>
                    @endforeach
                </div>

                <div class="hidden md:block">
                    <x-ui.table :headers="['Pertanyaan', 'Formulir', 'Periode', 'Urutan', 'Aksi']">
                        @foreach ($category->questions->sortBy([
                            fn ($left, $right) => strcmp($left->evaluationForm->title, $right->evaluationForm->title),
                            fn ($left, $right) => $left->sort_order <=> $right->sort_order,
                        ]) as $question)
                            <tr>
                                <td class="min-w-[28rem] whitespace-normal px-5 py-5 align-top text-sm leading-7 text-zinc-950">
                                    {{ $question->question_text }}
                                </td>
                                <td class="min-w-[16rem] whitespace-normal px-5 py-5 align-top text-sm font-semibold leading-7 text-zinc-950">
                                    {{ $question->evaluationForm->title }}
                                </td>
                                <td class="whitespace-normal px-5 py-5 align-top text-sm leading-7 text-zinc-600">
                                    {{ $question->evaluationForm->evaluationPeriod->name }}
                                </td>
                                <td class="whitespace-nowrap px-5 py-5 align-top text-right font-mono text-xs font-bold text-zinc-400">
                                    {{ $question->sort_order }}
                                </td>
                                <td class="whitespace-nowrap px-5 py-5 align-top text-right">
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
                </div>
            @endif
        </section>
    </div>
</x-layouts.admin>
