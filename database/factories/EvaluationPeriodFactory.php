<?php

namespace Database\Factories;

use App\Models\EvaluationPeriod;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<EvaluationPeriod>
 */
class EvaluationPeriodFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => 'Evaluasi '.fake()->randomElement(['Ganjil', 'Genap']).' '.fake()->year(),
            'semester' => fake()->randomElement(['Ganjil', 'Genap']),
            'academic_year' => fake()->randomElement(['2025/2026', '2026/2027']),
            'start_date' => now()->subDays(7)->toDateString(),
            'end_date' => now()->addDays(14)->toDateString(),
            'is_active' => true,
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes): array => [
            'is_active' => false,
        ]);
    }
}
