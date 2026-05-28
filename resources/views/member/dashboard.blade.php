@extends('layouts.guild')

@section('content')
<div class="space-y-8">
    
    <!-- Character Info Panel -->
    <div class="glass-panel rounded-3xl border border-purple-500/20 p-6 sm:p-8 flex flex-col md:flex-row items-center md:items-start justify-between gap-8 shadow-[0_0_25px_rgba(139,92,246,0.06)] relative overflow-hidden">
        <div class="absolute -top-12 -right-12 w-48 h-48 bg-amber-500/5 rounded-full blur-3xl pointer-events-none"></div>

        <div class="flex flex-col sm:flex-row items-center sm:items-start space-y-4 sm:space-y-0 sm:space-x-6 text-center sm:text-left z-10 w-full md:w-auto">
            <!-- Large Character Frame -->
            <div class="relative flex-shrink-0">
                <img class="h-24 w-24 rounded-2xl border-2 border-amber-500 shadow-lg" src="{{ $user->getAvatarUrl() }}" alt="Avatar">
                <span class="absolute -bottom-2 -right-2 bg-gradient-to-r from-amber-500 to-amber-600 border border-amber-400 text-slate-950 font-bold px-2 py-0.5 rounded-md text-xs font-fantasy">Lvl {{ $user->level }}</span>
            </div>

            <!-- Stats Scroll -->
            <div class="flex-grow space-y-2.5 w-full">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-fantasy text-slate-100 font-bold leading-tight">{{ $user->name }}</h1>
                    <span class="text-xs text-amber-500 font-fantasy uppercase tracking-widest font-bold">{{ $user->getRankName() }}</span>
                </div>
                
                <!-- Level Progress bar -->
                <div class="space-y-1 w-full max-w-md">
                    <div class="flex justify-between text-[11px] text-slate-400 font-semibold font-fantasy">
                        <span>MANA FLOW / EXP REGISTRY</span>
                        <span>{{ $user->exp }} / {{ $user->nextLevelExp() }} EXP</span>
                    </div>
                    <div class="w-full bg-slate-900 border border-purple-950/40 rounded-full h-3 overflow-hidden shadow-inner">
                        <div class="bg-gradient-to-r from-purple-700 via-purple-500 to-indigo-600 h-full rounded-full transition-all duration-500" style="width: {{ ($user->exp / $user->nextLevelExp()) * 100 }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Adventurer Record Widgets -->
        <div class="flex gap-4 w-full md:w-auto self-stretch md:self-auto justify-stretch z-10">
            <div class="glass-panel p-4 rounded-2xl border border-purple-900/30 text-center flex-1 md:w-28 flex flex-col justify-center">
                <span class="text-2xl font-fantasy text-amber-500 font-bold">{{ $completedQuestsCount }}</span>
                <span class="text-[9px] text-slate-500 uppercase tracking-wider font-semibold mt-1">Completed Quests</span>
            </div>
            <div class="glass-panel p-4 rounded-2xl border border-purple-900/30 text-center flex-1 md:w-28 flex flex-col justify-center">
                <span class="text-2xl font-fantasy text-teal-400 font-bold">{{ $myQuests->where('status', 'in_progress')->count() }}</span>
                <span class="text-[9px] text-slate-500 uppercase tracking-wider font-semibold mt-1">Active Claims</span>
            </div>
            <a href="{{ route('member.profile') }}" class="glass-panel p-4 rounded-2xl border border-purple-900/30 text-center flex-1 md:w-28 flex flex-col items-center justify-center hover:border-purple-500 transition group">
                <span class="text-xl group-hover:scale-110 transition">🔮</span>
                <span class="text-[9px] text-slate-400 uppercase tracking-wider font-bold mt-1 group-hover:text-amber-500 transition">Update Scroll</span>
            </a>
        </div>
    </div>

    <!-- Active Campaign Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Pinned / Claimed Quests -->
        <div class="lg:col-span-2 space-y-6">
            <h2 class="text-xl font-fantasy text-amber-400 border-b border-purple-900/40 pb-3 flex items-center space-x-2">
                <span>⚔️</span>
                <span>Your Active Campaigns</span>
            </h2>

            <div class="space-y-4">
                @forelse($myQuests as $quest)
                    <div class="glass-panel rounded-2xl p-5 border border-purple-900/20 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="space-y-1.5 flex-grow">
                            <div class="flex items-center space-x-2 flex-wrap gap-1">
                                <span class="text-[10px] font-bold px-2 py-0.5 rounded-md font-fantasy {{ $quest->getDifficultyClasses() }}">
                                    Rank {{ $quest->difficulty }}
                                </span>
                                <span class="text-[10px] font-bold px-2 py-0.5 rounded-md font-fantasy {{ $quest->getStatusClasses() }}">
                                    {{ $quest->getReadableStatus() }}
                                </span>
                                @if($quest->deadline)
                                    <span class="text-[10px] text-slate-500">⌛ {{ $quest->deadline->diffForHumans() }}</span>
                                @endif
                            </div>
                            <h3 class="text-base font-bold text-slate-100">{{ $quest->title }}</h3>
                            <p class="text-slate-400 text-xs line-clamp-2 max-w-xl">{{ $quest->description }}</p>

                            <!-- Revision Feedback Notice -->
                            @if($quest->status === 'in_progress' && $quest->activeSubmission && $quest->activeSubmission->status === 'revision')
                                <div class="bg-purple-950/40 border border-purple-900/50 p-3 rounded-xl text-xs text-purple-300 mt-2">
                                    <span class="font-bold block text-[10px] uppercase text-amber-500">📜 Officer feedback for revision:</span>
                                    <p class="italic mt-1">"{{ $quest->activeSubmission->feedback }}"</p>
                                </div>
                            @elseif($quest->status === 'in_progress' && $quest->activeSubmission && $quest->activeSubmission->status === 'rejected')
                                <div class="bg-rose-950/40 border border-rose-900/50 p-3 rounded-xl text-xs text-rose-300 mt-2">
                                    <span class="font-bold block text-[10px] uppercase text-red-500">❌ Submission rejected:</span>
                                    <p class="italic mt-1">"{{ $quest->activeSubmission->feedback }}"</p>
                                </div>
                            @endif
                        </div>

                        <!-- Action/Details -->
                        <div class="flex sm:flex-col items-start sm:items-end justify-between sm:justify-center gap-4 min-w-[140px]">
                            <div class="sm:text-right">
                                <span class="text-xs font-bold text-amber-400 block font-fantasy">{{ $quest->reward }}</span>
                                <span class="text-[10px] text-purple-400 block font-fantasy">+{{ $quest->getExpReward() }} EXP</span>
                            </div>

                            @if($quest->status === 'in_progress' || $quest->status === 'claimed')
                                <a href="{{ route('member.quests.submit.form', $quest->id) }}" class="bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-950 px-4 py-2 rounded-xl text-xs font-bold transition flex items-center space-x-1 shadow-sm">
                                    <span>📜 Submit Proof</span>
                                </a>
                            @else
                                <span class="text-[11px] text-slate-500 italic">Awaiting Officer review...</span>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="glass-panel rounded-2xl p-8 text-center text-slate-500 border border-dashed border-purple-900/30">
                        <span class="text-3xl">🏜️</span>
                        <p class="text-xs mt-2">No active campaigns. Visit the scroll board to claim a contract!</p>
                        <a href="{{ route('public.quests') }}" class="text-xs text-amber-500 font-bold hover:underline block mt-1">Explore Board →</a>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Available Quests Sidebar -->
        <div class="space-y-6">
            <h2 class="text-xl font-fantasy text-amber-400 border-b border-purple-900/40 pb-3 flex items-center space-x-2">
                <span>🛡️</span>
                <span>Available Board</span>
            </h2>

            <div class="space-y-4">
                @forelse($availableQuests->take(4) as $quest)
                    <div class="glass-panel rounded-2xl p-4 border border-purple-900/20 hover:border-purple-500/20 transition flex flex-col space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="text-[9px] font-bold px-1.5 py-0.5 rounded-md font-fantasy {{ $quest->getDifficultyClasses() }}">
                                Rank {{ $quest->difficulty }}
                            </span>
                            <span class="text-[10px] text-amber-500 font-fantasy font-semibold">{{ $quest->reward }}</span>
                        </div>
                        <h4 class="text-sm font-bold text-slate-200 line-clamp-1">{{ $quest->title }}</h4>
                        <p class="text-slate-400 text-[11px] line-clamp-2">{{ $quest->description }}</p>
                        
                        <form action="{{ route('member.quests.claim', $quest->id) }}" method="POST" class="pt-2">
                            @csrf
                            <button type="submit" class="w-full bg-[#090a0f] hover:bg-purple-950/20 border border-purple-900/50 hover:border-purple-500/50 text-purple-300 font-bold py-1.5 rounded-xl text-xs transition">
                                ⚔️ Claim Quest
                            </button>
                        </form>
                    </div>
                @empty
                    <div class="text-center py-6 text-slate-500 text-xs">
                        All board commissions have been claimed. Check back later!
                    </div>
                @endforelse
            </div>
        </div>

    </div>

</div>
@endsection
