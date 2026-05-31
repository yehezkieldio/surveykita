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

class QuestionController extends Controller
{
    public function index(): View
    {
        return view('admin.questions.index', [
            'questions' => Question::query()
                ->with(['evaluationForm', 'category'])
                ->orderByDesc('id')
                ->paginate(10),
        ]);
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
        if ($question->responseAnswers()->exists()) {
            return redirect()->route('admin.questions.index')
                ->with('error', 'Pertanyaan tidak dapat dihapus karena sudah memiliki jawaban evaluasi.');
        }

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
