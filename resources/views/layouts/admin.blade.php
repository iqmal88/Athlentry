<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel')</title>

    {{-- Tailwind (if using CDN) --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Optional custom font --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700" rel="stylesheet" />

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-100">

    {{-- =============== TOP NAVIGATION BAR (MAROON) =============== --}}
    <nav class="bg-[#800000] text-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">

            {{-- Left: Logo / Title --}}
            <div class="flex items-center gap-2">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 7l9-4 9 4-9 4-9-4zm0 8l9 4 9-4M3 7v8m18-8v8"/>
                </svg>
                <span class="text-lg font-semibold">Admin Dashboard</span>
            </div>

            {{-- Right: Navigation + Logout --}}
            <div class="flex items-center gap-6">

                <a href="{{ route('admin.announcements.index') }}"
                   class="text-sm hover:text-gray-200">
                    Announcements
                </a>
                <a href="#"
                   class="text-sm hover:text-gray-200">
                    Athlete Application
                </a>

                {{-- Add more admin menu links here later
                <a href="#" class="text-sm hover:text-gray-200">Users</a>
                --}}

                {{-- Logout --}}
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="bg-white text-[#800000] px-3 py-1 rounded-md font-medium hover:bg-gray-200">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    {{-- ===================== MAIN PAGE CONTENT ===================== --}}
    <main class="max-w-7xl mx-auto p-6">
        @yield('content')
    </main>

</body>
</html>
