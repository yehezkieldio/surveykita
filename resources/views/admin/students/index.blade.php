<x-layouts.admin heading="Manajemen Mahasiswa" eyebrow="Database Akademik">
    <x-slot:actions>
        <div class="flex flex-wrap items-center gap-2">
            <x-ui.button href="{{ route('admin.students.export.excel') }}" variant="secondary" size="sm">Export Excel</x-ui.button>
            <x-ui.button href="{{ route('admin.students.export.pdf') }}" variant="secondary" size="sm">Export PDF</x-ui.button>
            <x-ui.button href="{{ route('admin.students.create') }}" variant="teal" size="sm">
                <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Tambah Mahasiswa
            </x-ui.button>
        </div>
    </x-slot:actions>

    <div class="space-y-6">
        <section class="sk-table-panel">
            <div class="sk-table-panel-copy">
                <h2 class="sk-table-panel-title">Daftar mahasiswa aktif</h2>
                <p class="sk-table-panel-body">
                    Rapikan identitas mahasiswa dalam satu tabel yang mudah dipindai, dari nama, NIM, kelas, sampai program studi.
                </p>
            </div>

            <table id="students-table" class="w-full">
                <thead>
                    <tr>
                        <th>Mahasiswa</th>
                        <th>NIM</th>
                        <th>Kelas</th>
                        <th>Prodi</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
            </table>
        </section>
    </div>

    @push('scripts')
        <script>
            $(function() {
                window.adminTables.create('#students-table', {
                    ajax: "{{ route('admin.students.data') }}",
                    columns: [
                        {
                            data: 'name',
                            name: 'name',
                            render: function(data, type, row) {
                                return window.adminTables.stack(data, row.email);
                            }
                        },
                        {
                            data: 'nim',
                            name: 'nim',
                            render: function(data) {
                                return `<span class="sk-cell-code">${window.adminTables.escape(data)}</span>`;
                            }
                        },
                        {
                            data: 'class_name',
                            name: 'class_name',
                            render: function(data) {
                                return `<span class="sk-cell-muted">${window.adminTables.escape(data)}</span>`;
                            }
                        },
                        {
                            data: 'study_program',
                            name: 'study_program',
                            render: function(data) {
                                return `<span class="sk-cell-muted">${window.adminTables.escape(data)}</span>`;
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
                        searchPlaceholder: 'Cari nama, NIM, kelas, atau prodi...',
                        info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ mahasiswa',
                    },
                    order: [[0, 'asc']]
                });
            });
        </script>
    @endpush
</x-layouts.admin>
