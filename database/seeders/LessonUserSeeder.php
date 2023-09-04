<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LessonUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get random user and lesson IDs
        $userIds = DB::table('users')->pluck('id')->toArray();
        $lessonIds = DB::table('lessons')->pluck('id')->toArray();

        // Populate the lesson_user table
        foreach ($lessonIds as $lessonId) {
            // Decide if the lesson was watched randomly
            $watched = rand(0, 1);

            foreach ($userIds as $userId) {
                DB::table('lesson_user')->insert([
                    'user_id' => $userId,
                    'lesson_id' => $lessonId,
                    'watched' => $watched,
                ]);
            }
        }
    }
}
