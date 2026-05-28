@extends('layouts.guild')

@section('content')
<div class="space-y-8">
    
    <!-- Header Command Center -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 border-b border-purple-900/40 pb-4">
        <div>
            <h1 class="text-3xl font-fantasy text-amber-500 font-bold uppercase tracking-wide">Guild Staff Command Center</h1>
            <p class="text-xs text-purple-400 font-fantasy mt-0.5">MANAGE QUEST SCROLLS, MEMBERS, AND INTAKE PIPELINES</p>
        </div>

        <div class="flex items-center space-x-3 w-full sm:w-auto">
            <a href="{{ route('admin.quests.create') }}" class="flex-1 sm:flex-initial bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-950 px-5 py-2.5 rounded-xl text-xs font-bold transition flex items-center justify-center space-x-1.5 shadow-md">
                <span>📜 Pin New Quest</span>
            </a>
            <a href="{{ route('admin.announcements.create') }}" class="flex-1 sm:flex-initial bg-[#090a0f] hover:bg-purple-950/20 border border-purple-950/50 hover:border-purple-500/50 text-purple-300 px-5 py-2.5 rounded-xl text-xs font-bold transition flex items-center justify-center space-x-1.5">
                <span>📢 Proclaim Notice</span>
            </a>
        </div>
    </div>

    <!-- Statistics Panel -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="glass-panel p-5 rounded-2xl border border-purple-900/20 flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-2xl font-fantasy font-bold text-amber-500">{{ $stats['total_members'] }}</span>
                <span class="block text-[10px] text-slate-500 uppercase tracking-widest font-semibold">Adventurers Registered</span>
            </div>
            <span class="text-3xl">🛡️</span>
        </div>
        <div class="glass-panel p-5 rounded-2xl border border-purple-900/20 flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-2xl font-fantasy font-bold text-purple-400">{{ $stats['total_quests'] }}</span>
                <span class="block text-[10px] text-slate-500 uppercase tracking-widest font-semibold">Quest Scrolls Pinned</span>
            </div>
            <span class="text-3xl">📜</span>
        </div>
        <div class="glass-panel p-5 rounded-2xl border border-purple-900/20 flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-2xl font-fantasy font-bold text-rose-500">{{ $stats['pending_submissions'] }}</span>
                <span class="block text-[10px] text-slate-500 uppercase tracking-widest font-semibold font-fantasy">Pending Submissions</span>
            </div>
            <span class="text-3xl animate-pulse">⭐</span>
        </div>
        <div class="glass-panel p-5 rounded-2xl border border-purple-900/20 flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-2xl font-fantasy font-bold text-teal-400">{{ $stats['active_quests'] }}</span>
                <span class="block text-[10px] text-slate-500 uppercase tracking-widest font-semibold">Active Campaigns</span>
            </div>
            <span class="text-3xl">⚔️</span>
        </div>
    </div>

    <!-- Main Workspace Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Pending Submissions -->
        <div class="lg:col-span-2 space-y-6">
            <h2 class="text-xl font-fantasy text-amber-400 border-b border-purple-900/40 pb-3 flex items-center space-x-2">
                <span>⭐</span>
                <span>Submissions Awaiting Evaluation</span>
            </h2>

            <div class="space-y-4">
                @forelse($recentSubmissions as $submission)
                    <div class="glass-panel rounded-2xl p-5 border border-purple-900/20 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="space-y-1.5 flex-grow">
                            <div class="flex items-center space-x-2">
                                <span class="text-[9px] font-bold px-1.5 py-0.5 rounded-md font-fantasy {{ $submission->quest->getDifficultyClasses() }}">
                                    Rank {{ $submission->quest->difficulty }}
                                </span>
                                <span class="text-[10px] text-slate-500 font-fantasy">{{ $submission->created_at->diffForHumans() }}</span>
                            </div>
                            <h3 class="text-base font-bold text-slate-100">{{ $submission->quest->title }}</h3>
                            <div class="flex items-center space-x-2 text-xs text-slate-400">
                                <span>Adventurer:</span>
                                <span class="font-bold text-purple-300">{{ $submission->user->name }}</span>
                                <span class="text-slate-600">|</span>
                                <span>Lvl {{ $submission->user->level }}</span>
                            </div>
                        </div>

                        <!-- Action button -->
                        <div class="flex items-center space-x-3 self-end sm:self-auto">
                            <a href="{{ route('admin.submissions.review', $submission->id) }}" class="bg-gradient-to-r from-purple-700 to-indigo-800 hover:from-purple-600 hover:to-indigo-700 text-white px-4 py-2 rounded-xl text-xs font-bold transition shadow-sm border border-purple-500/20">
                                📜 Review Proof
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="glass-panel rounded-2xl p-8 text-center text-slate-500 border border-dashed border-purple-900/30">
                        <span class="text-3xl">💆</span>
                        <p class="text-xs mt-2">All adventurer logs are fully reviewed. Take a sip of tea, Officer!</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Active Quests / Commissions list -->
        <div class="space-y-6">
            <h2 class="text-xl font-fantasy text-amber-400 border-b border-purple-900/40 pb-3 flex items-center space-x-2">
                <span>⚔️</span>
                <span>Active Campaigns</span>
            </h2>

            <div class="space-y-4">
                @forelse($activeQuests as $quest)
                    <div class="glass-panel rounded-2xl p-4 border border-purple-900/20 flex flex-col space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="text-[9px] font-bold px-1.5 py-0.5 rounded-md font-fantasy {{ $quest->getDifficultyClasses() }}">
                                Rank {{ $quest->difficulty }}
                            </span>
                            <span class="text-[9px] font-bold px-1.5 py-0.5 rounded-md font-fantasy {{ $quest->getStatusClasses() }}">
                                {{ $quest->getReadableStatus() }}
                            </span>
                        </div>
                        <h4 class="text-sm font-bold text-slate-200 line-clamp-1">{{ $quest->title }}</h4>
                        
                        <div class="flex items-center space-x-2 text-[11px] text-slate-400 pt-1">
                            <span>Claimed by:</span>
                            <span class="font-bold text-amber-500">{{ $quest->assignee ? $quest->assignee->name : 'Unassigned' }}</span>
                        </div>

                        <!-- Staff Action buttons -->
                        <div class="flex items-center justify-end space-x-2 pt-2 border-t border-purple-950/20">
                            <a href="{{ route('admin.quests.edit', $quest->id) }}" class="text-[10px] text-purple-400 hover:text-purple-300 font-bold uppercase transition">Edit</a>
                            <span class="text-slate-700 text-[10px]">|</span>
                            <form action="{{ route('admin.quests.destroy', $quest->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to incinerate this quest scroll?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-[10px] text-rose-500 hover:text-rose-400 font-bold uppercase transition">Delete</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-6 text-slate-500 text-xs">
                        No active quest campaigns currently in play.
                    </div>
                @endforelse
            </div>
        </div>

    </div>

</div>
@endsection
