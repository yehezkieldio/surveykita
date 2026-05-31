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
        Route::get('/students', [StudentController::class, 'index'])->name('students.index');
        Route::get('/periods', [EvaluationPeriodController::class, 'index'])->name('periods.index');
        Route::get('/forms', [EvaluationFormController::class, 'index'])->name('forms.index');
        Route::get('/categories', [QuestionCategoryController::class, 'index'])->name('categories.index');
        Route::get('/questions', [QuestionController::class, 'index'])->name('questions.index');

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
