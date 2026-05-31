<x-layouts.admin title="Detail Mahasiswa - SurveyKita" heading="Detail Mahasiswa">
    <x-card heading="{{ $student->name }}" subheading="{{ $student->nim }} - {{ $student->study_program }}">
        <dl class="grid gap-3 text-sm md:grid-cols-2">
            <div><dt class="text-zinc-500">Email</dt><dd class="font-medium">{{ $student->user->email }}</dd></div>
            <div><dt class="text-zinc-500">Kelas</dt><dd class="font-medium">{{ $student->class_name }}</dd></div>
            <div><dt class="text-zinc-500">Angkatan</dt><dd class="font-medium">{{ $student->enrollment_year }}</dd></div>
            <div><dt class="text-zinc-500">Respons</dt><dd class="font-medium">{{ $student->responses->count() }}</dd></div>
        </dl>
        <div class="mt-4 flex gap-2">
            <x-button :href="route('admin.students.edit', $student)">Edit</x-button>
            <x-button variant="secondary" :href="route('admin.students.index')">Kembali</x-button>
        </div>
    </x-card>
</x-layouts.admin>
