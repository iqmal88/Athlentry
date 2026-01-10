<!doctype html>
<html lang="en" class="antialiased scroll-smooth">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>@yield('title', 'Admin Studio')</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background: #ffffff;
            color: #1A1D1F;
        }

        /* Sidebar Canva Style */
        #sidebar {
            width: 280px;
            min-width: 280px;
            height: 100vh;
            background: #ffffff;
            border-right: 1px solid #F3F5F7;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 50;
        }

        /* Sidebar Hidden State */
        .sidebar-hidden {
            margin-left: -280px;
        }

        /* Nav Item Styling */
        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            border-radius: 12px;
            color: #6F767E;
            font-weight: 600;
            font-size: 0.875rem;
            transition: all 0.2s ease;
            margin-bottom: 4px;
            text-decoration: none !important;
        }

        .nav-item:hover {
            background: #F4F4F4;
            color: #1A1D1F;
        }

        .nav-item.active {
            background: #F4F4F4;
            color: #800000; /* Maroon */
        }

        .nav-item i {
            font-size: 1.25rem;
        }

        /* Floating Toggle Button */
        #sidebar-toggle {
            position: fixed;
            left: 265px; /* Sits on the edge */
            top: 32px;
            z-index: 100;
            width: 32px;
            height: 32px;
            background: #ffffff;
            border: 1px solid #F3F5F7;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        #sidebar-toggle.collapsed {
            left: 16px;
        }

        #sidebar-toggle:hover {
            background: #800000;
            color: #ffffff;
        }

        /* Content Area */
        .main-content {
            background: #FCFCFC; /* Warna abu-abu sangat muda khas Canva */
            height: 100vh;
            overflow-y: auto;
            width: 100%;
        }

        /* Custom Scrollbar */
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #EBEBEB; border-radius: 10px; }

        .section-label {
            font-size: 0.7rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #9A9FA5;
            padding: 0 16px;
            margin-bottom: 12px;
            margin-top: 24px;
        }
    </style>
</head>
<body class="flex overflow-hidden">

    <aside id="sidebar" class="flex flex-col flex-shrink-0">
        <div class="h-24 flex items-center px-8">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-[#800000] rounded-xl flex items-center justify-center shadow-lg shadow-red-900/10">
                    <i class="bi bi-intersect text-white h5 mb-0"></i>
                </div>
                <div class="flex flex-col">
                    <span class="text-lg font-extrabold tracking-tighter leading-none uppercase">Admin <span class="text-[#800000]">Studio</span></span>
                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-1">Management</span>
                </div>
            </div>
        </div>

        <nav class="flex-1 px-4 custom-scrollbar overflow-y-auto">
            <div class="section-label">Main Menu</div>
            
            <a href="{{ route('admin.announcements.index') }}" class="nav-item {{ Request::routeIs('admin.announcements.*') ? 'active' : '' }}">
                <i class="bi bi-megaphone"></i>
                <span>Announcements</span>
            </a>

            <a href="{{ route('admin.events.list') }}" class="nav-item {{ Request::routeIs('admin.events.*') ? 'active' : '' }}">
                <i class="bi bi-people"></i>
                <span>Athlete Application</span>
            </a>

            <a href="{{ route('admin.gameinfo.index') }}" class="nav-item {{ Request::routeIs('admin.gameinfo.*') ? 'active' : '' }}">
                <i class="bi bi-controller"></i>
                <span>Game Information</span>
            </a>
            
            <a href="{{ route('admin.selection.index') }}" class="nav-item {{ Request::routeIs('admin.selection.*') ? 'active' : '' }}">
                <i class="bi bi-check2-square"></i>
                <span>Selection Status</span>
            </a>

            <a href="{{ route('admin.reports.index') }}" class="nav-item {{ Request::routeIs('admin.reports.*') ? 'active' : '' }}">
                <i class="bi bi-bar-chart-line"></i>
                <span>Reports & Analytics</span>
            </a>
        </nav>

        <div class="p-6 border-t border-gray-50">
            <div class="flex items-center justify-between p-3 rounded-2xl hover:bg-gray-50 transition-all cursor-pointer group">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-[#800000]/5 text-[#800000] border border-[#800000]/10 flex items-center justify-center font-bold">
                        {{ strtoupper(substr(Auth::user()->Name ?? 'A', 0, 1)) }}
                    </div>
                    <div class="flex flex-col">
                        <span class="text-sm font-bold text-gray-900 leading-none">{{ Auth::user()->Name ?? 'Admin' }}</span>
                        <span class="text-[10px] font-medium text-gray-400 mt-1">Super Admin</span>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="text-gray-300 group-hover:text-red-600 transition-colors">
                        <i class="bi bi-box-arrow-right"></i>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <div id="sidebar-toggle">
        <i class="bi bi-chevron-left" id="toggle-icon"></i>
    </div>

    <main class="main-content flex flex-col">
        <header class="h-20 flex items-center justify-between px-10 flex-shrink-0 bg-white/50 backdrop-blur-md sticky top-0 z-40">
            <div class="flex items-center gap-4">
                <nav class="text-sm font-semibold text-gray-400">
                    <span class="hover:text-gray-600 cursor-pointer">Portal</span>
                    <i class="bi bi-chevron-right mx-2 text-[10px]"></i>
                    <span class="text-gray-900 capitalize">
                        @php echo str_replace('-', ' ', Request::segment(2) ?? 'Home'); @endphp
                    </span>
                </nav>
            </div>

            <div class="flex items-center gap-6">
                <div class="flex flex-col items-end border-r pr-6 border-gray-100">
                    <span id="live-time" class="text-sm font-bold text-gray-900 tabular-nums">00:00:00</span>
                    <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest">System Live</span>
                </div>
                
                <button class="w-10 h-10 rounded-xl hover:bg-gray-100 transition-all flex items-center justify-center text-gray-500">
                    <i class="bi bi-bell"></i>
                </button>
            </div>
        </header>

        <div class="flex-1 p-10 custom-scrollbar">
            <div class="max-w-[1400px] mx-auto">
                @yield('content')
            </div>

            <footer class="mt-20 py-10 border-t border-gray-100 flex items-center justify-between opacity-30">
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.3em]">© 2026 Admin Studio v2.5</span>
                <div class="flex gap-2">
                    <div class="w-1 h-1 rounded-full bg-red-900"></div>
                    <div class="w-1 h-1 rounded-full bg-gray-400"></div>
                </div>
            </footer>
        </div>
    </main>

    <script>
        const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.getElementById('sidebar-toggle');
        const toggleIcon = document.getElementById('toggle-icon');

        // Sidebar Toggle Logic
        toggleBtn.addEventListener('click', () => {
            const isHidden = sidebar.classList.toggle('sidebar-hidden');
            toggleBtn.classList.toggle('collapsed');
            
            if (isHidden) {
                toggleIcon.classList.replace('bi-chevron-left', 'bi-chevron-right');
                localStorage.setItem('sidebar-pref', 'hidden');
            } else {
                toggleIcon.classList.replace('bi-chevron-right', 'bi-chevron-left');
                localStorage.setItem('sidebar-pref', 'visible');
            }
        });

        // Restore Preference
        if (localStorage.getItem('sidebar-pref') === 'hidden') {
            sidebar.classList.add('sidebar-hidden');
            toggleBtn.classList.add('collapsed');
            toggleIcon.classList.replace('bi-chevron-left', 'bi-chevron-right');
        }

        // Live Clock
        setInterval(() => {
            document.getElementById('live-time').innerText = new Date().toLocaleTimeString('en-GB');
        }, 1000);
    </script>
</body>
</html>