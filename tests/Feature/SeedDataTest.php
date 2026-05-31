<?php

use App\Models\EvaluationForm;
use App\Models\EvaluationPeriod;
use App\Models\Question;
use App\Models\QuestionCategory;
use App\Models\Response;
use App\Models\ResponseAnswer;
use App\Models\Student;
use App\Models\User;
use App\Services\NimParser;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('database seeder creates complete demonstrable SurveyKita data', function () {
    $this->seed();

    expect(User::query()->where('role', 'admin')->count())->toBeGreaterThanOrEqual(1)
        ->and(User::query()->where('role', 'mahasiswa')->count())->toBeGreaterThanOrEqual(8)
        ->and(Student::query()->count())->toBeGreaterThanOrEqual(8)
        ->and(EvaluationPeriod::query()->count())->toBe(2)
        ->and(EvaluationForm::query()->count())->toBeGreaterThanOrEqual(4)
        ->and(QuestionCategory::query()->count())->toBeGreaterThanOrEqual(5)
        ->and(Question::query()->count())->toBeBetween(15, 25)
        ->and(Response::query()->count())->toBeGreaterThanOrEqual(12)
        ->and(ResponseAnswer::query()->count())->toBeGreaterThan(0);

    expect(User::query()->where('email', 'admin@universitasmulia.ac.id')->exists())->toBeTrue()
        ->and(User::query()->where('email', '2311032@students.universitasmulia.ac.id')->exists())->toBeTrue();
});

test('seeded mahasiswa profiles contain valid parsed NIM details', function () {
    $this->seed();

    $parser = new NimParser;

    $students = Student::query()
        ->with('user')
        ->whereNotNull('nim')
        ->get();

    expect($students)->toHaveCount(Student::query()->count())
        ->and($students->pluck('program_code')->unique()->count())->toBeGreaterThanOrEqual(4);

    $students->each(function (Student $student) use ($parser): void {
        $parsed = $parser->parse($student->nim);

        expect($student->user->hasCompleteStudentProfile())->toBeTrue()
            ->and($student->program_code)->toBe($parsed['program_code'])
            ->and($student->study_program)->toBe($parsed['study_program'])
            ->and($student->enrollment_year)->toBe($parsed['enrollment_year'])
            ->and($student->sequence_number)->toBe($parsed['sequence_number']);
    });
});

test('seeded responses provide meaningful dashboard and report data', function () {
    $this->seed();

    $activeCurrentForms = EvaluationForm::query()
        ->where('is_active', true)
        ->whereHas('evaluationPeriod', function ($query): void {
            $query->where('is_active', true)
                ->whereDate('start_date', '<=', now())
                ->whereDate('end_date', '>=', now());
        })
        ->withCount(['questions', 'responses'])
        ->get();

    expect($activeCurrentForms)->not->toBeEmpty()
        ->and($activeCurrentForms->sum('responses_count'))->toBeGreaterThanOrEqual(12)
        ->and($activeCurrentForms->min('questions_count'))->toBeGreaterThanOrEqual(4)
        ->and(Response::query()->whereNotNull('suggestion')->count())->toBeGreaterThanOrEqual(5)
        ->and(ResponseAnswer::query()->whereBetween('score', [1, 5])->count())->toBe(ResponseAnswer::query()->count());
});
