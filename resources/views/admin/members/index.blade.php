@extends('layouts.guild')

@section('content')
<div class="space-y-8">
    
    <!-- Header -->
    <div class="flex items-center justify-between border-b border-purple-900/40 pb-4">
        <div>
            <h1 class="text-3xl font-fantasy text-amber-500 font-bold uppercase tracking-wide">Guild Adventurers Roster</h1>
            <p class="text-xs text-purple-400 font-fantasy mt-0.5">MONITOR ADVENTURER PROGRESSIONS & ADJUST MANA DENSITY</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="text-xs text-purple-400 hover:text-purple-300 transition">← Back to Command Center</a>
    </div>

    <!-- Members Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @foreach($members as $member)
            <div class="glass-panel rounded-2xl p-5 border border-purple-900/20 hover:border-purple-500/20 transition flex flex-col justify-between space-y-4 shadow-sm relative overflow-hidden">
                <div class="absolute -top-12 -right-12 w-28 h-28 bg-purple-600/5 rounded-full blur-2xl pointer-events-none"></div>

                <!-- Profile header card -->
                <div class="flex items-start justify-between">
                    <div class="flex items-center space-x-3.5">
                        <div class="relative">
                            <img class="h-12 w-12 rounded-xl border border-purple-500 shadow-md" src="{{ $member->getAvatarUrl() }}" alt="Avatar">
                            @if($member->role === 'member')
                                <span class="absolute -bottom-1.5 -right-1.5 bg-amber-500 text-[#090a0f] text-[9px] font-bold px-1.5 py-0.5 rounded-md border border-amber-300 font-fantasy">Lvl {{ $member->level }}</span>
                            @endif
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-slate-100">{{ $member->name }}</h3>
                            <span class="text-[10px] text-amber-500 font-fantasy uppercase tracking-widest font-bold">{{ $member->getRankName() }}</span>
                        </div>
                    </div>

                    <!-- Role Badge -->
                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-md font-fantasy uppercase
                        @if($member->isAdmin()) bg-amber-500/10 text-amber-400 border border-amber-500/30
                        @elseif($member->isOfficer()) bg-purple-500/10 text-purple-400 border border-purple-500/30
                        @else bg-slate-800 text-slate-400 border border-slate-700/50
                        @endif">
                        {{ $member->role }}
                    </span>
                </div>

                <!-- EXP Stats -->
                @if($member->role === 'member')
                    <div class="space-y-1">
                        <div class="flex justify-between text-[10px] text-slate-500 font-fantasy font-semibold">
                            <span>EXP REGISTRY</span>
                            <span>{{ $member->exp }} / {{ $member->nextLevelExp() }} EXP</span>
                        </div>
                        <div class="w-full bg-[#090a0f] border border-purple-950/20 rounded-full h-2 overflow-hidden shadow-inner">
                            <div class="bg-gradient-to-r from-purple-700 to-indigo-600 h-full rounded-full" style="width: {{ ($member->exp / $member->nextLevelExp()) * 100 }}%"></div>
                        </div>
                    </div>
                @else
                    <div class="text-[11px] text-slate-500 italic font-fantasy">
                        Staff Members are exempt from EXP limits.
                    </div>
                @endif

                <!-- Adjust form section -->
                <div x-data="{ open: false }" class="border-t border-purple-950/20 pt-3">
                    <button @click="open = !open" class="text-[10px] font-bold text-purple-400 hover:text-purple-300 uppercase tracking-wider flex items-center space-x-1 select-none">
                        <span>🔮</span>
                        <span x-text="open ? 'Close Stat Panel' : 'Adjust Mana Flow (Adjust Stats)'"></span>
                    </button>

                    <div x-show="open" x-collapse x-cloak class="mt-3 bg-[#090a0f] border border-purple-900/40 p-4 rounded-xl shadow-inner">
                        <form action="{{ route('admin.members.adjust', $member->id) }}" method="POST" class="space-y-4">
                            @csrf
                            
                            <div class="grid grid-cols-2 gap-3">
                                <!-- Level -->
                                <div class="space-y-1">
                                    <label class="text-[9px] font-fantasy text-slate-500 uppercase tracking-widest block">Character Level</label>
                                    <input type="number" name="level" value="{{ $member->level }}" required min="1" max="100" class="w-full bg-[#06070a] border border-purple-900/40 focus:border-amber-500 focus:ring-0 text-slate-200 rounded-lg px-2.5 py-1.5 text-xs transition">
                                </div>

                                <!-- EXP -->
                                <div class="space-y-1">
                                    <label class="text-[9px] font-fantasy text-slate-500 uppercase tracking-widest block">Aetheric EXP</label>
                                    <input type="number" name="exp" value="{{ $member->exp }}" required min="0" class="w-full bg-[#06070a] border border-purple-900/40 focus:border-amber-500 focus:ring-0 text-slate-200 rounded-lg px-2.5 py-1.5 text-xs transition">
                                </div>
                            </div>

                            <!-- Role -->
                            <div class="space-y-1">
                                <label class="text-[9px] font-fantasy text-slate-500 uppercase tracking-widest block">Guild Role</label>
                                <select name="role" class="w-full bg-[#06070a] border border-purple-900/40 focus:border-amber-500 focus:ring-0 text-slate-200 rounded-lg px-2.5 py-1.5 text-xs transition font-fantasy">
                                    <option value="member" {{ $member->role === 'member' ? 'selected' : '' }}>Member (Adventurer)</option>
                                    <option value="officer" {{ $member->role === 'officer' ? 'selected' : '' }}>Officer (Staff)</option>
                                    <option value="admin" {{ $member->role === 'admin' ? 'selected' : '' }}>Admin (Guild Master)</option>
                                </select>
                            </div>

                            <!-- Submit -->
                            <div class="flex justify-end pt-2">
                                <button type="submit" class="bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-950 font-bold px-4 py-2 rounded-lg text-[10px] transition uppercase tracking-wider">
                                    Apply Calibration
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        @endforeach
    </div>

</div>
@endsection
