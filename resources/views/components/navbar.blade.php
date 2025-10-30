<nav class="bg-white shadow-md p-4 flex justify-between items-center sticky top-0 z-50">
    <h1 class="text-xl font-bold text-blue-700">🏅 Athlentry</h1>

    <div class="space-x-6 text-gray-700 font-medium hidden md:block">
        <a href="#" class="hover:text-blue-600">Announcement</a>
        <a href="#" class="hover:text-blue-600">Application</a>
        <a href="#" class="hover:text-blue-600">Game Information</a>
        <a href="#" class="hover:text-blue-600">Dashboard and Report</a>
        <a href="#" class="hover:text-blue-600">Status</a>
    </div>

    <div class="flex items-center space-x-4">
        <a href="{{ route('profile.view') }}" class="text-blue-700 hover:underline">Profile</a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded-lg hover:bg-red-600 transition">
                Log out
            </button>
        </form>
    </div>
</nav>
