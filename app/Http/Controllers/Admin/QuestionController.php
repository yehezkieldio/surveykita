<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class QuestionController extends Controller
{
    public function index(): View
    {
        return view('admin.modules.index', [
            'heading' => 'Pertanyaan Evaluasi',
            'description' => 'Pertanyaan Likert untuk setiap form akan dikelola melalui modul ini.',
        ]);
    }
}
