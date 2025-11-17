@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#E15B5B]">
    <div class="max-w-7xl mx-auto px-8 py-10">

        <h2 class="text-xl font-semibold text-white mb-6">Featured Events</h2>

        <div class="grid grid-cols-4 gap-6 mb-12">
            @foreach ($announcements as $announce)
                @include('Announcement.components.card',['announce'=>$announce])
            @endforeach
        </div>

        <h2 class="text-lg font-semibold text-white mb-4">Special Offers</h2>

        <div class="w-48">
            <img src="{{ asset('images/sample-offer.jpg') }}" class="rounded-lg shadow mb-2">
            <div class="text-white text-sm font-semibold">Purchase Sukfac T-Shirt</div>
            <div class="text-white text-xs">26 October 2025, Sunday</div>
        </div>

    </div>
</div>
@endsection
