<?php

namespace App\Http\Controllers;

use App\Models\Quest;
use App\Models\User;
use App\Models\Announcement;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    /**
     * Display the RPG Dark Fantasy Landing Page
     */
    public function index()
    {
        // Active quests: latest available or in-progress
        $activeQuests = Quest::whereIn('status', ['available', 'in_progress'])
            ->latest()
            ->take(3)
            ->get();

        // Top Adventurers: Members sorted by level and exp DESC
        $topAdventurers = User::where('role', 'member')
            ->orderBy('level', 'desc')
            ->orderBy('exp', 'desc')
            ->take(3)
            ->get();

        // Latest announcements
        $announcements = Announcement::latest()->take(3)->get();

        // Total numbers for stats display
        $stats = [
            'quests_completed' => Quest::where('status', 'completed')->count(),
            'active_adventurers' => User::where('role', 'member')->count(),
            'available_quests' => Quest::where('status', 'available')->count(),
        ];

        return view('public.landing', compact('activeQuests', 'topAdventurers', 'announcements', 'stats'));
    }

    /**
     * Display the public Quest Board
     */
    public function questBoard(Request $request)
    {
        $query = Quest::query();

        // Search filter
        if ($request->has('search') && !empty($request->search)) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Difficulty filter
        if ($request->has('difficulty') && !empty($request->difficulty)) {
            $query->where('difficulty', $request->difficulty);
        }

        // Status filter
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        } else {
            // By default, show everything except maybe show completed at the bottom
            $query->orderByRaw("FIELD(status, 'available', 'claimed', 'in_progress', 'under_review', 'completed')");
        }

        $quests = $query->latest()->paginate(10);
        $difficulties = ['F', 'E', 'D', 'C', 'B', 'A', 'S'];

        return view('public.board', compact('quests', 'difficulties'));
    }
}
