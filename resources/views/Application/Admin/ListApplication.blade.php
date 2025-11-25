@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto p-6">

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold">List of All Applications</h1>
        <a href="{{ route('admin.games.index') }}" class="text-sm text-gray-600">Manage Games</a>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-700 p-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow p-4">

        {{-- FILTER AREA --}}
        <div class="flex items-center justify-between mb-4">
            <form method="GET" action="{{ route('admin.applications.index') }}" class="flex items-center gap-2">
                <select name="GameID" class="border rounded p-2 text-sm">
                    <option value="">All Games</option>
                    @foreach(\App\Models\GameInfo::with('event')->orderBy('GameName')->get() as $g)
                        <option value="{{ $g->GameID }}" @if(request('GameID') == $g->GameID) selected @endif>
                            {{ optional($g->event)->EventName ? optional($g->event)->EventName . ' — ' : '' }}{{ $g->GameName }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="px-3 py-2 bg-blue-600 text-white rounded text-sm">Filter</button>
            </form>

            <div class="text-sm text-gray-500">Total Applications: {{ $applications->count() }}</div>
        </div>

        {{-- APPLICATIONS TABLE --}}
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr class="text-left text-sm text-gray-600">
                        <th class="p-3">Applicant</th>
                        <th class="p-3">Game</th>
                        <th class="p-3">Applied On</th>
                        <th class="p-3">Status</th>
                        <th class="p-3">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    @forelse($applications as $app)
                        <tr>
                            {{-- Applicant --}}
                            <td class="p-3">
                                <div class="font-medium">{{ $app->user->Name ?? 'N/A' }}</div>
                                <div class="text-xs text-gray-500">{{ $app->user->MatricNo ?? '-' }}</div>
                            </td>

                            {{-- Game --}}
                            <td class="p-3">
                                <div>{{ $app->game->GameName ?? $app->SnapshotGameName }}</div>
                                <div class="text-xs text-gray-500">
                                    {{ optional($app->game->event)->EventName ?? $app->SnapshotEventName }}
                                </div>
                            </td>

                            {{-- Applied At --}}
                            <td class="p-3">
                                {{ optional($app->DateApplied)->format('d M Y H:i') ?? $app->created_at->format('d M Y H:i') }}
                            </td>

                            {{-- Status --}}
                            <td class="p-3">
                                <span class="inline-block px-2 py-1 text-xs rounded
                                    @if(optional($app->status)->Name == 'Accepted') bg-green-100 text-green-700
                                    @elseif(optional($app->status)->Name == 'Rejected') bg-red-100 text-red-700
                                    @elseif(optional($app->status)->Name == 'Waitlist') bg-yellow-100 text-yellow-700
                                    @else bg-gray-100 text-gray-700
                                    @endif">
                                    {{ optional($app->status)->Name ?? 'Pending' }}
                                </span>
                            </td>

                            {{-- Actions --}}
                            <td class="p-3">
                                <div class="flex items-center gap-3">
                                    <a href="{{ route('admin.applications.show', $app->ApplicationID) }}" 
                                       class="text-blue-600 text-sm">View</a>

                                    <form action="{{ route('admin.applications.destroy', $app->ApplicationID) }}" method="POST" 
                                          onsubmit="return confirm('Delete this application?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-sm text-red-600">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-6 text-center text-gray-500">
                                No applications found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

    </div>
</div>
@endsection
