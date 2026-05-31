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
        return view('admin.dashboard', [
            'studentCount' => Student::query()->count(),
            'activePeriodCount' => EvaluationPeriod::active()->count(),
            'activeFormCount' => EvaluationForm::query()->where('is_active', true)->count(),
            'questionCount' => Question::query()->count(),
            'responseCount' => Response::query()->count(),
        ]);
    }
}
