@extends('layouts.admin')

@section('content')
<div class="max-w-3xl mx-auto p-6">

    <h1 class="text-2xl font-semibold mb-6">Add New Event</h1>

    <div class="bg-white rounded-2xl shadow p-6">
        <form action="{{ route('admin.events.store') }}" method="POST">
            @csrf

            {{-- Event Name --}}
            <label class="block mb-4">
                <span class="text-gray-700">Event Name</span>
                <input type="text" name="EventName" class="block w-full border rounded p-2" required>
            </label>

            {{-- Location --}}
            <label class="block mb-4">
                <span class="text-gray-700">Location</span>
                <input type="text" name="Location" class="block w-full border rounded p-2">
            </label>

            {{-- Start & End Date --}}
            <div class="grid grid-cols-2 gap-4">
                <label class="block">
                    <span class="text-gray-700">Start Date</span>
                    <input type="date" name="StartDate" class="block w-full border rounded p-2">
                </label>

                <label class="block">
                    <span class="text-gray-700">End Date</span>
                    <input type="date" name="EndDate" class="block w-full border rounded p-2">
                </label>
            </div>

            {{-- Description --}}
            <label class="block my-4">
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

            <button class="px-4 py-2 bg-blue-600 text-white rounded">Create Event</button>
        </form>
    </div>

</div>
@endsection
