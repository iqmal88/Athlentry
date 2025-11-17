@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-[#E15B5B]">
    <div class="max-w-3xl mx-auto px-8 py-10">
        
        <div class="bg-white rounded-xl shadow p-8">
            <h2 class="text-xl font-semibold mb-6">Add Announcement</h2>

            {{-- FORM --}}
            <form action="{{ route('admin.announcements.store') }}" method="POST">
                @csrf

                <div class="mb-5">
                    <label class="block font-medium mb-1">Title</label>
                    <input type="text" name="Title" required
                           class="w-full px-4 py-2 border rounded-lg">
                </div>

                <div class="mb-5">
                    <label class="block font-medium mb-1">Location</label>
                    <input type="text" name="Location"
                           class="w-full px-4 py-2 border rounded-lg">
                </div>

                <div class="mb-5">
                    <label class="block font-medium mb-1">Date</label>
                    <input type="date" name="Date"
                           class="w-full px-4 py-2 border rounded-lg">
                </div>

                <div class="mb-5">
                    <label class="block font-medium mb-1">Description</label>
                    <textarea name="Description" rows="4"
                              class="w-full px-4 py-2 border rounded-lg"></textarea>
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                        class="bg-green-600 text-white px-6 py-2 rounded-lg">
                        Blast
                    </button>
                </div>

            </form>
        </div>

    </div>
</div>
@endsection
