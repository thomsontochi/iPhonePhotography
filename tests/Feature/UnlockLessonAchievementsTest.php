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

class UnlockLessonAchievementsTest extends TestCase
{
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
        // Create a user
        $user = User::factory()->create();
    
        // Create a lesson (adjust the details based on your implementation)
        $lesson = Lesson::factory()->create();
    
        // Simulate a user watching lessons
        LessonWatched::dispatch($lesson, $user); // Dispatch the LessonWatched event
    
        // Assert that the user unlocks the 'First Lesson Watched' achievement
       $this->assertTrue($user->unlocked_achievements->contains('First Lesson Watched'));
        
        // // Simulate the user watching more lessons to unlock the '5 Lessons Watched' achievement
        // LessonWatched::dispatch($lesson2, $user);
        // LessonWatched::dispatch($lesson3, $user);
        // LessonWatched::dispatch($lesson4, $user);
        // LessonWatched::dispatch($lesson5, $user);
    
        // Assert that the user unlocks the '5 Lessons Watched' achievement
        // $this->assertTrue($user->unlocked_achievements->contains('5 Lessons Watched'));
    }
    
    
}
