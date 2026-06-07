<x-layouts.admin heading="Mahasiswa" eyebrow="Manajemen Data">
    <x-slot:actions>
        <x-ui.button href="{{ route('admin.students.create') }}" variant="teal" size="sm">
            Tambah Mahasiswa
        </x-ui.button>
    </x-slot:actions>

    <x-ui.card no-padding class="overflow-hidden">
        <table id="students-table" class="min-w-full">
            <thead>
                <tr>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Program Studi</th>
                    <th>Kelas</th>
                    <th>Respons</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </x-ui.card>

    @push('scripts')
        <script>
            $(function() {
                $('#students-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: '{{ route('admin.students.data') }}',
                    columns: [
                        { data: 'nim', name: 'nim', className: 'font-mono text-xs font-bold text-zinc-900' },
                        { data: 'name', name: 'name', className: 'text-sm font-semibold text-zinc-950' },
                        { data: 'email', name: 'email', className: 'text-sm text-zinc-600' },
                        { data: 'study_program', name: 'study_program', className: 'text-sm text-zinc-600' },
                        { data: 'class_name', name: 'class_name', className: 'text-sm text-zinc-600' },
                        { data: 'responses_count_display', name: 'responses_count', className: 'text-right text-sm font-bold text-teal-600' },
                        { data: 'actions', name: 'actions', orderable: false, searchable: false, className: 'text-right' }
                    ],
                    language: {
                        url: 'https://cdn.datatables.net/plug-ins/2.3.5/i18n/id.json'
                    },
                    layout: {
                        topStart: 'search',
                        topEnd: null,
                        bottomStart: 'info',
                        bottomEnd: 'paging'
                    }
                });
            });
        </script>
    @endpush
</x-layouts.admin>
