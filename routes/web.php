<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\EvaluationFormController;
use App\Http\Controllers\Admin\EvaluationPeriodController;
use App\Http\Controllers\Admin\QuestionCategoryController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\ReportExportController;
use App\Http\Controllers\Admin\ResultController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Student\DashboardController as StudentDashboardController;
use App\Http\Controllers\Student\EvaluationController;
use App\Http\Controllers\Student\ProfileController;
use App\Http\Controllers\Student\SubmissionController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login')->name('home');

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function (): void {
        Route::get('/dashboard', AdminDashboardController::class)->name('dashboard');
        Route::resource('students', StudentController::class);
        Route::resource('periods', EvaluationPeriodController::class);
        Route::resource('forms', EvaluationFormController::class);
        Route::resource('categories', QuestionCategoryController::class)->except('show');
        Route::resource('questions', QuestionController::class)->except('show');

        Route::get('/results', [ResultController::class, 'index'])->name('results.index');
        Route::get('/results/{form}', [ResultController::class, 'show'])->name('results.show');
        Route::get('/results/{form}/export/pdf', [ReportExportController::class, 'pdf'])->name('results.export.pdf');
        Route::get('/results/{form}/export/excel', [ReportExportController::class, 'excel'])->name('results.export.excel');
    });

Route::middleware(['auth', 'role:mahasiswa'])
    ->prefix('student')
    ->name('student.')
    ->group(function (): void {
        Route::get('/dashboard', StudentDashboardController::class)->name('dashboard');
        Route::get('/profile/complete', [ProfileController::class, 'edit'])->name('profile.complete');
        Route::get('/evaluations', [EvaluationController::class, 'index'])->name('evaluations.index');
        Route::post('/evaluations/{form}/submit', [EvaluationController::class, 'submit'])->name('evaluations.submit');
        Route::get('/submissions', [SubmissionController::class, 'index'])->name('submissions.index');
    });
