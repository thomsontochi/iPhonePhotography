<?php

namespace Database\Seeders;

use App\Models\Lesson;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\BadgeSeeder;
use Database\Seeders\CommentSeeder;
use Database\Seeders\LessonUserSeeder;
use Database\Seeders\UsersTableSeeder;
use Database\Seeders\WatchedLessonSeeder;
use Database\Seeders\AchievementsTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
            $lessons = Lesson::factory()
            ->count(20)
            ->create();
            $this->call([
                CommentSeeder::class,
                UsersTableSeeder::class,
                AchievementsTableSeeder::class,
                LessonUserSeeder::class,
                BadgeSeeder::class,
                BadgeUserSeeder::class,
               
            ]);
    }
}
