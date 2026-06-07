<x-layouts.admin heading="Kategori Pertanyaan" eyebrow="Manajemen Konten">
    <x-slot:actions>
        <x-ui.button href="{{ route('admin.categories.create') }}" variant="teal" size="sm">
            <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            Tambah Kategori
        </x-ui.button>
    </x-slot:actions>

    <div class="space-y-6">
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
    </div>

    @push('scripts')
        <script>
            $(function() {
                $('#categories-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('admin.categories.data') }}",
                    columns: [
                        { 
                            data: 'name', 
                            name: 'name', 
                            className: 'font-semibold text-zinc-950',
                            render: function(data, type, row) {
                                return `<div>${data}</div><div class="text-[10px] text-zinc-400 max-w-xs truncate">${row.description || ''}</div>`;
                            }
                        },
                        { data: 'slug', name: 'slug', className: 'font-mono text-xs text-zinc-400 uppercase tracking-tight' },
                        { data: 'questions_count', name: 'questions_count', className: 'text-sm font-bold text-zinc-950' },
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
                        searchPlaceholder: "Cari kategori...",
                        lengthMenu: "_MENU_",
                        info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ kategori",
                    },
                    pageLength: 25,
                    order: [[0, 'asc']]
                });
            });
        </script>
    @endpush
</x-layouts.admin>
