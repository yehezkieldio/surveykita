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
    </div>

    @push('scripts')
        <script>
            $(function() {
                $('#periods-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('admin.periods.data') }}",
                    columns: [
                        { data: 'name', name: 'name', className: 'font-semibold text-zinc-950' },
                        { 
                            data: 'start_date', 
                            name: 'start_date',
                            render: function(data, type, row) {
                                return `<div class="text-xs font-medium text-zinc-500">${data} — ${row.end_date}</div>`;
                            }
                        },
                        { 
                            data: 'is_active', 
                            name: 'is_active',
                            render: function(data) {
                                return data 
                                    ? '<span class="inline-flex items-center gap-1.5 text-[10px] font-bold uppercase tracking-widest text-teal-600"><span class="h-1.5 w-1.5 rounded-full bg-teal-500"></span> Aktif</span>'
                                    : '<span class="inline-flex items-center gap-1.5 text-[10px] font-bold uppercase tracking-widest text-zinc-400"><span class="h-1.5 w-1.5 rounded-full bg-zinc-300"></span> Nonaktif</span>';
                            }
                        },
                        { data: 'evaluation_forms_count', name: 'evaluation_forms_count', className: 'text-sm font-bold text-zinc-950' },
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
                        searchPlaceholder: "Cari periode...",
                        lengthMenu: "_MENU_",
                        info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ periode",
                    },
                    pageLength: 25,
                    order: [[1, 'desc']]
                });
            });
        </script>
    @endpush
</x-layouts.admin>
