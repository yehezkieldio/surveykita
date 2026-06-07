<x-layouts.admin heading="Periode Evaluasi" eyebrow="Pengaturan Jadwal">
    <x-slot:actions>
        <x-ui.button href="{{ route('admin.periods.create') }}" variant="teal" size="sm">
            <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            Buat Periode Baru
        </x-ui.button>
    </x-slot:actions>

    <div class="space-y-6">
        <section class="sk-table-panel">
            <div class="sk-table-panel-copy">
                <h2 class="sk-table-panel-title">Siklus evaluasi</h2>
                <p class="sk-table-panel-body">
                    Kelola nama periode, rentang jadwal, dan aktivasi form dengan tampilan yang tetap ringkas meski judul periodenya panjang.
                </p>
            </div>

            <table id="periods-table" class="w-full">
                <thead>
                    <tr>
                        <th>Nama Periode</th>
                        <th>Jadwal</th>
                        <th>Status</th>
                        <th>Form</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
            </table>
        </section>
    </div>

    @push('scripts')
        <script>
            $(function() {
                window.adminTables.create('#periods-table', {
                    ajax: "{{ route('admin.periods.data') }}",
                    columns: [
                        {
                            data: 'name',
                            name: 'name',
                            render: function(data) {
                                return window.adminTables.stack(data, 'Periode evaluasi', 'sk-cell-title sk-cell-title-compact', 'sk-cell-support');
                            }
                        },
                        {
                            data: 'start_date',
                            name: 'start_date',
                            render: function(data, type, row) {
                                return window.adminTables.stack(data, row.end_date, 'sk-cell-title', 'sk-cell-support');
                            }
                        },
                        {
                            data: 'is_active',
                            name: 'is_active',
                            render: function(data) {
                                return data
                                    ? window.adminTables.badge('Aktif', 'success')
                                    : window.adminTables.badge('Nonaktif', 'neutral');
                            }
                        },
                        {
                            data: 'evaluation_forms_count',
                            name: 'evaluation_forms_count',
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
                        searchPlaceholder: 'Cari periode evaluasi...',
                        info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ periode',
                    },
                    order: [[1, 'desc']]
                });
            });
        </script>
    @endpush
</x-layouts.admin>
