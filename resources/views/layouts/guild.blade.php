<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark h-full bg-[#090a0f]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SideQuest') }} - RPG Adventurers Guild</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@700&family=Cinzel:wght@500;700;900&family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind & Vite Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Inline Styles for Custom RPG Glows -->
    <style>
        .font-fantasy-header {
            font-family: 'Cinzel Decorative', cursive, serif;
        }
        .font-fantasy {
            font-family: 'Cinzel', serif;
        }
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #090a0f;
            background-image: 
                radial-gradient(at 0% 0%, rgba(88, 28, 135, 0.15) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(217, 119, 6, 0.08) 0px, transparent 50%);
        }
        .medieval-border {
            border: 2px solid;
            border-image: linear-gradient(to right, #4c1d95, #d97706, #4c1d95) 1;
        }
        .glow-purple {
            box-shadow: 0 0 20px rgba(168, 85, 247, 0.25);
        }
        .glow-gold {
            box-shadow: 0 0 20px rgba(245, 158, 11, 0.2);
        }
        .glow-text-gold {
            text-shadow: 0 0 10px rgba(245, 158, 11, 0.4);
        }
        .glass-panel {
            background: rgba(21, 23, 30, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(139, 92, 246, 0.15);
        }
        /* Custom scrollbar for RPG immersion */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #090a0f;
        }
        ::-webkit-scrollbar-thumb {
            background: #4c1d95;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #d97706;
        }
    </style>
</head>
<body class="min-h-full flex flex-col text-slate-200 antialiased">
    <!-- Header Navigation -->
    <header class="sticky top-0 z-50 glass-panel border-b border-purple-900/30 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Brand / Logo -->
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                        <span class="text-3xl font-fantasy-header text-amber-500 glow-text-gold tracking-widest transition group-hover:text-amber-400">SideQuest</span>
                        <div class="hidden sm:flex flex-col">
                            <span class="text-xs tracking-[0.2em] font-fantasy text-purple-400 uppercase">Adventurers Guild</span>
                        </div>
                    </a>
                </div>

                <!-- Navigation Links -->
                <nav class="hidden md:flex space-x-6">
                    <a href="{{ route('home') }}" class="text-sm font-medium transition hover:text-amber-400 {{ request()->routeIs('home') ? 'text-amber-500 font-bold border-b-2 border-amber-500 pb-1' : 'text-slate-300' }}">Home</a>
                    <a href="{{ route('public.quests') }}" class="text-sm font-medium transition hover:text-amber-400 {{ request()->routeIs('public.quests') ? 'text-amber-500 font-bold border-b-2 border-amber-500 pb-1' : 'text-slate-300' }}">Quest Board</a>
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-sm font-medium transition hover:text-amber-400 {{ request()->routeIs('dashboard') || request()->routeIs('member.dashboard') || request()->routeIs('admin.dashboard') ? 'text-amber-500 font-bold border-b-2 border-amber-500 pb-1' : 'text-slate-300' }}">Dashboard</a>
                        @if(auth()->user()->isAdmin() || auth()->user()->isOfficer())
                            <a href="{{ route('admin.members') }}" class="text-sm font-medium transition hover:text-amber-400 {{ request()->routeIs('admin.members') ? 'text-amber-500 font-bold border-b-2 border-amber-500 pb-1' : 'text-slate-300' }}">Members Roster</a>
                        @endif
                    @endauth
                </nav>

                <!-- Auth Buttons / User Profile -->
                <div class="flex items-center space-x-4">
                    @auth
                        <div class="flex items-center space-x-3">
                            <!-- Character Plate -->
                            <div class="hidden sm:flex flex-col text-right">
                                <span class="text-sm font-bold text-slate-200">{{ auth()->user()->name }}</span>
                                <span class="text-xs text-amber-500 font-fantasy uppercase tracking-wider">{{ auth()->user()->getRankName() }}</span>
                            </div>
                            <a href="{{ auth()->user()->role === 'member' ? route('member.profile') : '#' }}" class="relative group">
                                <img class="h-10 w-10 rounded-xl border border-purple-500 shadow-md group-hover:border-amber-400 transition" src="{{ auth()->user()->getAvatarUrl() }}" alt="Avatar">
                                @if(auth()->user()->role === 'member')
                                    <span class="absolute -bottom-1 -right-1 bg-amber-500 text-[#090a0f] text-[10px] font-bold px-1 rounded-md border border-amber-300">Lvl {{ auth()->user()->level }}</span>
                                @endif
                            </a>
                        </div>
                        
                        <!-- Logout Action -->
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-xs font-semibold text-slate-400 hover:text-red-400 border border-slate-700/50 hover:border-red-900/50 bg-slate-900/50 hover:bg-red-950/20 px-3 py-2 rounded-xl transition">
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-300 hover:text-amber-400 transition">Sign In</a>
                        <a href="{{ route('register') }}" class="text-sm font-semibold bg-gradient-to-r from-purple-700 to-indigo-800 hover:from-purple-600 hover:to-indigo-700 text-white px-5 py-2.5 rounded-xl transition shadow-[0_0_15px_rgba(109,40,217,0.3)] hover:shadow-[0_0_20px_rgba(109,40,217,0.5)] border border-purple-500/25">Join Guild</a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="flex-grow max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Status Messages -->
        @if (session('success'))
            <div class="mb-6 glass-panel border border-emerald-500/30 text-emerald-400 p-4 rounded-xl shadow-lg flex items-center space-x-3 animate-fade-in">
                <span class="text-xl">✨</span>
                <span class="text-sm font-medium">{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 glass-panel border border-rose-500/30 text-rose-400 p-4 rounded-xl shadow-lg flex items-center space-x-3 animate-fade-in">
                <span class="text-xl">⚠️</span>
                <span class="text-sm font-medium">{{ session('error') }}</span>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="mt-auto border-t border-purple-950/40 bg-[#06070a] py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between space-y-4 md:space-y-0 text-slate-500 text-xs">
            <div class="flex items-center space-x-2">
                <span class="text-amber-500 font-fantasy-header text-sm">SideQuest</span>
                <span>© 2026 Adventurers Guild. Crafted for high-tier campaigns.</span>
            </div>
            <div class="flex space-x-4">
                <span class="text-slate-600">Client Inquiries:</span>
                <a href="https://wa.me/{{ env('WHATSAPP_NUMBER', '6281234567890') }}" target="_blank" class="text-amber-500 hover:underline flex items-center space-x-1 font-bold">
                    <span>💬 Request via WhatsApp</span>
                </a>
            </div>
        </div>
    </footer>
</body>
</html>
