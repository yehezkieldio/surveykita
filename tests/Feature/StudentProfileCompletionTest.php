<?php

use App\Models\Student;
use App\Models\User;
use App\Services\NimParser;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\put;

uses(RefreshDatabase::class);

it('treats guessed google class names as incomplete until confirmed', function () {
    $parsed = app(NimParser::class)->parse('2311032');

    $student = Student::factory()->create([
        'nim' => $parsed['nim'],
        'program_code' => $parsed['program_code'],
        'study_program' => $parsed['study_program'],
        'enrollment_year' => $parsed['enrollment_year'],
        'sequence_number' => $parsed['sequence_number'],
        'class_name' => 'IFB6A',
        'class_name_confirmed' => false,
    ]);

    expect($student->fresh()->isComplete())->toBeFalse();
    expect($student->user->fresh()->hasCompleteStudentProfile())->toBeFalse();
});

it('confirms class name when student completes profile', function () {
    $user = User::factory()->create([
        'role' => 'mahasiswa',
    ]);

    $student = Student::factory()->create([
        'user_id' => $user->id,
        'nim' => '2311032',
        'program_code' => '11',
        'study_program' => 'S1 Informatika',
        'enrollment_year' => 2023,
        'sequence_number' => '032',
        'class_name' => 'IFB6A',
        'class_name_confirmed' => false,
    ]);

    actingAs($user);

    put(route('student.profile.update'), [
        'nim' => '2311032',
        'name' => 'Mahasiswa Uji',
        'class_name' => 'A',
    ])->assertRedirect(route('student.dashboard'));

    expect($student->fresh()->class_name)->toBe('IFB6A');
    expect($student->fresh()->class_name_confirmed)->toBeTrue();
    expect($user->fresh()->hasCompleteStudentProfile())->toBeTrue();
});
