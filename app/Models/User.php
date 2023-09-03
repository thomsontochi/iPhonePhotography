<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
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

    public function watchedLessons()
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

    public function getCurrentBadge()
    {
        // Logic to determine the user's current badge based on unlocked achievements

        if ($this->unlocked_achievements()->count() >= 10) {
            return 'Master';
        } elseif ($this->unlocked_achievements()->count() >= 8) {
            return 'Advanced';
        } elseif ($this->unlocked_achievements()->count() >= 4) {
            return 'Intermediate';
        } else {
            return 'Beginner';
        }
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
        // Logic to determine the next available achievements regardless of groups

        $nextAvailableAchievements = Achievement::whereNotIn('name', $this->unlocked_achievements->pluck('name'))
            ->pluck('name')->toArray();

        return $nextAvailableAchievements;
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
}
