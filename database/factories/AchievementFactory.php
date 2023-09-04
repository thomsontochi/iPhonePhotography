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
        // $achievements = [
        //     [
        //         'name' => 'First Lesson Watched',
        //         'description' => 'Watch your first lesson.',
        //     ],
        //     [
        //         'name' => '5 Lessons Watched',
        //         'description' => 'Watch 5 lessons.',
        //     ],
        //     [
        //         'name' => '10 Lessons Watched',
        //         'description' => 'Watch 10 lessons.',
        //     ],
        //     [
        //         'name' => '25 Lessons Watched',
        //         'description' => 'Watch 25 lessons.',
        //     ],
        //     [
        //         'name' => '50 Lessons Watched',
        //         'description' => 'Watch 50 lessons.',
        //     ],
        //     [
        //         'name' => 'First Comment Written',
        //         'description' => 'Write your first comment.',
        //     ],
        //     [
        //         'name' => '5 Comments Written',
        //         'description' => 'Write 5 comments.',
        //     ],
        //     [
        //         'name' => '10 Comments Written',
        //         'description' => 'Write 10 comments.',
        //     ],
        //     [
        //         'name' => '20 Comments Written',
        //         'description' => 'Write 20 comments.',
        //     ],
            
        // ];


        // return [
        //     'name' => $this->faker->name,
        //     'description' => $this->faker->sentence(),
        // ];
        // Choose a random achievement from the list
        // $achievement = $this->faker->randomElement($achievements);

        // return $achievement;

        // return [
        //     'name' => $this->faker->unique()->randomElement(['First Lesson Watched', '5 Lessons Watched', '10 Lessons Watched', '25 Lessons Watched', '50 Lessons Watched']),
    
        //     'description' => $this->faker->sentence(),
        // ];

        return [
            'name' => $this->faker->sentence(3), 
            'description' => $this->faker->paragraph,
        ];


    }
}
