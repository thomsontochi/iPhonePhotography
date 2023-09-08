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
        $watchedLessonsCount = $user->lessons()->count();

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

                // Call the assignBadges method to update badges
                $this->assignBadges($user);

                // Fire the AchievementUnlocked event
                event(new AchievementUnlocked($achievementName, $user));
            }
        }
    }


    private function assignBadges($user)
    {
        // Get the user's unlocked achievements
        $unlockedAchievements = $user->unlocked_achievements->pluck('name')->toArray();

        // Define badge progression logic
        $badgeProgression = [
            'Beginner' => ['First Lesson Watched'],
            'Intermediate' => ['5 Lessons Watched'],
            'Advanced' => ['10 Lessons Watched'],
            'Master' => ['25 Lessons Watched', '50 Lessons Watched'],
        ];

        // Determine the highest badge the user has achieved
        $highestBadge = null;

        foreach ($badgeProgression as $badgeName => $achievementNames) {
            if (count(array_intersect($achievementNames, $unlockedAchievements)) === count($achievementNames)) {
                $highestBadge = $badgeName;
            } else {
                break;
            }
        }

        // Assign the highest badge to the user
        if ($highestBadge) {
            $user->badges()->sync([$highestBadge]);
        }
    }




  












}
