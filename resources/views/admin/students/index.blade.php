<x-layouts.admin heading="Manajemen Mahasiswa" eyebrow="Database Akademik">
    <x-slot:actions>
        <x-ui.button href="{{ route('admin.students.create') }}" variant="teal" size="sm">
            <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            Tambah Mahasiswa
        </x-ui.button>
    </x-slot:actions>

    <div class="space-y-6">
        {{-- Table Section --}}
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
    </div>

    @push('scripts')
        <script>
            $(function() {
                $('#students-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('admin.students.data') }}",
                    columns: [
                        { 
                            data: 'name', 
                            name: 'name', 
                            className: 'font-semibold text-zinc-950',
                            render: function(data, type, row) {
                                return `<div>${data}</div><div class="text-[10px] text-zinc-400 font-mono uppercase tracking-tight">${row.email}</div>`;
                            }
                        },
                        { data: 'nim', name: 'nim', className: 'font-mono text-xs text-zinc-500 uppercase tracking-widest' },
                        { data: 'class_name', name: 'class_name', className: 'text-sm text-zinc-600' },
                        { data: 'study_program', name: 'study_program', className: 'text-sm text-zinc-600' },
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
                        searchPlaceholder: "Cari mahasiswa...",
                        lengthMenu: "_MENU_",
                        info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ mahasiswa",
                        paginate: {
                            previous: "Sebelumnya",
                            next: "Berikutnya"
                        }
                    },
                    pageLength: 25,
                    order: [[0, 'asc']],
                    drawCallback: function() {
                        // Apply specific cell adjustments if needed
                    }
                });
            });
        </script>
    @endpush
</x-layouts.admin>
