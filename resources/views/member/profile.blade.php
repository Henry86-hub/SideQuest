@extends('layouts.guild')

@section('content')
<div class="max-w-xl mx-auto space-y-6">
    
    <!-- Header -->
    <div class="flex items-center space-x-2">
        <a href="{{ route('member.dashboard') }}" class="text-xs text-purple-400 hover:text-purple-300 transition">← Back to Character Sheet</a>
    </div>

    <!-- Edit Profile Card -->
    <div class="glass-panel p-6 sm:p-8 rounded-2xl border border-purple-500/20 shadow-lg">
        <h2 class="text-xl font-fantasy text-amber-400 border-b border-purple-900/30 pb-2 mb-6">🔮 Update Adventurer Scroll</h2>

        <form action="{{ route('member.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Avatar Preview & Input -->
            <div class="flex flex-col sm:flex-row items-center space-y-4 sm:space-y-0 sm:space-x-4 pb-4 border-b border-purple-950/20">
                <div class="relative">
                    <img class="h-16 w-16 rounded-xl border border-amber-500 shadow-md" src="{{ $user->getAvatarUrl() }}" alt="Avatar">
                    <span class="absolute -bottom-1 -right-1 bg-amber-500 text-slate-950 text-[10px] font-bold px-1 rounded-md border border-amber-300">Lvl {{ $user->level }}</span>
                </div>
                <div class="space-y-1">
                    <label for="avatar" class="block text-xs font-fantasy text-slate-400 uppercase tracking-wider">Upload New Avatar Scroll</label>
                    <input type="file" name="avatar" id="avatar" class="block w-full text-xs text-slate-500 file:mr-4 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-purple-950/40 file:text-purple-300 hover:file:bg-purple-900/40 cursor-pointer">
                    <span class="text-[10px] text-slate-500 block">JPG or PNG (Max 2MB)</span>
                    @error('avatar')
                        <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Name -->
            <div class="space-y-1.5">
                <label for="name" class="block text-xs font-fantasy text-slate-400 uppercase tracking-wider">Adventurer Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required class="w-full bg-[#090a0f] border border-purple-900/50 focus:border-amber-500 focus:ring-0 text-slate-200 rounded-xl px-4 py-2.5 text-sm transition">
                @error('name')
                    <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- Email -->
            <div class="space-y-1.5">
                <label for="email" class="block text-xs font-fantasy text-slate-400 uppercase tracking-wider">Aetheric Mail (Email)</label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required class="w-full bg-[#090a0f] border border-purple-900/50 focus:border-amber-500 focus:ring-0 text-slate-200 rounded-xl px-4 py-2.5 text-sm transition">
                @error('email')
                    <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- Action buttons -->
            <div class="flex items-center justify-end space-x-3 border-t border-purple-950/20 pt-4">
                <a href="{{ route('member.dashboard') }}" class="text-xs text-slate-400 hover:text-slate-200 transition">Cancel</a>
                <button type="submit" class="bg-gradient-to-r from-purple-700 to-indigo-800 hover:from-purple-600 hover:to-indigo-700 text-white px-6 py-2.5 rounded-xl text-xs font-bold transition shadow-sm hover:scale-[1.02] border border-purple-500/20">
                    🔮 Save Scroll
                </button>
            </div>

        </form>
    </div>

</div>
@endsection
