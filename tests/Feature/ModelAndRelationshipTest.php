<?php

use App\Models\EvaluationForm;
use App\Models\EvaluationPeriod;
use App\Models\Question;
use App\Models\QuestionCategory;
use App\Models\Response;
use App\Models\ResponseAnswer;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('user exposes student relationship and role helpers', function () {
    $user = User::query()->create([
        'name' => 'Mahasiswa Mulia',
        'email' => '2311032@students.universitasmulia.ac.id',
        'role' => 'mahasiswa',
        'password' => null,
    ]);

    $student = Student::query()->create([
        'user_id' => $user->id,
        'nim' => '2311032',
        'name' => 'Mahasiswa Mulia',
        'program_code' => '11',
        'study_program' => 'S1 Informatika',
        'enrollment_year' => 2023,
        'sequence_number' => '032',
        'class_name' => 'IF-23A',
    ]);

    expect($user->isMahasiswa())->toBeTrue()
        ->and($user->isAdmin())->toBeFalse()
        ->and($user->hasCompleteStudentProfile())->toBeTrue()
        ->and($user->student->is($student))->toBeTrue()
        ->and($student->user->is($user))->toBeTrue();
});

test('student profile helper returns false when required profile data is missing', function () {
    $user = User::query()->create([
        'name' => 'Mahasiswa Google',
        'email' => '2311033@students.universitasmulia.ac.id',
        'role' => 'mahasiswa',
        'password' => null,
    ]);

    Student::query()->create([
        'user_id' => $user->id,
        'name' => 'Mahasiswa Google',
    ]);

    expect($user->hasCompleteStudentProfile())->toBeFalse();
});

test('evaluation periods and forms expose active and fillable helpers', function () {
    $openPeriod = EvaluationPeriod::query()->create([
        'name' => 'Evaluasi Semester Ganjil',
        'semester' => 'Ganjil',
        'academic_year' => '2026/2027',
        'start_date' => now()->subDay()->toDateString(),
        'end_date' => now()->addDay()->toDateString(),
        'is_active' => true,
    ]);

    $closedPeriod = EvaluationPeriod::query()->create([
        'name' => 'Evaluasi Lama',
        'semester' => 'Genap',
        'academic_year' => '2025/2026',
        'start_date' => now()->subMonth()->toDateString(),
        'end_date' => now()->subWeek()->toDateString(),
        'is_active' => true,
    ]);

    $activeForm = EvaluationForm::query()->create([
        'evaluation_period_id' => $openPeriod->id,
        'title' => 'Evaluasi Layanan Akademik',
        'description' => 'Evaluasi layanan akademik semester berjalan.',
        'target_type' => 'layanan_akademik',
        'is_active' => true,
    ]);

    $inactiveForm = EvaluationForm::query()->create([
        'evaluation_period_id' => $openPeriod->id,
        'title' => 'Evaluasi Nonaktif',
        'target_type' => 'administrasi',
        'is_active' => false,
    ]);

    $expiredForm = EvaluationForm::query()->create([
        'evaluation_period_id' => $closedPeriod->id,
        'title' => 'Evaluasi Kedaluwarsa',
        'target_type' => 'fasilitas',
        'is_active' => true,
    ]);

    expect(EvaluationPeriod::active()->count())->toBe(2)
        ->and($openPeriod->isCurrentlyOpen())->toBeTrue()
        ->and($closedPeriod->isCurrentlyOpen())->toBeFalse()
        ->and($activeForm->isFillable())->toBeTrue()
        ->and($inactiveForm->isFillable())->toBeFalse()
        ->and($expiredForm->isFillable())->toBeFalse()
        ->and($activeForm->evaluationPeriod->is($openPeriod))->toBeTrue();
});

test('response graph connects forms questions categories students and answers', function () {
    $user = User::query()->create([
        'name' => 'Mahasiswa Responden',
        'email' => '2312034@students.universitasmulia.ac.id',
        'role' => 'mahasiswa',
        'password' => null,
    ]);

    $student = Student::query()->create([
        'user_id' => $user->id,
        'nim' => '2312034',
        'name' => 'Mahasiswa Responden',
        'program_code' => '12',
        'study_program' => 'S1 Teknologi Informasi',
        'enrollment_year' => 2023,
        'sequence_number' => '034',
        'class_name' => 'TI-23A',
    ]);

    $period = EvaluationPeriod::query()->create([
        'name' => 'Evaluasi Semester Ganjil',
        'semester' => 'Ganjil',
        'academic_year' => '2026/2027',
        'start_date' => now()->subDay()->toDateString(),
        'end_date' => now()->addDay()->toDateString(),
        'is_active' => true,
    ]);

    $form = EvaluationForm::query()->create([
        'evaluation_period_id' => $period->id,
        'title' => 'Evaluasi Pembelajaran',
        'target_type' => 'pembelajaran',
        'is_active' => true,
    ]);

    $category = QuestionCategory::query()->create([
        'name' => 'Pembelajaran',
        'description' => 'Kualitas proses pembelajaran.',
    ]);

    $question = Question::query()->create([
        'evaluation_form_id' => $form->id,
        'question_category_id' => $category->id,
        'question_text' => 'Dosen menyampaikan materi dengan jelas.',
        'sort_order' => 1,
        'is_required' => true,
    ]);

    $response = Response::query()->create([
        'evaluation_form_id' => $form->id,
        'student_id' => $student->id,
        'submitted_at' => now(),
        'suggestion' => 'Pertahankan kualitas layanan.',
    ]);

    $answer = ResponseAnswer::query()->create([
        'response_id' => $response->id,
        'question_id' => $question->id,
        'score' => 5,
    ]);

    expect($period->evaluationForms()->first()->is($form))->toBeTrue()
        ->and($form->questions()->first()->is($question))->toBeTrue()
        ->and($form->responses()->first()->is($response))->toBeTrue()
        ->and($category->questions()->first()->is($question))->toBeTrue()
        ->and($question->evaluationForm->is($form))->toBeTrue()
        ->and($question->category->is($category))->toBeTrue()
        ->and($response->student->is($student))->toBeTrue()
        ->and($response->evaluationForm->is($form))->toBeTrue()
        ->and($response->answers()->first()->is($answer))->toBeTrue()
        ->and($answer->response->is($response))->toBeTrue()
        ->and($answer->question->is($question))->toBeTrue()
        ->and($form->isFillable($student))->toBeFalse();
});
