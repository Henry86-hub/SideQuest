@extends('layouts.guild')

@section('content')
<div class="space-y-8">
    
    <!-- Title Section -->
    <div class="text-center py-6 border-b border-purple-900/40 max-w-xl mx-auto">
        <h1 class="text-3xl sm:text-5xl font-fantasy-header text-amber-500 glow-text-gold tracking-widest uppercase">Quest Board</h1>
        <p class="text-sm font-fantasy text-purple-400 mt-2">PINNED COMMISSIONS FROM ALL REALMS & DISTRICTS</p>
    </div>

    <!-- Filter scrolls / Forms -->
    <form action="{{ route('public.quests') }}" method="GET" class="glass-panel p-6 rounded-2xl border border-purple-900/30 grid grid-cols-1 md:grid-cols-4 gap-4 items-end shadow-md">
        <!-- Search input -->
        <div class="md:col-span-2 flex flex-col space-y-1.5">
            <label for="search" class="text-xs font-fantasy text-amber-500 uppercase tracking-wider">Search Scrolls</label>
            <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Search by quest name or key terms..." class="bg-[#090a0f] border border-purple-900/50 focus:border-amber-500 focus:ring-0 text-slate-200 rounded-xl px-4 py-2.5 text-sm transition">
        </div>

        <!-- Difficulty select -->
        <div class="flex flex-col space-y-1.5">
            <label for="difficulty" class="text-xs font-fantasy text-amber-500 uppercase tracking-wider">Quest Rank</label>
            <select name="difficulty" id="difficulty" class="bg-[#090a0f] border border-purple-900/50 focus:border-amber-500 focus:ring-0 text-slate-200 rounded-xl px-4 py-2.5 text-sm transition font-fantasy">
                <option value="">All Ranks</option>
                @foreach($difficulties as $diff)
                    <option value="{{ $diff }}" {{ request('difficulty') === $diff ? 'selected' : '' }}>Rank {{ $diff }}</option>
                @endforeach
            </select>
        </div>

        <!-- Submit filter -->
        <div>
            <button type="submit" class="w-full bg-purple-900/80 hover:bg-purple-800 text-purple-200 hover:text-white font-bold py-2.5 rounded-xl border border-purple-500/30 transition text-sm flex items-center justify-center space-x-1.5 shadow-sm">
                <span>🔍 Filter Board</span>
            </button>
        </div>
    </form>

    <!-- Quests list -->
    <div class="space-y-4">
        @forelse($quests as $quest)
            <div class="glass-panel rounded-2xl p-6 border border-purple-900/20 hover:border-purple-500/30 transition shadow-sm hover:shadow-[0_0_15px_rgba(139,92,246,0.06)] flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                <!-- Info Section -->
                <div class="space-y-3 flex-grow">
                    <div class="flex items-center space-x-2 flex-wrap gap-1">
                        <span class="text-xs font-bold px-2 py-0.5 rounded-md font-fantasy {{ $quest->getDifficultyClasses() }}">
                            Rank {{ $quest->difficulty }}
                        </span>
                        <span class="text-xs font-bold px-2 py-0.5 rounded-md font-fantasy {{ $quest->getStatusClasses() }}">
                            {{ $quest->getReadableStatus() }}
                        </span>
                        @if($quest->deadline)
                            <span class="text-[11px] text-slate-500 flex items-center space-x-1">
                                <span>⌛ Deadline:</span>
                                <span>{{ $quest->deadline->format('M d, Y H:i') }}</span>
                            </span>
                        @endif
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-slate-100">{{ $quest->title }}</h2>
                        <p class="text-slate-400 text-sm mt-2 leading-relaxed max-w-3xl whitespace-pre-line">{{ $quest->description }}</p>
                    </div>
                </div>

                <!-- Reward / Action section -->
                <div class="flex flex-col sm:flex-row lg:flex-col lg:items-end justify-between items-start sm:items-center lg:justify-center border-t border-purple-950/20 lg:border-t-0 pt-4 lg:pt-0 gap-4 min-w-[200px]">
                    <div class="lg:text-right">
                        <span class="block text-[10px] text-slate-500 uppercase tracking-wider">Reward Chest</span>
                        <span class="text-lg font-bold text-amber-400 font-fantasy block">{{ $quest->reward }}</span>
                        <span class="text-xs text-purple-400 block font-fantasy">+{{ $quest->getExpReward() }} EXP</span>
                    </div>

                    <div class="w-full sm:w-auto">
                        @auth
                            @if(auth()->user()->role === 'member')
                                @if($quest->status === 'available')
                                    <form action="{{ route('member.quests.claim', $quest->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full sm:w-auto bg-gradient-to-r from-purple-700 to-indigo-800 hover:from-purple-600 hover:to-indigo-700 text-white px-5 py-2.5 rounded-xl font-bold transition text-xs flex items-center justify-center space-x-1 shadow-md border border-purple-500/20">
                                            <span>⚔️ Claim Quest</span>
                                        </button>
                                    </form>
                                @else
                                    <button disabled class="w-full sm:w-auto bg-slate-900 border border-slate-800/80 text-slate-600 px-5 py-2.5 rounded-xl text-xs font-semibold cursor-not-allowed">
                                        Claimed / Active
                                    </button>
                                @endif
                            @else
                                <span class="text-xs text-amber-500 font-fantasy uppercase tracking-wider">Staff Roster Restricted</span>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="w-full sm:w-auto block text-center bg-slate-900/60 hover:bg-slate-900 border border-purple-900/40 hover:border-purple-500/30 text-purple-300 px-5 py-2.5 rounded-xl font-bold transition text-xs">
                                🔒 Sign In to Claim
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        @empty
            <div class="glass-panel rounded-2xl p-12 text-center text-slate-500 border border-dashed border-purple-900/30">
                <span class="text-4xl">🏜️</span>
                <h3 class="text-lg font-fantasy text-slate-400 mt-3 font-bold">No Scrolls Found</h3>
                <p class="text-sm mt-1 max-w-md mx-auto">No quest commissions match your filtering. Alter your filters or write a search scroll!</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $quests->links() }}
    </div>

</div>
@endsection
