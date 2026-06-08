<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreQuestionRequest;
use App\Http\Requests\Admin\UpdateQuestionRequest;
use App\Models\EvaluationForm;
use App\Models\Question;
use App\Models\QuestionCategory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\Facades\DataTables;

class QuestionController extends Controller
{
    public function index(): View
    {
        return view('admin.questions.index');
    }

    public function data(): JsonResponse
    {
        $query = Question::query()
            ->with(['evaluationForm', 'category']);

        if (request()->filled('evaluation_form_id')) {
            $query->where('evaluation_form_id', request('evaluation_form_id'));
        }

        return DataTables::eloquent($query)
            ->addColumn('text', fn (Question $question): string => $question->question_text)
            ->addColumn('form_title', fn (Question $question): string => $question->evaluationForm->title)
            ->addColumn('category_name', fn (Question $question): string => $question->category->name)
            ->addColumn('actions', fn (Question $question): string =>
                view('admin.questions.partials.actions', ['question' => $question])->render()
            )
            ->rawColumns(['actions'])
            ->toJson()
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }


    public function create(): View
    {
        return view('admin.questions.create', $this->formOptions());
    }

    public function store(StoreQuestionRequest $request): RedirectResponse
    {
        Question::query()->create($request->validated());

        return redirect()->route('admin.questions.index')
            ->with('success', 'Pertanyaan evaluasi berhasil dibuat.');
    }

    public function show(Question $question): View
    {
        return view('admin.questions.show', [
            'question' => $question->load([
                'evaluationForm.evaluationPeriod',
                'category',
            ])->loadCount('responseAnswers'),
        ]);
    }

    public function edit(Question $question): View
    {
        return view('admin.questions.edit', [
            'question' => $question,
            ...$this->formOptions(),
        ]);
    }

    public function update(UpdateQuestionRequest $request, Question $question): RedirectResponse
    {
        $question->update($request->validated());

        return redirect()->route('admin.questions.index')
            ->with('success', 'Pertanyaan evaluasi berhasil diperbarui.');
    }

    public function destroy(Question $question): RedirectResponse
    {
        $question->delete();

        return redirect()->route('admin.questions.index')
            ->with('success', 'Pertanyaan evaluasi berhasil dihapus.');
    }

    /**
     * @return array{forms: Collection<int, EvaluationForm>, categories: Collection<int, QuestionCategory>}
     */
    private function formOptions(): array
    {
        return [
            'forms' => EvaluationForm::query()->latest()->get(),
            'categories' => QuestionCategory::query()->orderBy('name')->get(),
        ];
    }
}
