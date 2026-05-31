<?php

namespace App\Exports\Sheets;

use App\Models\EvaluationForm;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;

class SummarySheet implements FromArray, WithTitle
{
    use FormatsExportValues;

    /**
     * @param  array<string, mixed>  $result
     */
    public function __construct(
        private readonly EvaluationForm $form,
        private readonly array $result,
    ) {}

    public function array(): array
    {
        return [
            ['Judul Evaluasi', $this->form->title],
            ['Periode', $this->form->evaluationPeriod->name],
            ['Total Responden', $this->exportValue($this->result['total_respondents'])],
            ['Total Jawaban', $this->exportValue($this->result['total_answers'])],
            ['Rata-rata Skor', $this->exportValue($this->result['average_score'])],
            ['Persentase Kepuasan', $this->exportValue($this->result['satisfaction_percentage'])],
            ['Kategori Kepuasan', $this->result['satisfaction_category']],
        ];
    }

    public function title(): string
    {
        return 'Ringkasan';
    }
}
