<x-layouts.admin heading="Tambah Mahasiswa" eyebrow="Mahasiswa">
    <x-slot:actions>
        <x-ui.button href="{{ route('admin.students.index') }}" variant="secondary" size="sm">
            Kembali
        </x-ui.button>
    </x-slot:actions>

    <div class="max-w-3xl">
        <x-ui.card>
            <form action="{{ route('admin.students.store') }}" method="POST">
                @csrf
                @include('admin.students.partials.form')

                <div class="mt-8 flex justify-end gap-3 border-t border-zinc-100 pt-6">
                    <x-ui.button href="{{ route('admin.students.index') }}" variant="ghost">Batal</x-ui.button>
                    <x-ui.button variant="teal">Simpan Mahasiswa</x-ui.button>
                </div>
            </form>
        </x-ui.card>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const emailInput = document.getElementById('email');
                const nimInput = document.getElementById('nim');
                const classNameInput = document.getElementById('class_name');

                const programAbbreviations = {
                    '11': 'IF', '12': 'TI', '13': 'SI', '15': 'DKV',
                    '21': 'AK', '22': 'MN', '31': 'HK', '32': 'PGPAUD',
                    '33': 'FA', '41': 'SI', '51': 'TI', '52': 'TS', '53': 'TP'
                };

                emailInput.addEventListener('input', function() {
                    const email = this.value;
                    const nimMatch = email.match(/^(\d{7})@/);
                    
                    if (nimMatch) {
                        const nim = nimMatch[1];
                        nimInput.value = nim;
                        updateClassName(nim);
                    }
                });

                nimInput.addEventListener('input', function() {
                    if (this.value.length === 7) {
                        updateClassName(this.value);
                    }
                });

                function updateClassName(nim) {
                    if (!/^\d{7}$/.test(nim)) return;
                    
                    const year = parseInt(nim.substring(0, 2));
                    const progCode = nim.substring(2, 4);
                    const prog = programAbbreviations[progCode] || progCode;
                    
                    const admissionYear = 2000 + year;
                    const today = new Date();
                    const currentYear = today.getFullYear();
                    const currentMonth = today.getMonth() + 1; // 0-indexed
                    
                    const semester = ((currentYear - admissionYear) * 2) + (currentMonth >= 8 ? 1 : 0);
                    const safeSemester = Math.max(1, semester);
                    
                    classNameInput.value = `${prog}B${safeSemester}A`;
                }
            });
        </script>
    @endpush
</x-layouts.admin>
