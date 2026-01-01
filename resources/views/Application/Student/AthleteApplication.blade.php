@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">

    <h2 class="text-2xl font-semibold mb-6">
        Athlete Application
    </h2>

    {{-- Alerts --}}
    @if(session('success'))
        <div class="mb-4 p-3 rounded bg-green-100 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 p-3 rounded bg-red-100 text-red-700">
            {{ session('error') }}
        </div>
    @endif

    @forelse($events as $event)
        {{-- EVENT CARD --}}
        <div class="bg-white rounded-xl shadow mb-6">

            {{-- Event Header --}}
            <div class="border-b px-6 py-4">
                <h3 class="text-lg font-bold text-gray-800">
                    {{ $event->EventName }}
                </h3>
                <p class="text-sm text-gray-500">
                    {{ $event->Location ?? 'Location not specified' }}
                </p>
            </div>

            {{-- Games Table --}}
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50">
                        <tr class="text-left text-gray-600">
                            <th class="px-6 py-3">Sport</th>
                            <th class="px-6 py-3">Category</th>
                            <th class="px-6 py-3 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($event->games as $game)
                            <tr class="border-t hover:bg-gray-50 transition">
                                <td class="px-6 py-3 font-medium">
                                    {{ $game->GameName }}
                                </td>
                                <td class="px-6 py-3">
                                    {{ $game->Category ?? '-' }}
                                </td>
                                <td class="px-6 py-3 text-center">
                                    @if($game->applied > 0)
                                        <span class="inline-block px-3 py-1 text-xs font-semibold
                                                     bg-green-100 text-green-700 rounded-full">
                                            Applied
                                        </span>
                                    @else
                                        <a href="{{ route('student.application.apply', $game->GameID) }}"
                                           class="inline-block px-4 py-1.5 text-sm font-medium
                                                  bg-blue-600 text-white rounded-lg
                                                  hover:bg-blue-700 transition">
                                            Apply
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    @empty
        <div class="bg-white p-6 rounded shadow text-center text-gray-500">
            No events available at the moment.
        </div>
    @endforelse

</div>
@endsection
