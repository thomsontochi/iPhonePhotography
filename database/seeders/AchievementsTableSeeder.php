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
        // Achievement::create([
        //     'name' => 'First Lesson Watched',
        //     'description' => 'Watch your first lesson.',
        // ]);
        // Achievement::create([
        //     'name' => '5 Lessons Watched',
        //     'description' => 'Watch 5 lessons.',
        // ]);

        // Achievement::create([
        //     'name' => '10 Lessons Watched',
        //     'description' => 'Watch 10 lessons.',
        // ]);

        // Achievement::create([
        //     'name' => '25 Lessons Watched',
        //     'description' => 'Watch 25 lessons.',
        // ]);

        // Achievement::create([
        //     'name' => '50 Lessons Watched',
        //     'description' => 'Watch 50 lessons.',
        // ]);

    
        // Achievement::create([
        //     'name' => 'First Comment Written',
        //     'description' => 'Write your first comment.',
        // ]);
    
        // Achievement::create([
        //     'name' => '3 Comments Written',
        //     'description' => 'Write 3 comments.',
        // ]);


        // Achievement::create([
        //     'name' => '5 Comments Written',
        //     'description' => 'Write 5 comments.',
        // ]);


        // Achievement::create([
        //     'name' => '10 Comments Written',
        //     'description' => 'Write 10 comments.',
        // ]);


        // Achievement::create([
        //     'name' => '20 Comments Written',
        //     'description' => 'Write 20 comments.',
        // ]);



         // Create specific achievements with the desired names and descriptions
    $achievements = [
        ['name' => 'First Lesson Watched', 'description' => 'Watch your first lesson.'],
        ['name' => '5 Lessons Watched', 'description' => 'Watch 5 lessons.'],
        ['name' => '10 Lessons Watched', 'description' => 'Watch 10 lessons.'],
        ['name' => '25 Lessons Watched', 'description' => 'Watch 25 lessons.'],
        ['name' => '50 Lessons Watched', 'description' => 'Watch 50 lessons.'],
        // Add more achievements as needed
    ];

    foreach ($achievements as $achievementData) {
        Achievement::create($achievementData);
    }
    }
}
