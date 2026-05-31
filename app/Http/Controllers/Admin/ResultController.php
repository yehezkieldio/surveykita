<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class ResultController extends Controller
{
    public function index(): View
    {
        return view('admin.results.index');
    }

    public function show(string $form): View
    {
        return view('admin.results.show', ['form' => $form]);
    }
}
