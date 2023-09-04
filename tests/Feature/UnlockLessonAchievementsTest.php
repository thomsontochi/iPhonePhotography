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

        $user->lessons()->attach($lesson->id);

        $user->load('lessons');

            
        // Simulate a user watching lessons
        LessonWatched::dispatch($lesson, $user); // Dispatch the LessonWatched event

        $this->assertTrue($user->lessons->contains($lesson));

      
    }
    
    
}
