@props(['heading' => null, 'chart', 'description' => null])

<x-ui.card :title="$heading" :description="$description" {{ $attributes->merge(['class' => 'overflow-hidden']) }}>
    <div class="min-h-[320px]">
        {!! $chart->container() !!}
    </div>
    
    @push('scripts')
        {!! $chart->script() !!}
    @endpush
</x-ui.card>
