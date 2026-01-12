<!doctype html>
<html lang="en" class="antialiased scroll-smooth">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Student Portal - @yield('title', 'Athlentry')</title>

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

        /* Sidebar Canva Style (Student Teal) */
        #sidebar {
            width: 280px;
            min-width: 280px;
            height: 100vh;
            background: #ffffff;
            border-right: 1px solid #F3F5F7;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 50;
            position: relative;
        }

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
            color: #0D9488; /* Teal Blue Pelajar */
        }

        /* Floating Toggle Button */
        #sidebar-toggle {
            position: fixed;
            left: 265px;
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
            background: #0D9488;
            color: #ffffff;
        }

        .main-content {
            background: #FCFCFC;
            height: 100vh;
            overflow-y: auto;
            width: 100%;
            transition: all 0.3s ease;
        }

        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
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
                <div class="w-10 h-10 bg-[#0D9488] rounded-xl flex items-center justify-center shadow-lg shadow-teal-900/10">
                    <i class="bi bi-lightning-fill text-white h5 mb-0"></i>
                </div>
                <div class="flex flex-col">
                    <span class="text-lg font-extrabold tracking-tighter leading-none uppercase text-teal-950">Athle<span class="text-[#0D9488]">ntry</span></span>
                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-1">Student Portal</span>
                </div>
            </div>
        </div>

        <nav class="flex-1 px-4 custom-scrollbar overflow-y-auto">
            <div class="section-label">Main Menu</div>
            
            @php
                $navItems = [
                    ['route' => 'student.announcements.index', 'icon' => 'bi-house-door', 'label' => 'Homepage'],
                    ['route' => 'student.gameinfo.index', 'icon' => 'bi-info-circle', 'label' => 'Game Information'],
                    ['route' => 'student.application.index', 'icon' => 'bi-plus-square', 'label' => 'Apply Athletes'],
                    ['route' => 'student.applications.status', 'icon' => 'bi-activity', 'label' => 'Status Update'],
                ];
            @endphp

            @foreach($navItems as $item)
                <a href="{{ route($item['route']) }}" class="nav-item {{ request()->routeIs($item['route']) ? 'active' : '' }}">
                    <i class="bi {{ $item['icon'] }}"></i>
                    <span>{{ $item['label'] }}</span>
                </a>
            @endforeach
        </nav>

        <div class="p-6 border-t border-gray-50">
            <div class="flex items-center justify-between p-3 rounded-2xl hover:bg-gray-50 transition-all cursor-pointer group">
                <a href="{{ route('student.profile.show') }}" class="flex items-center gap-3 no-underline">
                    <div class="w-10 h-10 rounded-full bg-[#0D9488]/5 text-[#0D9488] border border-[#0D9488]/10 flex items-center justify-center font-bold">
                        {{ strtoupper(substr(Auth::user()->Name ?? 'S', 0, 1)) }}
                    </div>
                    <div class="flex flex-col">
                        <span class="text-sm font-bold text-gray-900 leading-none">{{ Auth::user()->Name ?? 'Student' }}</span>
                        <span class="text-[10px] font-medium text-gray-400 mt-1">Athlete Profile</span>
                    </div>
                </a>
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
                    <span class="hover:text-gray-600 cursor-pointer uppercase tracking-widest text-[10px]">Portal</span>
                    <i class="bi bi-chevron-right mx-2 text-[10px]"></i>
                    <span class="text-gray-900 capitalize text-[10px] uppercase tracking-widest">
                        {{ str_replace('.', ' ', request()->route()->getName()) }}
                    </span>
                </nav>
            </div>

            <div class="flex items-center gap-6">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="px-5 py-2.5 bg-gray-100 text-gray-600 text-xs font-bold rounded-xl hover:bg-red-600 hover:text-white transition-all">
                        Sign Out
                    </button>
                </form>
            </div>
        </header>

        <div class="flex-1 p-10 custom-scrollbar">
            <div class="max-w-[1400px] mx-auto">
                @yield('content')
            </div>

            <footer class="mt-20 py-10 border-t border-gray-100 flex items-center justify-between opacity-30">
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.3em]">© {{ date('Y') }} Athlentry Student Studio</span>
            </footer>
        </div>
    </main>

    <script>
        const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.getElementById('sidebar-toggle');
        const toggleIcon = document.getElementById('toggle-icon');

        toggleBtn.addEventListener('click', () => {
            const isHidden = sidebar.classList.toggle('sidebar-hidden');
            toggleBtn.classList.toggle('collapsed');
            
            if (isHidden) {
                toggleIcon.classList.replace('bi-chevron-left', 'bi-chevron-right');
                localStorage.setItem('student-sidebar-pref', 'hidden');
            } else {
                toggleIcon.classList.replace('bi-chevron-right', 'bi-chevron-left');
                localStorage.setItem('student-sidebar-pref', 'visible');
            }
        });

        // Simpan pilihan user
        if (localStorage.getItem('student-sidebar-pref') === 'hidden') {
            sidebar.classList.add('sidebar-hidden');
            toggleBtn.classList.add('collapsed');
            toggleIcon.classList.replace('bi-chevron-left', 'bi-chevron-right');
        }
    </script>
</body>
</html>