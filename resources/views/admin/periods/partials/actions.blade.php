<div class="flex justify-end gap-2">
    <x-ui.button href="{{ route('admin.periods.show', $period) }}" variant="ghost" size="sm">Detail</x-ui.button>
    <x-ui.button href="{{ route('admin.periods.edit', $period) }}" variant="secondary" size="sm">Edit</x-ui.button>
</div>
