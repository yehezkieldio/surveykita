<x-layouts.admin heading="Kategori Pertanyaan" eyebrow="Manajemen Konten">
    <x-slot:actions>
        <div class="flex flex-wrap items-center gap-2">
            <x-ui.button href="{{ route('admin.categories.export.excel') }}" variant="secondary" size="sm">
                <svg class="mr-2 h-4 w-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m.75 12l3 3m0 0l3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                </svg>
                Excel
            </x-ui.button>
            <x-ui.button href="{{ route('admin.categories.export.pdf') }}" variant="secondary" size="sm">
                <svg class="mr-2 h-4 w-4 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                </svg>
                PDF
            </x-ui.button>
            <x-ui.button href="{{ route('admin.categories.create') }}" variant="teal" size="sm">
                <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Tambah Kategori
            </x-ui.button>
        </div>
    </x-slot:actions>

    <section class="sk-table-panel">
        <table id="categories-table" class="w-full">
            <thead>
                <tr>
                    <th>Nama Kategori</th>
                    <th>Slug</th>
                    <th>Jumlah Pertanyaan</th>
                    <th class="text-right">Aksi</th>
                </tr>
            </thead>
        </table>
    </section>

    @push('scripts')
        <script>
            $(function() {
                window.adminTables.create('#categories-table', {
                    ajax: "{{ route('admin.categories.data') }}",
                    columns: [
                        {
                            data: 'name',
                            name: 'name',
                            render: function(data, type, row) {
                                return window.adminTables.stack(data, row.description || '', 'sk-cell-title', 'sk-cell-support');
                            }
                        },
                        {
                            data: 'slug',
                            name: 'slug',
                            searchable: false,
                            render: function(data) {
                                return `<span class="sk-cell-muted">${window.adminTables.escape(data)}</span>`;
                            }
                        },
                        {
                            data: 'questions_count',
                            name: 'questions_count',
                            searchable: false,
                            render: function(data) {
                                return `<span class="sk-cell-number">${window.adminTables.escape(data)}</span>`;
                            }
                        },
                        {
                            data: 'actions',
                            name: 'actions',
                            orderable: false,
                            searchable: false,
                            className: 'text-right'
                        }
                    ],
                    language: {
                        searchPlaceholder: 'Cari kategori atau slug...',
                        info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ kategori',
                    },
                    order: [[0, 'asc']]
                });
            });
        </script>
    @endpush
</x-layouts.admin>
