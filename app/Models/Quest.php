<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quest extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'reward',
        'difficulty',
        'status',
        'deadline',
        'assigned_to',
    ];

    protected $casts = [
        'deadline' => 'datetime',
    ];

    /**
     * Relationships
     */
    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }

    public function activeSubmission()
    {
        // Returns the latest pending or rejected submission
        return $this->hasOne(Submission::class)->latestOfMany();
    }

    /**
     * RPG EXP reward calculation based on difficulty
     */
    public function getExpReward(): int
    {
        return match ($this->difficulty) {
            'F' => 20,
            'E' => 40,
            'D' => 80,
            'C' => 150,
            'B' => 300,
            'A' => 600,
            'S' => 1200,
            default => 10,
        };
    }

    /**
     * Tailwind Classes for Difficulty Badges
     */
    public function getDifficultyClasses(): string
    {
        return match ($this->difficulty) {
            'F' => 'bg-slate-800 text-slate-400 border border-slate-700 shadow-sm',
            'E' => 'bg-emerald-950 text-emerald-400 border border-emerald-800 shadow-sm',
            'D' => 'bg-blue-950 text-blue-400 border border-blue-800 shadow-sm',
            'C' => 'bg-cyan-950 text-cyan-400 border border-cyan-800 shadow-sm',
            'B' => 'bg-indigo-950 text-indigo-400 border border-indigo-800 shadow-sm',
            'A' => 'bg-amber-950/80 text-amber-400 border border-amber-600 shadow-[0_0_8px_rgba(245,158,11,0.2)]',
            'S' => 'bg-red-950/90 text-red-400 border border-red-500 font-extrabold animate-pulse shadow-[0_0_15px_rgba(239,68,68,0.5)] uppercase tracking-wider',
            default => 'bg-slate-900 text-slate-400',
        };
    }

    /**
     * Tailwind Classes for Status Badges
     */
    public function getStatusClasses(): string
    {
        return match ($this->status) {
            'available' => 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/30',
            'claimed' => 'bg-amber-500/10 text-amber-400 border border-amber-500/30',
            'in_progress' => 'bg-sky-500/10 text-sky-400 border border-sky-500/30',
            'under_review' => 'bg-purple-500/10 text-purple-400 border border-purple-500/30 shadow-[0_0_8px_rgba(168,85,247,0.2)]',
            'completed' => 'bg-slate-500/10 text-slate-400 line-through border border-slate-500/20',
            default => 'bg-slate-800 text-slate-400',
        };
    }

    /**
     * Display status in readable format
     */
    public function getReadableStatus(): string
    {
        return match ($this->status) {
            'available' => 'Available',
            'claimed' => 'Claimed',
            'in_progress' => 'In Progress',
            'under_review' => 'Under Review',
            'completed' => 'Completed',
            default => ucfirst($this->status),
        };
    }
}
