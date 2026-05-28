@extends('layouts.guild')

@section('content')
<!-- Hero Section -->
<div class="relative overflow-hidden glass-panel border border-purple-500/20 rounded-3xl p-8 sm:p-12 mb-12 shadow-[0_0_30px_rgba(139,92,246,0.1)]">
    <!-- Glowing background elements -->
    <div class="absolute -top-24 -left-24 w-72 h-72 bg-purple-600/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-24 -right-24 w-72 h-72 bg-amber-500/5 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-3xl relative z-10">
        <span class="text-xs uppercase tracking-[0.25em] text-amber-500 font-bold font-fantasy">⚔️ ESTABLISHED IN THE AGE OF DRAGONS ⚔️</span>
        <h1 class="text-4xl sm:text-6xl font-fantasy-header text-transparent bg-clip-text bg-gradient-to-r from-amber-400 via-amber-200 to-amber-500 tracking-wider mt-4 leading-none select-none drop-shadow-[0_4px_12px_rgba(245,158,11,0.25)]">
            SideQuest Guild
        </h1>
        <p class="text-lg sm:text-2xl text-purple-300 font-fantasy tracking-wide mt-2">
            The Legendary Sanctuary for Bold Adventurers & Isekai Wanderers
        </p>
        <p class="text-slate-400 mt-6 leading-relaxed max-w-2xl text-sm sm:text-base">
            Need a hydra exterminated, a cursed amulet cleansed, or supplies escorted across dragon territory? Or perhaps you are a wandering adventurer looking to claim glory and gold? Welcome to the SideQuest Guild. Submit your commission or pick up your blade.
        </p>

        <div class="flex flex-col sm:flex-row items-stretch sm:items-center space-y-4 sm:space-y-0 sm:space-x-4 mt-8">
            <a href="https://wa.me/{{ env('WHATSAPP_NUMBER', '6288905130453') }}" target="_blank" class="flex items-center justify-center space-x-2 bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-950 font-bold px-8 py-4 rounded-xl transition shadow-[0_0_15px_rgba(245,158,11,0.3)] hover:scale-[1.02]">
                <span>💬 Request Quest via WhatsApp</span>
            </a>
            <a href="{{ route('public.quests') }}" class="flex items-center justify-center bg-slate-900/80 hover:bg-slate-800 border border-purple-500/30 hover:border-purple-500/70 text-purple-300 px-8 py-4 rounded-xl font-bold transition">
                <span>🛡️ Explore Quest Board</span>
            </a>
        </div>
    </div>
</div>

<!-- Stats Counter -->
<div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-12">
    <div class="glass-panel rounded-2xl p-6 border border-purple-900/30 text-center flex flex-col justify-center">
        <span class="text-3xl font-fantasy text-amber-500 font-bold">{{ $stats['quests_completed'] }}</span>
        <span class="text-xs text-slate-500 uppercase tracking-widest mt-1">Quests Completed</span>
    </div>
    <div class="glass-panel rounded-2xl p-6 border border-purple-900/30 text-center flex flex-col justify-center">
        <span class="text-3xl font-fantasy text-purple-400 font-bold">{{ $stats['active_adventurers'] }}</span>
        <span class="text-xs text-slate-500 uppercase tracking-widest mt-1">Active Adventurers</span>
    </div>
    <div class="glass-panel rounded-2xl p-6 border border-purple-900/30 text-center flex flex-col justify-center">
        <span class="text-3xl font-fantasy text-teal-400 font-bold">{{ $stats['available_quests'] }}</span>
        <span class="text-xs text-slate-500 uppercase tracking-widest mt-1">Available Commissions</span>
    </div>
</div>

<!-- Main Sections Grid -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    <!-- Quests Board Preview -->
    <div class="lg:col-span-2 space-y-6">
        <div class="flex items-center justify-between border-b border-purple-900/40 pb-3">
            <h2 class="text-2xl font-fantasy text-amber-400 flex items-center space-x-2">
                <span>📜</span>
                <span>Active Quest Scroll Preview</span>
            </h2>
            <a href="{{ route('public.quests') }}" class="text-xs text-purple-400 hover:text-purple-300 transition hover:underline">View All Quests →</a>
        </div>

        <div class="space-y-4">
            @forelse($activeQuests as $quest)
                <div class="glass-panel rounded-2xl p-5 border border-purple-900/20 hover:border-purple-500/30 transition shadow-sm hover:shadow-[0_0_15px_rgba(139,92,246,0.08)] flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div class="space-y-1">
                        <div class="flex items-center space-x-2 flex-wrap gap-1">
                            <span class="text-xs font-bold px-2 py-0.5 rounded-md font-fantasy {{ $quest->getDifficultyClasses() }}">
                                Rank {{ $quest->difficulty }}
                            </span>
                            <span class="text-xs font-bold px-2 py-0.5 rounded-md font-fantasy {{ $quest->getStatusClasses() }}">
                                {{ $quest->getReadableStatus() }}
                            </span>
                        </div>
                        <h3 class="text-lg font-bold text-slate-100 group-hover:text-amber-400 transition">{{ $quest->title }}</h3>
                        <p class="text-slate-400 text-xs line-clamp-2 max-w-xl">{{ $quest->description }}</p>
                    </div>

                    <!-- Reward Badge -->
                    <div class="text-left sm:text-right min-w-[150px]">
                        <span class="block text-[10px] text-slate-500 uppercase tracking-wider">Reward Chest</span>
                        <span class="text-sm font-bold text-amber-400 font-fantasy block">{{ $quest->reward }}</span>
                        <span class="text-[10px] text-purple-400 block font-fantasy">+{{ $quest->getExpReward() }} EXP</span>
                    </div>
                </div>
            @empty
                <div class="glass-panel rounded-2xl p-8 text-center text-slate-500 border border-dashed border-purple-900/30">
                    <span class="text-3xl">🏜️</span>
                    <p class="text-sm mt-2">The quest board is currently empty. Check back after next sundown!</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Right Side: Top Adventurers & Announcements -->
    <div class="space-y-8">
        
        <!-- Top Adventurers -->
        <div class="space-y-4">
            <h2 class="text-xl font-fantasy text-amber-400 border-b border-purple-900/40 pb-3 flex items-center space-x-2">
                <span>🏆</span>
                <span>Top Adventurers</span>
            </h2>
            <div class="space-y-3">
                @forelse($topAdventurers as $index => $adventurer)
                    <div class="glass-panel rounded-2xl p-4 border border-purple-900/20 flex items-center space-x-3">
                        <!-- Rank Medal -->
                        <div class="flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center font-fantasy font-bold text-sm
                            @if($index == 0) bg-amber-500/10 text-amber-400 border border-amber-500/40 shadow-[0_0_10px_rgba(245,158,11,0.2)]
                            @elseif($index == 1) bg-slate-400/10 text-slate-300 border border-slate-400/40
                            @else bg-amber-700/10 text-amber-600 border border-amber-800/40
                            @endif">
                            #{{ $index + 1 }}
                        </div>
                        
                        <!-- Avatar -->
                        <img class="w-10 h-10 rounded-xl border border-purple-500/30" src="{{ $adventurer->getAvatarUrl() }}" alt="Avatar">

                        <!-- Stats info -->
                        <div class="flex-grow">
                            <span class="block text-sm font-bold text-slate-100">{{ $adventurer->name }}</span>
                            <div class="flex justify-between items-center text-[10px] text-slate-500 mt-0.5">
                                <span class="font-fantasy text-amber-500">{{ $adventurer->getRankName() }}</span>
                                <span>Lvl {{ $adventurer->level }}</span>
                            </div>
                            
                            <!-- EXP progress bar -->
                            <div class="w-full bg-slate-900/90 rounded-full h-1.5 mt-1 border border-purple-950/20 overflow-hidden">
                                <div class="bg-purple-600 h-1.5 rounded-full" style="width: {{ ($adventurer->exp / $adventurer->nextLevelExp()) * 100 }}%"></div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-6 text-slate-500 text-xs">
                        No registered members in the hall of fame yet.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Announcements Board -->
        <div class="space-y-4">
            <h2 class="text-xl font-fantasy text-amber-400 border-b border-purple-900/40 pb-3 flex items-center space-x-2">
                <span>📢</span>
                <span>Guild Proclamations</span>
            </h2>
            <div class="space-y-3">
                @forelse($announcements as $announcement)
                    <div class="glass-panel rounded-xl p-4 border border-purple-900/20 hover:border-purple-500/20 transition">
                        <span class="block text-xs font-bold text-amber-500">{{ $announcement->created_at->diffForHumans() }}</span>
                        <h4 class="text-sm font-bold text-slate-200 mt-1">{{ $announcement->title }}</h4>
                        <p class="text-xs text-slate-400 mt-1 leading-relaxed">{{ $announcement->content }}</p>
                    </div>
                @empty
                    <div class="text-center py-6 text-slate-500 text-xs">
                        No proclamations issued by the Guild Master recently.
                    </div>
                @endforelse
            </div>
        </div>

    </div>

</div>
@endsection
