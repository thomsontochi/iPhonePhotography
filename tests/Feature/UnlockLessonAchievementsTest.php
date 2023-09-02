<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
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

    public function testLessonWatchedEvent()
    {
        // Create a user with unlocked achievements
        $user = User::factory()->create();
        $user->unlocked_achievements()->attach([1, 2]); // Attach achievement IDs (e.g., 1 and 2)

        // Simulate a LessonWatched event by adding records to the watched_lessons table
        $lessonIds = [1, 2, 3, 4, 5]; // Assuming these are the lesson IDs watched by the user
        foreach ($lessonIds as $lessonId) {
            WatchedLesson::factory()->create([
                'user_id' => $user->id,
                'lesson_id' => $lessonId,
            ]);
        }

        // Reload the user to fetch the updated unlocked achievements
        $user->load('unlocked_achievements');
        // dd($user->unlocked_achievement);

        // Assert that the UnlockLessonAchievements listener unlocks achievements correctly
        $this->assertTrue($user->unlocked_achievements->contains('First Lesson Watched'));
        $this->assertTrue($user->unlocked_achievements->contains('5 Lessons Watched'));
        // Add assertions for other achievements as needed

        // Assert that the AchievementUnlocked event is fired with the correct achievement name and user
        Event::assertDispatched(AchievementUnlocked::class, function ($event) use ($user) {
            return $event->user->id === $user->id &&
                $event->achievementName === '5 Lessons Watched';
        });
    }
}
