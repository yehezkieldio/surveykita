<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class EvaluationFormController extends Controller
{
    public function index(): View
    {
        return view('admin.modules.index', [
            'heading' => 'Form Evaluasi',
            'description' => 'Form evaluasi akademik akan dikelola melalui modul ini.',
        ]);
    }
}
