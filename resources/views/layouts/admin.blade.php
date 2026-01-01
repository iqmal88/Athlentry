<!doctype html>
<html lang="en" class="antialiased">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>@yield('title', 'Admin Panel')</title>

    <!-- Tailwind CDN (good for prototyping; compile Tailwind for production) -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700" rel="stylesheet" />

    <style>
        :root {
            --brand: #800000;
            --muted: #6b7280;
        }
        html.dark { --bg: #0b1220; --panel: #071226; --text: #e6eef8; --muted: #94a3b8; }
        html:not(.dark) { --bg: #f3f4f6; --panel: #ffffff; --text: #0f172a; --muted: #6b7280; }
        body { font-family: 'Inter', sans-serif; background: var(--bg); color: var(--text); }
        /* small helpers */
        .brand { background-color: var(--brand); }
        .brand-text { color: var(--brand); }
    </style>
</head>
<body class="min-h-screen">

<!-- Wrapper -->
<div class="min-h-screen flex">

    <!-- SIDEBAR (md+) -->
    <aside id="sidebar" class="hidden md:flex md:flex-col w-64 bg-white/80 dark:bg-[color:var(--panel)] shadow-lg">
        <div class="px-6 py-5 flex items-center gap-3 border-b dark:border-neutral-800">
            <div class="bg-[color:var(--brand)]/10 rounded p-2">
                <svg class="w-6 h-6 text-[color:var(--brand)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 7l9-4 9 4-9 4-9-4zm0 8l9 4 9-4M3 7v8m18-8v8"/>
                </svg>
            </div>
            <div>
                <h1 class="text-lg font-semibold">Admin Dashboard</h1>
                <p class="text-xs text-[color:var(--muted)]">Manage your site</p>
            </div>
        </div>

        <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
            <a href="{{ route('admin.announcements.index') }}"
               class="group flex items-center gap-3 px-3 py-2 rounded-md hover:bg-[color:var(--brand)]/10 transition">
                <svg class="w-5 h-5 text-[color:var(--brand)] group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
                <span class="text-sm">Announcements</span>
            </a>

            <a href="{{ route('admin.events.list') }}"
               class="group flex items-center gap-3 px-3 py-2 rounded-md hover:bg-[color:var(--brand)]/10 transition">
                <svg class="w-5 h-5 text-[color:var(--brand)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M8 7V3m8 4V3M3 11h18M5 21h14a2 2 0 002-2V7H3v12a2 2 0 002 2z"/>
                </svg>
                <span class="text-sm">Athlete Application</span>
            </a>

            <a href="{{ route('admin.gameinfo.index') }}"
               class="group flex items-center gap-3 px-3 py-2 rounded-md hover:bg-[color:var(--brand)]/10 transition">
                <svg class="w-5 h-5 text-[color:var(--brand)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 17v-6a2 2 0 012-2h2a2 2 0 012 2v6M9 17H7a2 2 0 00-2 2v1h14v-1a2 2 0 00-2-2h-2"/>
                </svg>
                <span class="text-sm">Game Information</span>
            </a>

            <a href="{{ route('admin.selection.status.index') }}"
               class="group flex items-center gap-3 px-3 py-2 rounded-md hover:bg-[color:var(--brand)]/10 transition">
                <svg class="w-5 h-5 text-[color:var(--brand)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12l2 2 4-4M7 7h.01M7 11h.01M7 15h.01M12 7h.01" />
                </svg>
                <span class="text-sm">Selection Status</span>
            </a>
        </nav>

        <div class="px-4 py-4 border-t dark:border-neutral-800">
            <a href="{{ route('admin.profile.view') }}" class="flex items-center gap-3 px-2 py-2 rounded-md hover:bg-gray-100 dark:hover:bg-neutral-800 transition">
                <div class="w-9 h-9 rounded-full bg-[color:var(--brand)]/10 text-[color:var(--brand)] flex items-center justify-center font-semibold">
                    {{ strtoupper(substr(Auth::user()->Name ?? 'A', 0, 1)) }}
                </div>
                <div>
                    <p class="text-sm font-medium">{{ Auth::user()->Name ?? 'Admin' }}</p>
                    <p class="text-xs text-[color:var(--muted)]">View profile</p>
                </div>
            </a>
        </div>
    </aside>

    <!-- Main area -->
    <div class="flex-1 flex flex-col">

        <!-- TOP NAVBAR -->
        <header class="w-full bg-[color:var(--panel)] border-b dark:border-neutral-800 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">

                    <!-- Left: Mobile menu button + Brand (mobile) -->
                    <div class="flex items-center gap-3">
                        <button id="mobile-toggle" class="md:hidden p-2 rounded-md hover:bg-gray-100 dark:hover:bg-neutral-800 transition"
                                aria-label="Open sidebar">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </button>

                        <div class="hidden md:flex items-center gap-3">
                            <div class="bg-[color:var(--brand)]/10 p-2 rounded-md">
                                <svg class="w-6 h-6 text-[color:var(--brand)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M3 7l9-4 9 4-9 4-9-4zm0 8l9 4 9-4M3 7v8m18-8v8"/>
                                </svg>
                            </div>
                            <span class="font-semibold text-sm">Admin Dashboard</span>
                        </div>
                    </div>

                    <!-- Center: Search -->
                    <div class="flex-1 mx-4">
                        <form action="#" method="GET" class="max-w-xl mx-auto">
                            <label for="global-search" class="sr-only">Search</label>
                            <div class="relative">
                                <input id="global-search" name="q" type="search"
                                       class="w-full rounded-full border border-gray-200 dark:border-neutral-800 bg-white/90 dark:bg-neutral-900 px-4 py-2 pl-10 text-sm placeholder:text-[color:var(--muted)] focus:outline-none focus:ring-2 focus:ring-[color:var(--brand)] transition"
                                       placeholder="Search announcements, applicants, events..." />
                                <div class="absolute left-3 top-1/2 -translate-y-1/2 text-[color:var(--muted)]">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M21 21l-4.35-4.35M10.5 18a7.5 7.5 0 100-15 7.5 7.5 0 000 15z"/>
                                    </svg>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Right: actions -->
                    <div class="flex items-center gap-3">
                        <!-- Dark mode -->
                        <button id="dark-toggle" class="p-2 rounded-md hover:bg-gray-100 dark:hover:bg-neutral-800 transition" title="Toggle dark mode">
                            <svg id="icon-sun" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707.707M6.343 6.343l-.707.707m12.728 0l.707.707M6.343 17.657l.707.707M12 8a4 4 0 100 8 4 4 0 000-8z"/>
                            </svg>
                            <svg id="icon-moon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 118.646 3.646 7 7 0 0020.354 15.354z"/>
                            </svg>
                        </button>

                        <!-- Notifications -->
                        <button class="relative p-2 rounded-md hover:bg-gray-100 dark:hover:bg-neutral-800 transition" title="Notifications">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h11z"/>
                            </svg>
                            <span class="absolute -top-0.5 -right-0.5 inline-flex items-center justify-center px-1.5 py-0.5 text-xs font-semibold leading-none text-white bg-red-600 rounded-full">3</span>
                        </button>

                        <!-- Profile dropdown -->
                        <div class="relative" x-data>
                            <button id="profile-btn" class="flex items-center gap-2 px-3 py-1.5 rounded-full hover:bg-gray-100 dark:hover:bg-neutral-800 transition" aria-expanded="false" aria-haspopup="true">
                                <div class="w-8 h-8 rounded-full bg-[color:var(--brand)]/10 text-[color:var(--brand)] flex items-center justify-center font-bold">
                                    {{ strtoupper(substr(Auth::user()->Name ?? 'A', 0, 1)) }}
                                </div>
                                <span class="hidden sm:block text-sm font-medium">{{ Auth::user()->Name ?? 'Admin' }}</span>
                                <svg class="w-4 h-4 text-[color:var(--muted)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>

                            <!-- dropdown -->
                            <div id="profile-menu" class="hidden absolute right-0 mt-2 w-48 bg-white dark:bg-neutral-900 text-sm rounded-md shadow-lg overflow-hidden z-10">
                                <a href="{{ route('admin.profile.view') }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-neutral-800">My Profile</a>
                                <div class="border-t dark:border-neutral-800"></div>
                                <form action="{{ route('logout') }}" method="POST" class="m-0">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-red-600 hover:bg-gray-100 dark:hover:bg-neutral-800">Logout</button>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </header>

        <!-- Mobile overlay sidebar -->
        <div id="mobile-sidebar" class="fixed inset-0 z-30 hidden">
            <div id="mobile-backdrop" class="absolute inset-0 bg-black/40"></div>
            <aside class="absolute left-0 top-0 bottom-0 w-72 bg-white dark:bg-neutral-900 shadow-xl">
                <div class="px-4 py-5 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="bg-[color:var(--brand)]/10 p-2 rounded">
                            <svg class="w-6 h-6 text-[color:var(--brand)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M3 7l9-4 9 4-9 4-9-4zm0 8l9 4 9-4M3 7v8m18-8v8"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="font-semibold">Admin</h2>
                            <p class="text-xs text-[color:var(--muted)]">Hello, {{ Auth::user()->Name ?? 'Admin' }}</p>
                        </div>
                    </div>
                    <button id="mobile-close" class="p-2 rounded-md hover:bg-gray-100 dark:hover:bg-neutral-800">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <nav class="px-4 py-4 space-y-1">
                    <a href="{{ route('admin.announcements.index') }}" class="block px-3 py-2 rounded hover:bg-gray-100">Announcements</a>
                    <a href="{{ route('admin.events.list') }}" class="block px-3 py-2 rounded hover:bg-gray-100">Athlete Application</a>
                    <a href="{{ route('admin.gameinfo.index') }}" class="block px-3 py-2 rounded hover:bg-gray-100">Game Information</a>
                    <a href="{{ route('admin.selection.status.index') }}" class="block px-3 py-2 rounded hover:bg-gray-100">Selection Status</a>
                </nav>
            </aside>
        </div>

        <!-- MAIN CONTENT -->
        <main class="flex-1 overflow-y-auto p-6">
            <div class="max-w-7xl mx-auto">
                @yield('content')
            </div>
        </main>

        <!-- FOOTER -->
        <footer class="border-t dark:border-neutral-800 text-sm text-[color:var(--muted)]">
            <div class="max-w-7xl mx-auto px-4 py-3">
                <div class="flex items-center justify-between">
                    <div>© {{ date('Y') }} Your Organization</div>
                    <div class="hidden sm:block">Made with <span class="text-[color:var(--brand)]">❤</span></div>
                </div>
            </div>
        </footer>
    </div>
</div>

<!-- Minimal JS: toggle mobile sidebar, profile dropdown, dark mode -->
<script>
    (function () {
        // Elements
        const mobileToggle = document.getElementById('mobile-toggle');
        const mobileSidebar = document.getElementById('mobile-sidebar');
        const mobileBackdrop = document.getElementById('mobile-backdrop');
        const mobileClose = document.getElementById('mobile-close');

        const profileBtn = document.getElementById('profile-btn');
        const profileMenu = document.getElementById('profile-menu');

        const darkToggle = document.getElementById('dark-toggle');
        const iconSun = document.getElementById('icon-sun');
        const iconMoon = document.getElementById('icon-moon');

        // Mobile open/close
        function openMobile() { mobileSidebar.classList.remove('hidden'); }
        function closeMobile() { mobileSidebar.classList.add('hidden'); }
        mobileToggle && mobileToggle.addEventListener('click', openMobile);
        mobileClose && mobileClose.addEventListener('click', closeMobile);
        mobileBackdrop && mobileBackdrop.addEventListener('click', closeMobile);

        // Profile dropdown
        profileBtn && profileBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            const open = !profileMenu.classList.contains('hidden');
            profileMenu.classList.toggle('hidden', open);
        });
        document.addEventListener('click', function () {
            profileMenu && profileMenu.classList.add('hidden');
        });

        // Dark mode: check localStorage or prefers-color-scheme
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
            localStorage.setItem('admin-dark', dark ? '1' : '0');
        }

        // Initialize dark
        const stored = localStorage.getItem('admin-dark');
        if (stored === null) {
            const prefers = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
            setDarkMode(prefers);
        } else {
            setDarkMode(stored === '1');
        }

        darkToggle && darkToggle.addEventListener('click', function () {
            const isDark = document.documentElement.classList.contains('dark');
            setDarkMode(!isDark);
        });

        // Close on escape
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                closeMobile();
                profileMenu && profileMenu.classList.add('hidden');
            }
        });
    })();
</script>

</body>
</html>