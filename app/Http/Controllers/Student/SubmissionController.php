<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Response;
use Illuminate\Contracts\View\View;

class SubmissionController extends Controller
{
    public function index(): View
    {
        return view('student.submissions.index', [
            'responses' => auth()->user()?->student?->responses()
                ->with('evaluationForm.evaluationPeriod')
                ->latest('submitted_at')
                ->paginate(10),
        ]);
    }

    public function success(Response $response): View
    {
        abort_unless($response->student_id === auth()->user()?->student?->id, 403);

        return view('student.submissions.success', [
            'response' => $response->load('evaluationForm.evaluationPeriod'),
        ]);
    }
}
