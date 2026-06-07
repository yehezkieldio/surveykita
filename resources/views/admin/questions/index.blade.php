<x-layouts.admin heading="Butir Pertanyaan" eyebrow="Database Instrumen">
    <x-slot:actions>
        <x-ui.button href="{{ route('admin.questions.create') }}" variant="teal" size="sm">
            <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            Tambah Pertanyaan
        </x-ui.button>
    </x-slot:actions>

    <div class="space-y-6">
        {{-- Filters area --}}
        <div class="flex flex-wrap items-center gap-4 bg-white border border-zinc-200 p-4 shadow-sm">
            <div class="flex flex-col gap-1">
                <label class="text-[10px] font-bold uppercase tracking-widest text-zinc-400">Filter Instrumen</label>
                <select id="form-filter" class="!w-64 !border-zinc-300 bg-white px-3 py-1.5 text-xs font-bold focus:!border-teal-600 focus:!ring-0 outline-none transition-all">
                    <option value="">Semua Instrumen</option>
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
    </div>

    @push('scripts')
        <script>
            $(function() {
                let table = $('#questions-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('admin.questions.data') }}",
                        data: function (d) {
                            d.evaluation_form_id = $('#form-filter').val();
                        }
                    },
                    columns: [
                        { 
                            data: 'text', 
                            name: 'text', 
                            className: 'font-medium text-zinc-950 max-w-md',
                            render: function(data) {
                                return `<div class="whitespace-normal leading-relaxed">${data}</div>`;
                            }
                        },
                        { data: 'form_title', name: 'evaluationForm.title', className: 'text-xs text-zinc-500' },
                        { data: 'category_name', name: 'category.name', className: 'text-xs font-bold uppercase tracking-tight text-zinc-400' },
                        { data: 'sort_order', name: 'sort_order', className: 'text-sm font-mono text-zinc-400' },
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
                        searchPlaceholder: "Cari pertanyaan...",
                        lengthMenu: "_MENU_",
                        info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ pertanyaan",
                    },
                    pageLength: 25,
                    order: [[1, 'asc'], [3, 'asc']]
                });

                $('#form-filter').on('change', function() {
                    table.draw();
                });
            });
        </script>
    @endpush
</x-layouts.admin>
