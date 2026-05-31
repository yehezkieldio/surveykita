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

uses(RefreshDatabase::class);

function pdfExportFixture(): EvaluationForm
{
    $period = EvaluationPeriod::factory()->create([
        'name' => 'Evaluasi Genap',
        'semester' => 'Genap',
        'academic_year' => '2025/2026',
    ]);
    $form = EvaluationForm::factory()->for($period)->create(['title' => 'Evaluasi Akademik']);
    $category = QuestionCategory::factory()->create(['name' => 'Layanan Akademik']);
    $question = Question::factory()->for($form)->for($category, 'category')->create([
        'question_text' => 'Layanan akademik responsif.',
    ]);
    $student = Student::factory()->for(User::factory()->mahasiswa())->create(['name' => 'Siti Rahma']);
    $response = Response::factory()->for($form, 'evaluationForm')->for($student)->create([
        'suggestion' => 'Pertahankan layanan akademik.',
    ]);

    ResponseAnswer::factory()->for($response)->for($question)->create(['score' => 5]);

    return $form;
}

test('admin can download evaluation result PDF report', function () {
    $form = pdfExportFixture();

    $response = $this->actingAs(User::factory()->admin()->create())
        ->get(route('admin.results.export.pdf', $form));

    $response->assertSuccessful();
    expect($response->headers->get('content-type'))->toContain('application/pdf')
        ->and($response->headers->get('content-disposition'))->toContain('surveykita-evaluasi-akademik.pdf')
        ->and($response->getContent())->toStartWith('%PDF');
});

test('PDF export route is protected from guests and mahasiswa', function () {
    $form = pdfExportFixture();

    $this->get(route('admin.results.export.pdf', $form))
        ->assertRedirect(route('login'));

    $this->actingAs(User::factory()->mahasiswa()->create())
        ->get(route('admin.results.export.pdf', $form))
        ->assertForbidden();
});

test('PDF report template includes required academic result sections', function () {
    $form = pdfExportFixture();
    $result = app(EvaluationResultService::class)->forForm($form);

    $html = view('pdf.evaluation-report', [
        'form' => $form,
        'result' => $result,
    ])->render();

    expect($html)
        ->toContain('Evaluasi Akademik')
        ->toContain('Evaluasi Genap')
        ->toContain('Total Responden')
        ->toContain('1')
        ->toContain('Rata-rata Skor')
        ->toContain('5')
        ->toContain('Persentase Kepuasan')
        ->toContain('100%')
        ->toContain('Sangat Puas')
        ->toContain('Layanan Akademik')
        ->toContain('Layanan akademik responsif.')
        ->toContain('Pertahankan layanan akademik.');
});

test('admin can export PDF for form with no responses', function () {
    $period = EvaluationPeriod::factory()->create(['name' => 'Periode Kosong']);
    $form = EvaluationForm::factory()->for($period)->create(['title' => 'Evaluasi Kosong']);
    $category = QuestionCategory::factory()->create(['name' => 'Kepuasan Umum']);
    Question::factory()->for($form)->for($category, 'category')->create([
        'question_text' => 'Secara umum puas.',
    ]);

    $response = $this->actingAs(User::factory()->admin()->create())
        ->get(route('admin.results.export.pdf', $form));

    $response->assertSuccessful();
    expect($response->headers->get('content-type'))->toContain('application/pdf');
});
