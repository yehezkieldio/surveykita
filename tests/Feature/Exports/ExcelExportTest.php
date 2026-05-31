<?php

use App\Exports\EvaluationReportExport;
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
use Maatwebsite\Excel\Excel as ExcelFormat;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

uses(RefreshDatabase::class);

function excelExportFixture(): EvaluationForm
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
    $student = Student::factory()->for(User::factory()->mahasiswa())->create([
        'nim' => '2311032',
        'name' => 'Siti Rahma',
    ]);
    $response = Response::factory()->for($form, 'evaluationForm')->for($student)->create([
        'suggestion' => 'Pertahankan layanan akademik.',
    ]);

    ResponseAnswer::factory()->for($response)->for($question)->create(['score' => 5]);

    return $form;
}

function loadExcelExport(EvaluationForm $form): Spreadsheet
{
    $result = app(EvaluationResultService::class)->forForm($form);
    $binary = Excel::raw(new EvaluationReportExport($form, $result), ExcelFormat::XLSX);
    $path = tempnam(sys_get_temp_dir(), 'surveykita-excel-');

    file_put_contents($path, $binary);
    $spreadsheet = IOFactory::load($path);
    unlink($path);

    return $spreadsheet;
}

test('admin can download evaluation result Excel report', function () {
    $form = excelExportFixture();
    Excel::fake();

    $this->actingAs(User::factory()->admin()->create())
        ->get(route('admin.results.export.excel', $form))
        ->assertSuccessful();

    Excel::assertDownloaded(
        'surveykita-evaluasi-akademik.xlsx',
        fn (EvaluationReportExport $export): bool => $export instanceof EvaluationReportExport,
    );
});

test('Excel export route is protected from guests and mahasiswa', function () {
    $form = excelExportFixture();

    $this->get(route('admin.results.export.excel', $form))
        ->assertRedirect(route('login'));

    $this->actingAs(User::factory()->mahasiswa()->create())
        ->get(route('admin.results.export.excel', $form))
        ->assertForbidden();
});

test('Excel workbook includes required report sheets and data', function () {
    $spreadsheet = loadExcelExport(excelExportFixture());

    expect($spreadsheet->getSheetNames())->toBe([
        'Ringkasan',
        'Rekap Kategori',
        'Rekap Pertanyaan',
        'Distribusi Likert',
        'Saran',
        'Respons Mentah',
    ]);

    $summary = $spreadsheet->getSheetByName('Ringkasan');
    $category = $spreadsheet->getSheetByName('Rekap Kategori');
    $question = $spreadsheet->getSheetByName('Rekap Pertanyaan');
    $distribution = $spreadsheet->getSheetByName('Distribusi Likert');
    $suggestions = $spreadsheet->getSheetByName('Saran');
    $raw = $spreadsheet->getSheetByName('Respons Mentah');

    expect($summary->getCell('B1')->getValue())->toBe('Evaluasi Akademik')
        ->and($summary->getCell('B2')->getValue())->toBe('Evaluasi Genap')
        ->and($summary->getCell('B5')->getValue())->toEqual(5)
        ->and($summary->getCell('B6')->getValue())->toEqual(100)
        ->and($summary->getCell('B7')->getValue())->toBe('Sangat Puas')
        ->and($category->getCell('A2')->getValue())->toBe('Layanan Akademik')
        ->and($question->getCell('A2')->getValue())->toBe('Layanan akademik responsif.')
        ->and($distribution->getCell('B6')->getValue())->toEqual(1)
        ->and($suggestions->getCell('B2')->getValue())->toBe('Pertahankan layanan akademik.')
        ->and($raw->getCell('B2')->getValue())->toBe('Siti Rahma')
        ->and($raw->getCell('C2')->getValue())->toEqual('2311032')
        ->and($raw->getCell('G2')->getValue())->toEqual(5);
});

test('Excel workbook remains zero safe without responses', function () {
    $period = EvaluationPeriod::factory()->create(['name' => 'Periode Kosong']);
    $form = EvaluationForm::factory()->for($period)->create(['title' => 'Evaluasi Kosong']);
    $category = QuestionCategory::factory()->create(['name' => 'Kepuasan Umum']);
    Question::factory()->for($form)->for($category, 'category')->create([
        'question_text' => 'Secara umum puas.',
    ]);

    $spreadsheet = loadExcelExport($form);

    expect($spreadsheet->getSheetByName('Ringkasan')->getCell('B3')->getValue())->toEqual(0)
        ->and($spreadsheet->getSheetByName('Ringkasan')->getCell('B6')->getValue())->toEqual(0)
        ->and($spreadsheet->getSheetByName('Rekap Pertanyaan')->getCell('A2')->getValue())->toBe('Secara umum puas.')
        ->and($spreadsheet->getSheetByName('Respons Mentah')->getCell('A2')->getValue())->toBeNull();
});
