<?php

namespace Database\Factories;

use App\Models\EvaluationForm;
use App\Models\Question;
use App\Models\QuestionCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Question>
 */
class QuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'evaluation_form_id' => EvaluationForm::factory(),
            'question_category_id' => QuestionCategory::factory(),
            'question_text' => fake()->sentence(),
            'sort_order' => fake()->numberBetween(1, 20),
            'is_required' => true,
        ];
    }

    public function optional(): static
    {
        return $this->state(fn (array $attributes): array => [
            'is_required' => false,
        ]);
    }
}
