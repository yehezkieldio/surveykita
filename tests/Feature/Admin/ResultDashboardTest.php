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

function resultDashboardFixture(): array
{
    $period = EvaluationPeriod::factory()->create(['name' => 'Periode Hasil']);
    $form = EvaluationForm::factory()->for($period)->create(['title' => 'Evaluasi Hasil Akademik']);
    $category = QuestionCategory::factory()->create(['name' => 'Layanan Akademik']);
    $question = Question::factory()->for($form)->for($category, 'category')->create([
        'question_text' => 'Layanan akademik mudah diakses.',
        'sort_order' => 1,
    ]);

    collect([5, 3])->each(function (int $score, int $index) use ($form, $question): void {
        $user = User::factory()->mahasiswa()->create();
        $student = Student::factory()->for($user)->create();
        $response = Response::factory()->for($form, 'evaluationForm')->for($student)->create([
            'suggestion' => $index === 0 ? 'Pertahankan layanan akademik.' : null,
        ]);

        ResponseAnswer::factory()->for($response)->for($question)->create(['score' => $score]);
    });

    return [$period, $form, $category, $question];
}

test('admin can view result index with filters', function () {
    [$period, $form, $category] = resultDashboardFixture();

    $this->actingAs(User::factory()->admin()->create())
        ->get(route('admin.results.index', [
            'period_id' => $period->id,
            'form_id' => $form->id,
            'category_id' => $category->id,
        ]))
        ->assertSuccessful()
        ->assertSee('Evaluasi Hasil Akademik')
        ->assertSee('2')
        ->assertSee('80%')
        ->assertSee('Puas');
});

test('admin can view result detail summaries recaps and suggestions', function () {
    [, $form] = resultDashboardFixture();

    $this->actingAs(User::factory()->admin()->create())
        ->get(route('admin.results.show', $form))
        ->assertSuccessful()
        ->assertSee('Total Responden')
        ->assertSee('2')
        ->assertSee('Rata-rata Skor')
        ->assertSee('4')
        ->assertSee('80%')
        ->assertSee('Puas')
        ->assertSee('Layanan Akademik')
        ->assertSee('Layanan akademik mudah diakses.')
        ->assertSee('Pertahankan layanan akademik.');
});

test('result detail supports category filter and empty states', function () {
    $period = EvaluationPeriod::factory()->create();
    $form = EvaluationForm::factory()->for($period)->create(['title' => 'Evaluasi Kosong']);
    $category = QuestionCategory::factory()->create(['name' => 'Kepuasan Umum']);
    Question::factory()->for($form)->for($category, 'category')->create([
        'question_text' => 'Secara umum puas.',
    ]);

    $this->actingAs(User::factory()->admin()->create())
        ->get(route('admin.results.show', [$form, 'category_id' => $category->id]))
        ->assertSuccessful()
        ->assertSee('Belum Ada Respon')
        ->assertSee('0%')
        ->assertSee('Secara umum puas.');
});

test('mahasiswa cannot access result dashboard', function () {
    $this->actingAs(User::factory()->mahasiswa()->create())
        ->get(route('admin.results.index'))
        ->assertForbidden();
});
