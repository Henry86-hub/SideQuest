@extends('layouts.guild')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    
    <!-- Header -->
    <div class="flex items-center space-x-2">
        <a href="{{ route('member.dashboard') }}" class="text-xs text-purple-400 hover:text-purple-300 transition">← Back to Character Sheet</a>
    </div>

    <!-- Quest summary -->
    <div class="glass-panel p-6 rounded-2xl border border-purple-900/30">
        <div class="flex items-center space-x-2">
            <span class="text-xs font-bold px-2 py-0.5 rounded-md font-fantasy {{ $quest->getDifficultyClasses() }}">
                Rank {{ $quest->difficulty }}
            </span>
            <span class="text-xs text-amber-500 font-fantasy font-bold">Target Contract</span>
        </div>
        <h2 class="text-xl sm:text-2xl font-fantasy text-slate-100 font-bold mt-2">{{ $quest->title }}</h2>
        <p class="text-xs text-slate-400 mt-2 leading-relaxed whitespace-pre-line border-t border-purple-950/20 pt-3">{{ $quest->description }}</p>
        
        <div class="flex justify-between items-center mt-4 border-t border-purple-950/20 pt-3">
            <div>
                <span class="text-[10px] text-slate-500 block uppercase tracking-wider">Reward Chest</span>
                <span class="text-sm font-bold text-amber-400 font-fantasy">{{ $quest->reward }}</span>
            </div>
            <div class="text-right">
                <span class="text-[10px] text-slate-500 block uppercase tracking-wider font-fantasy">EXP Value</span>
                <span class="text-sm font-bold text-purple-400 font-fantasy">+{{ $quest->getExpReward() }} EXP</span>
            </div>
        </div>
    </div>

    <!-- Submission Form -->
    <div class="glass-panel p-6 rounded-2xl border border-purple-500/20 shadow-lg">
        <h3 class="text-lg font-fantasy text-amber-400 border-b border-purple-900/30 pb-2 mb-4">🏆 Submit Quest Proof</h3>

        <form action="{{ route('member.quests.submit', $quest->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- File Upload -->
            <div class="space-y-2">
                <label for="file" class="block text-xs font-fantasy text-slate-400 uppercase tracking-wider">Proof Artifact (Image, PDF, or ZIP/RAR)</label>
                <div class="relative bg-[#090a0f] border border-purple-900/50 hover:border-purple-500/50 transition rounded-xl p-4 flex flex-col items-center justify-center text-center cursor-pointer group">
                    <input type="file" name="file" id="file" required class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                    <span class="text-3xl group-hover:scale-110 transition">📤</span>
                    <span class="text-xs font-bold text-purple-300 mt-2 block">Choose file scroll or drag here</span>
                    <span class="text-[10px] text-slate-500 mt-1 block">JPG, PNG, PDF, ZIP or RAR (Max 10MB)</span>
                </div>
                @error('file')
                    <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- Notes -->
            <div class="space-y-2">
                <label for="note" class="block text-xs font-fantasy text-slate-400 uppercase tracking-wider">Adventure Log Notes</label>
                <textarea name="note" id="note" rows="5" placeholder="Document how you resolved the quest contract, describe your findings, or leave notes for the review officer..." class="w-full bg-[#090a0f] border border-purple-900/50 focus:border-amber-500 focus:ring-0 text-slate-200 rounded-xl px-4 py-2.5 text-sm transition"></textarea>
                @error('note')
                    <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- Action buttons -->
            <div class="flex items-center justify-end space-x-3 border-t border-purple-950/20 pt-4">
                <a href="{{ route('member.dashboard') }}" class="text-xs text-slate-400 hover:text-slate-200 transition">Cancel</a>
                <button type="submit" class="bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-950 px-6 py-3 rounded-xl text-xs font-bold transition shadow-sm hover:scale-[1.02]">
                    📜 Submit Quest Log
                </button>
            </div>

        </form>
    </div>

</div>
@endsection
