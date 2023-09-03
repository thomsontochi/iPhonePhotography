<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Lesson;
use App\Models\WatchedLesson;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class WatchedLessonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // WatchedLesson::factory()->count(10)->create();
        WatchedLesson::factory()->count(10)->create([
            'user_id' => User::factory(),
            'lesson_id' => Lesson::factory(),
        ]);
    }
}
