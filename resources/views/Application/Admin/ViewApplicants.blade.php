@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10">

  {{-- Back link --}}
  <div class="mb-3">
    <a href="{{ route('admin.events.list') }}"
       class="inline-flex items-center gap-2 text-sm text-gray-600 hover:text-[#800000] transition">
      <svg xmlns="http://www.w3.org/2000/svg"
           class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M15 19l-7-7 7-7" />
      </svg>
      Back to Events
    </a>
  </div>

  {{-- Page header --}}
  <div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-900">{{ $game->GameName }}</h1>

    <p class="text-sm text-gray-500 mt-1">
      Applicants:
      <span class="font-semibold">{{ $applications->count() }}</span>
      @if(isset($capacity))
        / {{ $capacity }}
      @endif
    </p>
  </div>

  {{-- Main container --}}
  <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8">

    {{-- Feedback messages --}}
    @if(session('success'))
      <div class="mb-4 p-3 rounded bg-green-50 text-green-800 border border-green-100">
        {{ session('success') }}
      </div>
    @endif
    @if(session('error'))
      <div class="mb-4 p-3 rounded bg-red-50 text-red-800 border border-red-100">
        {{ session('error') }}
      </div>
    @endif

    {{-- Applicants list --}}
    <h2 class="text-xl font-semibold text-gray-800 mb-4">Applicants</h2>

    <div class="space-y-4">
      @forelse($applications as $app)

        <div class="flex items-center justify-between bg-gray-50 border border-gray-200 rounded-xl px-5 py-4 shadow-sm hover:shadow-md transition">

          {{-- Left: Applicant info --}}
          <div>
            <div class="text-gray-900 font-semibold text-lg">
              {{ optional($app->user)->name ?? (optional($app->user)->FullName ?? 'User ' . $app->UserID) }}
            </div>

            <div class="text-sm text-gray-500 mt-1">
              Applied:
              <span class="font-medium">
                {{ \Carbon\Carbon::parse($app->DateApplied)->format('d M Y, h:i A') }}
              </span>
            </div>

            @if($app->StatusID)
              <div class="mt-1">
                <span class="inline-flex items-center px-2 py-0.5 text-xs rounded-full 
                @if($app->StatusID == 2) bg-green-100 text-green-700 
                @else bg-gray-200 text-gray-700 @endif">
                  Status: {{ $app->StatusID }}
                </span>
              </div>
            @endif
          </div>

          {{-- Right: Select button --}}
          <form method="POST" action="{{ route('admin.applications.select', $app->ApplicationID) }}">
            @csrf
            <input type="hidden" name="StatusID" value="2" />

            <button
              type="submit"
              class="inline-flex items-center px-5 py-2 bg-green-700 text-white rounded-full text-sm font-medium 
                     hover:bg-green-800 focus:outline-none shadow">
              Select
            </button>
          </form>
        </div>

      @empty
        <div class="p-5 bg-white rounded-xl text-center text-gray-600 border">
          No applicants yet for this game.
        </div>
      @endforelse
    </div>

  </div>

</div>
@endsection
