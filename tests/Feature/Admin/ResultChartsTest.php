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

function resultChartsFixture(): array
{
    $period = EvaluationPeriod::factory()->create(['name' => 'Periode Chart']);
    $academic = QuestionCategory::factory()->create(['name' => 'Layanan Akademik']);
    $facility = QuestionCategory::factory()->create(['name' => 'Fasilitas']);

    $academicForm = EvaluationForm::factory()->for($period)->create(['title' => 'Evaluasi Akademik']);
    $academicQuestion = Question::factory()->for($academicForm)->for($academic, 'category')->create([
        'question_text' => 'Layanan akademik jelas.',
    ]);
    $facilityQuestion = Question::factory()->for($academicForm)->for($facility, 'category')->create([
        'question_text' => 'Fasilitas kelas memadai.',
    ]);

    collect([
        [$academicQuestion->id => 5, $facilityQuestion->id => 4],
        [$academicQuestion->id => 3, $facilityQuestion->id => 4],
    ])->each(function (array $scores) use ($academicForm): void {
        $student = Student::factory()->for(User::factory()->mahasiswa())->create();
        $response = Response::factory()->for($academicForm, 'evaluationForm')->for($student)->create();

        foreach ($scores as $questionId => $score) {
            ResponseAnswer::factory()->for($response)->create([
                'question_id' => $questionId,
                'score' => $score,
            ]);
        }
    });

    $facilityForm = EvaluationForm::factory()->for($period)->create(['title' => 'Evaluasi Fasilitas']);
    $facilityOnlyQuestion = Question::factory()->for($facilityForm)->for($facility, 'category')->create([
        'question_text' => 'Area kampus nyaman.',
    ]);
    $student = Student::factory()->for(User::factory()->mahasiswa())->create();
    $response = Response::factory()->for($facilityForm, 'evaluationForm')->for($student)->create();
    ResponseAnswer::factory()->for($response)->for($facilityOnlyQuestion)->create(['score' => 2]);

    return [$academicForm, $facilityForm];
}

test('admin result index renders ApexCharts from form result data', function () {
    resultChartsFixture();

    $this->actingAs(User::factory()->admin()->create())
        ->get(route('admin.results.index'))
        ->assertSuccessful()
        ->assertSee('surveykita_overall_satisfaction')
        ->assertSee('surveykita_respondent_count')
        ->assertSee('Persentase Kepuasan per Form')
        ->assertSee('Jumlah Responden per Form')
        ->assertSee('Evaluasi Akademik')
        ->assertSee('Evaluasi Fasilitas')
        ->assertSee('data":[80,40]', false)
        ->assertSee('data":[2,1]', false);
});

test('admin result detail renders ApexCharts from category and Likert data', function () {
    [$form] = resultChartsFixture();

    $this->actingAs(User::factory()->admin()->create())
        ->get(route('admin.results.show', $form))
        ->assertSuccessful()
        ->assertSee('surveykita_category_average')
        ->assertSee('surveykita_likert_distribution')
        ->assertSee('Rata-rata Skor per Kategori')
        ->assertSee('Distribusi Skor Likert')
        ->assertSee('Layanan Akademik')
        ->assertSee('Fasilitas')
        ->assertSee('data":[4,4]', false)
        ->assertSee('data":[0,0,1,2,1]', false);
});
