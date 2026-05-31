<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\EvaluationForm;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $student = auth()->user()?->student;

        return view('student.dashboard', [
            'activeFormCount' => EvaluationForm::query()
                ->where('is_active', true)
                ->whereHas('evaluationPeriod', fn ($query) => $query->active()
                    ->whereDate('start_date', '<=', now())
                    ->whereDate('end_date', '>=', now()))
                ->count(),
            'submissionCount' => $student?->responses()->count() ?? 0,
            'profileComplete' => auth()->user()?->hasCompleteStudentProfile() ?? false,
        ]);
    }
}
