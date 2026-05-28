@extends('layouts.guild')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    
    <!-- Header -->
    <div class="flex items-center space-x-2">
        <a href="{{ route('admin.dashboard') }}" class="text-xs text-purple-400 hover:text-purple-300 transition">← Back to Command Center</a>
    </div>

    <!-- Create Card -->
    <div class="glass-panel p-6 sm:p-8 rounded-2xl border border-purple-500/20 shadow-lg">
        <h2 class="text-xl font-fantasy text-amber-400 border-b border-purple-900/30 pb-2 mb-6">📜 Draft New Quest Scroll</h2>

        <form action="{{ route('admin.quests.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Title -->
            <div class="space-y-1.5">
                <label for="title" class="block text-xs font-fantasy text-slate-400 uppercase tracking-wider">Quest Commission Title</label>
                <input type="text" name="title" id="title" required placeholder="e.g. Cleansing the Old Mill Ruins" class="w-full bg-[#090a0f] border border-purple-900/50 focus:border-amber-500 focus:ring-0 text-slate-200 rounded-xl px-4 py-2.5 text-sm transition">
                @error('title')
                    <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- Description -->
            <div class="space-y-1.5">
                <label for="description" class="block text-xs font-fantasy text-slate-400 uppercase tracking-wider">Scroll Description (Intake Contract Details)</label>
                <textarea name="description" id="description" rows="6" required placeholder="Describe the threat, location, and key requirements. State weak spots, potential dangers, and exact items required to be retrieved..." class="w-full bg-[#090a0f] border border-purple-900/50 focus:border-amber-500 focus:ring-0 text-slate-200 rounded-xl px-4 py-2.5 text-sm transition"></textarea>
                @error('description')
                    <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Reward -->
                <div class="space-y-1.5">
                    <label for="reward" class="block text-xs font-fantasy text-slate-400 uppercase tracking-wider">Reward Chest Loot</label>
                    <input type="text" name="reward" id="reward" required placeholder="e.g. 500 Gold Coins & 1x Health Potion" class="w-full bg-[#090a0f] border border-purple-900/50 focus:border-amber-500 focus:ring-0 text-slate-200 rounded-xl px-4 py-2.5 text-sm transition">
                    @error('reward')
                        <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Difficulty Select -->
                <div class="space-y-1.5">
                    <label for="difficulty" class="block text-xs font-fantasy text-slate-400 uppercase tracking-wider">Danger Rank (Difficulty)</label>
                    <select name="difficulty" id="difficulty" required class="w-full bg-[#090a0f] border border-purple-900/50 focus:border-amber-500 focus:ring-0 text-slate-200 rounded-xl px-4 py-2.5 text-sm transition font-fantasy">
                        @foreach($difficulties as $diff)
                            <option value="{{ $diff }}">Rank {{ $diff }} (EXP Value: 
                                @if($diff == 'F') 20
                                @elseif($diff == 'E') 40
                                @elseif($diff == 'D') 80
                                @elseif($diff == 'C') 150
                                @elseif($diff == 'B') 300
                                @elseif($diff == 'A') 600
                                @elseif($diff == 'S') 1200
                                @endif EXP)
                            </option>
                        @endforeach
                    </select>
                    @error('difficulty')
                        <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Deadline -->
            <div class="space-y-1.5">
                <label for="deadline" class="block text-xs font-fantasy text-slate-400 uppercase tracking-wider">Contract Deadline Time</label>
                <input type="datetime-local" name="deadline" id="deadline" class="w-full bg-[#090a0f] border border-purple-900/50 focus:border-amber-500 focus:ring-0 text-slate-200 rounded-xl px-4 py-2.5 text-sm transition">
                @error('deadline')
                    <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- Action buttons -->
            <div class="flex items-center justify-end space-x-3 border-t border-purple-950/20 pt-4">
                <a href="{{ route('admin.dashboard') }}" class="text-xs text-slate-400 hover:text-slate-200 transition">Cancel</a>
                <button type="submit" class="bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-950 px-6 py-3 rounded-xl text-xs font-bold transition shadow-sm hover:scale-[1.02]">
                    📜 Pin to Quest Board
                </button>
            </div>

        </form>
    </div>

</div>
@endsection
