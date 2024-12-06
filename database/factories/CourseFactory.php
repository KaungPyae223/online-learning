<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'course_name' => $this->faker->sentence(3),
            'course_info' => $this->faker->paragraph(3),
            'price' => $this->faker->randomNumber(3),
            'course_description' => $this->faker->paragraph(5),
            'can_learn' => json_encode([
                $this->faker->sentence,
                $this->faker->sentence,
                $this->faker->sentence,
            ]),
            'skill_gain' => json_encode([
                $this->faker->sentence,
                $this->faker->sentence,
                $this->faker->sentence,
            ]),
            'category_id' => $this->faker->numberBetween(1, 5),
            'level_id' => $this->faker->numberBetween(1, 3),
            'language_id' => $this->faker->numberBetween(1, 3),
            'instructor_id' => $this->faker->numberBetween(1, 5),
            'course_image' => $this->faker->imageUrl(),
        ];
    }
}
