<?php

namespace App\Exports;

use App\Exports\Sheets\CategoryRecapSheet;
use App\Exports\Sheets\LikertDistributionSheet;
use App\Exports\Sheets\QuestionRecapSheet;
use App\Exports\Sheets\RawResponsesSheet;
use App\Exports\Sheets\SuggestionsSheet;
use App\Exports\Sheets\SummarySheet;
use App\Models\EvaluationForm;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class EvaluationReportExport implements WithMultipleSheets
{
    /**
     * @param  array<string, mixed>  $result
     */
    public function __construct(
        private readonly EvaluationForm $form,
        private readonly array $result,
    ) {}

    public function sheets(): array
    {
        return [
            new SummarySheet($this->form, $this->result),
            new CategoryRecapSheet($this->result),
            new QuestionRecapSheet($this->result),
            new LikertDistributionSheet($this->result),
            new SuggestionsSheet($this->result),
            new RawResponsesSheet($this->form),
        ];
    }
}
