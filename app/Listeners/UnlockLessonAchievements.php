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
        // Check the user's total unlocked achievements to determine the appropriate badge
        $totalAchievements = $user->unlocked_achievements->count();

        // Define the badge names and their corresponding achievement counts
        $badgeMap = [
            'Beginner' => 0,
            'Intermediate' => 4,
            'Advanced' => 8,
            'Master' => 10,
        ];

        // Determine the user's current badge
        $currentBadge = null;
        foreach ($badgeMap as $badgeName => $achievementCount) {
            if ($totalAchievements >= $achievementCount) {
                $currentBadge = $badgeName;
            } else {
                break;
            }
        }

        // Attach the current badge to the user
        if ($currentBadge) {
            // Assuming you have a Badge model to store badges
            $badge = Badge::where('name', $currentBadge)->first();
            if ($badge) {
                // Check if the user already has this badge to avoid duplicate attachments
                if (!$user->badges->contains('name', $badge->name)) {
                    // Attach the badge to the user
                    $user->badges()->attach($badge->id);
                }
            }
        }
    }
}
