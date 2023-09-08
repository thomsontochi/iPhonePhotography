<?php

namespace Database\Factories;

use App\Models\Achievement;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Achievement>
 */
class AchievementFactory extends Factory
{
    protected $model = Achievement::class;
    
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $achievementOrder = [
            'First Lesson Watched',
            '5 Lessons Watched',
            '10 Lessons Watched',
            '25 Lessons Watched',
            '50 Lessons Watched',
        ];
        
        $index = $this->faker->unique()->numberBetween(0, count($achievementOrder) - 1);

        return [
            'name' => $achievementOrder[$index],
            'description' => $this->faker->paragraph,
        ];


        // $achievements = [
        //     'First Lesson Watched',
        //     '5 Lessons Watched',
        //     '10 Lessons Watched',
        //     '25 Lessons Watched',
        //     '50 Lessons Watched',
        // ];
    
        // return [
        //     'name' => $achievements[$this->faker->numberBetween(0, 4)],
        //     'description' => $this->faker->paragraph,
        // ];


    }
}
