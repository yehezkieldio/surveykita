<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EvaluationForm;
use App\Services\EvaluationResultService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class ReportExportController extends Controller
{
    public function pdf(EvaluationForm $form, EvaluationResultService $results): Response
    {
        $form->load('evaluationPeriod');
        $result = $results->forForm($form);
        $filename = 'surveykita-'.Str::slug($form->title).'.pdf';

        return Pdf::loadView('pdf.evaluation-report', [
            'form' => $form,
            'result' => $result,
        ])->setPaper('a4')->download($filename);
    }

    public function excel(string $form): Response
    {
        return response('Excel report export endpoint for form '.$form, 200);
    }
}
