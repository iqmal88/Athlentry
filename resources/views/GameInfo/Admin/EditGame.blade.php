@extends('layouts.admin')

@section('content')
<div class="max-w-3xl mx-auto p-6">

    <h1 class="text-2xl font-semibold mb-6">Edit Game</h1>

    <div class="bg-white rounded-2xl shadow p-6">

        <form action="{{ route('admin.games.update', $game->GameID) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Event --}}
            <label class="block mb-4">
                <span class="text-gray-700">Event</span>
                <select name="EventID" class="mt-1 block w-full border rounded p-2">
                    @foreach($events as $event)
                        <option value="{{ $event->EventID }}" 
                                @if($game->EventID == $event->EventID) selected @endif>
                            {{ $event->EventName }}
                        </option>
                    @endforeach
                </select>
            </label>

            {{-- Game Name --}}
            <label class="block mb-4">
                <span class="text-gray-700">Game Name</span>
                <input type="text" name="GameName" class="block w-full border rounded p-2" value="{{ $game->GameName }}" required>
            </label>

            {{-- Category --}}
            <label class="block mb-4">
                <span class="text-gray-700">Category</span>
                <input type="text" name="Category" class="block w-full border rounded p-2" value="{{ $game->Category }}">
            </label>

            {{-- Date & Time --}}
            <div class="grid grid-cols-2 gap-4">
                <label class="block">
                    <span class="text-gray-700">Game Date</span>
                    <input type="date" name="GameDate" class="block w-full border rounded p-2" 
                           value="{{ $game->GameDate }}">
                </label>

                <label class="block">
                    <span class="text-gray-700">Game Time</span>
                    <input type="time" name="GameTime" class="block w-full border rounded p-2"
                           value="{{ $game->GameTime }}">
                </label>
            </div>

            {{-- Description --}}
            <label class="block my-4">
                <span class="text-gray-700">Description</span>
                <textarea name="Description" rows="3" class="block w-full border rounded p-2">{{ $game->Description }}</textarea>
            </label>

            {{-- Status --}}
            <label class="block mb-6">
                <span class="text-gray-700">Status</span>
                <select name="Status" class="block w-full border rounded p-2">
                    <option value="Open" @if($game->Status == 'Open') selected @endif>Open</option>
                    <option value="Closed" @if($game->Status == 'Closed') selected @endif>Closed</option>
                </select>
            </label>

            <button class="px-4 py-2 bg-blue-600 text-white rounded">Update Game</button>
        </form>

    </div>
</div>
@endsection
