<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    use HasFactory;

    protected $fillable = [
        'quest_id',
        'user_id',
        'file',
        'note',
        'status',
        'feedback',
    ];

    /**
     * Relationships
     */
    public function quest()
    {
        return $this->belongsTo(Quest::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Tailwind Classes for Submission Status
     */
    public function getStatusClasses(): string
    {
        return match ($this->status) {
            'pending' => 'bg-amber-500/10 text-amber-400 border border-amber-500/30',
            'approved' => 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/30',
            'rejected' => 'bg-rose-500/10 text-rose-400 border border-rose-500/30',
            'revision' => 'bg-purple-500/10 text-purple-400 border border-purple-500/30 shadow-[0_0_8px_rgba(168,85,247,0.2)]',
            default => 'bg-slate-800 text-slate-400',
        };
    }

    /**
     * Display status in readable format
     */
    public function getReadableStatus(): string
    {
        return match ($this->status) {
            'pending' => 'Pending Review',
            'approved' => 'Approved & Completed',
            'rejected' => 'Rejected',
            'revision' => 'Revision Required',
            default => ucfirst($this->status),
        };
    }
}
