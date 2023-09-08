<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Lesson;
use App\Events\LessonWatched;
use App\Models\WatchedLesson;
use App\Events\AchievementUnlocked;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UnlockLessonAchievementsTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic feature test example.
     */
    // public function test_example(): void
    // {
    //     $response = $this->get('/');

    //     $response->assertStatus(200);
    // }

    // public function testUnlockingLessonAchievements()
    // {
    //     // Create a user and lessons as needed for testing
    //     $user = User::factory()->create();
    //     $lesson = Lesson::factory()->create();


    //     // Associate the lesson with the user
    //     $user->lessons()->attach($lesson->id);

    //     // Simulate the user watching lessons
    //     LessonWatched::dispatch($lesson, $user);


    //     dd($user->unlocked_achievements->contains('First Lesson Watched'));

    //     // Assertions for unlocking achievements and badges
    //     $this->assertTrue($user->unlocked_achievements->contains('First Lesson Watched'));
    //     $this->assertTrue($user->badges->contains('name', 'Beginner'));
    //     $this->assertFalse($user->badges->contains('name', 'Intermediate'));

    //     // Simulate the user watching more lessons to unlock the '5 Lessons Watched' achievement
    //     LessonWatched::dispatch($lesson1, $user);
    //     LessonWatched::dispatch($lesson2, $user);

    //     // Assertions for unlocking the '5 Lessons Watched' achievement and badge progression
    //     $this->assertTrue($user->unlocked_achievements->contains('5 Lessons Watched'));
    //     $this->assertTrue($user->badges->contains('name', 'Intermediate'));


    // }

    public function testUnlockingLessonAchievements()
    {
        // Create a user and lessons as needed for testing
        $user = User::factory()->create();
        $lesson = Lesson::factory()->create();

        // Associate the lesson with the user
        $user->lessons()->attach($lesson->id);
       
        // Simulate the user watching lessons
      LessonWatched::dispatch($lesson, $user);

       dd(LessonWatched::dispatch($lesson, $user));

      
        // Retrieve the achievement names from the relationship
        $unlockedAchievementNames = $user->unlocked_achievements->pluck('name')->toArray();


        // Assertions for unlocking achievements and badges
        $this->assertTrue(in_array('First Lesson Watched', $unlockedAchievementNames));
        $this->assertTrue($user->badges->contains('name', 'Beginner'));
        $this->assertFalse($user->badges->contains('name', 'Intermediate'));

        // Create additional lessons as needed for the next achievements
        $lesson1 = Lesson::factory()->create();
        $lesson2 = Lesson::factory()->create();

        // Associate the additional lessons with the user
        $user->lessons()->attach([$lesson1->id, $lesson2->id]);

        // Simulate the user watching more lessons to unlock the '5 Lessons Watched' achievement
        LessonWatched::dispatch($lesson1, $user);
        LessonWatched::dispatch($lesson2, $user);

        // Retrieve the updated achievement names from the relationship
        $updatedAchievementNames = $user->unlocked_achievements->pluck('name')->toArray();

        // Assertions for unlocking the '5 Lessons Watched' achievement and badge progression
        $this->assertTrue(in_array('5 Lessons Watched', $updatedAchievementNames));
        $this->assertTrue($user->badges->contains('name', 'Intermediate'));
    }
}
