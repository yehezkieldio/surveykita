<x-layouts.admin title="Mahasiswa - SurveyKita" heading="Data Mahasiswa">
    <section class="border border-zinc-200 bg-white">
        <div class="flex flex-col gap-4 border-b border-zinc-200 p-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h2 class="font-display text-2xl font-semibold leading-none tracking-[-0.05em] text-zinc-950">Daftar Mahasiswa</h2>
                <p class="mt-2 max-w-3xl text-sm leading-6 text-zinc-600">Tabel server-side Yajra DataTables untuk pencarian, sorting, pagination, dan operasi data mahasiswa.</p>
            </div>
            <x-button :href="route('admin.students.create')">Tambah Mahasiswa</x-button>
        </div>

        <div class="p-4">
            <table id="students-table" class="display w-full text-sm">
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
        </div>
    </section>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                new DataTable('#students-table', {
                    processing: true,
                    serverSide: true,
                    ajax: '{{ route('admin.students.data') }}',
                    pageLength: 10,
                    lengthMenu: [10, 25, 50, 100],
                    order: [[1, 'asc']],
                    columns: [
                        { data: 'nim', name: 'nim' },
                        { data: 'name', name: 'name' },
                        { data: 'email', name: 'user.email', orderable: false },
                        { data: 'study_program', name: 'study_program' },
                        { data: 'class_name', name: 'class_name' },
                        { data: 'responses_count_display', name: 'responses_count', searchable: false, className: 'dt-body-right' },
                        { data: 'actions', name: 'actions', orderable: false, searchable: false, className: 'dt-body-right' },
                    ],
                    language: {
                        search: 'Cari',
                        lengthMenu: 'Tampilkan _MENU_ data',
                        info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
                        infoEmpty: 'Tidak ada data',
                        infoFiltered: '(disaring dari _MAX_ data)',
                        zeroRecords: 'Tidak ada data yang cocok',
                        processing: 'Memuat data',
                        paginate: {
                            first: 'Awal',
                            last: 'Akhir',
                            next: 'Berikutnya',
                            previous: 'Sebelumnya'
                        }
                    }
                });
            });
        </script>
    @endpush
</x-layouts.admin>
