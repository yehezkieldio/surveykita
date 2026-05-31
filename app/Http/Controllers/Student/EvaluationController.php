<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class EvaluationController extends Controller
{
    public function index(): View
    {
        return view('student.evaluations.index');
    }

    public function submit(string $form): RedirectResponse
    {
        return redirect('/student/evaluations/'.$form);
    }
}
