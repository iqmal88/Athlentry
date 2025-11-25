@extends('layouts.admin')

@section('content')
<div class="max-w-3xl mx-auto p-6">

    <h1 class="text-2xl font-semibold mb-6">Add New Game</h1>

    @if(session('error'))
        <div class="bg-red-100 text-red-700 border border-red-200 p-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow p-6">

        <form action="{{ route('admin.games.store') }}" method="POST">
            @csrf

            {{-- Event --}}
            <label class="block mb-4">
                <span class="text-gray-700">Event</span>
                <select name="EventID" class="mt-1 block w-full border rounded p-2">
                    <option value="">-- Select Event --</option>
                    @foreach($events as $event)
                        <option value="{{ $event->EventID }}">{{ $event->EventName }}</option>
                    @endforeach
                </select>
            </label>

            {{-- Game Name --}}
            <label class="block mb-4">
                <span class="text-gray-700">Game Name</span>
                <input type="text" name="GameName" class="block w-full border rounded p-2" required>
            </label>

            {{-- Category --}}
            <label class="block mb-4">
                <span class="text-gray-700">Category</span>
                <input type="text" name="Category" class="block w-full border rounded p-2">
            </label>

            {{-- Date & Time --}}
            <div class="grid grid-cols-2 gap-4">
                <label class="block">
                    <span class="text-gray-700">Game Date</span>
                    <input type="date" name="GameDate" class="block w-full border rounded p-2">
                </label>

                <label class="block">
                    <span class="text-gray-700">Game Time</span>
                    <input type="time" name="GameTime" class="block w-full border rounded p-2">
                </label>
            </div>

            {{-- Selection Place --}}
            <label class="block my-4">
                <span class="text-gray-700">Selection Place</span>
                <input type="text" name="SelectionPlace" class="block w-full border rounded p-2">
            </label>

            {{-- Coach --}}
            <div class="grid grid-cols-2 gap-4">
                <label class="block">
                    <span class="text-gray-700">Coach Name</span>
                    <input type="text" name="CoachName" class="block w-full border rounded p-2">
                </label>

                <label class="block">
                    <span class="text-gray-700">Coach Phone</span>
                    <input type="text" name="CoachPhone" class="block w-full border rounded p-2">
                </label>
            </div>

            {{-- Capacity --}}
            <label class="block my-4">
                <span class="text-gray-700">Capacity</span>
                <input type="number" name="Capacity" class="block w-full border rounded p-2">
            </label>

            {{-- Description --}}
            <label class="block mb-4">
                <span class="text-gray-700">Description</span>
                <textarea name="Description" rows="3" class="block w-full border rounded p-2"></textarea>
            </label>

            {{-- Status --}}
            <label class="block mb-6">
                <span class="text-gray-700">Status</span>
                <select name="Status" class="block w-full border rounded p-2">
                    <option value="Open">Open</option>
                    <option value="Closed">Closed</option>
                </select>
            </label>

            <button class="px-4 py-2 bg-blue-600 text-white rounded">Create Game</button>
        </form>

    </div>
</div>
@endsection
