<?php

namespace Database\Factories;

use App\Models\LessonUser;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class LessonUserFactory extends Factory
{
    protected $model = LessonUser::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => rand(1, 100), // Adjust the range as needed
            'lesson_id' => rand(1, 50), // Adjust the range as needed
            'watched' => $this->faker->boolean(),
        ];
    }
}
