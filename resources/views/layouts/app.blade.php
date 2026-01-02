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
            transition: background-color 0.3s ease;
            background-color: #f8fafc;
            color: #0f172a;
        }

        /* Student Glassmorphism */
        .glass-student {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(13, 148, 136, 0.1);
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }

        .nav-active {
            background: var(--brand);
            color: white !important;
            box-shadow: 0 10px 15px -3px rgba(13, 148, 136, 0.2);
        }
        
        .animate-fade-in { animation: fadeIn 0.4s ease-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</head>
<body class="min-h-screen overflow-hidden">

<div class="flex h-screen overflow-hidden">

    <aside id="sidebar" class="hidden md:flex flex-col w-72 bg-white border-r border-teal-50 shadow-sm transition-all duration-300">
        <div class="p-8">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-teal-600 rounded-xl flex items-center justify-center shadow-lg shadow-teal-900/20">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <h1 class="text-xl font-extrabold tracking-tighter italic uppercase text-teal-950">ATHLE<span class="text-teal-600 not-italic">STUDIO</span></h1>
            </div>
        </div>

        <nav class="flex-1 px-6 space-y-2">
            <p class="px-2 text-[10px] font-black uppercase tracking-[0.2em] text-teal-400 mb-4">Athlete Menu</p>
            
            @php
                $navItems = [
                    ['route' => 'student.announcements.index', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6', 'label' => 'Home Hub'],
                    ['route' => 'student.application.index', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2', 'label' => 'Applications'],
                    ['route' => '#', 'icon' => 'M16 11V7a4 4 0 118 0v4M5 9h14l1 12H4L5 9z', 'label' => 'Game Registry'],
                    ['route' => '#', 'icon' => 'M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h11z', 'label' => 'Announcements'],
                    ['route' => '#', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'label' => 'Live Status'],
                ];
            @endphp

            @foreach($navItems as $item)
                <a href="{{ $item['route'] == '#' ? '#' : route($item['route']) }}" 
                   class="group flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-300 {{ Request::routeIs($item['route']) ? 'nav-active' : 'text-slate-500 hover:bg-teal-50 hover:text-teal-700' }}">
                    <svg class="w-5 h-5 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}" />
                    </svg>
                    <span class="text-sm font-bold tracking-tight">{{ $item['label'] }}</span>
                </a>
            @endforeach
        </nav>

        <div class="p-6">
            <div class="p-4 bg-teal-50/50 rounded-3xl border border-teal-100 flex items-center gap-3 group cursor-pointer hover:bg-teal-100 transition-all">
                <div class="w-10 h-10 rounded-full bg-teal-600 text-white flex items-center justify-center font-black text-sm group-hover:rotate-12 transition-transform">
                    {{ strtoupper(substr(Auth::user()->Name ?? 'S', 0, 1)) }}
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-black text-teal-950 truncate">{{ Auth::user()->Name ?? 'Student' }}</p>
                    <p class="text-[10px] text-teal-600 uppercase font-bold tracking-widest">Athlete Profile</p>
                </div>
                <svg class="w-4 h-4 text-teal-400 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
            </div>
        </div>
    </aside>

    <main class="flex-1 flex flex-col min-w-0 overflow-hidden bg-[#fdfdfd]">
        
        <header class="h-20 flex items-center justify-between px-8 bg-transparent shrink-0">
            <div class="flex items-center gap-4 flex-1">
                <button id="mobile-toggle" class="md:hidden p-2 rounded-xl bg-white shadow-sm border border-teal-100 text-teal-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>

                <div class="hidden md:flex items-center gap-3 bg-white border border-teal-50 px-4 py-2 rounded-2xl w-full max-w-md shadow-sm focus-within:ring-2 focus-within:ring-teal-500/20 focus-within:border-teal-500 transition-all">
                    <svg class="w-4 h-4 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input type="text" placeholder="Search for games or news..." class="bg-transparent border-none focus:ring-0 text-sm w-full placeholder:text-slate-400 font-medium">
                </div>
            </div>

            <div class="flex items-center gap-3">
                <button class="p-3 rounded-2xl bg-white border border-teal-50 text-teal-600 shadow-sm hover:scale-110 active:scale-95 transition-all relative">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h11z"/></svg>
                    <span class="absolute top-2.5 right-3 w-2 h-2 bg-red-500 rounded-full border-2 border-white"></span>
                </button>

                <div class="h-8 w-px bg-teal-100 mx-2"></div>

                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="flex items-center gap-2 px-5 py-2.5 rounded-2xl bg-teal-50 text-teal-700 text-xs font-black uppercase tracking-widest hover:bg-teal-600 hover:text-white transition-all shadow-sm">
                        Sign Out
                    </button>
                </form>
            </div>
        </header>

        <div class="flex-1 overflow-y-auto p-8 animate-fade-in">
            <div class="max-w-7xl mx-auto">
                @yield('content')
            </div>

            <footer class="mt-20 py-10 border-t border-teal-50 text-center">
                 <p class="text-[10px] font-black uppercase tracking-[0.3em] text-teal-300">© {{ date('Y') }} Athlentry Student Studio v2.0</p>
            </footer>
        </div>
    </main>
</div>

<div id="mobile-sidebar" class="fixed inset-0 z-50 hidden">
    <div id="mobile-backdrop" class="absolute inset-0 bg-teal-900/40 backdrop-blur-sm"></div>
    <aside class="absolute left-0 top-0 bottom-0 w-80 bg-white shadow-2xl flex flex-col">
        <div class="p-8 flex items-center justify-between border-b border-teal-50">
            <h2 class="font-black italic uppercase text-teal-600">ATHLESTUDIO</h2>
            <button id="mobile-close" class="p-2 rounded-xl bg-teal-50 text-teal-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
        </div>
        <nav class="p-6 space-y-2">
            @foreach($navItems as $item)
                <a href="{{ $item['route'] == '#' ? '#' : route($item['route']) }}" class="flex items-center gap-4 p-4 rounded-2xl text-slate-600 font-bold hover:bg-teal-50 hover:text-teal-600 transition-all">
                    <span class="text-sm">{{ $item['label'] }}</span>
                </a>
            @endforeach
        </nav>
    </aside>
</div>

<script>
    (function(){
        const mobileToggle = document.getElementById('mobile-toggle');
        const mobileSidebar = document.getElementById('mobile-sidebar');
        const mobileBackdrop = document.getElementById('mobile-backdrop');
        const mobileClose = document.getElementById('mobile-close');

        function toggleMenu() { mobileSidebar.classList.toggle('hidden'); }
        mobileToggle?.addEventListener('click', toggleMenu);
        mobileClose?.addEventListener('click', toggleMenu);
        mobileBackdrop?.addEventListener('click', toggleMenu);
    })();
</script>

</body>
</html>