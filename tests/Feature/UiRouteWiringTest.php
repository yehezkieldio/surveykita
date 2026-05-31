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
use Illuminate\Support\Facades\Route;

uses(RefreshDatabase::class);

function uiRouteFixture(): array
{
    $period = EvaluationPeriod::factory()->create(['name' => 'Periode UI']);
    $category = QuestionCategory::factory()->create(['name' => 'Layanan Akademik']);
    $fillableForm = EvaluationForm::factory()->for($period)->create(['title' => 'Evaluasi UI Aktif']);
    $submittedForm = EvaluationForm::factory()->for($period)->create(['title' => 'Evaluasi UI Terkirim']);
    $fillableQuestion = Question::factory()->for($fillableForm)->for($category, 'category')->create([
        'question_text' => 'Informasi akademik mudah dipahami.',
    ]);
    $submittedQuestion = Question::factory()->for($submittedForm)->for($category, 'category')->create([
        'question_text' => 'Layanan akademik responsif.',
    ]);
    $admin = User::factory()->admin()->create();
    $studentUser = User::factory()->mahasiswa()->create();
    $student = Student::factory()->for($studentUser)->create([
        'nim' => '2311032',
        'name' => 'Siti Rahma',
    ]);
    $response = Response::factory()->for($submittedForm, 'evaluationForm')->for($student)->create();

    ResponseAnswer::factory()->for($response)->for($submittedQuestion)->create(['score' => 5]);
    ResponseAnswer::factory()->for(Response::factory()->for($fillableForm, 'evaluationForm')->for(Student::factory())->create())
        ->for($fillableQuestion)
        ->create(['score' => 4]);

    return [$admin, $studentUser, $student, $period, $category, $fillableForm, $submittedForm, $response];
}

test('required public auth admin and mahasiswa routes are registered', function () {
    $routeNames = [
        'login',
        'login.store',
        'logout',
        'auth.google.redirect',
        'auth.google.callback',
        'auth.google.rejected',
        'admin.dashboard',
        'admin.students.index',
        'admin.students.create',
        'admin.students.show',
        'admin.students.edit',
        'admin.periods.index',
        'admin.periods.create',
        'admin.periods.show',
        'admin.periods.edit',
        'admin.forms.index',
        'admin.forms.create',
        'admin.forms.show',
        'admin.forms.edit',
        'admin.categories.index',
        'admin.categories.create',
        'admin.categories.edit',
        'admin.questions.index',
        'admin.questions.create',
        'admin.questions.edit',
        'admin.results.index',
        'admin.results.show',
        'admin.results.export.pdf',
        'admin.results.export.excel',
        'student.dashboard',
        'student.profile.complete',
        'student.profile.update',
        'student.evaluations.index',
        'student.evaluations.show',
        'student.evaluations.fill',
        'student.evaluations.submit',
        'student.submissions.index',
        'student.submissions.success',
    ];

    foreach ($routeNames as $routeName) {
        expect(Route::has($routeName))->toBeTrue($routeName.' is missing');
    }
});

test('admin pages render real views with route-backed actions', function () {
    [$admin, , , $period, $category, $form] = uiRouteFixture();

    $urls = [
        route('admin.dashboard'),
        route('admin.students.index'),
        route('admin.students.create'),
        route('admin.students.show', $period->evaluationForms()->first()->responses()->first()->student),
        route('admin.students.edit', $period->evaluationForms()->first()->responses()->first()->student),
        route('admin.periods.index'),
        route('admin.periods.create'),
        route('admin.periods.show', $period),
        route('admin.periods.edit', $period),
        route('admin.forms.index'),
        route('admin.forms.create'),
        route('admin.forms.show', $form),
        route('admin.forms.edit', $form),
        route('admin.categories.index'),
        route('admin.categories.create'),
        route('admin.categories.edit', $category),
        route('admin.questions.index'),
        route('admin.questions.create'),
        route('admin.questions.edit', $form->questions()->first()),
        route('admin.results.index'),
        route('admin.results.show', $form),
    ];

    foreach ($urls as $url) {
        $this->actingAs($admin)
            ->get($url)
            ->assertSuccessful()
            ->assertDontSee('href="#"', false)
            ->assertDontSee('action="#"', false)
            ->assertDontSee('endpoint');
    }
});

test('mahasiswa pages render real views with route-backed actions', function () {
    [, $studentUser, , , , $fillableForm, , $response] = uiRouteFixture();

    $urls = [
        route('student.dashboard'),
        route('student.evaluations.index'),
        route('student.evaluations.show', $fillableForm),
        route('student.evaluations.fill', $fillableForm),
        route('student.submissions.index'),
        route('student.submissions.success', $response),
    ];

    foreach ($urls as $url) {
        $this->actingAs($studentUser)
            ->get($url)
            ->assertSuccessful()
            ->assertDontSee('href="#"', false)
            ->assertDontSee('action="#"', false)
            ->assertDontSee('endpoint');
    }
});

test('guest and incomplete profile pages render without dead actions', function () {
    $incompleteUser = User::factory()->mahasiswa()->create();

    $this->get(route('login'))
        ->assertSuccessful()
        ->assertDontSee('href="#"', false)
        ->assertDontSee('action="#"', false);

    $this->get(route('auth.google.rejected'))
        ->assertSuccessful()
        ->assertDontSee('href="#"', false)
        ->assertDontSee('action="#"', false);

    $this->actingAs($incompleteUser)
        ->get(route('student.profile.complete'))
        ->assertSuccessful()
        ->assertDontSee('href="#"', false)
        ->assertDontSee('action="#"', false);
});
