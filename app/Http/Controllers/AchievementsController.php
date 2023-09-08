<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Lesson;
use Illuminate\Http\Request;
use App\Events\LessonWatched;

class AchievementsController extends Controller
{
    public function index(User $user)
    {
        // Get the user's unlocked achievements
        $unlockedAchievements = $user->unlocked_achievements->pluck('name')->toArray();

        // dd($unlockedAchievements);

        // Get the user's current badge
        $currentBadge = $user->getCurrentBadge();


        // Get the next badge and remaining achievements to unlock it
        $nextBadge = $user->getNextBadge();
        $remainingToUnlockNextBadge = $user->getRemainingToUnlockNextBadge();

        // Get the next available achievements 
        $nextAvailableAchievements = $user->getNextAvailableAchievements();

        // build response data
        $responseData = [
            'unlocked_achievements' => $unlockedAchievements,
            'current_badge' => $currentBadge,
            'next_badge' => $nextBadge,
            'remaining_to_unlock_next_badge' => $remainingToUnlockNextBadge,
        ];

        // Check if there are next available achievements
        if (!empty($nextAvailableAchievements)) {
            $responseData['next_available_achievements'] = $nextAvailableAchievements;
        }

        // Return the data as a JSON response
        return response()->json($responseData);

        // Return the data as a JSON response
        // return response()->json([
        //     'unlocked_achievements' => $unlockedAchievements,
        //     'next_available_achievements' => $nextAvailableAchievements,
        //     'current_badge' => $currentBadge,
        //     'next_badge' => $nextBadge,
        //     'remaining_to_unlock_next_badge' => $remainingToUnlockNextBadge,
        // ]);
    }
}
