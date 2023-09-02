<?php

namespace App\Listeners;

use App\Models\Achievement;
use App\Events\CommentWritten;
use App\Events\AchievementUnlocked;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UnlockCommentAchievements
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
    public function handle(CommentWritten $event)
    {
        $user = $event->user;
        $writtenCommentsCount = $user->comments()->count();

        if ($writtenCommentsCount >= 1) {
            $this->unlockAchievement($user, 'First Comment Written');
        }
        if ($writtenCommentsCount >= 3) {
            $this->unlockAchievement($user, '3 Comments Written');
        }
    }

    private function unlockAchievement($user, $achievementName)
    {
        // Check if the user already unlocked this achievement to avoid duplicates
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
