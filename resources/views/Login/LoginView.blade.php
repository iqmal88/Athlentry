<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Athlentry | Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-50 to-blue-100 min-h-screen flex items-center justify-center">

    <div class="bg-white shadow-2xl rounded-2xl p-8 w-full max-w-md">
        <h1 class="text-3xl font-bold text-center text-blue-700 mb-6">Athlentry Login</h1>

        {{-- Error message --}}
        @if (session('error'))
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-sm">
                {{ session('error') }}
            </div>
        @endif

        {{-- Login form --}}
        <form method="POST" action="{{ route('login.post') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700">Matric Number</label>
                <input 
                    type="text" 
                    name="MatricNo" 
                    class="w-full mt-1 p-2 border rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none" 
                    placeholder="e.g. CB23001" 
                    required
                >
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Password</label>
                <input 
                    type="password" 
                    name="Password" 
                    class="w-full mt-1 p-2 border rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none" 
                    placeholder="Enter your password" 
                    required
                >
            </div>

            <div class="text-right">
                <a href="{{ route('forgotpass.view') }}" class="text-sm text-blue-600 hover:underline">
                    Forgot Password?
                </a>
            </div>


            <button 
                type="submit" 
                class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition font-semibold"
            >
                Login
            </button>
        </form>

        <p class="text-center text-sm text-gray-600 mt-4">
            Don’t have an account? 
            <a href="{{ route('register.view') }}" class="text-blue-600 hover:underline font-semibold">
                Register here
            </a>
        </p>
    </div>

</body>
</html>
