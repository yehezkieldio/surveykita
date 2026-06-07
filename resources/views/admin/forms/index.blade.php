<x-layouts.admin heading="Instrumen Evaluasi" eyebrow="Pengaturan Formulir">
    <x-slot:actions>
        <div class="flex flex-wrap items-center gap-2">
            <x-ui.button id="forms-export-excel" href="{{ route('admin.forms.export.excel') }}" variant="secondary" size="sm">Export Excel</x-ui.button>
            <x-ui.button id="forms-export-pdf" href="{{ route('admin.forms.export.pdf') }}" variant="secondary" size="sm">Export PDF</x-ui.button>
            <x-ui.button href="{{ route('admin.forms.create') }}" variant="teal" size="sm">
                <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Buat Instrumen Baru
            </x-ui.button>
        </div>
    </x-slot:actions>

    <div class="space-y-6">
        <section class="sk-table-panel">
            <div class="sk-table-panel-copy">
                <h2 class="sk-table-panel-title">Instrumen per periode</h2>
                <p class="sk-table-panel-body">
                    Lacak form evaluasi berdasarkan periode, target, jumlah soal, dan respons tanpa membuat kontrol tabel terasa terpisah dari halaman.
                </p>
            </div>

            <div id="forms-toolbar" class="sk-table-inline-filters">
                <div class="sk-table-filter-group">
                    <label for="period-filter" class="sk-table-filter-label">Filter periode</label>
                    <select id="period-filter" class="sk-table-select">
                        <option value="">Semua periode</option>
                        @foreach(\App\Models\EvaluationPeriod::orderBy('start_date', 'desc')->get() as $period)
                            <option value="{{ $period->id }}">{{ $period->name }}</option>
                        @endforeach
                    </select>
                </div>
                <p class="sk-table-filter-hint">
                    Gunakan filter ketika Anda ingin fokus pada satu siklus evaluasi tanpa mengubah pencarian global.
                </p>
            </div>

            <table id="forms-table" class="w-full">
                <thead>
                    <tr>
                        <th>Judul Instrumen</th>
                        <th>Periode</th>
                        <th>Target</th>
                        <th>Soal</th>
                        <th>Respons</th>
                        <th>Status</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
            </table>
        </section>
    </div>

    @push('scripts')
        <script>
            $(function() {
                const syncExportLinks = function() {
                    const periodId = $('#period-filter').val();
                    const pairs = [
                        ['#forms-export-excel', "{{ route('admin.forms.export.excel') }}"],
                        ['#forms-export-pdf', "{{ route('admin.forms.export.pdf') }}"],
                    ];

                    pairs.forEach(function([selector, base]) {
                        const url = new URL(base, window.location.origin);

                        if (periodId) {
                            url.searchParams.set('period_id', periodId);
                        }

                        $(selector).attr('href', url.toString());
                    });
                };

                const table = window.adminTables.create('#forms-table', {
                    ajax: {
                        url: "{{ route('admin.forms.data') }}",
                        data: function(d) {
                            d.period_id = $('#period-filter').val();
                        }
                    },
                    columns: [
                        {
                            data: 'title',
                            name: 'title',
                            render: function(data, type, row) {
                                return window.adminTables.stack(data, row.description || '', 'sk-cell-title', 'sk-cell-support');
                            }
                        },
                        {
                            data: 'period_name',
                            name: 'evaluationPeriod.name',
                            render: function(data) {
                                return `<span class="sk-cell-muted">${window.adminTables.escape(data)}</span>`;
                            }
                        },
                        {
                            data: 'target_type',
                            name: 'target_type',
                            render: function(data) {
                                return window.adminTables.badge(data === 'student' ? 'Mahasiswa' : data, 'info');
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
                            data: 'responses_count',
                            name: 'responses_count',
                            render: function(data) {
                                return `<span class="sk-cell-number">${window.adminTables.escape(data)}</span>`;
                            }
                        },
                        {
                            data: 'is_active',
                            name: 'is_active',
                            render: function(data) {
                                return data
                                    ? window.adminTables.badge('Aktif', 'success')
                                    : window.adminTables.badge('Draf', 'warning');
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
                        searchPlaceholder: 'Cari judul, periode, atau target form...',
                        info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ instrumen',
                    },
                    order: [[1, 'desc']]
                });

                window.adminTables.mountFilters(table, '#forms-toolbar');
                syncExportLinks();

                $('#period-filter').on('change', function() {
                    syncExportLinks();
                    table.draw();
                });
            });
        </script>
    @endpush
</x-layouts.admin>
