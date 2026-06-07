<?php

namespace App\Services;

use Akaunting\Apexcharts\Chart;
use Illuminate\Support\Collection;

class ResultChartService
{
    /**
     * @param  Collection<int, array{form: mixed, result: array<string, mixed>}>  $rows
     * @return array<string, Chart>
     */
    public function indexCharts(Collection $rows): array
    {
        $labels = $rows
            ->map(fn (array $row): string => $row['form']->title)
            ->values()
            ->all();

        return [
            'overall_satisfaction' => $this->barChart(
                'surveykita_overall_satisfaction',
                'Persentase Kepuasan per Form',
                $labels,
                'Persentase Kepuasan',
                $rows->map(fn (array $row): float => $row['result']['satisfaction_percentage'])->values()->all(),
                '#0f766e',
            ),
            'respondent_count' => $this->barChart(
                'surveykita_respondent_count',
                'Jumlah Responden per Form',
                $labels,
                'Jumlah Responden',
                $rows->map(fn (array $row): int => $row['result']['total_respondents'])->values()->all(),
                '#4f46e5',
            ),
        ];
    }

    /**
     * @param  array<string, mixed>  $result
     * @return array<string, Chart>
     */
    public function detailCharts(array $result): array
    {
        $categoryRows = collect($result['average_score_per_category']);

        return [
            'category_average' => $this->barChart(
                'surveykita_category_average',
                'Rata-rata Skor per Kategori',
                $categoryRows->pluck('category')->values()->all(),
                'Rata-rata Skor',
                $categoryRows->pluck('average_score')->values()->all(),
                '#7c3aed',
            ),
            'likert_distribution' => $this->barChart(
                'surveykita_likert_distribution',
                'Distribusi Skor Likert',
                collect($result['likert_distribution'])
                    ->keys()
                    ->map(fn (int $score): string => 'Skor '.$score)
                    ->values()
                    ->all(),
                'Jumlah Jawaban',
                collect($result['likert_distribution'])->values()->all(),
                '#ea580c',
            ),
        ];
    }

    /**
     * @param  list<string>  $labels
     * @param  list<int|float>  $data
     */
    private function barChart(
        string $id,
        string $title,
        array $labels,
        string $seriesName,
        array $data,
        string $color,
    ): Chart {
        $chart = new Chart;
        $chart->setType('bar')
            ->setHeight(320)
            ->setTitle($title)
            ->setSubtitle(' ')
            ->setColors([$color])
            ->setDataset($seriesName, 'bar', $data)
            ->setXaxis([
                'categories' => $labels,
                'labels' => [
                    'rotate' => -45,
                    'trim' => true,
                    'maxHeight' => 100,
                    'style' => ['fontSize' => '10px', 'fontWeight' => 600, 'colors' => '#71717a'],
                ],
            ])
            ->setYaxis([
                'min' => 0,
                'labels' => [
                    'style' => ['fontSize' => '10px', 'fontWeight' => 500, 'colors' => '#71717a'],
                    'maxWidth' => 100,
                ],
            ])
            ->setOption([
                'dataLabels' => ['enabled' => false],
                'grid' => ['borderColor' => '#e4e4e7', 'strokeDashArray' => 4],
                'noData' => ['text' => 'Belum ada data'],
                'plotOptions' => [
                    'bar' => [
                        'borderRadius' => 4,
                        'columnWidth' => '48%',
                    ],
                ],
                'chart' => [
                    'id' => $id,
                    'toolbar' => ['show' => false],
                    'fontFamily' => 'inherit',
                ],
            ]);

        return $chart;
    }
}
