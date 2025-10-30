@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto mt-10 bg-white rounded-2xl shadow-md p-8">
    <div class="flex flex-col md:flex-row items-center md:items-start gap-8">
        {{-- Left section: profile photo --}}
        <div class="flex flex-col items-center w-full md:w-1/3">
            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->Name) }}&background=3b82f6&color=fff&size=128"
                 class="w-32 h-32 rounded-full border-4 border-blue-500 shadow-md" alt="Profile photo">

            <button class="mt-4 bg-blue-600 text-white text-sm px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                Change Photo
            </button>
        </div>

        {{-- Right section: user details --}}
        <div class="flex-1 w-full">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-semibold text-gray-800">My Profile</h1>
                <a href="{{ route('profile.edit') }}"
                   class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                    Edit Profile
                </a>
            </div>

            {{-- Success message --}}
            @if (session('success'))
                <div class="bg-green-100 text-green-700 p-3 rounded-lg mb-4 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-1 gap-6">
                <div>
                    <p class="text-sm text-gray-500">Name</p>
                    <p class="font-medium text-gray-800">{{ $user->Name }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Matric ID</p>
                    <p class="font-medium text-gray-800">{{ $user->MatricNo }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Email</p>
                    <p class="font-medium text-gray-800">{{ $user->Email }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Phone Number</p>
                    <p class="font-medium text-gray-800">{{ $user->PhoneNumber }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Password</p>
                    <p class="font-medium text-gray-800">********</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
