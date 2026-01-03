<!doctype html>
<html lang="en" class="antialiased scroll-smooth">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Student Portal - @yield('title', 'Athlentry')</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root { --brand: #0D9488; --brand-dark: #0F766E; }
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: #f8fafc;
            color: #0f172a;
        }

        .glass-student {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(13, 148, 136, 0.1);
        }

        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }

        .nav-active {
            background: var(--brand);
            color: white !important;
            box-shadow: 0 10px 15px -3px rgba(13, 148, 136, 0.2);
        }

        .animate-fade-in {
            animation: fadeIn 0.4s ease-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>

<body class="min-h-screen overflow-hidden">

<div class="flex h-screen overflow-hidden">

    {{-- SIDEBAR --}}
    <aside class="hidden md:flex flex-col w-72 bg-white border-r border-teal-50 shadow-sm">

        {{-- LOGO --}}
        <div class="p-8">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-teal-600 rounded-xl flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                              d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <h1 class="text-xl font-extrabold italic uppercase text-teal-950">
                    ATHLE<span class="text-teal-600 not-italic">NTRY</span>
                </h1>
            </div>
        </div>

        {{-- NAV --}}
        <nav class="flex-1 px-6 space-y-2">
            <p class="px-2 text-[10px] font-black uppercase tracking-[0.2em] text-teal-400 mb-4">
                Athlete Menu
            </p>

            @php
                $navItems = [
                    ['route' => 'student.announcements.index', 'label' => 'Homepage'],
                    ['route' => 'student.gameinfo.index', 'label' => 'Game Information'],
                    ['route' => 'student.application.index', 'label' => 'Apply'],

                ];
            @endphp

            @foreach($navItems as $item)
                <a href="{{ route($item['route']) }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all
                   {{ request()->routeIs($item['route']) ? 'nav-active' : 'text-slate-500 hover:bg-teal-50 hover:text-teal-700' }}">
                    <span class="text-sm font-bold">{{ $item['label'] }}</span>
                </a>
            @endforeach
        </nav>

        {{-- ✅ PROFILE LINK (FIXED) --}}
        <div class="p-6">
            <a href="{{ route('student.profile.show') }}"
               class="block p-4 bg-teal-50/50 rounded-3xl border border-teal-100 flex items-center gap-3 group hover:bg-teal-100 transition-all">

                <div class="w-10 h-10 rounded-full bg-teal-600 text-white
                            flex items-center justify-center font-black text-sm
                            group-hover:rotate-12 transition-transform">
                    {{ strtoupper(substr(Auth::user()->Name ?? 'S', 0, 1)) }}
                </div>

                <div class="min-w-0 flex-1">
                    <p class="text-sm font-black text-teal-950 truncate">
                        {{ Auth::user()->Name ?? 'Student' }}
                    </p>
                    <p class="text-[10px] text-teal-600 uppercase font-bold tracking-widest">
                        Athlete Profile
                    </p>
                </div>

                <svg class="w-4 h-4 text-teal-400 group-hover:translate-x-1 transition-transform"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>
    </aside>

    {{-- MAIN --}}
    <main class="flex-1 flex flex-col min-w-0 bg-[#fdfdfd]">

        {{-- HEADER --}}
        <header class="h-20 flex items-center justify-between px-8">
            <h2 class="font-black uppercase tracking-widest text-teal-600 text-sm">
                Student Dashboard
            </h2>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                        class="px-6 py-2 rounded-2xl bg-teal-50 text-teal-700
                               text-xs font-black uppercase tracking-widest
                               hover:bg-teal-600 hover:text-white transition">
                    Sign Out
                </button>
            </form>
        </header>

        {{-- CONTENT --}}
        <div class="flex-1 overflow-y-auto p-8 animate-fade-in">
            <div class="max-w-7xl mx-auto">
                @yield('content')
            </div>

            <footer class="mt-20 py-10 border-t border-teal-50 text-center">
                <p class="text-[10px] font-black uppercase tracking-[0.3em] text-teal-300">
                    © {{ date('Y') }} Athlentry Student Studio
                </p>
            </footer>
        </div>
    </main>
</div>

</body>
</html>
