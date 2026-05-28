<?php

namespace App\Http\Controllers;

use App\Models\Quest;
use App\Models\Submission;
use App\Models\User;
use App\Models\Announcement;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display Admin/Officer Dashboard
     */
    public function dashboard()
    {
        $stats = [
            'total_members' => User::where('role', 'member')->count(),
            'total_quests' => Quest::count(),
            'pending_submissions' => Submission::where('status', 'pending')->count(),
            'active_quests' => Quest::whereIn('status', ['claimed', 'in_progress', 'under_review'])->count(),
        ];

        // Recent submissions
        $recentSubmissions = Submission::with(['user', 'quest'])
            ->latest()
            ->take(5)
            ->get();

        // Active quests list
        $activeQuests = Quest::with('assignee')
            ->whereIn('status', ['claimed', 'in_progress', 'under_review'])
            ->latest()
            ->get();

        return view('admin.dashboard', compact('stats', 'recentSubmissions', 'activeQuests'));
    }

    /**
     * Show Quest creation board
     */
    public function createQuest()
    {
        $difficulties = ['F', 'E', 'D', 'C', 'B', 'A', 'S'];
        return view('admin.quests.create', compact('difficulties'));
    }

    /**
     * Save new Quest
     */
    public function storeQuest(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'reward' => 'required|string|max:255',
            'difficulty' => 'required|in:F,E,D,C,B,A,S',
            'deadline' => 'nullable|date',
        ]);

        Quest::create([
            'title' => $request->title,
            'description' => $request->description,
            'reward' => $request->reward,
            'difficulty' => $request->difficulty,
            'deadline' => $request->deadline,
            'status' => 'available'
        ]);

        return redirect()->route('admin.dashboard')->with('success', '📜 A new quest scroll has been pinned to the board!');
    }

    /**
     * Show Quest edit board
     */
    public function editQuest(Quest $quest)
    {
        $difficulties = ['F', 'E', 'D', 'C', 'B', 'A', 'S'];
        return view('admin.quests.edit', compact('quest', 'difficulties'));
    }

    /**
     * Update Quest
     */
    public function updateQuest(Request $request, Quest $quest)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'reward' => 'required|string|max:255',
            'difficulty' => 'required|in:F,E,D,C,B,A,S',
            'deadline' => 'nullable|date',
            'status' => 'required|in:available,claimed,in_progress,under_review,completed',
        ]);

        $quest->update($request->all());

        return redirect()->route('admin.dashboard')->with('success', '📜 Quest scroll has been magically updated!');
    }

    /**
     * Delete Quest
     */
    public function deleteQuest(Quest $quest)
    {
        $quest->delete();
        return redirect()->route('admin.dashboard')->with('success', '🗑️ Quest scroll has been incinerated.');
    }

    /**
     * Review submission details
     */
    public function reviewSubmission(Submission $submission)
    {
        $submission->load(['user', 'quest']);
        return view('admin.submissions.review', compact('submission'));
    }

    /**
     * Approve submission and reward EXP
     */
    public function approveSubmission(Request $request, Submission $submission)
    {
        $request->validate([
            'feedback' => 'nullable|string|max:1000'
        ]);

        $quest = $submission->quest;
        $user = $submission->user;

        // 1. Update Submission status
        $submission->update([
            'status' => 'approved',
            'feedback' => $request->feedback
        ]);

        // 2. Update Quest status
        $quest->update([
            'status' => 'completed'
        ]);

        // 3. Award EXP
        $expGained = $quest->getExpReward();
        $leveledUp = $user->addExp($expGained);

        $msg = '🏆 Submission approved! Adventurer ' . $user->name . ' gained ' . $expGained . ' EXP.';
        if ($leveledUp) {
            $msg .= ' ✨ LEVEL UP! Member has reached Level ' . $user->level . '!';
        }

        return redirect()->route('admin.dashboard')->with('success', $msg);
    }

    /**
     * Reject or request revision
     */
    public function rejectSubmission(Request $request, Submission $submission)
    {
        $request->validate([
            'feedback' => 'required|string|max:1000',
            'action_type' => 'required|in:reject,revision'
        ]);

        $quest = $submission->quest;
        $newStatus = $request->action_type === 'reject' ? 'rejected' : 'revision';

        // Update Submission
        $submission->update([
            'status' => $newStatus,
            'feedback' => $request->feedback
        ]);

        // Reset Quest status to in_progress so the member can submit again
        $quest->update([
            'status' => 'in_progress'
        ]);

        $msg = $request->action_type === 'reject' 
            ? '❌ Quest submission rejected. Scroll sent back to progress.' 
            : '🔄 Revision requested. Adventurer notified with instructions!';

        return redirect()->route('admin.dashboard')->with('success', $msg);
    }

    /**
     * Manage Guild Members Roster
     */
    public function members()
    {
        $members = User::orderBy('role')
            ->orderBy('level', 'desc')
            ->get();

        return view('admin.members.index', compact('members'));
    }

    /**
     * Adjust member details (level, exp, role)
     */
    public function adjustMember(Request $request, User $user)
    {
        $request->validate([
            'level' => 'required|integer|min:1|max:100',
            'exp' => 'required|integer|min:0',
            'role' => 'required|in:admin,officer,member',
        ]);

        // Check if admin is editing themselves to prevent losing admin status accidentally
        if (auth()->id() === $user->id && $request->role !== 'admin') {
            return redirect()->back()->with('error', 'Halt! You cannot strip yourself of the Guild Master title.');
        }

        $user->update($request->only(['level', 'exp', 'role']));

        return redirect()->route('admin.members')->with('success', '🔮 Mana flow adjusted! ' . $user->name . '\'s level/EXP has been updated.');
    }

    /**
     * Create Announcement Form
     */
    public function createAnnouncement()
    {
        return view('admin.announcements.create');
    }

    /**
     * Store Announcement
     */
    public function storeAnnouncement(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        Announcement::create($request->all());

        return redirect()->route('admin.dashboard')->with('success', '📢 A new proclamation has been announced to the Guild!');
    }

    /**
     * Delete Announcement
     */
    public function deleteAnnouncement(Announcement $announcement)
    {
        $announcement->delete();
        return redirect()->route('admin.dashboard')->with('success', '🗑️ Proclamation has been archived.');
    }
}
