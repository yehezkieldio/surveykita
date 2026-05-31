<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class EvaluationPeriodController extends Controller
{
    public function index(): View
    {
        return view('admin.modules.index', [
            'heading' => 'Periode Evaluasi',
            'description' => 'Periode aktif dan rentang tanggal evaluasi akan dikelola melalui modul ini.',
        ]);
    }
}
