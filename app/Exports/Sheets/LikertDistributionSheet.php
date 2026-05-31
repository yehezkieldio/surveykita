<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;

class LikertDistributionSheet implements FromArray, WithTitle
{
    use FormatsExportValues;

    /**
     * @param  array<string, mixed>  $result
     */
    public function __construct(private readonly array $result) {}

    public function array(): array
    {
        $rows = [
            ['Skor', 'Jumlah Jawaban'],
        ];

        foreach ($this->result['likert_distribution'] as $score => $count) {
            $rows[] = [$score, $this->exportValue($count)];
        }

        return $rows;
    }

    public function title(): string
    {
        return 'Distribusi Likert';
    }
}
