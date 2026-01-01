@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto">

    <div class="bg-white rounded-xl shadow p-6">

        <h2 class="text-xl font-semibold mb-4">
            Confirm Athlete Application
        </h2>

        <div class="space-y-3 mb-6">
            <div>
                <p class="text-sm text-gray-500">Event</p>
                <p class="font-medium">{{ $game->event->EventName }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Sport</p>
                <p class="font-medium">{{ $game->GameName }}</p>
            </div>
        </div>

        <div class="bg-yellow-50 border border-yellow-200 text-yellow-700
                    p-3 rounded mb-6 text-sm">
            Please confirm that you want to apply for this sport.
        </div>

        <form method="POST" action="{{ route('student.application.submit', $game->GameID) }}">
            @csrf

            <div class="flex justify-between">
                <a href="{{ route('student.application.index') }}"
                   class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 transition">
                    Cancel
                </a>

                <button type="submit"
                        class="px-4 py-2 rounded-lg bg-green-600
                               text-white hover:bg-green-700 transition">
                    Submit Application
                </button>
            </div>
        </form>

    </div>

</div>
@endsection
