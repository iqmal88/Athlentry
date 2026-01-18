<!doctype html>
<html lang="en" class="antialiased scroll-smooth">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>@yield('title', 'Student Studio')</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        html, body { margin: 0; padding: 0; height: 100%; width: 100%; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #F2F4F7; color: #1A1D1F; overflow: hidden; width: 100vw; }
        
        /* --- Sidebar --- */
        #sidebar { width: 280px; min-width: 280px; height: 100vh; background: #ffffff; border-right: 1px solid rgba(0,0,0,0.05); transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); z-index: 50; }
        .sidebar-hidden { margin-left: -280px; }
        
        /* --- Nav Items (Matched to Admin Style) --- */
        .nav-item { display: flex; align-items: center; gap: 14px; padding: 10px 16px; border-radius: 12px; color: #6F767E; font-weight: 600; font-size: 0.875rem; transition: all 0.2s ease; margin-bottom: 4px; text-decoration: none !important; }
        .nav-item:hover { background: #F4F4F4; color: #1A1D1F; transform: translateX(4px); }
        .nav-item.active { background: #F0FDFA; color: #0D9488; border: 1px solid rgba(13, 148, 136, 0.1); }
        
        /* --- iOS Toggle --- */
        .ios-switch { position: relative; display: inline-block; width: 42px; height: 24px; }
        .ios-switch input { opacity: 0; width: 0; height: 0; }
        .slider { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #E9E9EB; transition: .4s; border-radius: 34px; }
        .slider:before { position: absolute; content: ""; height: 20px; width: 20px; left: 2px; bottom: 2px; background-color: white; transition: .4s; border-radius: 50%; box-shadow: 0 2px 5px rgba(0,0,0,0.15); }
        input:checked + .slider { background-color: #0D9488; }
        input:checked + .slider:before { transform: translateX(18px); }
        
        /* --- Glass Header --- */
        .glass-header { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); border-bottom: 1px solid rgba(0,0,0,0.05); }
        .section-label { font-size: 0.65rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.1em; color: #9A9FA5; padding: 0 16px; margin: 24px 0 12px 0; }
        .custom-scrollbar::-webkit-scrollbar { width: 5px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #EBEBEB; border-radius: 10px; }
        
        /* --- FULL SCREEN FIX --- */
        .main-content { height: 100vh; overflow-y: auto; flex: 1 1 0%; display: flex; flex-direction: column; width: 100%; }
        .content-body { flex: 1; padding: 2rem; width: 100%; overflow-y: auto; }
    </style>
</head>
<body class="flex">

    <aside id="sidebar" class="flex flex-col flex-shrink-0">
        <div class="h-20 flex items-center px-8">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-[#0D9488] rounded-lg flex items-center justify-center shadow-lg shadow-teal-900/20">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <div class="flex flex-col">
                    <span class="text-md font-extrabold tracking-tight uppercase text-teal-950">Student <span class="text-[#0D9488]">Studio</span></span>
                    <span class="text-[9px] font-bold text-gray-400 uppercase tracking-widest leading-none">Athlete Portal</span>
                </div>
            </div>
        </div>

        <nav class="flex-1 px-4 custom-scrollbar overflow-y-auto">
            <div class="section-label">Main Menu</div>
            
            <a href="{{ route('student.announcements.index') }}" class="nav-item {{ Request::routeIs('student.announcements.*') ? 'active' : '' }}">
                <i class="bi bi-megaphone"></i> <span>Announcements</span>
            </a>

            <a href="{{ route('student.gameinfo.index') }}" class="nav-item {{ Request::routeIs('student.gameinfo.*') ? 'active' : '' }}">
                <i class="bi bi-controller"></i> <span>Game Information</span>
            </a>

            <a href="{{ route('student.application.index') }}" class="nav-item {{ Request::routeIs('student.application.*') ? 'active' : '' }}">
                <i class="bi bi-people"></i> <span>Apply Athlete</span>
            </a>
            
            <a href="{{ route('student.applications.status') }}" class="nav-item {{ Request::routeIs('student.applications.status') ? 'active' : '' }}">
                <i class="bi bi-check2-square"></i> <span>Selection Status</span>
            </a>
        </nav>

        <div class="p-4 border-t border-gray-100">
            <div class="flex items-center justify-between p-2 rounded-2xl hover:bg-gray-50 transition-all group">
                <a href="{{ route('student.profile.show') }}" class="flex items-center gap-3 flex-1 min-w-0 pr-2 no-underline">
                    <div class="w-10 h-10 rounded-full bg-[#0D9488]/10 text-[#0D9488] border border-[#0D9488]/10 flex items-center justify-center font-bold flex-shrink-0 uppercase">
                        {{ strtoupper(substr(Auth::user()->Name ?? 'S', 0, 1)) }}
                    </div>
                    <div class="flex flex-col truncate">
                        <span class="text-sm font-bold text-gray-900 leading-tight truncate group-hover:text-[#0D9488] transition-colors">
                            {{ Auth::user()->Name ?? 'Student' }}
                        </span>
                        <span class="text-[10px] font-medium text-gray-400 uppercase tracking-tighter italic">Athlete Identity</span>
                    </div>
                </a>

                <form action="{{ route('logout') }}" method="POST" class="flex-shrink-0">
                    @csrf
                    <button type="submit" class="w-8 h-8 flex items-center justify-center text-gray-300 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all" title="Logout">
                        <i class="bi bi-box-arrow-right text-lg"></i> </button>
                </form>
            </div>
        </div>
    </aside>

    <main class="main-content">
        <header class="h-16 flex items-center justify-between px-10 flex-shrink-0 glass-header sticky top-0 z-40">
            <div class="flex items-center gap-8">
                <div class="flex items-center gap-3">
                    <label class="ios-switch">
                        <input type="checkbox" id="ios-toggle-input" checked>
                        <span class="slider"></span>
                    </label>
                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest hidden sm:block">Sidebar</span>
                </div>

                <nav class="flex items-center text-xs font-semibold text-gray-400 uppercase tracking-widest">
                    <span class="hover:text-[#0D9488] transition-colors cursor-pointer">Student</span>
                    <i class="bi bi-chevron-right mx-2 text-[10px] text-gray-300"></i>
                    <span class="text-gray-900">
                        @php
                            $segment = Request::segment(2);
                            echo match($segment) {
                                'announcements' => 'Announcements',
                                'game-info'     => 'Game Information',
                                'applications'  => 'Athlete Application',
                                'profile'       => 'My Profile',
                                default         => 'Dashboard'
                            };
                        @endphp
                    </span>
                </nav>
            </div>

            <div class="flex items-center gap-6">
                <div class="hidden md:flex flex-col items-end border-r pr-6 border-gray-100">
                    <span id="live-time" class="text-sm font-bold text-gray-900 tabular-nums leading-none">00:00:00</span>
                    <span class="text-[9px] font-black text-gray-300 uppercase tracking-widest mt-1">Local Time</span>
                </div>

                {{-- Notification Bell --}}
                @php 
                    $unreadCount = App\Models\Notification::unreadCount(Auth::user()->UserID);
                @endphp
                <a href="{{ route('student.notifications.index') }}" class="relative text-gray-600 hover:text-[#0D9488] transition-colors">
                    <i class="bi bi-bell text-lg"></i>
                    @if($unreadCount > 0)
                        <span class="absolute -top-2 -right-2 w-5 h-5 bg-red-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center">
                            {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                        </span>
                    @endif
                </a>
                
                @php $status = auth()->user()->getCompletionStatus(); @endphp
                <div class="flex items-center gap-3">
                    <div class="flex flex-col items-end">
                        <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest">Profile</span>
                        <span class="text-[10px] font-bold {{ $status['is_complete'] ? 'text-teal-600' : 'text-amber-500' }} uppercase">{{ $status['percentage'] }}% Ready</span>
                    </div>
                    <div class="w-8 h-8 rounded-full border-2 border-gray-100 p-0.5">
                        <div class="h-full w-full rounded-full {{ $status['is_complete'] ? 'bg-teal-500' : 'bg-amber-500' }} shadow-sm"></div>
                    </div>
                </div>
            </div>
        </header>

        <div class="content-body custom-scrollbar">
            <div class="w-full animate-in fade-in slide-in-from-bottom-4 duration-700">
                @yield('content')
            </div>
        </div>
    </main>

    <script>
        const sidebar = document.getElementById('sidebar');
        const iosToggle = document.getElementById('ios-toggle-input');

        iosToggle.addEventListener('change', () => {
            if (iosToggle.checked) {
                sidebar.classList.remove('sidebar-hidden');
                localStorage.setItem('student-sidebar-pref', 'visible');
            } else {
                sidebar.classList.add('sidebar-hidden');
                localStorage.setItem('student-sidebar-pref', 'hidden');
            }
        });

        if (localStorage.getItem('student-sidebar-pref') === 'hidden') {
            sidebar.classList.add('sidebar-hidden');
            iosToggle.checked = false;
        }

        setInterval(() => {
            document.getElementById('live-time').innerText = new Date().toLocaleTimeString('en-GB');
        }, 1000);
    </script>
</body>
</html>