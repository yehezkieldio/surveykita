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

beforeEach(function () {
    $this->period = EvaluationPeriod::factory()->create(['is_active' => true]);
    $this->category = QuestionCategory::factory()->create();
    $this->form = EvaluationForm::factory()->for($this->period)->create(['is_active' => true]);
    $this->question = Question::factory()->for($this->form)->for($this->category, 'category')->create();

    $this->admin = User::factory()->admin()->create();
    $this->studentUser = User::factory()->mahasiswa()->create();
    $this->student = Student::factory()->for($this->studentUser)->create();
});

test('guest is redirected from admin routes', function () {
    $this->get(route('admin.dashboard'))->assertRedirect(route('login'));
    $this->get(route('admin.students.index'))->assertRedirect(route('login'));
});

test('mahasiswa is forbidden from admin routes', function () {
    $this->actingAs($this->studentUser)
        ->get(route('admin.dashboard'))
        ->assertForbidden();
});

test('admin can open dashboard and CRUD index pages', function () {
    $this->actingAs($this->admin);

    $routes = [
        'admin.dashboard',
        'admin.students.index',
        'admin.periods.index',
        'admin.forms.index',
        'admin.categories.index',
        'admin.questions.index',
        'admin.results.index',
    ];

    foreach ($routes as $route) {
        $this->get(route($route))->assertSuccessful();
    }
});

test('admin can open CRUD create pages', function () {
    $this->actingAs($this->admin);

    $routes = [
        'admin.students.create',
        'admin.periods.create',
        'admin.forms.create',
        'admin.categories.create',
        'admin.questions.create',
    ];

    foreach ($routes as $route) {
        $this->get(route($route))->assertSuccessful();
    }
});

test('admin can open result detail and exports', function () {
    // Add a response to make it non-empty
    $response = Response::factory()->for($this->form, 'evaluationForm')->for($this->student)->create();
    ResponseAnswer::factory()->for($response)->for($this->question)->create(['score' => 4]);

    $this->actingAs($this->admin);

    $this->get(route('admin.results.show', $this->form))->assertSuccessful();
    $this->get(route('admin.results.export.pdf', $this->form))->assertSuccessful();
    $this->get(route('admin.results.export.excel', $this->form))->assertSuccessful();
});

test('admin can open exports for form with no responses', function () {
    $emptyForm = EvaluationForm::factory()->for($this->period)->create();

    $this->actingAs($this->admin);

    $this->get(route('admin.results.export.pdf', $emptyForm))->assertSuccessful();
    $this->get(route('admin.results.export.excel', $emptyForm))->assertSuccessful();
});

test('mahasiswa can open student portal pages', function () {
    $this->actingAs($this->studentUser);

    $this->get(route('student.dashboard'))->assertSuccessful();
    $this->get(route('student.evaluations.index'))->assertSuccessful();
    $this->get(route('student.submissions.index'))->assertSuccessful();
});
