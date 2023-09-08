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



    public function testUnlockingLessonAchievements()
    {
        // Create a user and lessons as needed for testing
        $lesson = Lesson::factory()->create();
        $user = User::factory()->create();

        // Associate the lesson with the user
        $user->lessons()->attach($lesson->id);
      
        // Simulate the user watching lessons
        LessonWatched::dispatch($lesson, $user);

        // Retrieve the achievement names from the relationship
        $unlockedAchievementNames = $user->unlocked_achievements->pluck('name')->toArray();


        // Assertions for unlocking achievements and badges
        $this->assertTrue(in_array('First Lesson Watched', $unlockedAchievementNames));

        
    }
}
