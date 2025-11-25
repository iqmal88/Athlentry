@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto p-6">

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold">{{ $game->GameName }}</h1>
        <a href="{{ route('admin.games.index') }}" class="text-sm text-gray-600">Back to Games</a>
    </div>

    <div class="bg-white rounded-2xl shadow p-6 space-y-6">

        {{-- Info --}}
        <div class="grid grid-cols-2 gap-4">
            <div>
                <div class="text-sm text-gray-600">Event</div>
                <div class="font-medium">{{ optional($game->event)->EventName }}</div>
            </div>

            <div>
                <div class="text-sm text-gray-600">Category</div>
                <div class="font-medium">{{ $game->Category ?? '-' }}</div>
            </div>

            <div>
                <div class="text-sm text-gray-600">Game Date</div>
                <div class="font-medium">{{ $game->GameDate->format('d M Y') }}</div>
            </div>

            <div>
                <div class="text-sm text-gray-600">Game Time</div>
                <div class="font-medium">{{ $game->GameTime ?? '-' }}</div>
            </div>

            <div>
                <div class="text-sm text-gray-600">Selection Place</div>
                <div class="font-medium">{{ $game->SelectionPlace ?? '-' }}</div>
            </div>

            <div>
                <div class="text-sm text-gray-600">Coach</div>
                <div class="font-medium">{{ $game->CoachName ?? '-' }} ({{ $game->CoachPhone ?? '-' }})</div>
            </div>

            <div>
                <div class="text-sm text-gray-600">Capacity</div>
                <div class="font-medium">{{ $game->Capacity ?? '-' }}</div>
            </div>

            <div>
                <div class="text-sm text-gray-600">Status</div>
                <div class="font-medium">{{ $game->Status }}</div>
            </div>
        </div>

        {{-- Description --}}
        <div>
            <div class="text-sm text-gray-600">Description</div>
            <div class="mt-1 text-gray-800">{{ $game->Description ?? '-' }}</div>
        </div>

        {{-- Link to applicants --}}
        <div class="pt-4">
            <a href="{{ route('admin.games.applications', $game->GameID) }}"
               class="px-4 py-2 bg-blue-600 text-white rounded">
               View Applicants
            </a>
        </div>

    </div>

</div>
@endsection
