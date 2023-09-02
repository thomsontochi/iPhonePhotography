<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AchievementsController extends Controller
{
    public function index(User $user)
    {
        // dd($user);
        // return response()->json([
        //     'unlocked_achievements' => [],
        //     'next_available_achievements' => [],
        //     'current_badge' => '',
        //     'next_badge' => '',
        //     'remaing_to_unlock_next_badge' => 0
        // ]);
        // Get the user's unlocked achievements
        $unlockedAchievements = $user->unlocked_achievements->pluck('name')->toArray();

        // Get the user's current badge
        $currentBadge = $user->getCurrentBadge();

        // Get the next badge and remaining achievements to unlock it
        $nextBadge = $user->getNextBadge();
        $remainingToUnlockNextBadge = $user->getRemainingToUnlockNextBadge();

        // Get the next available achievements for each group
        $nextAvailableAchievements = $user->getNextAvailableAchievements();

        // Return the data as a JSON response
        return response()->json([
            'unlocked_achievements' => $unlockedAchievements,
            'next_available_achievements' => $nextAvailableAchievements,
            'current_badge' => $currentBadge,
            'next_badge' => $nextBadge,
            'remaining_to_unlock_next_badge' => $remainingToUnlockNextBadge,
        ]);
    }
}
