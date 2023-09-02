<?php

namespace Database\Factories;

use App\Models\WatchedLesson;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WatchedLesson>
 */
class WatchedLessonFactory extends Factory
{
    protected $model = WatchedLesson::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
       
        return [
            'user_id' => 1,
            'lesson_id' => 1, 
            
        ];
    }
}
