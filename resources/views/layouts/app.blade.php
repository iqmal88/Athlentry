<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Student - @yield('title', 'Athlentry')</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <style> :root{ --maroon:#8B1E2F; --maroon-dark:#5e101b } body{ font-family:Inter,system-ui; } </style>
</head>
<body class="bg-gray-50 min-h-screen">
  {{-- optional nav for students --}}
  <nav class="bg-white shadow px-4 py-3">
    <div class="max-w-6xl mx-auto flex justify-between items-center">
      <a href="{{ route('home') }}" class="font-semibold">Athlentry</a>
      <div>
        @auth
          <span class="text-sm mr-3">Hi, {{ auth()->user()->Name }}</span>
          <a href="{{ route('logout') }}" class="text-sm text-red-600">Logout</a>
        @endauth
      </div>
    </div>
  </nav>

  <main class="py-6">
    @yield('content')
  </main>

  @yield('scripts')
</body>
</html>
