<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Badge;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class BadgeUserFactory extends Factory
{
    protected $model = Badge::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'badge_id' => Badge::factory(),
        ];

        // return [
        //     'user_id' => $this->faker->numberBetween(1, User::count()),
        //     'badge_id' => $this->faker->numberBetween(1, Badge::count()),
        // ];
    }
}
