<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\EvaluationForm;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class EvaluationController extends Controller
{
    public function index(): View
    {
        return view('student.evaluations.index');
    }

    public function show(string $form): View
    {
        $form = EvaluationForm::query()->findOrFail($form);

        return view('student.evaluations.show', [
            'form' => $form->load(['evaluationPeriod', 'questions.category']),
        ]);
    }

    public function submit(string $form): RedirectResponse
    {
        return redirect()->route('student.evaluations.show', $form);
    }
}
