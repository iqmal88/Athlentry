<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Athlentry | Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-50 to-blue-100 min-h-screen flex items-center justify-center">

    <div class="bg-white shadow-2xl rounded-2xl p-8 w-full max-w-md">
        <h1 class="text-3xl font-bold text-center text-blue-700 mb-6">Register Account</h1>
        
        {{-- Error message --}}
        @if (session('error'))
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-sm">
                {{ session('error') }}
            </div>
        @endif

        {{-- Success message --}}
        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4 text-sm">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('register.post') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700">Full Name</label>
                <input type="text" name="Name" class="w-full mt-1 p-2 border rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none" placeholder="Enter your name" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="Email" class="w-full mt-1 p-2 border rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none" placeholder="e.g. name@student.ump.edu.my" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Matric Number/Staff Number</label>
                <input type="text" name="MatricNo" class="w-full mt-1 p-2 border rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none" placeholder="e.g. CB23001" required>
            </div>
            
            <div>
                 <label class="block text-sm font-medium text-gray-700">Phone Number</label>
                 <input 
                    type="text" 
                    name="PhoneNumber" 
                    class="w-full mt-1 p-2 border rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none" 
                    placeholder="e.g. 0123456789" 
                    required
                >
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="Password" class="w-full mt-1 p-2 border rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none" placeholder="Create a password" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Medical History (Optional)</label>
                <textarea name="MedicalHistory" rows="3" class="w-full mt-1 p-2 border rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none" placeholder="E.g. Asthma, knee injury, etc."></textarea>
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition font-semibold">
                Register
            </button>
        </form>

        <p class="text-center text-sm text-gray-600 mt-4">
            Already have an account?
            <a href="{{ route('login.view') }}" class="text-blue-600 hover:underline font-semibold">Login here</a>
        </p>
    </div>

</body>
</html>
