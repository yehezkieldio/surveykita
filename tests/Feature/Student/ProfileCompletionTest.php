<?php

use App\Models\EvaluationForm;
use App\Models\EvaluationPeriod;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;

uses(RefreshDatabase::class);

function incompleteMahasiswa(): User
{
    return User::factory()->mahasiswa()->create([
        'email' => '2311032@students.universitasmulia.ac.id',
        'password' => null,
    ]);
}

test('incomplete mahasiswa can access dashboard and profile completion page', function () {
    $user = incompleteMahasiswa();

    $this->actingAs($user)->get(route('student.dashboard'))->assertSuccessful();
    $this->actingAs($user)->get(route('student.profile.complete'))->assertSuccessful()
        ->assertSee('Lengkapi Profil');
});

test('incomplete mahasiswa is redirected before accessing evaluation fill page', function () {
    $user = incompleteMahasiswa();
    $form = EvaluationForm::factory()->for(EvaluationPeriod::factory())->create();

    $this->actingAs($user)->get(route('student.evaluations.show', $form))
        ->assertRedirect(route('student.profile.complete'));

    $this->actingAs($user)->post(route('student.evaluations.submit', $form), [])
        ->assertRedirect(route('student.profile.complete'));
});

test('profile completion validates required fields and NIM program code', function () {
    $user = incompleteMahasiswa();

    $this->actingAs($user)->from(route('student.profile.complete'))->put(route('student.profile.update'), [
        'nim' => '',
        'name' => '',
        'class_name' => '',
    ])->assertRedirect(route('student.profile.complete'))
        ->assertSessionHasErrors(['nim', 'name', 'class_name']);

    $this->actingAs($user)->from(route('student.profile.complete'))->put(route('student.profile.update'), [
        'nim' => '2399001',
        'name' => 'Mahasiswa Salah',
        'class_name' => 'XX-23A',
    ])->assertRedirect(route('student.profile.complete'))
        ->assertSessionHasErrors('nim');
});

test('google-created mahasiswa without student profile can complete profile', function () {
    Carbon::setTestNow('2026-06-01');

    $user = User::factory()->mahasiswa()->create([
        'name' => 'Google Student',
        'email' => '2311032@students.universitasmulia.ac.id',
        'google_id' => 'google-2311032',
        'password' => null,
    ]);

    $this->actingAs($user)->put(route('student.profile.update'), [
        'nim' => '2311032',
        'name' => 'Google Student',
        'class_name' => 'IFB-23-A',
    ])->assertRedirect(route('student.dashboard'));

    $student = $user->refresh()->student;

    expect($student)->toBeInstanceOf(Student::class)
        ->and($student->nim)->toBe('2311032')
        ->and($student->program_code)->toBe('11')
        ->and($student->study_program)->toBe('S1 Informatika')
        ->and($student->enrollment_year)->toBe(2023)
        ->and($student->sequence_number)->toBe('032')
        ->and($student->class_name)->toBe('IFB6A')
        ->and($user->hasCompleteStudentProfile())->toBeTrue();

    Carbon::setTestNow();
});

test('completed profile can access evaluation fill page', function () {
    $user = User::factory()->mahasiswa()->create([
        'email' => '2312045@students.universitasmulia.ac.id',
    ]);

    Student::factory()->for($user)->create([
        'nim' => '2312045',
        'name' => 'Mahasiswa Lengkap',
        'program_code' => '12',
        'study_program' => 'S1 Teknologi Informasi',
        'enrollment_year' => 2023,
        'sequence_number' => '045',
        'class_name' => 'TI-23A',
    ]);

    $form = EvaluationForm::factory()->for(EvaluationPeriod::factory())->create([
        'title' => 'Evaluasi Pembelajaran',
    ]);

    $this->actingAs($user)->get(route('student.evaluations.show', $form))
        ->assertSuccessful()
        ->assertSee('Evaluasi Pembelajaran');
});
