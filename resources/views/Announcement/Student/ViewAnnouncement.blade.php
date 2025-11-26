@extends('layouts.app')

@section('title', $announcement->Title)

@section('content')
@php
    // local dev fallback image (replace with your placeholder if needed)
    $fallbackImage = '/mnt/data/a0b72737-0944-4be7-9875-4f13fc0c3094.png';
    $imgSrc = $announcement->Image ? asset('storage/' . $announcement->Image) : $fallbackImage;
@endphp

<div class="min-h-screen bg-gray-50 py-8">
  <div class="max-w-6xl mx-auto px-4">

    {{-- Header --}}
    <div class="mb-6">
      <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900">{{ $announcement->Title }}</h1>
      <p class="text-sm text-gray-500 mt-1">Announcement details</p>
    </div>

    {{-- Main layout: image + description (left), info card (right) --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

      {{-- Left: image + description --}}
      <div class="lg:col-span-2">
        <div class="bg-white rounded-xl overflow-hidden shadow-md">
          <img src="{{ $imgSrc }}" alt="{{ $announcement->Title }}" class="w-full h-96 object-cover">

          <div class="p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-3">About</h2>

            <div class="prose text-gray-700">
              {!! nl2br(e($announcement->Description ?? 'No additional details.')) !!}
            </div>
          </div>
        </div>

        {{-- optional: Back button --}}
        <div class="mt-4">
          <a href="{{ route('student.announcements.index') }}"
             class="inline-flex items-center gap-2 px-4 py-2 rounded-md border bg-white text-gray-700 hover:shadow">
            &larr; Back to Announcements
          </a>
        </div>
      </div>

      {{-- Right: event info card (view only) --}}
      <aside class="bg-white rounded-xl shadow-md p-5">
        <div class="border-b pb-4 mb-4">
          <h3 class="text-sm font-semibold text-gray-700">Event Info</h3>
        </div>

        <div class="space-y-4 text-sm text-gray-700">
          {{-- DATE --}}
          <div class="flex items-start gap-3">
            <div class="flex-shrink-0 mt-0.5">
              <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M8 7V3m8 4V3M3 11h18M5 21h14a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2z"/>
              </svg>
            </div>
            <div>
              <div class="text-xs text-gray-500">Date</div>
              <div class="font-medium">{{ $announcement->Date ? \Carbon\Carbon::parse($announcement->Date)->format('d F, Y') : '-' }}</div>
            </div>
          </div>

          {{-- TIME --}}
          <div class="flex items-start gap-3">
            <div class="flex-shrink-0 mt-0.5">
              <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 8v4l3 3M12 6a6 6 0 1 0 0 12 6 6 0 0 0 0-12z"/>
              </svg>
            </div>
            <div>
              <div class="text-xs text-gray-500">Time</div>
              <div class="font-medium">
                @if($announcement->TimeFrom || $announcement->TimeUntil)
                  {{ $announcement->TimeFrom ? \Carbon\Carbon::parse($announcement->TimeFrom)->format('h:i A') : '' }}
                  @if($announcement->TimeFrom && $announcement->TimeUntil) &nbsp;–&nbsp; @endif
                  {{ $announcement->TimeUntil ? \Carbon\Carbon::parse($announcement->TimeUntil)->format('h:i A') : '' }}
                @else
                  -
                @endif
                <div class="text-xs text-gray-400 mt-1">({{ config('app.timezone') }})</div>
              </div>
            </div>
          </div>

          {{-- LOCATION --}}
          <div class="flex items-start gap-3">
            <div class="flex-shrink-0 mt-0.5">
              <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 11c1.657 0 3-1.343 3-3S13.657 5 12 5 9 6.343 9 8s1.343 3 3 3z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 21s8-4.5 8-10a8 8 0 1 0-16 0c0 5.5 8 10 8 10z"/>
              </svg>
            </div>
            <div>
              <div class="text-xs text-gray-500">Location</div>
              <div class="font-medium">{{ $announcement->Location ?? '-' }}</div>
            </div>
          </div>

          {{-- Add to calendar link --}}
          <div class="pt-2">
            <a href="#" class="text-sm text-[#e7542e] hover:underline">Add to my calendar</a>
          </div>
        </div>
      </aside>
    </div>
  </div>
</div>

<style>
/* small polish */
.prose p { color: #374151; }
.bg-white { background: linear-gradient(180deg,#ffffff,#fffaf9); } /* subtle warmth */
</style>
@endsection
