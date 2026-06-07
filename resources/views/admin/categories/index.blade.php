<x-layouts.admin heading="Kategori Pertanyaan" eyebrow="Manajemen Konten">
    <x-slot:actions>
        <div class="flex flex-wrap items-center gap-2">
            <x-ui.button href="{{ route('admin.categories.export.excel') }}" variant="secondary" size="sm">Export Excel</x-ui.button>
            <x-ui.button href="{{ route('admin.categories.export.pdf') }}" variant="secondary" size="sm">Export PDF</x-ui.button>
            <x-ui.button href="{{ route('admin.categories.create') }}" variant="teal" size="sm">
                <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Tambah Kategori
            </x-ui.button>
        </div>
    </x-slot:actions>

    <div class="space-y-6">
        <section class="sk-table-panel">
            <div class="sk-table-panel-copy">
                <h2 class="sk-table-panel-title">Taksonomi pertanyaan</h2>
                <p class="sk-table-panel-body">
                    Susun kategori dan distribusi pertanyaan dalam satu daftar yang konsisten, tanpa perbedaan ukuran teks atau gaya kolom.
                </p>
            </div>

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
    </div>

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
                            render: function(data) {
                                return `<span class="sk-cell-muted">${window.adminTables.escape(data)}</span>`;
                            }
                        },
                        {
                            data: 'questions_count',
                            name: 'questions_count',
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
