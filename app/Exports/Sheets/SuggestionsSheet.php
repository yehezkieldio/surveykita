<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;

class SuggestionsSheet implements FromArray, WithTitle
{
    /**
     * @param  array<string, mixed>  $result
     */
    public function __construct(private readonly array $result) {}

    public function array(): array
    {
        $rows = [
            ['Mahasiswa', 'Saran / Komentar'],
        ];

        foreach ($this->result['suggestions'] as $suggestion) {
            $rows[] = [
                $suggestion['student_name'],
                $suggestion['suggestion'],
            ];
        }

        return $rows;
    }

    public function title(): string
    {
        return 'Saran';
    }
}
