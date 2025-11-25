@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto p-6">

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold">List of Games</h1>
        <a href="{{ route('admin.games.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded">
            Add New Game
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 border border-green-200 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="space-y-6">
        @forelse($events as $event)
            <div class="bg-white rounded-2xl shadow p-5">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">{{ $event->EventName }}</h2>

                @if($event->games->count() == 0)
                    <p class="text-gray-500 text-sm">No games added to this event.</p>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($event->games as $game)
                            <div class="border rounded-xl p-4">
                                <h3 class="font-semibold text-gray-800 text-lg">{{ $game->GameName }}</h3>

                                <div class="text-sm text-gray-600 mt-2">
                                    <div>Date: {{ $game->GameDate->format('d M Y') }}</div>
                                    <div>Category: {{ $game->Category ?? '-' }}</div>
                                    <div>Status: 
                                        <span class="px-2 py-1 rounded text-xs 
                                            @if($game->Status == 'Open') bg-green-100 text-green-700
                                            @elseif($game->Status == 'Closed') bg-red-100 text-red-700
                                            @else bg-gray-100 text-gray-700 @endif">
                                            {{ $game->Status ?? 'N/A' }}
                                        </span>
                                    </div>
                                </div>

                                <div class="flex items-center gap-3 mt-3">
                                    <a href="{{ route('admin.games.show', $game->GameID) }}" 
                                       class="text-blue-600 text-sm">View</a>

                                    <a href="{{ route('admin.games.edit', $game->GameID) }}" 
                                       class="text-yellow-600 text-sm">Edit</a>

                                    <form action="{{ route('admin.games.destroy', $game->GameID) }}" 
                                          method="POST" 
                                          onsubmit="return confirm('Delete this game?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-600 text-sm">Delete</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @empty
            <div class="text-center text-gray-500">No events available.</div>
        @endforelse
    </div>

</div>
@endsection
