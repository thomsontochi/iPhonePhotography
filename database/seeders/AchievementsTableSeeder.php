<?php

namespace Database\Seeders;

use App\Models\Achievement;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AchievementsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Achievement::factory()->count(5)->create(); // Create 5 dummy achievements
        Achievement::create([
            'name' => 'First Lesson Watched',
            'description' => 'Watch your first lesson.',
        ]);
        Achievement::create([
            'name' => '5 Lessons Watched',
            'description' => 'Watch 5 lessons.',
        ]);

        Achievement::create([
            'name' => '10 Lessons Watched',
            'description' => 'Watch 10 lessons.',
        ]);

        Achievement::create([
            'name' => '25 Lessons Watched',
            'description' => 'Watch 25 lessons.',
        ]);

        Achievement::create([
            'name' => '50 Lessons Watched',
            'description' => 'Watch 50 lessons.',
        ]);
    }
}
