<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

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
        'role',
        'avatar',
        'level',
        'exp',
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

    /**
     * Roles checks
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isOfficer(): bool
    {
        return $this->role === 'officer';
    }

    public function isMember(): bool
    {
        return $this->role === 'member';
    }

    /**
     * RPG Guild Rank Names based on level
     */
    public function getRankName(): string
    {
        if ($this->isAdmin()) return 'Guild Master';
        if ($this->isOfficer()) return 'Guild Officer';

        $lvl = $this->level;
        if ($lvl >= 75) return 'S-Rank Legend';
        if ($lvl >= 50) return 'A-Rank Master';
        if ($lvl >= 30) return 'B-Rank Elite';
        if ($lvl >= 15) return 'C-Rank Veteran';
        if ($lvl >= 5) return 'D-Rank Adventurer';
        return 'E-Rank Novice';
    }

    /**
     * EXP required to reach the NEXT level
     */
    public function nextLevelExp(): int
    {
        return $this->level * 100;
    }

    /**
     * Add EXP and handle level ups recursively
     * Returns true if user leveled up at least once.
     */
    public function addExp(int $amount): bool
    {
        if ($this->role !== 'member') return false; // Only member user levels up

        $this->exp += $amount;
        $leveledUp = false;

        while ($this->exp >= $this->nextLevelExp()) {
            $this->exp -= $this->nextLevelExp();
            $this->level++;
            $leveledUp = true;
        }

        $this->save();
        return $leveledUp;
    }

    /**
     * Get avatar url or default fallback
     */
    public function getAvatarUrl(): string
    {
        if ($this->avatar) {
            return asset('storage/' . $this->avatar);
        }

        // Return a cute SVG avatar fallback based on user role/level
        $class = 'Novice';
        if ($this->isAdmin()) $class = 'Master';
        elseif ($this->isOfficer()) $class = 'Officer';
        elseif ($this->level >= 30) $class = 'Hero';
        elseif ($this->level >= 15) $class = 'Mage';
        elseif ($this->level >= 5) $class = 'Warrior';

        return 'https://api.dicebear.com/7.x/adventurer/svg?seed=' . urlencode($this->name) . '&radius=10';
    }

    /**
     * Relationships
     */
    public function assignedQuests()
    {
        return $this->hasMany(Quest::class, 'assigned_to');
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }
}
