<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('guest is redirected from protected dashboards to login', function () {
    $this->get('/admin/dashboard')->assertRedirect('/login');
    $this->get('/student/dashboard')->assertRedirect('/login');
});

test('admin can access admin dashboard', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->get('/admin/dashboard')
        ->assertSuccessful()
        ->assertSee('Dashboard Admin');
});

test('mahasiswa cannot access admin dashboard', function () {
    $student = User::factory()->mahasiswa()->create();

    $this->actingAs($student)
        ->get('/admin/dashboard')
        ->assertForbidden();
});

test('mahasiswa can access student dashboard', function () {
    $student = User::factory()->mahasiswa()->create();

    $this->actingAs($student)
        ->get('/student/dashboard')
        ->assertSuccessful()
        ->assertSee('Dashboard Mahasiswa');
});

test('admin cannot submit an evaluation as mahasiswa', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->post('/student/evaluations/1/submit')
        ->assertForbidden();
});

test('mahasiswa cannot access result and export routes', function (string $uri) {
    $student = User::factory()->mahasiswa()->create();

    $this->actingAs($student)
        ->get($uri)
        ->assertForbidden();
})->with([
    '/admin/results',
    '/admin/results/1',
    '/admin/results/1/export/pdf',
    '/admin/results/1/export/excel',
]);
