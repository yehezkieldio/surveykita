<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EvaluationForm;
use App\Models\EvaluationPeriod;
use App\Models\Question;
use App\Models\Response;
use App\Models\Student;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $studentCount = Student::query()->count();
        $activePeriodCount = EvaluationPeriod::active()->count();
        $activeFormCount = EvaluationForm::query()->where('is_active', true)->count();
        $questionCount = Question::query()->count();
        $responseCount = Response::query()->count();

        $activePeriods = EvaluationPeriod::active()->latest()->take(5)->get();
        $activeForms = EvaluationForm::query()
            ->where('is_active', true)
            ->with(['evaluationPeriod'])
            ->withCount(['questions', 'responses'])
            ->take(6)
            ->get();

        $recentResponses = Response::query()
            ->with(['student', 'evaluationForm.evaluationPeriod'])
            ->latest('submitted_at')
            ->take(5)
            ->get();

        $formsWithoutQuestions = EvaluationForm::query()
            ->where('is_active', true)
            ->whereDoesntHave('questions')
            ->take(5)
            ->get();

        $responseCountForActiveForms = Response::query()
            ->whereHas('evaluationForm', fn ($query) => $query->where('is_active', true))
            ->count();

        $potentialResponseCount = $studentCount * $activeFormCount;
        $completionPercentage = $potentialResponseCount > 0
            ? round(($responseCountForActiveForms / $potentialResponseCount) * 100)
            : 0;

        return view('admin.dashboard', [
            'studentCount' => $studentCount,
            'activePeriodCount' => $activePeriodCount,
            'activeFormCount' => $activeFormCount,
            'questionCount' => $questionCount,
            'responseCount' => $responseCount,
            'activePeriods' => $activePeriods,
            'activeForms' => $activeForms,
            'recentResponses' => $recentResponses,
            'formsWithoutQuestions' => $formsWithoutQuestions,
            'responseCountForActiveForms' => $responseCountForActiveForms,
            'potentialResponseCount' => $potentialResponseCount,
            'completionPercentage' => $completionPercentage,
        ]);
    }
}
