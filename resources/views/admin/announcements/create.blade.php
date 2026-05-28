@extends('layouts.guild')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    
    <!-- Header -->
    <div class="flex items-center space-x-2">
        <a href="{{ route('admin.dashboard') }}" class="text-xs text-purple-400 hover:text-purple-300 transition">← Back to Command Center</a>
    </div>

    <!-- Create Card -->
    <div class="glass-panel p-6 sm:p-8 rounded-2xl border border-purple-500/20 shadow-lg">
        <h2 class="text-xl font-fantasy text-amber-400 border-b border-purple-900/30 pb-2 mb-6">📢 Proclaim Guild Notice</h2>

        <form action="{{ route('admin.announcements.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Title -->
            <div class="space-y-1.5">
                <label for="title" class="block text-xs font-fantasy text-slate-400 uppercase tracking-wider">Notice Proclamation Title</label>
                <input type="text" name="title" id="title" required placeholder="e.g. 🏰 Annual Adventurers Festival!" class="w-full bg-[#090a0f] border border-purple-900/50 focus:border-amber-500 focus:ring-0 text-slate-200 rounded-xl px-4 py-2.5 text-sm transition">
                @error('title')
                    <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- Content -->
            <div class="space-y-1.5">
                <label for="content" class="block text-xs font-fantasy text-slate-400 uppercase tracking-wider">Proclamation Content (Notice Scroll)</label>
                <textarea name="content" id="content" rows="6" required placeholder="Draft the notice content clearly. State schedules, rules, announcements, warnings, or collaborations..." class="w-full bg-[#090a0f] border border-purple-900/50 focus:border-amber-500 focus:ring-0 text-slate-200 rounded-xl px-4 py-2.5 text-sm transition"></textarea>
                @error('content')
                    <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- Action buttons -->
            <div class="flex items-center justify-end space-x-3 border-t border-purple-950/20 pt-4">
                <a href="{{ route('admin.dashboard') }}" class="text-xs text-slate-400 hover:text-slate-200 transition">Cancel</a>
                <button type="submit" class="bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-950 px-6 py-3 rounded-xl text-xs font-bold transition shadow-sm hover:scale-[1.02]">
                    📢 Broadcast Proclamation
                </button>
            </div>

        </form>
    </div>

</div>
@endsection
