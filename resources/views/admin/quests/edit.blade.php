@extends('layouts.guild')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    
    <!-- Header -->
    <div class="flex items-center space-x-2">
        <a href="{{ route('admin.dashboard') }}" class="text-xs text-purple-400 hover:text-purple-300 transition">← Back to Command Center</a>
    </div>

    <!-- Edit Card -->
    <div class="glass-panel p-6 sm:p-8 rounded-2xl border border-purple-500/20 shadow-lg">
        <h2 class="text-xl font-fantasy text-amber-400 border-b border-purple-900/30 pb-2 mb-6">📜 Edit Quest Scroll #{{ $quest->id }}</h2>

        <form action="{{ route('admin.quests.update', $quest->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Title -->
            <div class="space-y-1.5">
                <label for="title" class="block text-xs font-fantasy text-slate-400 uppercase tracking-wider">Quest Commission Title</label>
                <input type="text" name="title" id="title" value="{{ old('title', $quest->title) }}" required class="w-full bg-[#090a0f] border border-purple-900/50 focus:border-amber-500 focus:ring-0 text-slate-200 rounded-xl px-4 py-2.5 text-sm transition">
                @error('title')
                    <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- Description -->
            <div class="space-y-1.5">
                <label for="description" class="block text-xs font-fantasy text-slate-400 uppercase tracking-wider">Scroll Description (Intake Contract Details)</label>
                <textarea name="description" id="description" rows="6" required class="w-full bg-[#090a0f] border border-purple-900/50 focus:border-amber-500 focus:ring-0 text-slate-200 rounded-xl px-4 py-2.5 text-sm transition">{{ old('description', $quest->description) }}</textarea>
                @error('description')
                    <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Reward -->
                <div class="space-y-1.5">
                    <label for="reward" class="block text-xs font-fantasy text-slate-400 uppercase tracking-wider">Reward Chest Loot</label>
                    <input type="text" name="reward" id="reward" value="{{ old('reward', $quest->reward) }}" required class="w-full bg-[#090a0f] border border-purple-900/50 focus:border-amber-500 focus:ring-0 text-slate-200 rounded-xl px-4 py-2.5 text-sm transition">
                    @error('reward')
                        <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Difficulty Select -->
                <div class="space-y-1.5">
                    <label for="difficulty" class="block text-xs font-fantasy text-slate-400 uppercase tracking-wider">Danger Rank (Difficulty)</label>
                    <select name="difficulty" id="difficulty" required class="w-full bg-[#090a0f] border border-purple-900/50 focus:border-amber-500 focus:ring-0 text-slate-200 rounded-xl px-4 py-2.5 text-sm transition font-fantasy">
                        @foreach($difficulties as $diff)
                            <option value="{{ $diff }}" {{ $quest->difficulty === $diff ? 'selected' : '' }}>Rank {{ $diff }}</option>
                        @endforeach
                    </select>
                    @error('difficulty')
                        <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Status Select -->
                <div class="space-y-1.5">
                    <label for="status" class="block text-xs font-fantasy text-slate-400 uppercase tracking-wider">Quest Status State</label>
                    <select name="status" id="status" required class="w-full bg-[#090a0f] border border-purple-900/50 focus:border-amber-500 focus:ring-0 text-slate-200 rounded-xl px-4 py-2.5 text-sm transition font-fantasy">
                        <option value="available" {{ $quest->status === 'available' ? 'selected' : '' }}>Available</option>
                        <option value="claimed" {{ $quest->status === 'claimed' ? 'selected' : '' }}>Claimed</option>
                        <option value="in_progress" {{ $quest->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="under_review" {{ $quest->status === 'under_review' ? 'selected' : '' }}>Under Review</option>
                        <option value="completed" {{ $quest->status === 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                    @error('status')
                        <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Deadline -->
                <div class="space-y-1.5">
                    <label for="deadline" class="block text-xs font-fantasy text-slate-400 uppercase tracking-wider">Contract Deadline Time</label>
                    <input type="datetime-local" name="deadline" id="deadline" value="{{ $quest->deadline ? $quest->deadline->format('Y-m-d\TH:i') : '' }}" class="w-full bg-[#090a0f] border border-purple-900/50 focus:border-amber-500 focus:ring-0 text-slate-200 rounded-xl px-4 py-2.5 text-sm transition">
                    @error('deadline')
                        <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Action buttons -->
            <div class="flex items-center justify-end space-x-3 border-t border-purple-950/20 pt-4">
                <a href="{{ route('admin.dashboard') }}" class="text-xs text-slate-400 hover:text-slate-200 transition">Cancel</a>
                <button type="submit" class="bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-950 px-6 py-3 rounded-xl text-xs font-bold transition shadow-sm hover:scale-[1.02]">
                    📜 Update Quest Scroll
                </button>
            </div>

        </form>
    </div>

</div>
@endsection
