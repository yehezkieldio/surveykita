<x-layouts.admin heading="Butir Pertanyaan" eyebrow="Database Instrumen">
    <x-slot:actions>
        <div class="flex flex-wrap items-center gap-2">
            <x-ui.button id="questions-export-excel" href="{{ route('admin.questions.export.excel') }}" variant="secondary" size="sm">
                <svg class="mr-2 h-4 w-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m.75 12l3 3m0 0l3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                </svg>
                Excel
            </x-ui.button>
            <x-ui.button id="questions-export-pdf" href="{{ route('admin.questions.export.pdf') }}" variant="secondary" size="sm">
                <svg class="mr-2 h-4 w-4 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                </svg>
                PDF
            </x-ui.button>
            <x-ui.button href="{{ route('admin.questions.create') }}" variant="teal" size="sm">
                <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Tambah Pertanyaan
            </x-ui.button>
        </div>
    </x-slot:actions>

    <section class="sk-table-panel">
        <div id="questions-toolbar" class="sk-table-inline-filters">
            <div class="sk-table-filter-group">
                <label for="form-filter" class="sk-table-filter-label">Filter instrumen</label>
                <select id="form-filter" class="sk-table-select">
                    <option value="">Semua instrumen</option>
                    @foreach(\App\Models\EvaluationForm::orderBy('title')->get() as $form)
                        <option value="{{ $form->id }}">{{ $form->title }} ({{ $form->evaluationPeriod->name }})</option>
                    @endforeach
                </select>
            </div>
        </div>

        <table id="questions-table" class="w-full">
            <thead>
                <tr>
                    <th>Teks Pertanyaan</th>
                    <th>Instrumen</th>
                    <th>Kategori</th>
                    <th>Urutan</th>
                    <th class="text-right">Aksi</th>
                </tr>
            </thead>
        </table>
    </section>

    @push('scripts')
        <script>
            $(function() {
                const syncExportLinks = function() {
                    const formId = $('#form-filter').val();
                    const pairs = [
                        ['#questions-export-excel', "{{ route('admin.questions.export.excel') }}"],
                        ['#questions-export-pdf', "{{ route('admin.questions.export.pdf') }}"],
                    ];

                    pairs.forEach(function([selector, base]) {
                        const url = new URL(base, window.location.origin);

                        if (formId) {
                            url.searchParams.set('evaluation_form_id', formId);
                        }

                        $(selector).attr('href', url.toString());
                    });
                };

                const table = window.adminTables.create('#questions-table', {
                    ajax: {
                        url: "{{ route('admin.questions.data') }}",
                        data: function(d) {
                            d.evaluation_form_id = $('#form-filter').val();
                        }
                    },
                    columns: [
                        {
                            data: 'text',
                            name: 'question_text',
                            render: function(data) {
                                return `<div class="max-w-3xl whitespace-normal text-[0.8rem] leading-5 text-zinc-800">${window.adminTables.escape(data)}</div>`;
                            }
                        },
                        {
                            data: 'form_title',
                            name: 'evaluationForm.title',
                            render: function(data) {
                                return `<span class="sk-cell-muted">${window.adminTables.escape(data)}</span>`;
                            }
                        },
                        {
                            data: 'category_name',
                            name: 'category.name',
                            render: function(data) {
                                return window.adminTables.badge(data, 'neutral');
                            }
                        },
                        {
                            data: 'sort_order',
                            name: 'sort_order',
                            render: function(data) {
                                return `<span class="sk-cell-order">${window.adminTables.escape(data)}</span>`;
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
                        searchPlaceholder: 'Cari teks pertanyaan, kategori, atau instrumen...',
                        info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ pertanyaan',
                    },
                    order: [[1, 'asc'], [3, 'asc']]
                });

                window.adminTables.mountFilters(table, '#questions-toolbar');
                syncExportLinks();

                $('#form-filter').on('change', function() {
                    syncExportLinks();
                    table.draw();
                });
            });
        </script>
    @endpush
</x-layouts.admin>
