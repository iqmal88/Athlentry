@extends('layouts.admin')

@section('content')
<div class="max-w-6xl mx-auto px-6 py-10">

  {{-- Back link --}}
  <div class="mb-4">
    <a href="{{ route('admin.gameinfo.index') }}" 
       class="inline-flex items-center gap-2 text-sm text-gray-600 hover:text-[#800000] transition">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" 
           viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M15 19l-7-7 7-7" />
      </svg>
      Back to Game List
    </a>
  </div>

  {{-- HEADER CARD --}}
  <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-8 mb-8">

    <div class="flex items-start justify-between">
      <div class="space-y-1">
        <h1 class="text-3xl font-bold text-gray-900">{{ $game->GameName }}</h1>
        <p class="text-sm text-gray-500">
          Part of: 
          <span class="font-semibold text-gray-700">{{ $game->event->EventName ?? '-' }}</span>
        </p>
      </div>

      <div class="flex items-center gap-2">
        <a href="{{ route('admin.gameinfo.edit', $game->GameID) }}" 
           class="px-4 py-2 bg-[#800000] text-white rounded-lg shadow-sm hover:bg-[#650000] transition">
          Edit
        </a>

        <form action="{{ route('admin.gameinfo.destroy', $game->GameID) }}" method="POST"
              onsubmit="return confirm('Delete this game?');">
          @csrf @method('DELETE')
          <button class="px-4 py-2 bg-red-600 text-white rounded-lg shadow-sm hover:bg-red-700 transition">
            Delete
          </button>
        </form>
      </div>
    </div>

    {{-- STATUS BADGE --}}
    <div class="mt-5">
      <span class="inline-flex items-center px-4 py-1.5 rounded-full text-sm font-medium
        @if(strtolower($game->final_status) === 'open') bg-green-50 text-green-700
        @elseif(strtolower($game->final_status) === 'closed') bg-gray-100 text-gray-700
        @else bg-red-50 text-red-700 @endif">
        Status: {{ $game->final_status }}
      </span>
    </div>

  </div>

  {{-- CONTENT SECTIONS --}}
  <div class="space-y-8">

    {{-- DESCRIPTION --}}
    <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-8">
      <h2 class="text-xl font-semibold text-gray-900 mb-4">Description</h2>
      <p class="text-gray-700 whitespace-pre-line">
        {{ $game->Description ?: '-' }}
      </p>
    </div>

    {{-- DETAILS GRID --}}
    <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-8">
      <h2 class="text-xl font-semibold text-gray-900 mb-6">Details</h2>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-gray-700">

        <div>
          <p class="text-sm font-semibold text-gray-600">Selection Place</p>
          <p class="text-base mt-1">{{ $game->SelectionPlace ?: '-' }}</p>
        </div>

        <div>
          <p class="text-sm font-semibold text-gray-600">Selection Date</p>
          <p class="text-base mt-1">
            {{ $game->GameDate ? \Carbon\Carbon::parse($game->GameDate)->format('d M Y') : '-' }}
          </p>
        </div>

        <div>
          <p class="text-sm font-semibold text-gray-600">Coach</p>
          <p class="text-base mt-1">{{ $game->CoachName ?: '-' }}</p>
        </div>

        <div>
          <p class="text-sm font-semibold text-gray-600">Coach Phone Number</p>
          <p class="text-base mt-1">{{ $game->CoachPhone ?: '-' }}</p>
        </div>

        <div>
          <p class="text-sm font-semibold text-gray-600">Category</p>
          <p class="text-base mt-1">{{ $game->Category ?: '-' }}</p>
        </div>

        <div>
          <p class="text-sm font-semibold text-gray-600">Capacity</p>
          <p class="text-base mt-1">{{ $game->Capacity ?: '-' }}</p>
        </div>
      </div>
    </div>

    {{-- RULES --}}
    <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-8">
      <h2 class="text-xl font-semibold text-gray-900 mb-4">Rules</h2>

      @if($game->Rules)
        <ul class="list-disc pl-6 space-y-1 text-gray-700">
          @foreach(explode("\n", $game->Rules) as $rule)
            <li>{{ trim($rule) }}</li>
          @endforeach
        </ul>
      @else
        <p class="text-gray-500">No rules provided.</p>
      @endif
    </div>

  </div>

</div>
@endsection
