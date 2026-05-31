<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class QuestionCategoryController extends Controller
{
    public function index(): View
    {
        return view('admin.modules.index', [
            'heading' => 'Kategori Pertanyaan',
            'description' => 'Kategori layanan akademik akan dikelola melalui modul ini.',
        ]);
    }
}
