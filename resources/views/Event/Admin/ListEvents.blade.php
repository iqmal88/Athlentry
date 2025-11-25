@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto p-6">

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold">List of Events</h1>
        <a href="{{ route('admin.events.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded">
            Add New Event
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 border border-green-200 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow p-4">

        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50 text-gray-600">
                <tr>
                    <th class="p-3 text-left">Event</th>
                    <th class="p-3 text-left">Date</th>
                    <th class="p-3 text-left">Games</th>
                    <th class="p-3 text-left">Status</th>
                    <th class="p-3 text-left">Actions</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100">
                @forelse($events as $event)
                <tr>
                    <td class="p-3 font-medium">{{ $event->EventName }}</td>

                    <td class="p-3">
                        {{ $event->StartDate ? $event->StartDate->format('d M Y') : '-' }}  
                        to  
                        {{ $event->EndDate ? $event->EndDate->format('d M Y') : '-' }}
                    </td>

                    <td class="p-3">{{ $event->games_count ?? $event->games->count() }} Games</td>

                    <td class="p-3">
                        <span class="text-xs px-2 py-1 rounded 
                            @if($event->Status == 'Open') bg-green-100 text-green-700
                            @elseif($event->Status == 'Closed') bg-red-100 text-red-700
                            @else bg-gray-100 text-gray-700 @endif">
                            {{ $event->Status }}
                        </span>
                    </td>

                    <td class="p-3">
                        <div class="flex items-center gap-3">
                            <a href="{{ route('admin.events.show', $event->EventID) }}" class="text-blue-600 text-sm">View</a>
                            <a href="{{ route('admin.events.edit', $event->EventID) }}" class="text-yellow-600 text-sm">Edit</a>

                            <form action="{{ route('admin.events.destroy', $event->EventID) }}" method="POST" onsubmit="return confirm('Delete this event?');">
                                @csrf
                                @method('DELETE')
                                <button class="text-sm text-red-600">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-6 text-center text-gray-500">No events found.</td>
                </tr>
                @endforelse
            </tbody>

        </table>

    </div>
</div>
@endsection
