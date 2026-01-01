<!doctype html>
<html lang="en" class="antialiased">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Student - @yield('title', 'Athlentry')</title>

  <!-- Tailwind (good for prototyping) -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Font -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <style>
    :root{
      /* Student theme: teal/green so it's visually distinct from admin maroon */
      --brand: #0f766e;      /* primary brand (teal) */
      --brand-600: #0e6b62;  /* darker */
      --brand-50: #eafaf8;   /* pale tint */
      --muted: #6b7280;
    }
    html.dark { --bg: #071226; --panel: #071226; --text: #e6eef8; --muted:#94a3b8; }
    html:not(.dark) { --bg: #f7faf9; --panel: #ffffff; --text:#0f172a; --muted:#6b7280; }

    body { font-family: 'Inter', system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial; background:var(--bg); color:var(--text); }
    .brand { background-color: var(--brand); }
    .brand-text { color: var(--brand); }
  </style>
</head>
<body class="min-h-screen">

<!-- App wrapper -->
<div class="min-h-screen flex">

  <!-- SIDEBAR (md+) - light so student pages feel friendly and distinct -->
  <aside id="sidebar" class="hidden md:flex md:flex-col w-64 bg-white/95 shadow-sm">
    <div class="px-6 py-5 flex items-center gap-3 border-b">
      <div class="rounded p-2 bg-[color:var(--brand)]/10">
        <svg class="w-6 h-6 text-[color:var(--brand)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 7l9-4 9 4-9 4-9-4z"/>
        </svg>
      </div>
      <div>
        <h1 class="text-lg font-semibold">Athlentry</h1>
        <p class="text-xs text-[color:var(--muted)]">Student Portal</p>
      </div>
    </div>

    <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
      <a href="{{ route('student.announcements.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-[color:var(--brand)]/10 transition">
        <svg class="w-5 h-5 text-[color:var(--brand)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12h18M3 6h18M3 18h18"/></svg>
        <span class="text-sm">Home</span>
      </a>

      <a href="{{ '#' }}" class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-[color:var(--brand)]/10 transition">
        <svg class="w-5 h-5 text-[color:var(--brand)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14"/></svg>
        <span class="text-sm">Application</span>
      </a>

      <a href="{{ '#' }}" class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-[color:var(--brand)]/10 transition">
        <svg class="w-5 h-5 text-[color:var(--brand)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 20l9-5-9-5-9 5 9 5z"/></svg>
        <span class="text-sm">Game Info</span>
      </a>

      <a href="{{ '#' }}" class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-[color:var(--brand)]/10 transition">
        <svg class="w-5 h-5 text-[color:var(--brand)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h10M7 16h10"/></svg>
        <span class="text-sm">Announcements</span>
      </a>

      <a href="{{ '#' }}" class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-[color:var(--brand)]/10 transition">
        <svg class="w-5 h-5 text-[color:var(--brand)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6a2 2 0 012-2h2a2 2 0 012 2v6"/></svg>
        <span class="text-sm">Status</span>
      </a>
    </nav>

    <div class="px-4 py-4 border-t">
      <a href="{{ '#' }}" class="flex items-center gap-3 px-2 py-2 rounded-md hover:bg-gray-50 transition">
        <div class="w-9 h-9 rounded-full bg-[color:var(--brand)]/10 text-[color:var(--brand)] flex items-center justify-center font-semibold">
          {{ strtoupper(substr(Auth::user()->Name ?? 'S',0,1)) }}
        </div>
        <div>
          <p class="text-sm font-medium">{{ Auth::user()->Name ?? 'Student' }}</p>
          <p class="text-xs text-[color:var(--muted)]">View profile</p>
        </div>
      </a>
    </div>
  </aside>

  <!-- Main content column -->
  <div class="flex-1 flex flex-col">

    <!-- TOP NAVBAR (student teal) -->
    <header class="w-full bg-[linear-gradient(90deg,var(--brand),var(--brand-600))] text-white shadow-sm">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">

          <!-- Left: mobile menu + brand -->
          <div class="flex items-center gap-3">
            <button id="mobile-toggle" class="md:hidden p-2 rounded-md hover:bg-white/10 transition text-white" aria-label="Open sidebar">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>

            <div class="hidden md:flex items-center gap-3">
              <div class="bg-white/10 p-2 rounded-md">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7l9-4 9 4-9 4-9-4z"/></svg>
              </div>
              <span class="font-semibold text-sm">Athlentry</span>
            </div>
          </div>

          <!-- Center: optional small search -->
          <div class="flex-1 mx-4">
            <form action="#" method="GET" class="max-w-xl mx-auto">
              <label for="global-search" class="sr-only">Search</label>
              <div class="relative">
                <input id="global-search" name="q" type="search"
                       class="w-full rounded-full border border-white/20 bg-white/95 px-4 py-2 pl-10 text-sm placeholder:text-[color:var(--muted)] focus:outline-none focus:ring-2 focus:ring-[color:var(--brand)] transition"
                       placeholder="Search announcements, events..." />
                <div class="absolute left-3 top-1/2 -translate-y-1/2 text-[color:var(--brand)]">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M10.5 18a7.5 7.5 0 100-15 7.5 7.5 0 000 15z"/></svg>
                </div>
              </div>
            </form>
          </div>

          <!-- Right: actions -->
          <div class="flex items-center gap-3">
            <!-- notifications -->
            <button class="relative p-2 rounded-md hover:bg-white/10 transition" title="Notifications">
              <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h11z"/></svg>
              <span class="absolute -top-0.5 -right-0.5 inline-flex items-center justify-center px-1.5 py-0.5 text-xs font-semibold leading-none text-[color:var(--brand)] bg-white rounded-full">2</span>
            </button>

            <!-- profile dropdown -->
            <div class="relative">
              <button id="profile-btn" class="flex items-center gap-2 px-3 py-1.5 rounded-full hover:bg-white/10 transition">
                <div class="w-8 h-8 rounded-full bg-white text-[color:var(--brand)] flex items-center justify-center font-bold">
                  {{ strtoupper(substr(Auth::user()->Name ?? 'S',0,1)) }}
                </div>
                <span class="hidden sm:block text-sm font-medium">{{ Auth::user()->Name ?? 'Student' }}</span>
                <svg class="w-4 h-4 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
              </button>

              <div id="profile-menu" class="hidden absolute right-0 mt-2 w-48 bg-white text-sm rounded-md shadow-lg overflow-hidden z-10">
                <a href="{{ '#' }}" class="block px-4 py-2 hover:bg-gray-100">My Profile</a>
                <div class="border-t"></div>
                <form action="{{ route('logout') }}" method="POST" class="m-0">
                  @csrf
                  <button type="submit" class="w-full text-left px-4 py-2 text-red-600 hover:bg-gray-100">Logout</button>
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
      <aside class="absolute left-0 top-0 bottom-0 w-72 bg-white shadow-xl">
        <div class="px-4 py-5 flex items-center justify-between">
          <div class="flex items-center gap-3">
            <div class="bg-[color:var(--brand)]/10 p-2 rounded">
              <svg class="w-6 h-6 text-[color:var(--brand)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7l9-4 9 4-9 4-9-4z"/></svg>
            </div>
            <div>
              <h2 class="font-semibold">Athlentry</h2>
              <p class="text-xs text-[color:var(--muted)]">Hello, {{ Auth::user()->Name ?? 'Student' }}</p>
            </div>
          </div>
          <button id="mobile-close" class="p-2 rounded-md hover:bg-gray-100">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
          </button>
        </div>

        <nav class="px-4 py-4 space-y-1">
          <a href="{{ route('student.announcements.index') }}" class="block px-3 py-2 rounded hover:bg-gray-100">Home</a>
          <a href="{{ '#' }}" class="block px-3 py-2 rounded hover:bg-gray-100">Application</a>
          <a href="{{ '#' }}" class="block px-3 py-2 rounded hover:bg-gray-100">Game Info</a>
          <a href="{{ '#' }}" class="block px-3 py-2 rounded hover:bg-gray-100">Announcements</a>
          <a href="{{ '#' }}" class="block px-3 py-2 rounded hover:bg-gray-100">Status</a>
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
    <footer class="border-t text-sm text-[color:var(--muted)]">
      <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
        <div>© {{ date('Y') }} Athlentry</div>
        <div class="hidden sm:block">Student Portal</div>
      </div>
    </footer>
  </div>
</div>

<!-- Minimal JS: mobile sidebar + profile dropdown -->
<script>
  (function(){
    const mobileToggle = document.getElementById('mobile-toggle');
    const mobileSidebar = document.getElementById('mobile-sidebar');
    const mobileBackdrop = document.getElementById('mobile-backdrop');
    const mobileClose = document.getElementById('mobile-close');
    const profileBtn = document.getElementById('profile-btn');
    const profileMenu = document.getElementById('profile-menu');

    function openMobile(){ mobileSidebar.classList.remove('hidden'); }
    function closeMobile(){ mobileSidebar.classList.add('hidden'); }

    mobileToggle && mobileToggle.addEventListener('click', openMobile);
    mobileClose && mobileClose.addEventListener('click', closeMobile);
    mobileBackdrop && mobileBackdrop.addEventListener('click', closeMobile);

    profileBtn && profileBtn.addEventListener('click', function(e){
      e.stopPropagation();
      profileMenu.classList.toggle('hidden');
    });

    document.addEventListener('click', function(){ profileMenu && profileMenu.classList.add('hidden'); });
    document.addEventListener('keydown', function(e){ if(e.key === 'Escape'){ closeMobile(); profileMenu && profileMenu.classList.add('hidden'); } });
  })();
</script>

@yield('scripts')
</body>
</html>