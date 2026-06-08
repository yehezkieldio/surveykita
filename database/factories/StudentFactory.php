<?php

namespace Database\Factories;

use App\Models\Student;
use App\Models\User;
use App\Services\NimParser;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $programCode = fake()->randomElement(array_keys(NimParser::PROGRAMS));
        $sequence = str_pad((string) fake()->unique()->numberBetween(1, 999), 3, '0', STR_PAD_LEFT);
        $nim = '23'.$programCode.$sequence;
        $parsed = (new NimParser)->parse($nim);

        return [
            'user_id' => User::factory()->mahasiswa(),
            'nim' => $nim,
            'name' => fake()->name(),
            'program_code' => $parsed['program_code'],
            'study_program' => $parsed['study_program'],
            'enrollment_year' => $parsed['enrollment_year'],
            'sequence_number' => $parsed['sequence_number'],
            'class_name' => fake()->randomElement(['A', 'B', 'C']).'-'.$parsed['enrollment_year'],
            'class_name_confirmed' => true,
        ];
    }
}
