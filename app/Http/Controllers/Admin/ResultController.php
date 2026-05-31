<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EvaluationForm;
use App\Models\EvaluationPeriod;
use App\Models\QuestionCategory;
use App\Services\EvaluationResultService;
use App\Services\ResultChartService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function index(Request $request, EvaluationResultService $results, ResultChartService $charts): View
    {
        $periodId = $request->integer('period_id') ?: null;
        $formId = $request->integer('form_id') ?: null;
        $categoryId = $request->integer('category_id') ?: null;
        $category = $categoryId ? QuestionCategory::query()->find($categoryId) : null;

        $forms = EvaluationForm::query()
            ->with('evaluationPeriod')
            ->withCount(['questions', 'responses'])
            ->when($periodId, fn ($query) => $query->where('evaluation_period_id', $periodId))
            ->when($formId, fn ($query) => $query->whereKey($formId))
            ->latest()
            ->get();

        $rows = $forms->map(fn (EvaluationForm $form): array => [
            'form' => $form,
            'result' => $results->forForm($form, $category),
        ]);

        return view('admin.results.index', [
            'periods' => EvaluationPeriod::query()->latest()->get(),
            'allForms' => EvaluationForm::query()->latest()->get(),
            'categories' => QuestionCategory::query()->orderBy('name')->get(),
            'selectedPeriodId' => $periodId,
            'selectedFormId' => $formId,
            'selectedCategoryId' => $categoryId,
            'rows' => $rows,
            'charts' => $charts->indexCharts($rows),
        ]);
    }

    public function show(Request $request, string $form, EvaluationResultService $results, ResultChartService $charts): View
    {
        $form = EvaluationForm::query()
            ->with('evaluationPeriod')
            ->findOrFail($form);
        $category = $request->integer('category_id')
            ? QuestionCategory::query()->find($request->integer('category_id'))
            : null;

        $result = $results->forForm($form, $category);

        return view('admin.results.show', [
            'form' => $form,
            'categories' => QuestionCategory::query()->orderBy('name')->get(),
            'selectedCategoryId' => $category?->id,
            'result' => $result,
            'charts' => $charts->detailCharts($result),
        ]);
    }
}
