<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

test('guest can view login page', function () {
    $this->get('/login')
        ->assertSuccessful()
        ->assertSee('Masuk')
        ->assertSee('SurveyKita');
});

test('valid admin can login and is redirected to admin dashboard', function () {
    $admin = User::factory()->admin()->create([
        'email' => 'admin@universitasmulia.ac.id',
        'password' => Hash::make('password-admin'),
    ]);

    $this->post('/login', [
        'email' => 'admin@universitasmulia.ac.id',
        'password' => 'password-admin',
    ])->assertRedirect('/admin/dashboard');

    $this->assertAuthenticatedAs($admin);
});

test('valid mahasiswa can login and is redirected to student dashboard', function () {
    $student = User::factory()->mahasiswa()->create([
        'email' => '2311032@students.universitasmulia.ac.id',
        'password' => Hash::make('password-student'),
    ]);

    $this->post('/login', [
        'email' => '2311032@students.universitasmulia.ac.id',
        'password' => 'password-student',
    ])->assertRedirect('/student/dashboard');

    $this->assertAuthenticatedAs($student);
});

test('invalid login returns validation feedback', function () {
    User::factory()->admin()->create([
        'email' => 'admin@universitasmulia.ac.id',
        'password' => Hash::make('correct-password'),
    ]);

    $this->from('/login')->post('/login', [
        'email' => 'admin@universitasmulia.ac.id',
        'password' => 'wrong-password',
    ])->assertRedirect('/login')
        ->assertSessionHasErrors('email');

    $this->assertGuest();
});

test('logout invalidates the authenticated session', function () {
    $user = User::factory()->admin()->create();

    $this->actingAs($user)
        ->post('/logout')
        ->assertRedirect('/login');

    $this->assertGuest();
});
