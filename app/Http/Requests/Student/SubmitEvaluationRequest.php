<?php

namespace App\Http\Requests\Student;

use App\Models\EvaluationForm;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class SubmitEvaluationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isMahasiswa() ?? false;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'answers' => ['required', 'array'],
            'answers.*' => ['required', 'integer', 'between:1,5'],
            'suggestion' => ['nullable', 'string', 'max:2000'],
        ];
    }

    /**
     * @return array<int, callable(Validator): void>
     */
    public function after(): array
    {
        return [
            function (Validator $validator): void {
                $form = $this->evaluationForm();
                $student = $this->user()?->student;

                if (! $form || ! $student) {
                    $validator->errors()->add('form', 'Form evaluasi tidak ditemukan.');

                    return;
                }

                if (! $form->is_active) {
                    $validator->errors()->add('form', 'Form evaluasi sedang tidak aktif.');
                }

                if (! $form->evaluationPeriod?->isCurrentlyOpen()) {
                    $validator->errors()->add('form', 'Periode evaluasi tidak aktif atau sudah di luar jadwal.');
                }

                if ($form->responses()->whereBelongsTo($student)->exists()) {
                    $validator->errors()->add('form', 'Anda sudah mengisi form evaluasi ini.');
                }

                $answers = collect($this->input('answers', []));

                $form->questions()
                    ->where('is_required', true)
                    ->pluck('id')
                    ->each(function (int $questionId) use ($answers, $validator): void {
                        if (! $answers->has((string) $questionId) && ! $answers->has($questionId)) {
                            $validator->errors()->add('answers.'.$questionId, 'Pertanyaan wajib harus dijawab.');
                        }
                    });
            },
        ];
    }

    public function evaluationForm(): ?EvaluationForm
    {
        return EvaluationForm::query()
            ->with(['evaluationPeriod', 'questions'])
            ->find($this->route('form'));
    }
}
