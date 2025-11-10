<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Athlentry Admin' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    {{-- Admin Navbar --}}
    <nav class="bg-gray-800 text-white px-6 py-3 flex justify-between items-center">
        <h1 class="text-lg font-semibold">Athlentry Admin Panel</h1>
        <div class="space-x-4">
            <a href="{{ route('admin.dashboard') }}" class="hover:underline">Dashboard</a>
            <a href="{{ route('admin.students') }}" class="hover:underline">Students</a>
            <a href="{{ route('admin.announcements') }}" class="hover:underline">Announcements</a>
            <a href="{{ route('logout') }}" class="bg-red-500 hover:bg-red-600 px-3 py-1 rounded text-sm">Logout</a>
        </div>
    </nav>

    {{-- Main content --}}
    <main class="p-6">
        @yield('content')
    </main>

</body>
</html>
