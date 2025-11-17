@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-[rgb(235,100,100)]">
  <div class="max-w-6xl mx-auto px-6 py-8">

    {{-- Top bar / nav (visual only) --}}
    <div class="flex items-center justify-between mb-6">
      <div class="text-white">
        <nav class="flex gap-6 text-sm">
          <a class="opacity-90">Home</a>
          <a class="opacity-90">Application</a>
          <a class="opacity-90">Game Information</a>
          <span class="font-bold">Dashboard and Report</span>
          <a class="opacity-90">Status</a>
        </nav>
      </div>

      <div>
        <a href="{{ route('admin.announcements.create') }}" class="inline-block bg-emerald-500 text-white px-4 py-2 rounded-full">Add</a>
      </div>
    </div>

    @if(session('success'))
      <div class="mb-4 bg-green-100 text-green-800 p-3 rounded">{{ session('success') }}</div>
    @endif

    <div class="text-black/80 mb-4">
      <h2 class="text-base font-semibold mb-2">Featured Events</h2>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
      @foreach($announcements as $announce)
        @include('Announcement.components.card', ['announce' => $announce])
      @endforeach
    </div>

    {{-- Special Offers example --}}
    <div class="mb-6">
      <h3 class="text-base font-semibold mb-3">Special Offers</h3>
      <div class="w-48 bg-white p-3 rounded-lg shadow">
        <img src="{{ asset('images/sample-offer.jpg') }}" alt="offer" class="w-full rounded mb-2">
        <div class="text-xs font-semibold">Purchase Sukfac T-Shirt</div>
        <div class="text-[11px] text-slate-600">26 October 2025, Sunday</div>
      </div>
    </div>

  </div>
</div>
@endsection
