<?php

namespace App\Http\Controllers\Admin;

use App\Exports\AdminTableExport;
use App\Http\Controllers\Controller;
use App\Models\EvaluationForm;
use App\Models\EvaluationPeriod;
use App\Models\Question;
use App\Models\QuestionCategory;
use App\Models\Student;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\Response;

class TableExportController extends Controller
{
    public function studentsExcel(): Response
    {
        $export = $this->studentsPayload();

        return Excel::download(
            new AdminTableExport($export['headings'], $export['rows']),
            'mahasiswa.xlsx'
        );
    }

    public function studentsPdf(): Response
    {
        return $this->downloadPdf($this->studentsPayload(), 'mahasiswa.pdf');
    }

    public function periodsExcel(): Response
    {
        $export = $this->periodsPayload();

        return Excel::download(
            new AdminTableExport($export['headings'], $export['rows']),
            'periode-evaluasi.xlsx'
        );
    }

    public function periodsPdf(): Response
    {
        return $this->downloadPdf($this->periodsPayload(), 'periode-evaluasi.pdf');
    }

    public function formsExcel(Request $request): Response
    {
        $export = $this->formsPayload($request);

        return Excel::download(
            new AdminTableExport($export['headings'], $export['rows']),
            'instrumen-evaluasi.xlsx'
        );
    }

    public function formsPdf(Request $request): Response
    {
        return $this->downloadPdf($this->formsPayload($request), 'instrumen-evaluasi.pdf');
    }

    public function categoriesExcel(): Response
    {
        $export = $this->categoriesPayload();

        return Excel::download(
            new AdminTableExport($export['headings'], $export['rows']),
            'kategori-pertanyaan.xlsx'
        );
    }

    public function categoriesPdf(): Response
    {
        return $this->downloadPdf($this->categoriesPayload(), 'kategori-pertanyaan.pdf');
    }

    public function questionsExcel(Request $request): Response
    {
        $export = $this->questionsPayload($request);

        return Excel::download(
            new AdminTableExport($export['headings'], $export['rows']),
            'butir-pertanyaan.xlsx'
        );
    }

    public function questionsPdf(Request $request): Response
    {
        return $this->downloadPdf($this->questionsPayload($request), 'butir-pertanyaan.pdf');
    }

    /**
     * @return array{title: string, subtitle: string, headings: array<int, string>, rows: array<int, array<int, scalar|null>>}
     */
    private function studentsPayload(): array
    {
        $students = Student::query()
            ->with('user')
            ->orderBy('name')
            ->get();

        return [
            'title' => 'Daftar Mahasiswa',
            'subtitle' => 'Seluruh data mahasiswa yang terdaftar pada panel admin.',
            'headings' => ['Mahasiswa', 'Email', 'NIM', 'Kelas', 'Prodi'],
            'rows' => $students->map(fn (Student $student): array => [
                $student->name,
                $student->user?->email,
                $student->nim,
                $student->class_name,
                $student->study_program,
            ])->all(),
        ];
    }

    /**
     * @return array{title: string, subtitle: string, headings: array<int, string>, rows: array<int, array<int, scalar|null>>}
     */
    private function periodsPayload(): array
    {
        $periods = EvaluationPeriod::query()
            ->withCount('evaluationForms')
            ->orderByDesc('start_date')
            ->get();

        return [
            'title' => 'Periode Evaluasi',
            'subtitle' => 'Ringkasan semua periode evaluasi beserta jadwal dan jumlah form.',
            'headings' => ['Nama Periode', 'Semester', 'Tahun Akademik', 'Mulai', 'Selesai', 'Status', 'Jumlah Form'],
            'rows' => $periods->map(fn (EvaluationPeriod $period): array => [
                $period->name,
                $period->semester,
                $period->academic_year,
                $period->start_date->translatedFormat('d M Y'),
                $period->end_date->translatedFormat('d M Y'),
                $period->is_active ? 'Aktif' : 'Nonaktif',
                $period->evaluation_forms_count,
            ])->all(),
        ];
    }

    /**
     * @return array{title: string, subtitle: string, headings: array<int, string>, rows: array<int, array<int, scalar|null>>}
     */
    private function formsPayload(Request $request): array
    {
        $period = $request->filled('period_id')
            ? EvaluationPeriod::query()->find($request->integer('period_id'))
            : null;

        $forms = $this->formsQuery($request)
            ->orderByDesc('evaluation_period_id')
            ->orderBy('title')
            ->get();

        $subtitle = $period
            ? 'Data instrumen untuk periode '.$period->name.'.'
            : 'Seluruh instrumen evaluasi dari semua periode.';

        return [
            'title' => 'Instrumen Evaluasi',
            'subtitle' => $subtitle,
            'headings' => ['Judul Instrumen', 'Periode', 'Target', 'Soal', 'Respons', 'Status'],
            'rows' => $forms->map(fn (EvaluationForm $form): array => [
                $form->title,
                $form->evaluationPeriod->name,
                $this->humanizeTargetType($form->target_type),
                $form->questions_count,
                $form->responses_count,
                $form->is_active ? 'Aktif' : 'Draf',
            ])->all(),
        ];
    }

    /**
     * @return array{title: string, subtitle: string, headings: array<int, string>, rows: array<int, array<int, scalar|null>>}
     */
    private function categoriesPayload(): array
    {
        $categories = QuestionCategory::query()
            ->withCount('questions')
            ->orderBy('name')
            ->get();

        return [
            'title' => 'Kategori Pertanyaan',
            'subtitle' => 'Taksonomi kategori pertanyaan yang digunakan pada instrumen evaluasi.',
            'headings' => ['Nama Kategori', 'Slug', 'Deskripsi', 'Jumlah Pertanyaan'],
            'rows' => $categories->map(fn (QuestionCategory $category): array => [
                $category->name,
                Str::slug($category->name, '_'),
                $category->description,
                $category->questions_count,
            ])->all(),
        ];
    }

    /**
     * @return array{title: string, subtitle: string, headings: array<int, string>, rows: array<int, array<int, scalar|null>>}
     */
    private function questionsPayload(Request $request): array
    {
        $form = $request->filled('evaluation_form_id')
            ? EvaluationForm::query()->with('evaluationPeriod')->find($request->integer('evaluation_form_id'))
            : null;

        $questions = $this->questionsQuery($request)
            ->orderBy('evaluation_form_id')
            ->orderBy('sort_order')
            ->get();

        $subtitle = $form
            ? 'Butir pertanyaan untuk instrumen '.$form->title.' pada periode '.$form->evaluationPeriod->name.'.'
            : 'Seluruh butir pertanyaan dari semua instrumen evaluasi.';

        return [
            'title' => 'Butir Pertanyaan',
            'subtitle' => $subtitle,
            'headings' => ['Pertanyaan', 'Instrumen', 'Kategori', 'Urutan', 'Wajib'],
            'rows' => $questions->map(fn (Question $question): array => [
                $question->question_text,
                $question->evaluationForm->title,
                $question->category->name,
                $question->sort_order,
                $question->is_required ? 'Ya' : 'Tidak',
            ])->all(),
        ];
    }

    private function formsQuery(Request $request): Builder
    {
        return EvaluationForm::query()
            ->with('evaluationPeriod')
            ->withCount(['questions', 'responses'])
            ->when(
                $request->filled('period_id'),
                fn (Builder $query): Builder => $query->where('evaluation_period_id', $request->integer('period_id'))
            );
    }

    private function questionsQuery(Request $request): Builder
    {
        return Question::query()
            ->with(['evaluationForm.evaluationPeriod', 'category'])
            ->when(
                $request->filled('evaluation_form_id'),
                fn (Builder $query): Builder => $query->where('evaluation_form_id', $request->integer('evaluation_form_id'))
            );
    }

    /**
     * @param  array{title: string, subtitle: string, headings: array<int, string>, rows: array<int, array<int, scalar|null>>}  $export
     */
    private function downloadPdf(array $export, string $filename): Response
    {
        return Pdf::loadView('pdf.admin-table', [
            'title' => $export['title'],
            'subtitle' => $export['subtitle'],
            'headings' => $export['headings'],
            'rows' => $export['rows'],
            'generatedAt' => now(),
        ])->setPaper('a4', 'landscape')->download($filename);
    }

    private function humanizeTargetType(string $targetType): string
    {
        return str($targetType)
            ->replace('_', ' ')
            ->title()
            ->toString();
    }
}
