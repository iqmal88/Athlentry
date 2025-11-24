@extends('layouts.admin')

@section('title', 'Add Announcement')

@section('content')
        {{-- Header --}}
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-semibold text-gray-800">Create Announcement</h1>
                <p class="text-sm text-gray-500">Write a short message to blast to students.</p>
            </div>
        </div>

        {{-- Flash / validation --}}
        @if(session('success'))
            <div class="mb-4 rounded-md bg-green-50 border border-green-100 p-4 text-green-800">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 rounded-md bg-red-50 border border-red-100 p-4 text-red-800">
                <strong class="block mb-1">Please fix the following:</strong>
                <ul class="list-disc pl-5 space-y-1 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form card --}}
        <div class="bg-white rounded-2xl shadow-md overflow-hidden">
            <div class="p-6">

                <form action="{{ route('admin.announcements.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        {{-- Title --}}
                        <div>
                            <label for="Title" class="block text-sm font-medium text-gray-700 mb-1">Title <span class="text-red-500">*</span></label>
                            <input id="Title" name="Title" type="text" required
                                   value="{{ old('Title', $announcement->Title ?? '') }}"
                                   class="block w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#800000]/40 transition">
                            @error('Title')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Location --}}
                        <div>
                            <label for="Location" class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                            <input id="Location" name="Location" type="text"
                                   value="{{ old('Location', $announcement->Location ?? '') }}"
                                   class="block w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#800000]/40 transition">
                            @error('Location')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Date, TimeFrom, TimeUntil & Image --}}
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                        <div>
                            <label for="Date" class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                            <input id="Date" name="Date" type="date"
                                   value="{{ old('Date', isset($announcement->Date) ? $announcement->Date->format('Y-m-d') : '') }}"
                                   class="block w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#800000]/40 transition">
                            @error('Date')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="TimeFrom" class="block text-sm font-medium text-gray-700 mb-1">Time (From)</label>
                            <input id="TimeFrom" name="TimeFrom" type="time"
                                   value="{{ old('TimeFrom', isset($announcement->TimeFrom) ? \Carbon\Carbon::parse($announcement->TimeFrom)->format('H:i') : '') }}"
                                   class="block w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#800000]/40 transition">
                            @error('TimeFrom')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="TimeUntil" class="block text-sm font-medium text-gray-700 mb-1">Time (Until)</label>
                            <input id="TimeUntil" name="TimeUntil" type="time"
                                   value="{{ old('TimeUntil', isset($announcement->TimeUntil) ? \Carbon\Carbon::parse($announcement->TimeUntil)->format('H:i') : '') }}"
                                   class="block w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#800000]/40 transition">
                            @error('TimeUntil')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Optional image upload --}}
                        <div>
                            <label for="Image" class="block text-sm font-medium text-gray-700 mb-1">Image (optional)</label>
                            <input id="Image" name="Image" type="file" accept="image/*"
                                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:bg-[#F3F3F4]">
                            <p class="mt-1 text-xs text-gray-400">Max 2MB. Used to show on announcement cards.</p>
                            @error('Image')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Description --}}
                    <div>
                        <label for="Description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea id="Description" name="Description" rows="6"
                                  class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#800000]/40 transition"
                                  placeholder="Write the announcement details here...">{{ old('Description', $announcement->Description ?? '') }}</textarea>
                        @error('Description')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Buttons --}}
                    <div class="flex items-center justify-end gap-3">
                        <a href="{{ route('admin.announcements.index') }}"
                           class="inline-flex items-center px-4 py-2 rounded-lg border hover:shadow text-sm text-gray-700 bg-white">
                            Cancel
                        </a>

                        <button type="submit"
                                class="inline-flex items-center gap-2 px-5 py-2 rounded-lg bg-[#800000] text-white font-medium hover:brightness-95 transition">
                            Blast
                        </button>
                    </div>

                </form>

            </div>
        </div>
@endsection
