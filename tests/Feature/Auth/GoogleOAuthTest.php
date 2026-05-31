<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as SocialiteUser;

uses(RefreshDatabase::class);

function fakeGoogleUser(array $attributes): void
{
    Socialite::fake('google', (new SocialiteUser)->map($attributes));
}

test('guest is redirected to Google provider', function () {
    Socialite::fake('google');

    $this->get('/auth/google/redirect')
        ->assertRedirect();
});

test('allowed student email creates mahasiswa user and redirects to profile completion', function () {
    fakeGoogleUser([
        'id' => 'google-2311032',
        'name' => '2311032 MAHASISWA MULIA',
        'email' => '2311032@students.universitasmulia.ac.id',
    ]);

    $this->get('/auth/google/callback')
        ->assertRedirect('/student/profile/complete');

    $user = User::query()->where('email', '2311032@students.universitasmulia.ac.id')->firstOrFail();

    expect($user->role)->toBe('mahasiswa')
        ->and($user->name)->toBe('Mahasiswa Mulia')
        ->and($user->google_id)->toBe('google-2311032')
        ->and($user->password)->toBeNull();

    $this->assertAuthenticatedAs($user);
});

test('google callback normalizes allowed email to lowercase', function () {
    fakeGoogleUser([
        'id' => 'google-uppercase',
        'name' => 'Mahasiswa Upper',
        'email' => '2311033@STUDENTS.UNIVERSITASMULIA.AC.ID',
    ]);

    $this->get('/auth/google/callback')
        ->assertRedirect('/student/profile/complete');

    $this->assertDatabaseHas('users', [
        'email' => '2311033@students.universitasmulia.ac.id',
        'role' => 'mahasiswa',
        'google_id' => 'google-uppercase',
    ]);
});

test('non student Google email is rejected', function () {
    fakeGoogleUser([
        'id' => 'google-public',
        'name' => 'Public User',
        'email' => 'public@gmail.com',
    ]);

    $this->get('/auth/google/callback')
        ->assertRedirect('/auth/google/rejected');

    $this->assertGuest();
    $this->assertDatabaseMissing('users', ['email' => 'public@gmail.com']);
});

test('existing mahasiswa email is linked to Google account', function () {
    $student = User::factory()->mahasiswa()->create([
        'email' => '2311034@students.universitasmulia.ac.id',
        'google_id' => null,
    ]);

    fakeGoogleUser([
        'id' => 'google-existing',
        'name' => 'Existing Student',
        'email' => '2311034@students.universitasmulia.ac.id',
    ]);

    $this->get('/auth/google/callback')
        ->assertRedirect('/student/profile/complete');

    expect($student->refresh()->google_id)->toBe('google-existing')
        ->and($student->role)->toBe('mahasiswa');

    $this->assertAuthenticatedAs($student);
});

test('existing admin email is never linked or authenticated through Google', function () {
    $admin = User::factory()->admin()->create([
        'email' => '2399999@students.universitasmulia.ac.id',
        'google_id' => null,
    ]);

    fakeGoogleUser([
        'id' => 'google-admin-attempt',
        'name' => 'Admin Attempt',
        'email' => '2399999@students.universitasmulia.ac.id',
    ]);

    $this->get('/auth/google/callback')
        ->assertRedirect('/auth/google/rejected');

    expect($admin->refresh()->google_id)->toBeNull()
        ->and($admin->role)->toBe('admin');

    $this->assertGuest();
});
