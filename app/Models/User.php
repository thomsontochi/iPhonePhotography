<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
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
        // Logic to determine the next available achievements for each group

        $nextAvailableLessons = Achievement::whereNotIn('name', $this->unlocked_achievements->pluck('name'))
            ->where('group', 'Lessons Watched')
            ->pluck('name')->toArray();

        $nextAvailableComments = Achievement::whereNotIn('name', $this->unlocked_achievements->pluck('name'))
            ->where('group', 'Comments Written')
            ->pluck('name')->toArray();



        return [
            'Lessons Watched' => $nextAvailableLessons,
            'Comments Written' => $nextAvailableComments,

        ];
    }
}
