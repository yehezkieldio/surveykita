<x-layouts.admin heading="Instrumen Evaluasi" eyebrow="Pengaturan Formulir">
    <x-slot:actions>
        <x-ui.button href="{{ route('admin.forms.create') }}" variant="teal" size="sm">
            <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            Buat Instrumen Baru
        </x-ui.button>
    </x-slot:actions>

    <div class="space-y-6">
        {{-- Filters area --}}
        <div class="flex flex-wrap items-center gap-4 bg-white border border-zinc-200 p-4 shadow-sm">
            <div class="flex flex-col gap-1">
                <label class="text-[10px] font-bold uppercase tracking-widest text-zinc-400">Filter Periode</label>
                <select id="period-filter" class="!w-64 !border-zinc-300 bg-white px-3 py-1.5 text-xs font-bold focus:!border-teal-600 focus:!ring-0 outline-none transition-all">
                    <option value="">Semua Periode</option>
                    @foreach(\App\Models\EvaluationPeriod::orderBy('start_date', 'desc')->get() as $period)
                        <option value="{{ $period->id }}">{{ $period->name }}</option>
                    @endforeach
                </select>
            </div>
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
    </div>

    @push('scripts')
        <script>
            $(function() {
                let table = $('#forms-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('admin.forms.data') }}",
                        data: function (d) {
                            d.period_id = $('#period-filter').val();
                        }
                    },
                    columns: [
                        { 
                            data: 'title', 
                            name: 'title', 
                            className: 'font-semibold text-zinc-950 min-w-[200px]',
                            render: function(data, type, row) {
                                return `<div>${data}</div><div class="text-[10px] text-zinc-400 max-w-[200px] truncate">${row.description || ''}</div>`;
                            }
                        },
                        { data: 'period_name', name: 'evaluationPeriod.name', className: 'text-sm text-zinc-600' },
                        { 
                            data: 'target_type', 
                            name: 'target_type', 
                            className: 'text-[10px] font-bold text-zinc-500 uppercase tracking-tighter',
                            render: function(data) {
                                return data === 'student' ? 'Mahasiswa' : data;
                            }
                        },
                        { data: 'questions_count', name: 'questions_count', className: 'text-sm font-bold text-zinc-950' },
                        { data: 'responses_count', name: 'responses_count', className: 'text-sm font-bold text-teal-600' },
                        { 
                            data: 'is_active', 
                            name: 'is_active',
                            render: function(data) {
                                return data 
                                    ? '<span class="inline-flex items-center gap-1.5 text-[10px] font-bold uppercase tracking-widest text-teal-600">Aktif</span>'
                                    : '<span class="inline-flex items-center gap-1.5 text-[10px] font-bold uppercase tracking-widest text-zinc-400">Draf</span>';
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
                        search: "",
                        searchPlaceholder: "Cari instrumen...",
                        lengthMenu: "_MENU_",
                        info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ instrumen",
                    },
                    pageLength: 25,
                    order: [[1, 'desc']]
                });

                $('#period-filter').on('change', function() {
                    table.draw();
                });
            });
        </script>
    @endpush
</x-layouts.admin>
