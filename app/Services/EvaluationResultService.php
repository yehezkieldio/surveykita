<?php

namespace App\Services;

use App\Models\EvaluationForm;
use App\Models\Question;
use App\Models\QuestionCategory;
use App\Models\Response;
use App\Models\ResponseAnswer;
use Illuminate\Support\Collection;

class EvaluationResultService
{
    /**
     * @return array{
     *     form: EvaluationForm,
     *     category_filter: ?array{id: int, name: string},
     *     total_respondents: int,
     *     total_answers: int,
     *     average_score: float,
     *     satisfaction_percentage: float,
     *     satisfaction_category: string,
     *     average_score_per_category: list<array<string, mixed>>,
     *     average_score_per_question: list<array<string, mixed>>,
     *     likert_distribution: array<int, int>,
     *     suggestions: list<array<string, mixed>>,
     *     is_empty: bool
     * }
     */
    public function forForm(EvaluationForm $form, ?QuestionCategory $category = null): array
    {
        $questions = $form->questions()
            ->with('category')
            ->when($category, fn ($query): mixed => $query->whereBelongsTo($category))
            ->get();

        $responses = $form->responses()
            ->with('student')
            ->orderByDesc('submitted_at')
            ->get();

        $answers = ResponseAnswer::query()
            ->with(['question.category'])
            ->whereIn('response_id', $responses->pluck('id'))
            ->whereIn('question_id', $questions->pluck('id'))
            ->get();

        $totalAnswers = $answers->count();
        $averageScore = $this->averageScore($answers);
        $satisfactionPercentage = $this->satisfactionPercentage($averageScore);
        $isEmpty = $responses->isEmpty() || $totalAnswers === 0;

        return [
            'form' => $form,
            'category_filter' => $category ? [
                'id' => $category->id,
                'name' => $category->name,
            ] : null,
            'total_respondents' => $responses->count(),
            'total_answers' => $totalAnswers,
            'average_score' => $averageScore,
            'satisfaction_percentage' => $satisfactionPercentage,
            'satisfaction_category' => $isEmpty ? 'Belum Ada Respon' : $this->satisfactionCategory($satisfactionPercentage),
            'average_score_per_category' => $this->averageScorePerCategory($questions, $answers),
            'average_score_per_question' => $this->averageScorePerQuestion($questions, $answers),
            'likert_distribution' => $this->likertDistribution($answers),
            'suggestions' => $this->suggestions($responses),
            'is_empty' => $isEmpty,
        ];
    }

    public function satisfactionCategory(float $percentage): string
    {
        return match (true) {
            $percentage <= 20.0 => 'Sangat Tidak Puas',
            $percentage <= 40.0 => 'Tidak Puas',
            $percentage <= 60.0 => 'Cukup Puas',
            $percentage <= 80.0 => 'Puas',
            default => 'Sangat Puas',
        };
    }

    /**
     * @param  Collection<int, ResponseAnswer>  $answers
     */
    private function averageScore(Collection $answers): float
    {
        if ($answers->isEmpty()) {
            return 0.0;
        }

        return round($answers->avg('score'), 2);
    }

    private function satisfactionPercentage(float $averageScore): float
    {
        if ($averageScore <= 0.0) {
            return 0.0;
        }

        return round(($averageScore / 5) * 100, 2);
    }

    /**
     * @param  Collection<int, Question>  $questions
     * @param  Collection<int, ResponseAnswer>  $answers
     * @return list<array<string, mixed>>
     */
    private function averageScorePerCategory(Collection $questions, Collection $answers): array
    {
        return $questions
            ->pluck('category')
            ->filter()
            ->unique('id')
            ->values()
            ->map(function (QuestionCategory $category) use ($answers): array {
                $categoryAnswers = $answers->filter(
                    fn (ResponseAnswer $answer): bool => $answer->question->question_category_id === $category->id,
                );
                $averageScore = $this->averageScore($categoryAnswers);
                $percentage = $this->satisfactionPercentage($averageScore);

                return [
                    'category_id' => $category->id,
                    'category' => $category->name,
                    'total_answers' => $categoryAnswers->count(),
                    'average_score' => $averageScore,
                    'satisfaction_percentage' => $percentage,
                    'satisfaction_category' => $categoryAnswers->isEmpty()
                        ? 'Belum Ada Respon'
                        : $this->satisfactionCategory($percentage),
                ];
            })
            ->all();
    }

    /**
     * @param  Collection<int, Question>  $questions
     * @param  Collection<int, ResponseAnswer>  $answers
     * @return list<array<string, mixed>>
     */
    private function averageScorePerQuestion(Collection $questions, Collection $answers): array
    {
        return $questions
            ->values()
            ->map(function (Question $question) use ($answers): array {
                $questionAnswers = $answers->where('question_id', $question->id);
                $averageScore = $this->averageScore($questionAnswers);
                $percentage = $this->satisfactionPercentage($averageScore);

                return [
                    'question_id' => $question->id,
                    'question_text' => $question->question_text,
                    'category_id' => $question->category?->id,
                    'category' => $question->category?->name,
                    'total_answers' => $questionAnswers->count(),
                    'average_score' => $averageScore,
                    'satisfaction_percentage' => $percentage,
                    'satisfaction_category' => $questionAnswers->isEmpty()
                        ? 'Belum Ada Respon'
                        : $this->satisfactionCategory($percentage),
                ];
            })
            ->all();
    }

    /**
     * @param  Collection<int, ResponseAnswer>  $answers
     * @return array<int, int>
     */
    private function likertDistribution(Collection $answers): array
    {
        return collect(range(1, 5))
            ->mapWithKeys(fn (int $score): array => [
                $score => $answers->where('score', $score)->count(),
            ])
            ->all();
    }

    /**
     * @param  Collection<int, Response>  $responses
     * @return list<array<string, mixed>>
     */
    private function suggestions(Collection $responses): array
    {
        return $responses
            ->filter(fn ($response): bool => filled($response->suggestion))
            ->map(fn ($response): array => [
                'response_id' => $response->id,
                'student_id' => $response->student_id,
                'student_name' => $response->student?->name,
                'submitted_at' => $response->submitted_at,
                'suggestion' => $response->suggestion,
            ])
            ->values()
            ->all();
    }
}
