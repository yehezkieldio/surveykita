@props(['paginator'])

@if ($paginator->hasPages())
    <div {{ $attributes->merge(['class' => 'mt-6 border-t border-zinc-200 pt-6']) }}>
        {{ $paginator->links() }}
    </div>
@endif
