<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;

class ReportExportController extends Controller
{
    public function pdf(string $form): Response
    {
        return response('PDF report export endpoint for form '.$form, 200);
    }

    public function excel(string $form): Response
    {
        return response('Excel report export endpoint for form '.$form, 200);
    }
}
