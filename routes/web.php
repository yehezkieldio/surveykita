<?php

use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\EvaluationFormController;
use App\Http\Controllers\Admin\EvaluationPeriodController;
use App\Http\Controllers\Admin\QuestionCategoryController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\ReportExportController;
use App\Http\Controllers\Admin\ResultController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\TableExportController;
use App\Http\Controllers\Student\DashboardController as StudentDashboardController;
use App\Http\Controllers\Student\EvaluationController;
use App\Http\Controllers\Student\ProfileController;
use App\Http\Controllers\Student\SubmissionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (Auth::check()) {
        return Auth::user()->role === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('student.dashboard');
    }

    return redirect()->route('login');
})->name('home');

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function (): void {
        Route::get('/dashboard', AdminDashboardController::class)->name('dashboard');
        
        Route::get('/profile', [AdminProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [AdminProfileController::class, 'update'])->name('profile.update');

        Route::get('/students/data', [StudentController::class, 'data'])->name('students.data');
        Route::get('/students/export/excel', [TableExportController::class, 'studentsExcel'])->name('students.export.excel');
        Route::get('/students/export/pdf', [TableExportController::class, 'studentsPdf'])->name('students.export.pdf');
        Route::resource('students', StudentController::class);
        
        Route::get('/periods/data', [EvaluationPeriodController::class, 'data'])->name('periods.data');
        Route::get('/periods/export/excel', [TableExportController::class, 'periodsExcel'])->name('periods.export.excel');
        Route::get('/periods/export/pdf', [TableExportController::class, 'periodsPdf'])->name('periods.export.pdf');
        Route::resource('periods', EvaluationPeriodController::class);
        
        Route::get('/forms/data', [EvaluationFormController::class, 'data'])->name('forms.data');
        Route::get('/forms/export/excel', [TableExportController::class, 'formsExcel'])->name('forms.export.excel');
        Route::get('/forms/export/pdf', [TableExportController::class, 'formsPdf'])->name('forms.export.pdf');
        Route::resource('forms', EvaluationFormController::class);
        
        Route::get('/categories/data', [QuestionCategoryController::class, 'data'])->name('categories.data');
        Route::get('/categories/export/excel', [TableExportController::class, 'categoriesExcel'])->name('categories.export.excel');
        Route::get('/categories/export/pdf', [TableExportController::class, 'categoriesPdf'])->name('categories.export.pdf');
        Route::resource('categories', QuestionCategoryController::class)->except('show');
        
        Route::get('/questions/data', [QuestionController::class, 'data'])->name('questions.data');
        Route::get('/questions/export/excel', [TableExportController::class, 'questionsExcel'])->name('questions.export.excel');
        Route::get('/questions/export/pdf', [TableExportController::class, 'questionsPdf'])->name('questions.export.pdf');
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
        Route::put('/profile/complete', [ProfileController::class, 'update'])->name('profile.update');
        Route::get('/evaluations', [EvaluationController::class, 'index'])->name('evaluations.index');
        Route::middleware('student.profile.complete')->group(function (): void {
            Route::get('/evaluations/{form}', [EvaluationController::class, 'show'])->name('evaluations.show');
            Route::get('/evaluations/{form}/fill', [EvaluationController::class, 'fill'])->name('evaluations.fill');
            Route::post('/evaluations/{form}/submit', [EvaluationController::class, 'submit'])->name('evaluations.submit');
        });
        Route::get('/submissions', [SubmissionController::class, 'index'])->name('submissions.index');
        Route::get('/submissions/success/{response}', [SubmissionController::class, 'success'])->name('submissions.success');
    });
