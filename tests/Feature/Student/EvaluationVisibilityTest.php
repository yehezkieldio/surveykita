<?php

use App\Models\EvaluationForm;
use App\Models\EvaluationPeriod;
use App\Models\Response;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->mahasiswa()->create();
    $this->student = Student::factory()->for($this->user)->create();

    $this->activePeriod = EvaluationPeriod::factory()->create([
        'start_date' => now()->subDay()->toDateString(),
        'end_date' => now()->addDay()->toDateString(),
        'is_active' => true,
    ]);
});

test('inactive form cannot be opened by mahasiswa', function () {
    $form = EvaluationForm::factory()->for($this->activePeriod)->create(['is_active' => false]);

    $this->actingAs($this->user)->get(route('student.evaluations.show', $form))->assertNotFound();
    $this->actingAs($this->user)->get(route('student.evaluations.fill', $form))->assertNotFound();
});

test('form in inactive period cannot be opened by mahasiswa', function () {
    $inactivePeriod = EvaluationPeriod::factory()->create(['is_active' => false]);
    $form = EvaluationForm::factory()->for($inactivePeriod)->create(['is_active' => true]);

    $this->actingAs($this->user)->get(route('student.evaluations.show', $form))->assertNotFound();
    $this->actingAs($this->user)->get(route('student.evaluations.fill', $form))->assertNotFound();
});

test('form outside date range cannot be opened by mahasiswa', function () {
    $expiredPeriod = EvaluationPeriod::factory()->create([
        'start_date' => now()->subDays(10)->toDateString(),
        'end_date' => now()->subDay()->toDateString(),
        'is_active' => true,
    ]);
    $form = EvaluationForm::factory()->for($expiredPeriod)->create(['is_active' => true]);

    $this->actingAs($this->user)->get(route('student.evaluations.show', $form))->assertNotFound();
    $this->actingAs($this->user)->get(route('student.evaluations.fill', $form))->assertNotFound();
});

test('active open form can be opened by mahasiswa', function () {
    $form = EvaluationForm::factory()->for($this->activePeriod)->create(['is_active' => true]);

    $this->actingAs($this->user)->get(route('student.evaluations.show', $form))->assertSuccessful();
    $this->actingAs($this->user)->get(route('student.evaluations.fill', $form))->assertSuccessful();
});

test('canBeFilledBy behavior verification', function () {
    $form = EvaluationForm::factory()->for($this->activePeriod)->create(['is_active' => true]);

    // Case 1: Active and open
    expect($form->canBeFilledBy($this->student))->toBeTrue();

    // Case 2: Inactive form
    $form->update(['is_active' => false]);
    expect($form->canBeFilledBy($this->student))->toBeFalse();

    // Case 3: Closed period
    $form->update(['is_active' => true]);
    $this->activePeriod->update(['is_active' => false]);
    expect($form->canBeFilledBy($this->student))->toBeFalse();

    // Case 4: Already submitted
    $this->activePeriod->update(['is_active' => true]);
    Response::factory()->for($form, 'evaluationForm')->for($this->student)->create();
    expect($form->canBeFilledBy($this->student))->toBeFalse();
});
