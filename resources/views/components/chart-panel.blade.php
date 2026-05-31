@props(['heading', 'chart', 'subheading' => null])

<x-card :heading="$heading" :subheading="$subheading" {{ $attributes }}>
    <div class="min-h-64 overflow-hidden [&_.apexcharts-canvas]:max-h-72">
        {!! $chart->container() !!}
    </div>
</x-card>
