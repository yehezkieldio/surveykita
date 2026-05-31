@props(['heading', 'chart', 'subheading' => null])

<x-card :heading="$heading" :subheading="$subheading" {{ $attributes }}>
    <div class="min-h-80 overflow-hidden">
        {!! $chart->container() !!}
    </div>
</x-card>
