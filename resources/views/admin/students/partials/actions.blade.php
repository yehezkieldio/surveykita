<div class="flex justify-end gap-2">
    <x-ui.button href="{{ route('admin.students.show', $student) }}" variant="ghost" size="sm">Detail</x-ui.button>
    <x-ui.button href="{{ route('admin.students.edit', $student) }}" variant="secondary" size="sm">Edit</x-ui.button>
</div>
