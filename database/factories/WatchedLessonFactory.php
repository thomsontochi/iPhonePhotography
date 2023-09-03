<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Lesson;
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
       
       // Get random user and lesson IDs from your database
       $userIds = User::pluck('id')->toArray();
       $lessonIds = Lesson::pluck('id')->toArray();

       return [
           'user_id' => $this->faker->randomElement($userIds),
           'lesson_id' => $this->faker->randomElement($lessonIds),
       ];
    }
}
