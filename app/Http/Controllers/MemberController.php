<?php

namespace App\Http\Controllers;

use App\Models\Quest;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\File;

class MemberController extends Controller
{
    /**
     * Display the Member Dashboard
     */
    public function dashboard()
    {
        $user = auth()->user();

        // Get quests claimed/in-progress by this member
        $myQuests = Quest::where('assigned_to', $user->id)
            ->whereIn('status', ['claimed', 'in_progress', 'under_review'])
            ->latest()
            ->get();

        // Get completed quests by this member
        $completedQuestsCount = Quest::where('assigned_to', $user->id)
            ->where('status', 'completed')
            ->count();

        // Get all available quests that the user can claim
        $availableQuests = Quest::where('status', 'available')
            ->latest()
            ->get();

        return view('member.dashboard', compact('user', 'myQuests', 'completedQuestsCount', 'availableQuests'));
    }

    /**
     * Claim an available Quest
     */
    public function claimQuest(Quest $quest)
    {
        // Check if quest is available
        if ($quest->status !== 'available') {
            return redirect()->back()->with('error', 'Halt! This quest is no longer available to be claimed.');
        }

        $user = auth()->user();

        // Change quest state to claimed / in progress and assign to user
        $quest->update([
            'assigned_to' => $user->id,
            'status' => 'in_progress'
        ]);

        return redirect()->route('member.dashboard')->with('success', '⚔️ Quest "' . $quest->title . '" has been claimed! Fight with honor!');
    }

    /**
     * Show the Quest submission form
     */
    public function submitQuestForm(Quest $quest)
    {
        // Verify owner
        if ($quest->assigned_to !== auth()->id()) {
            abort(403, 'This quest does not belong to your party.');
        }

        // Verify status
        if (!in_array($quest->status, ['in_progress', 'claimed'])) {
            return redirect()->route('member.dashboard')->with('error', 'You cannot submit proof for this quest right now.');
        }

        return view('member.submit-quest', compact('quest'));
    }

    /**
     * Submit Quest Proof
     */
    public function submitQuest(Request $request, Quest $quest)
    {
        // Verify owner
        if ($quest->assigned_to !== auth()->id()) {
            abort(403, 'This quest does not belong to your party.');
        }

        if (!in_array($quest->status, ['in_progress', 'claimed'])) {
            return redirect()->route('member.dashboard')->with('error', 'You cannot submit proof for this quest right now.');
        }

        // Validate file proof (images, documents, zip)
        $request->validate([
            'file' => ['required', File::types(['jpg', 'jpeg', 'png', 'pdf', 'zip', 'rar'])->max(10240)], // 10MB Max
            'note' => 'nullable|string|max:1000',
        ]);

        // Upload file
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('submissions', 'public');

            // Delete previous pending submissions if they exist
            Submission::where('quest_id', $quest->id)
                ->where('user_id', auth()->id())
                ->where('status', 'pending')
                ->delete();

            // Create new submission
            Submission::create([
                'quest_id' => $quest->id,
                'user_id' => auth()->id(),
                'file' => $filePath,
                'note' => $request->note,
                'status' => 'pending'
            ]);

            // Set Quest status to under_review
            $quest->update([
                'status' => 'under_review'
            ]);

            return redirect()->route('member.dashboard')->with('success', '📜 Quest proof submitted successfully! The Guild Officers will review it shortly.');
        }

        return redirect()->back()->with('error', 'Failed to upload proof. Please try again.');
    }

    /**
     * Show edit profile form
     */
    public function editProfile()
    {
        $user = auth()->user();
        return view('member.profile', compact('user'));
    }

    /**
     * Update member profile and avatar
     */
    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'avatar' => ['nullable', File::types(['jpg', 'jpeg', 'png'])->max(2048)],
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->hasFile('avatar')) {
            // Delete old avatar
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }

            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($data);

        return redirect()->route('member.dashboard')->with('success', '🔮 Profile scrolls updated successfully!');
    }
}
