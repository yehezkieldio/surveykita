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

    // Add a response to make it non-empty
    $response = Response::factory()->for($this->form, 'evaluationForm')->for($this->student)->create();
    ResponseAnswer::factory()->for($response)->for($this->question)->create(['score' => 5]);
});

test('admin can request pdf export', function () {
    $this->actingAs($this->admin)
        ->get(route('admin.results.export.pdf', $this->form))
        ->assertSuccessful()
        ->assertHeader('Content-Type', 'application/pdf');
});

test('admin can request excel export', function () {
    $this->actingAs($this->admin)
        ->get(route('admin.results.export.excel', $this->form))
        ->assertSuccessful()
        ->assertHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
});

test('mahasiswa cannot access admin export routes', function () {
    $this->actingAs($this->studentUser);

    $this->get(route('admin.results.export.pdf', $this->form))->assertForbidden();
    $this->get(route('admin.results.export.excel', $this->form))->assertForbidden();
});

test('guest is redirected from admin export routes', function () {
    $this->get(route('admin.results.export.pdf', $this->form))->assertRedirect(route('login'));
    $this->get(route('admin.results.export.excel', $this->form))->assertRedirect(route('login'));
});

test('admin can request exports for form with no responses', function () {
    $emptyForm = EvaluationForm::factory()->for($this->period)->create(['is_active' => true]);

    $this->actingAs($this->admin);

    $this->get(route('admin.results.export.pdf', $emptyForm))->assertSuccessful();
    $this->get(route('admin.results.export.excel', $emptyForm))->assertSuccessful();
});
