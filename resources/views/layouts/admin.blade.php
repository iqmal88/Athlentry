<!doctype html>
<html lang="en" class="antialiased scroll-smooth">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>@yield('title', 'Admin Studio')</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root { --brand: #800000; }
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            transition: background-color 0.3s ease;
        }
        html.dark body { background: #0c0c0c; color: #f8fafc; }
        html:not(.dark) body { background: #fdfdfd; color: #0f172a; }

        /* Modern Glass Effect */
        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .dark .glass {
            background: rgba(15, 15, 15, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        /* Smooth Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
        .dark ::-webkit-scrollbar-thumb { background: #334155; }

        .animate-fade-in { animation: fadeIn 0.5s ease-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</head>
<body class="min-h-screen">

<div class="flex h-screen overflow-hidden">

    <aside id="sidebar" class="hidden lg:flex flex-col w-[280px] bg-white dark:bg-[#111111] border-r border-gray-100 dark:border-white/5 transition-all">
        <div class="p-8">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-[#800000] rounded-xl flex items-center justify-center shadow-lg shadow-red-900/20">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <h1 class="text-xl font-extrabold tracking-tighter italic uppercase">ADMIN <span class="text-[#800000] not-italic">STUDIO</span></h1>
            </div>
        </div>

        <nav class="flex-1 px-6 space-y-1">
            <p class="px-2 text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 dark:text-gray-600 mb-4 font-sans">Main Navigation</p>
            
            @php
                $navItems = [
                    ['route' => 'admin.announcements.index', 'icon' => 'M11 5.882V19.297A2.457 2.457 0 0111 19.297V5.882z', 'label' => 'Announcements'],
                    ['route' => 'admin.events.list', 'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z', 'label' => 'Athlete Apps'],
                    ['route' => 'admin.gameinfo.index', 'icon' => 'M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z', 'label' => 'Game Info'],
                    ['route' => 'admin.selection.status.index', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'label' => 'Selection Status'],
                ];
            @endphp

            @foreach($navItems as $item)
                <a href="{{ route($item['route']) }}" 
                   class="group flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-300 {{ Request::routeIs($item['route'].'*') ? 'bg-[#800000] text-white shadow-lg shadow-red-900/20' : 'text-gray-500 hover:bg-gray-50 dark:hover:bg-white/5' }}">
                    <svg class="w-5 h-5 {{ Request::routeIs($item['route'].'*') ? 'text-white' : 'text-gray-400 group-hover:text-[#800000]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}" />
                    </svg>
                    <span class="text-sm font-bold tracking-tight">{{ $item['label'] }}</span>
                </a>
            @endforeach
        </nav>

        <div class="p-6">
            <div class="p-4 bg-gray-50 dark:bg-white/5 rounded-[2rem] border border-transparent hover:border-gray-200 dark:hover:border-white/10 transition-all group">
                <a href="{{ route('admin.profile.view') }}" class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-full bg-[#800000] text-white flex items-center justify-center font-black text-sm group-hover:scale-110 transition-transform">
                        {{ strtoupper(substr(Auth::user()->Name ?? 'A', 0, 1)) }}
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-black truncate dark:text-white group-hover:text-[#800000] transition-colors">{{ Auth::user()->Name ?? 'Admin' }}</p>
                        <p class="text-[9px] text-gray-400 uppercase font-bold tracking-widest leading-none">Settings</p>
                    </div>
                    <svg class="w-4 h-4 text-gray-300 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                </a>
                
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="w-full py-2 bg-white dark:bg-[#1a1a1a] text-red-600 text-[10px] font-black uppercase tracking-widest rounded-xl shadow-sm border border-red-50 dark:border-red-900/20 hover:bg-red-600 hover:text-white transition-all">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <main class="flex-1 flex flex-col min-w-0 overflow-hidden">
        
        <header class="h-20 flex items-center justify-between px-8 bg-transparent">
            <div class="flex items-center gap-6">
                <button id="mobile-toggle" class="lg:hidden p-2 rounded-xl bg-white shadow-sm border border-gray-100 dark:bg-[#111111] dark:border-white/10">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>

                <nav class="hidden md:flex items-center gap-3">
                    <div class="flex items-center gap-2 px-4 py-2 bg-gray-100/50 dark:bg-white/5 rounded-2xl border border-gray-200/50 dark:border-white/5">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        <span class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400">Portal</span>
                        <svg class="w-3 h-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                        <span class="text-[10px] font-black uppercase tracking-[0.2em] text-[#800000]">
                            @php
                                $segment = Request::segment(2);
                                echo str_replace('-', ' ', $segment ?? 'Dashboard');
                            @endphp
                        </span>
                    </div>
                </nav>
            </div>

            <div class="flex items-center gap-4">
                <button id="dark-toggle" class="p-3 rounded-2xl bg-white dark:bg-[#111111] border border-gray-100 dark:border-white/10 shadow-sm hover:scale-110 active:scale-95 transition-all">
                    <svg id="icon-sun" class="w-5 h-5 hidden text-yellow-500" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"/></svg>
                    <svg id="icon-moon" class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"/></svg>
                </button>
                <div class="h-6 w-px bg-gray-200 dark:bg-white/10 hidden sm:block"></div>
                <div class="hidden sm:block text-right">
                    <p id="live-time" class="text-[11px] font-bold dark:text-white uppercase tracking-tighter tabular-nums text-gray-900">00:00:00</p>
                    <p class="text-[9px] font-black uppercase text-gray-400 tracking-widest leading-none">System Clock</p>
                </div>
            </div>
        </header>

        <div class="flex-1 overflow-y-auto animate-fade-in custom-scrollbar p-8">
            @yield('content')
            
            <footer class="mt-20 py-10 border-t border-gray-100 dark:border-white/5 opacity-50 grayscale flex items-center justify-between">
                <p class="text-[10px] font-black uppercase tracking-[0.3em] text-gray-400">© {{ date('Y') }} Admin Studio v2.0</p>
                <div class="flex gap-4">
                    <div class="w-2 h-2 rounded-full bg-[#800000]"></div>
                    <div class="w-2 h-2 rounded-full bg-gray-300"></div>
                </div>
            </footer>
        </div>
    </main>
</div>

<script>
    // Theme Toggle
    const darkToggle = document.getElementById('dark-toggle');
    const iconSun = document.getElementById('icon-sun');
    const iconMoon = document.getElementById('icon-moon');

    function setDarkMode(dark) {
        if (dark) {
            document.documentElement.classList.add('dark');
            iconSun.classList.remove('hidden');
            iconMoon.classList.add('hidden');
        } else {
            document.documentElement.classList.remove('dark');
            iconSun.classList.add('hidden');
            iconMoon.classList.remove('hidden');
        }
        localStorage.setItem('admin-studio-dark', dark ? '1' : '0');
    }

    const stored = localStorage.getItem('admin-studio-dark');
    if (stored === null) setDarkMode(window.matchMedia('(prefers-color-scheme: dark)').matches);
    else setDarkMode(stored === '1');
    darkToggle.addEventListener('click', () => setDarkMode(!document.documentElement.classList.contains('dark')));

    // Mobile Sidebar
    const mobileToggle = document.getElementById('mobile-toggle');
    const mobileSidebar = document.getElementById('mobile-sidebar');
    const mobileBackdrop = document.getElementById('mobile-backdrop');
    const mobileClose = document.getElementById('mobile-close');

    if(mobileToggle) mobileToggle.addEventListener('click', () => mobileSidebar.classList.remove('hidden'));
    [mobileBackdrop, mobileClose].forEach(el => el && el.addEventListener('click', () => mobileSidebar.classList.add('hidden')));

    // Live Clock
    function updateTime() {
        const now = new Date();
        const timeEl = document.getElementById('live-time');
        if(timeEl) timeEl.innerText = now.toLocaleTimeString();
    }
    setInterval(updateTime, 1000);
    updateTime();
</script>

</body>
</html>