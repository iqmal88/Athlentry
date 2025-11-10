@extends('layouts.admin')

@section('content')
<div class="flex justify-center items-center min-h-screen bg-gray-100">
    <div class="w-full max-w-md bg-white p-8 rounded-2xl shadow-lg">
        <h1 class="text-2xl font-bold text-gray-700 mb-6 text-center">Athlentry Admin Login</h1>

        {{-- Error message --}}
        @if ($errors->any())
            <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-4">
            @csrf

            {{-- Matric Number --}}
            <div>
                <label for="matric_no" class="block text-sm font-medium text-gray-600">Matric Number</label>
                <input type="text" id="matric_no" name="matric_no" value="{{ old('matric_no') }}"
                       class="w-full border border-gray-300 rounded-md p-2 mt-1 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                       required autofocus>
            </div>

            {{-- Password --}}
            <div>
                <label for="password" class="block text-sm font-medium text-gray-600">Password</label>
                <input type="password" id="password" name="password"
                       class="w-full border border-gray-300 rounded-md p-2 mt-1 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                       required>
            </div>

            {{-- Submit Button --}}
            <div>
                <button type="submit"
                        class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition duration-200">
                    Sign In
                </button>
            </div>
        </form>

        <p class="text-xs text-gray-500 text-center mt-6">© {{ date('Y') }} Athlentry Admin Panel</p>
    </div>
</div>
@endsection
