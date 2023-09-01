<?php

namespace App\Listeners;

use App\Models\Achievement;
use App\Events\LessonWatched;
use App\Events\AchievementUnlocked;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UnlockLessonAchievements
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(LessonWatched $event)
    {
        $user = $event->user;
        $watchedLessonsCount = $user->watched()->count();

        if ($watchedLessonsCount >= 1) {
            $this->unlockAchievement($user, 'First Lesson Watched');
        }
        if ($watchedLessonsCount >= 5) {
            $this->unlockAchievement($user, '5 Lessons Watched');
        }
    }

    private function unlockAchievement($user, $achievementName)
    {
        // Check if the user already unlocked this achievement to avoid duplicate unlocks.
        if (!$user->unlocked_achievements->contains($achievementName)) {
            // Assuming you have an Achievement model to store unlocked achievements
            $achievement = Achievement::where('name', $achievementName)->first();
    
            if ($achievement) {
                // Unlock the achievement for the user
                $user->unlocked_achievements()->attach($achievement->id);
    
                // Fire the AchievementUnlocked event
                event(new AchievementUnlocked($achievementName, $user));
            }
        }
    }
    





}
