@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto mt-10 bg-white rounded-2xl shadow-md p-8">
    <h1 class="text-2xl font-semibold text-gray-800 mb-6">Edit Profile</h1>

    {{-- Success message --}}
    @if (session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded-lg mb-4 text-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- Error messages --}}
    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded-lg mb-4 text-sm">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('profile.update') }}" class="space-y-5">
        @csrf

        {{-- Full Name (Read-Only) --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">Full Name</label>
            <input type="text" name="FullName" value="{{ $user->FullName }}" readonly
                class="w-full mt-1 p-2 border rounded-lg bg-gray-100 text-gray-600 cursor-not-allowed">
        </div>

        {{-- Matric ID (Read-Only) --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">Matric ID</label>
            <input type="text" name="MatricID" value="{{ $user->MatricID }}" readonly
                class="w-full mt-1 p-2 border rounded-lg bg-gray-100 text-gray-600 cursor-not-allowed">
        </div>

        {{-- Email --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" name="Email" value="{{ old('Email', $user->Email) }}"
                class="w-full mt-1 p-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
        </div>

        {{-- Phone Number --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">Phone Number</label>
            <input type="text" name="PhoneNumber" value="{{ old('PhoneNumber', $user->PhoneNumber) }}"
                class="w-full mt-1 p-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
        </div>

        {{-- Medical History --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">Medical History</label>
            <textarea name="MedicalHistory" rows="3"
                class="w-full mt-1 p-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">{{ old('MedicalHistory', $user->MedicalHistory) }}</textarea>
        </div>

        {{-- Password (Optional) --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">New Password (Optional)</label>
            <input type="password" name="Password"
                class="w-full mt-1 p-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                placeholder="Leave blank to keep current password">
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('profile.view') }}"
                class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 transition">
                Cancel
            </a>
            <button type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                Save Changes
            </button>
        </div>
    </form>
</div>
@endsection
