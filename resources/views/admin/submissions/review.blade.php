@extends('layouts.guild')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    
    <!-- Header -->
    <div class="flex items-center space-x-2">
        <a href="{{ route('admin.dashboard') }}" class="text-xs text-purple-400 hover:text-purple-300 transition">← Back to Command Center</a>
    </div>

    <!-- Review Arena Layout -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        
        <!-- Left Side: Quest Details & Submission Notes -->
        <div class="md:col-span-2 space-y-6">
            
            <!-- Quest Details -->
            <div class="glass-panel p-5 rounded-2xl border border-purple-900/30">
                <span class="text-[10px] font-bold px-2 py-0.5 rounded-md font-fantasy {{ $submission->quest->getDifficultyClasses() }}">
                    Rank {{ $submission->quest->difficulty }}
                </span>
                <h3 class="text-lg font-bold text-slate-100 mt-2">{{ $submission->quest->title }}</h3>
                <p class="text-xs text-slate-400 mt-2 leading-relaxed whitespace-pre-line border-t border-purple-950/20 pt-3">{{ $submission->quest->description }}</p>
                
                <div class="flex justify-between items-center mt-4 border-t border-purple-950/20 pt-3">
                    <div>
                        <span class="text-[9px] text-slate-500 block uppercase">Reward Chest</span>
                        <span class="text-xs font-bold text-amber-400 font-fantasy">{{ $submission->quest->reward }}</span>
                    </div>
                    <div class="text-right">
                        <span class="text-[9px] text-slate-500 block uppercase font-fantasy">EXP Value</span>
                        <span class="text-xs font-bold text-purple-400 font-fantasy">+{{ $submission->quest->getExpReward() }} EXP</span>
                    </div>
                </div>
            </div>

            <!-- Submission notes and logs -->
            <div class="glass-panel p-6 rounded-2xl border border-purple-500/20 space-y-4">
                <div class="flex items-center space-x-3 pb-3 border-b border-purple-950/20">
                    <img class="h-10 w-10 rounded-xl border border-purple-500 shadow-md" src="{{ $submission->user->getAvatarUrl() }}" alt="Avatar">
                    <div>
                        <h4 class="text-sm font-bold text-slate-200">{{ $submission->user->name }}</h4>
                        <span class="text-[10px] text-amber-500 font-fantasy uppercase tracking-wider font-semibold">Lvl {{ $submission->user->level }} • {{ $submission->user->getRankName() }}</span>
                    </div>
                </div>

                <div class="space-y-2">
                    <span class="block text-[10px] text-slate-500 uppercase tracking-wider font-fantasy">Adventure Log Entry Notes</span>
                    <div class="bg-[#090a0f] border border-purple-900/30 p-4 rounded-xl text-sm text-slate-300 leading-relaxed whitespace-pre-line">
                        {{ $submission->note ?: 'No notes documented by the adventurer.' }}
                    </div>
                </div>

                <!-- Proof File Preview -->
                <div class="space-y-2">
                    <span class="block text-[10px] text-slate-500 uppercase tracking-wider font-fantasy">Artifact Proof File</span>
                    
                    @php
                        $fileExtension = strtolower(pathinfo($submission->file, PATHINFO_EXTENSION));
                        $isImage = in_array($fileExtension, ['jpg', 'jpeg', 'png']);
                    @endphp

                    @if($isImage)
                        <div class="relative bg-[#090a0f] border border-purple-900/30 rounded-xl overflow-hidden shadow-inner flex items-center justify-center p-2">
                            <img class="max-w-full h-auto rounded-lg max-h-[350px] object-contain border border-purple-950/40 shadow-md" src="{{ asset('storage/' . $submission->file) }}" alt="Submission proof">
                        </div>
                    @endif

                    <div class="pt-2">
                        <a href="{{ asset('storage/' . $submission->file) }}" target="_blank" class="inline-flex items-center space-x-2 bg-purple-950/50 hover:bg-purple-900/40 border border-purple-900/50 hover:border-purple-500/50 px-4 py-2.5 rounded-xl text-xs font-bold text-purple-300 transition shadow-sm w-full sm:w-auto justify-center">
                            <span>📥 Download Artifact Proof</span>
                            <span class="text-[10px] text-slate-500 font-fantasy">({{ strtoupper($fileExtension) }})</span>
                        </a>
                    </div>
                </div>
            </div>

        </div>

        <!-- Right Side: Officer Judgement Actions -->
        <div class="space-y-6">
            
            <div class="glass-panel p-6 rounded-2xl border border-purple-500/20 space-y-6 shadow-md relative overflow-hidden">
                <div class="absolute -top-12 -right-12 w-32 h-32 bg-amber-500/5 rounded-full blur-2xl pointer-events-none"></div>
                <h3 class="text-base font-fantasy text-amber-500 border-b border-purple-900/30 pb-2 flex items-center space-x-1.5 uppercase font-bold tracking-wider">
                    <span>⚖️</span>
                    <span>Officer Judgement</span>
                </h3>

                <!-- Approval Form -->
                <form action="{{ route('admin.submissions.approve', $submission->id) }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="approve_feedback" class="block text-[10px] text-slate-500 uppercase tracking-wider font-fantasy mb-1.5">Congratulatory Log Note (Optional)</label>
                        <textarea name="feedback" id="approve_feedback" rows="3" placeholder="Leave words of encouragement or praise for completing the mission..." class="w-full bg-[#090a0f] border border-purple-900/50 focus:border-amber-500 focus:ring-0 text-slate-200 rounded-xl px-3 py-2 text-xs transition"></textarea>
                    </div>
                    <button type="submit" class="w-full bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-950 font-bold py-3 rounded-xl text-xs transition shadow-[0_0_15px_rgba(245,158,11,0.2)] hover:scale-[1.01] uppercase tracking-wide">
                        🏆 Approve & Reward EXP
                    </button>
                </form>

                <div class="border-t border-purple-950/30 my-4"></div>

                <!-- Rejection / Revision Form -->
                <form action="{{ route('admin.submissions.reject', $submission->id) }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-[10px] text-slate-500 uppercase tracking-wider font-fantasy mb-1.5">Judgement Type</label>
                        <div class="grid grid-cols-2 gap-2">
                            <label class="flex items-center justify-center p-2 border border-purple-900/50 bg-[#090a0f] rounded-xl text-xs text-slate-400 cursor-pointer select-none group hover:border-purple-500 transition">
                                <input type="radio" name="action_type" value="revision" checked class="mr-1.5 accent-purple-500 focus:ring-0">
                                <span>Request Revision</span>
                            </label>
                            <label class="flex items-center justify-center p-2 border border-purple-900/50 bg-[#090a0f] rounded-xl text-xs text-slate-400 cursor-pointer select-none group hover:border-rose-500 transition">
                                <input type="radio" name="action_type" value="reject" class="mr-1.5 accent-rose-500 focus:ring-0">
                                <span>Reject Proof</span>
                            </label>
                        </div>
                    </div>

                    <div>
                        <label for="reject_feedback" class="block text-[10px] text-slate-500 uppercase tracking-wider font-fantasy mb-1.5">Judgement Notes (Required)</label>
                        <textarea name="feedback" id="reject_feedback" required rows="3" placeholder="Provide clear instructions on why this is rejected or what changes are required for the revision scroll..." class="w-full bg-[#090a0f] border border-purple-900/50 focus:border-rose-500 focus:ring-0 text-slate-200 rounded-xl px-3 py-2 text-xs transition"></textarea>
                    </div>

                    <button type="submit" class="w-full bg-slate-900 hover:bg-rose-950/20 hover:text-rose-400 border border-slate-800 hover:border-rose-900 py-3 rounded-xl text-xs font-bold transition text-slate-400 uppercase tracking-wide">
                        ⚖️ Issue Demurral
                    </button>
                </form>

            </div>

        </div>

    </div>

</div>
@endsection
