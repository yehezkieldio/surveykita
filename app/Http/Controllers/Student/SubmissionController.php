<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class SubmissionController extends Controller
{
    public function index(): View
    {
        return view('student.submissions.index');
    }
}
