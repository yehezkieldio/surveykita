<?php

use Akaunting\Apexcharts\Chart;
use App\Services\ResultChartService;
use Illuminate\Support\Collection;

test('index charts use supported apexcharts option keys', function () {
    $service = new ResultChartService;

    $charts = $service->indexCharts(new Collection([
        [
            'form' => (object) ['title' => 'Form A Dengan Label Yang Sangat Panjang'],
            'result' => [
                'satisfaction_percentage' => 87.5,
                'total_respondents' => 12,
            ],
        ],
        [
            'form' => (object) ['title' => 'Form B'],
            'result' => [
                'satisfaction_percentage' => 91.2,
                'total_respondents' => 18,
            ],
        ],
    ]));

    expect($charts['overall_satisfaction'])->toBeInstanceOf(Chart::class)
        ->and($charts['respondent_count'])->toBeInstanceOf(Chart::class);

    $overallOptions = json_decode($charts['overall_satisfaction']->getOptions(), true, flags: JSON_THROW_ON_ERROR);
    $respondentOptions = json_decode($charts['respondent_count']->getOptions(), true, flags: JSON_THROW_ON_ERROR);

    expect($overallOptions['xaxis']['categories'][0])->toBe([
        'Form A Dengan',
        'Label Yang',
        'Sangat Panjang',
    ])
        ->and($overallOptions['xaxis']['categories'][1])->toBe('Form B')
        ->and($overallOptions['xaxis']['labels']['rotate'])->toBe(-35)
        ->and($overallOptions['xaxis']['labels']['rotateAlways'])->toBeFalse()
        ->and($overallOptions['xaxis']['labels']['hideOverlappingLabels'])->toBeFalse()
        ->and($overallOptions['yaxis']['min'])->toBe(0)
        ->and($overallOptions['chart']['id'])->toBe('surveykita_overall_satisfaction')
        ->and($respondentOptions['chart']['id'])->toBe('surveykita_respondent_count');
});

test('detail charts preserve category and likert labels in chart options', function () {
    $service = new ResultChartService;

    $charts = $service->detailCharts([
        'average_score_per_category' => [
            [
                'category' => 'Akademik',
                'average_score' => 4.2,
            ],
            [
                'category' => 'Fasilitas',
                'average_score' => 3.8,
            ],
        ],
        'likert_distribution' => [
            1 => 1,
            2 => 2,
            3 => 3,
            4 => 4,
            5 => 5,
        ],
    ]);

    $categoryOptions = json_decode($charts['category_average']->getOptions(), true, flags: JSON_THROW_ON_ERROR);
    $likertOptions = json_decode($charts['likert_distribution']->getOptions(), true, flags: JSON_THROW_ON_ERROR);

    expect($categoryOptions['xaxis']['categories'])->toBe(['Akademik', 'Fasilitas'])
        ->and($likertOptions['xaxis']['categories'])->toBe([
            'Skor 1',
            'Skor 2',
            'Skor 3',
            'Skor 4',
            'Skor 5',
        ])
        ->and($likertOptions['yaxis']['min'])->toBe(0);
});
