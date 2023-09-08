<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Badge;
use App\Models\Lesson;
use App\Models\Comment;
use App\Models\Achievement;
use App\Models\WatchedLesson;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function watched()
    {
        return $this->hasMany(WatchedLesson::class);
    }

    public function lessons()
    {
        return $this->belongsToMany(Lesson::class)->withTimestamps();
    }



    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function unlocked_achievements(): BelongsToMany
    {
        return $this->belongsToMany(Achievement::class)->withTimestamps();
        // return $this->belongsToMany(Achievement::class, 'user_achievements')->withTimestamps();
    }

    public function achievements()
    {
        return $this->belongsToMany(Achievement::class);
    }

    public function badges()
    {
        return $this->belongsToMany(Badge::class)->withTimestamps();
    }


    public function getCurrentBadge()
    {
        $unlockedAchievementsCount = $this->unlocked_achievements->count();

        // Define badge progression thresholds
        $badgeProgression = [
            'Beginner' => 0,
            'Intermediate' => 4,
            'Advanced' => 8,
            'Master' => 10,
        ];

        $currentBadge = 'Beginner';

        foreach ($badgeProgression as $badge => $threshold) {
            if ($unlockedAchievementsCount >= $threshold) {
                $currentBadge = $badge;
            }
        }

        return $currentBadge;
    }


    public function getNextBadge()
    {
        // Logic to determine the user's next badge based on unlocked achievements

        if ($this->unlocked_achievements()->count() >= 10) {
            return 'Master'; // User already has the highest badge
        } elseif ($this->unlocked_achievements()->count() >= 8) {
            return null; // No more badges to unlock after Advanced
        } elseif ($this->unlocked_achievements()->count() >= 4) {
            return 'Advanced';
        } else {
            return 'Intermediate';
        }
    }

    public function getRemainingToUnlockNextBadge()
    {
        $nextBadge = $this->getNextBadge();

        if ($nextBadge) {
            // Logic specific to your badge unlocking criteria

            $requiredAchievements = $this->getRequiredAchievementsForBadge($nextBadge);

            // Calculate the remaining achievements needed for the next badge
            $unlockedAchievements = $this->unlocked_achievements()->count();
            $remainingToUnlockNextBadge = max(0, $requiredAchievements - $unlockedAchievements);

            return $remainingToUnlockNextBadge;
        }

        return 0; // No more badges to unlock
    }


    public function getNextAvailableAchievements()
    {
        $unlockedAchievements = $this->unlocked_achievements->pluck('name')->toArray();

        $availableAchievements = [];

        // Define the order of achievements
        $achievementOrder = [
            'First Lesson Watched',
            '5 Lessons Watched',
            '10 Lessons Watched',
            '25 Lessons Watched',
            '50 Lessons Watched',

        ];

        // // Loop through achievements in order
        // foreach ($achievementOrder as $achievementName) {
        //     if (!in_array($achievementName, $unlockedAchievements)) {
        //         // This is the next available achievement
        //         $availableAchievements[] = $achievementName;
        //         break; // Exit the loop once found
        //     }
        // }

        // return $availableAchievements;

        foreach ($achievementOrder as $achievementName) {
            if (!in_array($achievementName, $unlockedAchievements)) {
                $availableAchievements[] = $achievementName;
                break; // Stop after finding the next available achievement
            }
        }

        return $availableAchievements;
    }

    public function getRequiredAchievementsForBadge($badgeName)
    {


        switch ($badgeName) {
            case 'Intermediate':
                return 4; // The Intermediate badge requires 4 achievements
            case 'Advanced':
                return 8; // The Advanced badge requires 8 achievements
            case 'Master':
                return 10; // The Master badge requires 10 achievements
            default:
                return 0; // Default case, no required achievements
        }
    }

    public function unlockBadge()
    {
        $unlockedAchievements = $this->unlocked_achievements()->count();

        if ($unlockedAchievements >= 10) {
            // Award the Master badge
            $this->badges()->attach(Badge::where('name', 'Master')->first());
        } elseif ($unlockedAchievements >= 8) {
            // Award the Advanced badge
            $this->badges()->attach(Badge::where('name', 'Advanced')->first());
        } elseif ($unlockedAchievements >= 4) {
            // Award the Intermediate badge
            $this->badges()->attach(Badge::where('name', 'Intermediate')->first());
        } elseif ($unlockedAchievements >= 0) {
            // Award the Beginner badge
            $this->badges()->attach(Badge::where('name', 'Beginner')->first());
        }
    }

    public function assignBadges()
    {
        $currentBadge = $this->getCurrentBadge();

        $badge = Badge::where('name', $currentBadge)->first();

        if ($badge && !$this->badges->contains($badge)) {
            $this->badges()->attach($badge);
        }
    }


}
