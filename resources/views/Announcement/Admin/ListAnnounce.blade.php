@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-[#E15B5B]">
    <div class="max-w-7xl mx-auto px-8 py-8">

        {{-- TOP NAV LIKE YOUR SCREENSHOT --}}
        <div class="flex items-center justify-between mb-10">
            <nav class="flex gap-6 text-white text-sm">
                <a>Home</a>
                <a>Application</a>
                <a>Game Information</a>
                <span class="font-bold">Dashboard and Report</span>
                <a>Status</a>
            </nav>

            {{-- ADD BUTTON --}}
            <a href="{{ route('admin.announcements.create') }}"
               class="bg-green-500 hover:bg-green-600 text-white px-5 py-2 rounded-full">
               Add
            </a>
        </div>

        {{-- FEATURED EVENTS --}}
        <h2 class="text-lg font-semibold text-white mb-4">Featured Events</h2>

        <div class="grid grid-cols-4 gap-6 mb-12">
            @foreach ($announcements as $announce)
                @include('Announcement.components.card',['announce'=>$announce])
            @endforeach
        </div>

        {{-- SPECIAL OFFERS --}}
        <h2 class="text-lg font-semibold text-white mb-4">Special Offers</h2>

        <div class="w-48">
            <img src="{{ asset('images/sample-offer.jpg') }}" class="rounded-lg shadow mb-2">
            <div class="text-white text-sm font-semibold">Purchase Sukfac T-Shirt</div>
            <div class="text-white text-xs">26 October 2025, Sunday</div>
        </div>

    </div>
</div>
@endsection
