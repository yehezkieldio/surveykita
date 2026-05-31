<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\Student\SubmitEvaluationRequest;
use App\Models\EvaluationForm;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class EvaluationController extends Controller
{
    public function index(): View
    {
        $student = auth()->user()?->student;

        return view('student.evaluations.index', [
            'forms' => EvaluationForm::query()
                ->with('evaluationPeriod')
                ->withExists(['responses as submitted' => fn (Builder $query) => $query->where('student_id', $student?->id)])
                ->where('is_active', true)
                ->whereHas('evaluationPeriod', fn ($query) => $query->active()
                    ->whereDate('start_date', '<=', now())
                    ->whereDate('end_date', '>=', now()))
                ->latest()
                ->get(),
        ]);
    }

    public function show(string $form): View
    {
        $form = EvaluationForm::query()->findOrFail($form);

        return view('student.evaluations.show', [
            'form' => $form->load(['evaluationPeriod', 'questions.category']),
        ]);
    }

    public function fill(string $form): View|RedirectResponse
    {
        $form = EvaluationForm::query()
            ->with(['evaluationPeriod', 'questions.category'])
            ->findOrFail($form);

        if (! $form->isFillable(auth()->user()->student)) {
            return redirect()->route('student.evaluations.index')
                ->with('error', 'Form evaluasi tidak dapat diisi.');
        }

        return view('student.evaluations.fill', ['form' => $form]);
    }

    public function submit(SubmitEvaluationRequest $request, string $form): RedirectResponse
    {
        $evaluationForm = $request->evaluationForm();
        $student = $request->user()->student;

        try {
            $response = DB::transaction(function () use ($request, $evaluationForm, $student) {
                $response = $evaluationForm->responses()->create([
                    'student_id' => $student->id,
                    'submitted_at' => now(),
                    'suggestion' => $request->validated('suggestion'),
                ]);

                $questions = $evaluationForm->questions()->get();
                $answers = collect($request->validated('answers'));

                $questions->each(function ($question) use ($answers, $response): void {
                    if (! $answers->has((string) $question->id) && ! $answers->has($question->id)) {
                        return;
                    }

                    $response->answers()->create([
                        'question_id' => $question->id,
                        'score' => (int) ($answers->get((string) $question->id) ?? $answers->get($question->id)),
                    ]);
                });

                return $response;
            });
        } catch (QueryException) {
            return redirect()->route('student.evaluations.fill', $evaluationForm)
                ->withErrors(['form' => 'Anda sudah mengisi form evaluasi ini.']);
        }

        return redirect()->route('student.submissions.success', $response)
            ->with('success', 'Evaluasi berhasil dikirim.');
    }
}
