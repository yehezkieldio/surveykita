<?php

namespace Database\Factories;

use App\Models\QuestionCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<QuestionCategory>
 */
class QuestionCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->randomElement([
                'Layanan Akademik',
                'Pembelajaran',
                'Fasilitas',
                'Administrasi',
                'Kepuasan Umum',
            ]),
            'description' => fake()->sentence(),
        ];
    }
}
