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

function completeStudentUser(): User
{
    $user = User::factory()->mahasiswa()->create([
        'email' => '2311032@students.universitasmulia.ac.id',
    ]);

    Student::factory()->for($user)->create([
        'nim' => '2311032',
        'name' => 'Mahasiswa Lengkap',
        'program_code' => '11',
        'study_program' => 'S1 Informatika',
        'enrollment_year' => 2023,
        'sequence_number' => '032',
        'class_name' => 'IF-23A',
    ]);

    return $user;
}

function evaluationFormFixture(array $periodOverrides = [], array $formOverrides = []): EvaluationForm
{
    $period = EvaluationPeriod::factory()->create(array_merge([
        'start_date' => now()->subDay()->toDateString(),
        'end_date' => now()->addDay()->toDateString(),
        'is_active' => true,
    ], $periodOverrides));

    $form = EvaluationForm::factory()->for($period)->create(array_merge([
        'title' => 'Evaluasi Layanan Akademik',
        'is_active' => true,
    ], $formOverrides));

    $category = QuestionCategory::factory()->create(['name' => 'Layanan Akademik']);

    Question::factory()->for($form)->for($category, 'category')->create([
        'question_text' => 'Layanan akademik jelas.',
        'sort_order' => 1,
        'is_required' => true,
    ]);

    Question::factory()->for($form)->for($category, 'category')->create([
        'question_text' => 'Petugas akademik membantu.',
        'sort_order' => 2,
        'is_required' => true,
    ]);

    return $form;
}

test('mahasiswa can submit an active evaluation once with optional suggestion', function () {
    $user = completeStudentUser();
    $form = evaluationFormFixture();
    $answers = $form->questions->pluck('id')->mapWithKeys(fn (int $id): array => [$id => 5])->all();

    $this->actingAs($user)->get(route('student.evaluations.fill', $form))
        ->assertSuccessful()
        ->assertSee('Evaluasi Layanan Akademik');

    $this->actingAs($user)->post(route('student.evaluations.submit', $form), [
        'answers' => $answers,
        'suggestion' => 'Layanan akademik sudah baik.',
    ])->assertRedirect();

    $response = Response::query()->where('evaluation_form_id', $form->id)->firstOrFail();

    expect($response->student->is($user->student))->toBeTrue()
        ->and($response->suggestion)->toBe('Layanan akademik sudah baik.')
        ->and(ResponseAnswer::query()->where('response_id', $response->id)->count())->toBe(2);
});

test('mahasiswa cannot submit the same evaluation form twice', function () {
    $user = completeStudentUser();
    $form = evaluationFormFixture();
    $response = Response::factory()->for($form, 'evaluationForm')->for($user->student)->create();

    $this->actingAs($user)->from(route('student.evaluations.fill', $form))->post(route('student.evaluations.submit', $form), [
        'answers' => $form->questions->pluck('id')->mapWithKeys(fn (int $id): array => [$id => 4])->all(),
    ])->assertRedirect(route('student.evaluations.fill', $form))
        ->assertSessionHasErrors('form');

    expect(Response::query()->where('evaluation_form_id', $form->id)->where('student_id', $user->student->id)->count())->toBe(1)
        ->and($response->exists)->toBeTrue();
});

test('inactive form inactive period and expired period cannot be submitted', function (EvaluationForm $form) {
    $user = completeStudentUser();

    $this->actingAs($user)->from(route('student.evaluations.index'))->get(route('student.evaluations.fill', $form))
        ->assertNotFound();

    $this->actingAs($user)->from(route('student.evaluations.index'))->post(route('student.evaluations.submit', $form), [
        'answers' => $form->questions->pluck('id')->mapWithKeys(fn (int $id): array => [$id => 4])->all(),
    ])->assertNotFound();
})->with([
    'inactive form' => fn () => evaluationFormFixture([], ['is_active' => false]),
    'inactive period' => fn () => evaluationFormFixture(['is_active' => false]),
    'expired period' => fn () => evaluationFormFixture([
        'start_date' => now()->subDays(10)->toDateString(),
        'end_date' => now()->subDay()->toDateString(),
    ]),
]);

test('required questions and invalid scores are rejected', function () {
    $user = completeStudentUser();
    $form = evaluationFormFixture();
    $questionIds = $form->questions->pluck('id')->values();

    $this->actingAs($user)->from(route('student.evaluations.fill', $form))->post(route('student.evaluations.submit', $form), [
        'answers' => [$questionIds[0] => 4],
    ])->assertRedirect(route('student.evaluations.fill', $form))
        ->assertSessionHasErrors('answers.'.$questionIds[1]);

    $this->actingAs($user)->from(route('student.evaluations.fill', $form))->post(route('student.evaluations.submit', $form), [
        'answers' => [$questionIds[0] => 0, $questionIds[1] => 6],
    ])->assertRedirect(route('student.evaluations.fill', $form))
        ->assertSessionHasErrors(['answers.'.$questionIds[0], 'answers.'.$questionIds[1]]);
});

test('admin cannot submit evaluation as mahasiswa', function () {
    $form = evaluationFormFixture();

    $this->actingAs(User::factory()->admin()->create())->post(route('student.evaluations.submit', $form), [
        'answers' => $form->questions->pluck('id')->mapWithKeys(fn (int $id): array => [$id => 5])->all(),
    ])->assertForbidden();
});
