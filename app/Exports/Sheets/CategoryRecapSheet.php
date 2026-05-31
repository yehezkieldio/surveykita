<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;

class CategoryRecapSheet implements FromArray, WithTitle
{
    use FormatsExportValues;

    /**
     * @param  array<string, mixed>  $result
     */
    public function __construct(private readonly array $result) {}

    public function array(): array
    {
        $rows = [
            ['Kategori', 'Jumlah Jawaban', 'Rata-rata Skor', 'Persentase Kepuasan', 'Kategori Kepuasan'],
        ];

        foreach ($this->result['average_score_per_category'] as $row) {
            $rows[] = [
                $row['category'],
                $this->exportValue($row['total_answers']),
                $this->exportValue($row['average_score']),
                $this->exportValue($row['satisfaction_percentage']),
                $row['satisfaction_category'],
            ];
        }

        return $rows;
    }

    public function title(): string
    {
        return 'Rekap Kategori';
    }
}
