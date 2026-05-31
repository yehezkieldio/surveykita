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
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

function adminActor(): User
{
    return User::factory()->admin()->create();
}

function mahasiswaActor(): User
{
    return User::factory()->mahasiswa()->create();
}

test('mahasiswa cannot access admin CRUD modules', function (string $uri) {
    $this->actingAs(mahasiswaActor())
        ->get($uri)
        ->assertForbidden();
})->with([
    'students' => ['/admin/students'],
    'periods' => ['/admin/periods'],
    'forms' => ['/admin/forms'],
    'categories' => ['/admin/categories'],
    'questions' => ['/admin/questions'],
]);

test('admin can create update view and delete a mahasiswa profile', function () {
    $admin = adminActor();

    $this->actingAs($admin)->get(route('admin.students.index'))->assertSuccessful();
    $this->actingAs($admin)->get(route('admin.students.create'))->assertSuccessful();

    $this->actingAs($admin)->post(route('admin.students.store'), [
        'name' => 'Mahasiswa Baru',
        'email' => '2311032@students.universitasmulia.ac.id',
        'nim' => '2311032',
        'class_name' => 'IF-23A',
        'password' => 'password',
    ])->assertRedirect();

    $student = Student::query()->where('nim', '2311032')->firstOrFail();

    expect($student->study_program)->toBe('S1 Informatika')
        ->and($student->user->role)->toBe('mahasiswa')
        ->and(Hash::check('password', $student->user->password))->toBeTrue();

    $this->actingAs($admin)->get(route('admin.students.show', $student))->assertSuccessful();
    $this->actingAs($admin)->get(route('admin.students.edit', $student))->assertSuccessful();

    $this->actingAs($admin)->put(route('admin.students.update', $student), [
        'name' => 'Mahasiswa Diperbarui',
        'email' => '2312045@students.universitasmulia.ac.id',
        'nim' => '2312045',
        'class_name' => 'TI-23A',
        'password' => '',
    ])->assertRedirect(route('admin.students.show', $student));

    expect($student->refresh()->study_program)->toBe('S1 Teknologi Informasi')
        ->and($student->name)->toBe('Mahasiswa Diperbarui')
        ->and($student->user->email)->toBe('2312045@students.universitasmulia.ac.id');

    $userId = $student->user_id;

    $this->actingAs($admin)->delete(route('admin.students.destroy', $student))
        ->assertRedirect(route('admin.students.index'));

    $this->assertModelMissing($student);
    $this->assertDatabaseMissing('users', ['id' => $userId]);
});

test('student validation rejects unknown NIM program codes', function () {
    $this->actingAs(adminActor())->from(route('admin.students.create'))->post(route('admin.students.store'), [
        'name' => 'Mahasiswa Salah',
        'email' => '2399001@students.universitasmulia.ac.id',
        'nim' => '2399001',
        'class_name' => 'XX-23A',
        'password' => 'password',
    ])->assertRedirect(route('admin.students.create'))
        ->assertSessionHasErrors('nim');
});

test('admin can manage evaluation periods with safe delete handling', function () {
    $admin = adminActor();

    $this->actingAs($admin)->get(route('admin.periods.index'))->assertSuccessful();
    $this->actingAs($admin)->get(route('admin.periods.create'))->assertSuccessful();

    $this->actingAs($admin)->post(route('admin.periods.store'), [
        'name' => 'Evaluasi Semester Genap',
        'semester' => 'Genap',
        'academic_year' => '2025/2026',
        'start_date' => now()->subDay()->toDateString(),
        'end_date' => now()->addWeek()->toDateString(),
        'is_active' => '1',
    ])->assertRedirect();

    $period = EvaluationPeriod::query()->where('name', 'Evaluasi Semester Genap')->firstOrFail();

    $this->actingAs($admin)->get(route('admin.periods.show', $period))->assertSuccessful();
    $this->actingAs($admin)->get(route('admin.periods.edit', $period))->assertSuccessful();

    $this->actingAs($admin)->put(route('admin.periods.update', $period), [
        'name' => 'Evaluasi Semester Genap 2025/2026',
        'semester' => 'Genap',
        'academic_year' => '2025/2026',
        'start_date' => now()->subDay()->toDateString(),
        'end_date' => now()->addWeek()->toDateString(),
        'is_active' => '0',
    ])->assertRedirect(route('admin.periods.show', $period));

    expect($period->refresh()->is_active)->toBeFalse();

    EvaluationForm::factory()->for($period)->create();

    $this->actingAs($admin)->delete(route('admin.periods.destroy', $period))
        ->assertRedirect(route('admin.periods.index'))
        ->assertSessionHas('error');

    $this->assertModelExists($period);

    $emptyPeriod = EvaluationPeriod::factory()->create(['name' => 'Periode Kosong']);

    $this->actingAs($admin)->delete(route('admin.periods.destroy', $emptyPeriod))
        ->assertRedirect(route('admin.periods.index'));

    $this->assertModelMissing($emptyPeriod);
});

test('admin can manage evaluation forms categories and questions', function () {
    $admin = adminActor();
    $period = EvaluationPeriod::factory()->create(['name' => 'Periode Aktif']);

    $this->actingAs($admin)->get(route('admin.categories.index'))->assertSuccessful();
    $this->actingAs($admin)->get(route('admin.categories.create'))->assertSuccessful();

    $this->actingAs($admin)->post(route('admin.categories.store'), [
        'name' => 'Layanan Akademik',
        'description' => 'Kategori layanan akademik.',
    ])->assertRedirect();

    $category = QuestionCategory::query()->where('name', 'Layanan Akademik')->firstOrFail();

    $this->actingAs($admin)->get(route('admin.categories.edit', $category))->assertSuccessful();
    $this->actingAs($admin)->put(route('admin.categories.update', $category), [
        'name' => 'Layanan Akademik dan Administrasi',
        'description' => 'Kategori layanan akademik dan administrasi.',
    ])->assertRedirect(route('admin.categories.index'));

    $this->actingAs($admin)->get(route('admin.forms.index'))->assertSuccessful();
    $this->actingAs($admin)->get(route('admin.forms.create'))->assertSuccessful();

    $this->actingAs($admin)->post(route('admin.forms.store'), [
        'evaluation_period_id' => $period->id,
        'title' => 'Evaluasi Layanan Akademik',
        'description' => 'Form evaluasi layanan akademik.',
        'target_type' => 'layanan_akademik',
        'is_active' => '1',
    ])->assertRedirect();

    $form = EvaluationForm::query()->where('title', 'Evaluasi Layanan Akademik')->firstOrFail();

    $this->actingAs($admin)->get(route('admin.forms.show', $form))->assertSuccessful();
    $this->actingAs($admin)->get(route('admin.forms.edit', $form))->assertSuccessful();

    $this->actingAs($admin)->put(route('admin.forms.update', $form), [
        'evaluation_period_id' => $period->id,
        'title' => 'Evaluasi Layanan Akademik Terbaru',
        'description' => 'Form evaluasi layanan akademik terbaru.',
        'target_type' => 'administrasi',
        'is_active' => '0',
    ])->assertRedirect(route('admin.forms.show', $form));

    expect($form->refresh()->is_active)->toBeFalse()
        ->and($form->target_type)->toBe('administrasi');

    $this->actingAs($admin)->get(route('admin.questions.index'))->assertSuccessful();
    $this->actingAs($admin)->get(route('admin.questions.create'))->assertSuccessful();

    $this->actingAs($admin)->post(route('admin.questions.store'), [
        'evaluation_form_id' => $form->id,
        'question_category_id' => $category->id,
        'question_text' => 'Petugas akademik memberikan layanan dengan ramah.',
        'sort_order' => 1,
        'is_required' => '1',
    ])->assertRedirect();

    $question = Question::query()->where('question_text', 'Petugas akademik memberikan layanan dengan ramah.')->firstOrFail();

    $this->actingAs($admin)->get(route('admin.questions.edit', $question))->assertSuccessful();
    $this->actingAs($admin)->put(route('admin.questions.update', $question), [
        'evaluation_form_id' => $form->id,
        'question_category_id' => $category->id,
        'question_text' => 'Petugas akademik memberikan layanan dengan cepat.',
        'sort_order' => 2,
        'is_required' => '0',
    ])->assertRedirect(route('admin.questions.index'));

    expect($question->refresh()->is_required)->toBeFalse()
        ->and($question->sort_order)->toBe(2);

    $this->actingAs($admin)->delete(route('admin.categories.destroy', $category))
        ->assertRedirect(route('admin.categories.index'))
        ->assertSessionHas('error');

    $this->actingAs($admin)->delete(route('admin.forms.destroy', $form))
        ->assertRedirect(route('admin.forms.index'))
        ->assertSessionHas('error');

    $response = Response::factory()->for($form, 'evaluationForm')->create();
    ResponseAnswer::factory()->for($response)->for($question)->create();

    $this->actingAs($admin)->delete(route('admin.questions.destroy', $question))
        ->assertRedirect(route('admin.questions.index'))
        ->assertSessionHas('error');
});

test('question validation requires valid form category and Likert metadata', function () {
    $this->actingAs(adminActor())->from(route('admin.questions.create'))->post(route('admin.questions.store'), [
        'evaluation_form_id' => 999,
        'question_category_id' => 999,
        'question_text' => '',
        'sort_order' => -1,
    ])->assertRedirect(route('admin.questions.create'))
        ->assertSessionHasErrors(['evaluation_form_id', 'question_category_id', 'question_text', 'sort_order']);
});
