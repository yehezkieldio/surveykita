<?php

namespace Database\Factories;

use App\Models\EvaluationForm;
use App\Models\EvaluationPeriod;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<EvaluationForm>
 */
class EvaluationFormFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'evaluation_period_id' => EvaluationPeriod::factory(),
            'title' => fake()->randomElement([
                'Evaluasi Layanan Akademik',
                'Evaluasi Pembelajaran',
                'Evaluasi Fasilitas',
                'Evaluasi Administrasi',
            ]),
            'description' => fake()->sentence(),
            'target_type' => fake()->randomElement([
                'layanan_akademik',
                'pembelajaran',
                'fasilitas',
                'administrasi',
                'kepuasan_umum',
            ]),
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
