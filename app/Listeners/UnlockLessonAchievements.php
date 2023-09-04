<?php

namespace App\Listeners;

use App\Models\Badge;
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

                // Attach any relevant badge if criteria are met
                $this->attachBadge($user, $achievement);

                // Fire the AchievementUnlocked event
                event(new AchievementUnlocked($achievementName, $user));
            }
        }
    }

    private function attachBadge($user, $achievement)
    {
        // Check the achievement's name to determine which badge to attach
        switch ($achievement->name) {
            case '5 Lessons Watched':
                // Assuming you have a Badge model to store badges
                $badge = Badge::where('name', 'Bronze Badge')->first();
                break;
                // Add more cases for other achievements and their associated badges
            default:
                $badge = null;
        }

        // Attach the badge to the user if a valid badge was found
        if ($badge) {
            // Check if the user already has this badge to avoid duplicate attachments
            if (!$user->badges->contains('name', $badge->name)) {
                // Attach the badge to the user
                $user->badges()->attach($badge->id);
            }
        }
    }
}
