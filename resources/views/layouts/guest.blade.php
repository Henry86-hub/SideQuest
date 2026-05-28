<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark h-full bg-[#090a0f]">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SideQuest') }} - Guild Gateway</title>

        <!-- Google Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@700&family=Cinzel:wght@500;700;900&family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

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
            .glow-text-gold {
                text-shadow: 0 0 10px rgba(245, 158, 11, 0.4);
            }
            .glass-panel {
                background: rgba(21, 23, 30, 0.85);
                backdrop-filter: blur(12px);
                -webkit-backdrop-filter: blur(12px);
                border: 1px solid rgba(139, 92, 246, 0.15);
            }
        </style>
    </head>
    <body class="min-h-screen flex flex-col justify-center items-center p-4 antialiased text-slate-200">
        <div class="w-full sm:max-w-md flex flex-col items-center">
            
            <!-- Guild Brand Title -->
            <a href="/" class="flex flex-col items-center space-y-1 mb-8 group">
                <span class="text-4xl font-fantasy-header text-amber-500 glow-text-gold tracking-widest transition group-hover:text-amber-400">SideQuest</span>
                <span class="text-xs tracking-[0.2em] font-fantasy text-purple-400 uppercase">Guild Gateway</span>
            </a>

            <!-- Card container -->
            <div class="w-full glass-panel px-8 py-8 shadow-[0_0_30px_rgba(139,92,246,0.1)] overflow-hidden rounded-2xl border border-purple-500/20">
                {{ $slot }}
            </div>
            
            <a href="/" class="text-xs font-fantasy text-purple-400 hover:text-amber-500 transition mt-6">
                ← Return to Guild Board
            </a>
        </div>
    </body>
</html>
