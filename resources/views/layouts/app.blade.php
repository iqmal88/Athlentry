<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Student - @yield('title', 'Athlentry')</title>

  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

  <style>
    body { font-family: Inter, system-ui, sans-serif; }
  </style>
</head>

<body class="bg-gray-50 min-h-screen">

  {{-- Student Navigation Bar --}}
  <nav class="bg-gradient-to-r from-blue-700 to-blue-600 shadow-lg">
    <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">

      {{-- Left: Logo --}}
      <a href="{{ route('student.announcements.index') }}" class="flex items-center gap-2">
        <img src="{{ asset('images/logo.png') }}" onerror="this.style.display='none';"
             class="h-7" alt="">
        <span class="text-white text-xl font-semibold tracking-wide">Athlentry</span>
      </a>

      {{-- Right: User dropdown --}}
      <div class="relative" x-data="{ open:false }">

        @auth
        <button class="flex items-center gap-2 text-white text-sm font-medium hover:opacity-90"
                @click="open = !open">
          <span>Hi, {{ auth()->user()->Name }}</span>
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
               viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M19 9l-7 7-7-7"/>
          </svg>
        </button>

        {{-- Dropdown --}}
        <div x-show="open" @click.outside="open = false"
             class="absolute right-0 mt-2 w-40 bg-white rounded-lg shadow-lg border p-2 z-20">
          <hr class="my-1">

          <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="text-red-600">Logout</button>
          </form>

        </div>
        @endauth

      </div>

    </div>
  </nav>


  <main class="py-6">
    @yield('content')
  </main>

  @yield('scripts')

  {{-- AlpineJS CD for dropdown --}}
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

</body>
</html>
