<?php

namespace App\Http\Controllers\Admin;

use App\Exports\EvaluationReportExport;
use App\Http\Controllers\Controller;
use App\Models\EvaluationForm;
use App\Services\EvaluationResultService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\Response;

class ReportExportController extends Controller
{
    public function pdf(string $form, EvaluationResultService $results): Response
    {
        $form = EvaluationForm::query()
            ->with('evaluationPeriod')
            ->findOrFail($form);
        $result = $results->forForm($form);
        $filename = 'surveykita-'.Str::slug($form->title).'.pdf';

        return Pdf::loadView('pdf.evaluation-report', [
            'form' => $form,
            'result' => $result,
        ])->setPaper('a4')->download($filename);
    }

    public function excel(string $form, EvaluationResultService $results): Response
    {
        $form = EvaluationForm::query()
            ->with('evaluationPeriod')
            ->findOrFail($form);
        $result = $results->forForm($form);
        $filename = 'surveykita-'.Str::slug($form->title).'.xlsx';

        return Excel::download(new EvaluationReportExport($form, $result), $filename);
    }
}
