<?php

use App\Models\EvaluationForm;
use App\Models\EvaluationPeriod;
use App\Models\Question;
use App\Models\QuestionCategory;
use App\Models\Response;
use App\Models\ResponseAnswer;
use App\Models\Student;
use App\Models\User;
use App\Services\EvaluationResultService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

function createEvaluationResultFixture(): EvaluationForm
{
    $period = EvaluationPeriod::factory()->create();
    $form = EvaluationForm::factory()->for($period)->create([
        'title' => 'Evaluasi Layanan Akademik',
        'target_type' => 'layanan_akademik',
        'is_active' => true,
    ]);

    $academic = QuestionCategory::factory()->create([
        'name' => 'Layanan Akademik',
        'description' => 'Kualitas layanan akademik.',
    ]);

    $facilities = QuestionCategory::factory()->create([
        'name' => 'Fasilitas',
        'description' => 'Kualitas fasilitas akademik.',
    ]);

    $questionOne = Question::factory()->for($form)->for($academic, 'category')->create([
        'question_text' => 'Informasi akademik jelas.',
        'sort_order' => 1,
    ]);
    $questionTwo = Question::factory()->for($form)->for($academic, 'category')->create([
        'question_text' => 'Dosen wali mudah dihubungi.',
        'sort_order' => 2,
    ]);
    $questionThree = Question::factory()->for($form)->for($facilities, 'category')->create([
        'question_text' => 'Ruang kelas nyaman.',
        'sort_order' => 3,
    ]);

    $studentOne = Student::factory()->for(User::factory()->mahasiswa())->create();
    $studentTwo = Student::factory()->for(User::factory()->mahasiswa())->create();

    $responseOne = Response::factory()->for($form, 'evaluationForm')->for($studentOne)->create([
        'suggestion' => 'Jadwal konsultasi akademik perlu dibuat lebih rutin.',
    ]);

    $responseTwo = Response::factory()->for($form, 'evaluationForm')->for($studentTwo)->create([
        'suggestion' => null,
    ]);

    collect([
        [$responseOne, $questionOne, 5],
        [$responseOne, $questionTwo, 4],
        [$responseOne, $questionThree, 3],
        [$responseTwo, $questionOne, 3],
        [$responseTwo, $questionTwo, 2],
        [$responseTwo, $questionThree, 1],
    ])->each(function (array $answer): void {
        [$response, $question, $score] = $answer;

        ResponseAnswer::factory()->for($response)->for($question)->create([
            'score' => $score,
        ]);
    });

    return $form;
}

test('it calculates Likert summaries for an evaluation form', function () {
    $result = app(EvaluationResultService::class)->forForm(createEvaluationResultFixture());

    expect($result['total_respondents'])->toBe(2)
        ->and($result['total_answers'])->toBe(6)
        ->and($result['average_score'])->toBe(3.0)
        ->and($result['satisfaction_percentage'])->toBe(60.0)
        ->and($result['satisfaction_category'])->toBe('Cukup Puas')
        ->and($result['is_empty'])->toBeFalse()
        ->and($result['likert_distribution'])->toBe([
            1 => 1,
            2 => 1,
            3 => 2,
            4 => 1,
            5 => 1,
        ]);
});

test('it calculates per-category and per-question averages', function () {
    $result = app(EvaluationResultService::class)->forForm(createEvaluationResultFixture());

    $categoryRows = collect($result['average_score_per_category'])
        ->map(fn (array $row): array => collect($row)->only([
            'category',
            'total_answers',
            'average_score',
            'satisfaction_percentage',
            'satisfaction_category',
        ])->all())
        ->all();

    $questionRows = collect($result['average_score_per_question'])
        ->map(fn (array $row): array => collect($row)->only([
            'question_text',
            'category',
            'total_answers',
            'average_score',
            'satisfaction_percentage',
            'satisfaction_category',
        ])->all())
        ->all();

    expect($categoryRows)->toMatchArray([
        [
            'category' => 'Layanan Akademik',
            'total_answers' => 4,
            'average_score' => 3.5,
            'satisfaction_percentage' => 70.0,
            'satisfaction_category' => 'Puas',
        ],
        [
            'category' => 'Fasilitas',
            'total_answers' => 2,
            'average_score' => 2.0,
            'satisfaction_percentage' => 40.0,
            'satisfaction_category' => 'Tidak Puas',
        ],
    ]);

    expect($questionRows)->toMatchArray([
        [
            'question_text' => 'Informasi akademik jelas.',
            'category' => 'Layanan Akademik',
            'total_answers' => 2,
            'average_score' => 4.0,
            'satisfaction_percentage' => 80.0,
            'satisfaction_category' => 'Puas',
        ],
        [
            'question_text' => 'Dosen wali mudah dihubungi.',
            'category' => 'Layanan Akademik',
            'total_answers' => 2,
            'average_score' => 3.0,
            'satisfaction_percentage' => 60.0,
            'satisfaction_category' => 'Cukup Puas',
        ],
        [
            'question_text' => 'Ruang kelas nyaman.',
            'category' => 'Fasilitas',
            'total_answers' => 2,
            'average_score' => 2.0,
            'satisfaction_percentage' => 40.0,
            'satisfaction_category' => 'Tidak Puas',
        ],
    ]);
});

test('it returns submitted suggestions with student context', function () {
    $result = app(EvaluationResultService::class)->forForm(createEvaluationResultFixture());

    expect($result['suggestions'])->toHaveCount(1)
        ->and($result['suggestions'][0]['student_name'])->not->toBeEmpty()
        ->and($result['suggestions'][0]['suggestion'])->toBe('Jadwal konsultasi akademik perlu dibuat lebih rutin.')
        ->and($result['suggestions'][0]['submitted_at'])->not->toBeNull();
});

test('it maps satisfaction categories at configured percentage boundaries', function (float $percentage, string $category) {
    expect(app(EvaluationResultService::class)->satisfactionCategory($percentage))->toBe($category);
})->with([
    'zero' => [0.0, 'Sangat Tidak Puas'],
    'twenty' => [20.0, 'Sangat Tidak Puas'],
    'twenty one' => [21.0, 'Tidak Puas'],
    'forty' => [40.0, 'Tidak Puas'],
    'forty one' => [41.0, 'Cukup Puas'],
    'sixty' => [60.0, 'Cukup Puas'],
    'sixty one' => [61.0, 'Puas'],
    'eighty' => [80.0, 'Puas'],
    'eighty one' => [81.0, 'Sangat Puas'],
    'one hundred' => [100.0, 'Sangat Puas'],
]);

test('it returns zero-safe empty state when a form has no responses', function () {
    $period = EvaluationPeriod::factory()->create();
    $form = EvaluationForm::factory()->for($period)->create();
    $category = QuestionCategory::factory()->create(['name' => 'Kepuasan Umum']);

    Question::factory()->for($form)->for($category, 'category')->create([
        'question_text' => 'Secara umum layanan akademik memuaskan.',
        'sort_order' => 1,
    ]);

    $result = app(EvaluationResultService::class)->forForm($form);

    expect($result['total_respondents'])->toBe(0)
        ->and($result['total_answers'])->toBe(0)
        ->and($result['average_score'])->toBe(0.0)
        ->and($result['satisfaction_percentage'])->toBe(0.0)
        ->and($result['satisfaction_category'])->toBe('Belum Ada Respon')
        ->and($result['is_empty'])->toBeTrue()
        ->and($result['likert_distribution'])->toBe([1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0])
        ->and($result['average_score_per_category'][0]['average_score'])->toBe(0.0)
        ->and($result['average_score_per_question'][0]['average_score'])->toBe(0.0)
        ->and($result['suggestions'])->toBe([]);
});
