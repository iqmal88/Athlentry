@extends('layouts.admin')

@section('content')
<div class="max-w-5xl mx-auto p-6">

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold">{{ $event->EventName }}</h1>

        <a href="{{ route('admin.events.index') }}" class="text-sm text-gray-600">Back to Events</a>
    </div>

    <div class="bg-white rounded-2xl shadow p-6 space-y-6">

        {{-- Event Summary --}}
        <div class="grid grid-cols-2 gap-4">

            <div>
                <div class="text-sm text-gray-600">Location</div>
                <div class="font-medium">{{ $event->Location ?? '-' }}</div>
            </div>

            <div>
                <div class="text-sm text-gray-600">Status</div>
                <div class="font-medium">{{ $event->Status }}</div>
            </div>

            <div>
                <div class="text-sm text-gray-600">Start Date</div>
                <div class="font-medium">
                    {{ $event->StartDate ? $event->StartDate->format('d M Y') : '-' }}
                </div>
            </div>

            <div>
                <div class="text-sm text-gray-600">End Date</div>
                <div class="font-medium">
                    {{ $event->EndDate ? $event->EndDate->format('d M Y') : '-' }}
                </div>
            </div>

        </div>

        {{-- Description --}}
        <div>
            <div class="text-sm text-gray-600">Description</div>
            <div class="mt-1 text-gray-800">{{ $event->Description ?? '-' }}</div>
        </div>

        {{-- Games Under Event --}}
        <div class="pt-4">
            <h2 class="text-xl font-semibold mb-4">Games in This Event</h2>

            @if($event->games->count() == 0)
                <div class="text-gray-500">No games added to this event.</div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($event->games as $game)
                        <div class="border rounded-xl p-4">
                            <h3 class="font-medium">{{ $game->GameName }}</h3>
                            <div class="text-sm text-gray-500">
                                {{ $game->GameDate->format('d M Y') }}
                            </div>

                            <div class="flex items-center gap-2 mt-3">
                                <a href="{{ route('admin.games.show', $game->GameID) }}"
                                   class="text-blue-600 text-sm">View</a>

                                <a href="{{ route('admin.games.edit', $game->GameID) }}" 
                                   class="text-yellow-600 text-sm">Edit</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    </div>

</div>
@endsection
