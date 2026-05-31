<?php

namespace Database\Factories;

use App\Models\EvaluationForm;
use App\Models\Response;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Response>
 */
class ResponseFactory extends Factory
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
            'student_id' => Student::factory(),
            'submitted_at' => now(),
            'suggestion' => fake()->optional()->sentence(),
        ];
    }
}
