<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class StudentController extends Controller
{
    public function index(): View
    {
        return view('admin.modules.index', [
            'heading' => 'Data Mahasiswa',
            'description' => 'Daftar mahasiswa akan dikelola melalui modul ini.',
        ]);
    }
}
