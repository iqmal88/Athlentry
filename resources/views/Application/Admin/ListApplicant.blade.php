@extends('layouts.admin')

@section('content')
<div class="max-w-5xl mx-auto p-6">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold">{{ $game->GameName }}</h1>
            <div class="text-sm text-gray-500">
                {{ optional($game->event)->EventName }} • 
                {{ $game->GameDate ? $game->GameDate->format('d M Y') : '-' }}
            </div>
        </div>
        <div>
            <a href="{{ route('admin.games.index') }}" class="text-sm text-gray-600 mr-3">Back to Games</a>
            <a href="{{ route('admin.applications.index') }}" class="text-sm text-gray-600">All Applications</a>
        </div>
    </div>

    {{-- Applicants List --}}
    <div class="bg-white rounded-2xl shadow p-4">
        <h2 class="text-lg font-medium mb-4">Applicants ({{ $applications->count() }})</h2>

        <div class="divide-y divide-gray-100">
            @forelse($applications as $app)
            <div class="p-3 flex items-start justify-between">
                <div>
                    <div class="font-medium">{{ $app->user->Name }}</div>
                    <div class="text-xs text-gray-500">Matric: {{ $app->user->MatricNo }}</div>
                    <div class="mt-2 text-sm text-gray-700">{{ Str::limit($app->Achievement ?? '-', 120) }}</div>
                </div>

                <div class="text-right">
                    <div class="text-sm text-gray-500 mb-2">
                        {{ optional($app->DateApplied)->format('d M Y H:i') }}
                    </div>

                    <div class="flex items-center gap-2 justify-end">
                        <a href="{{ route('admin.applications.show', $app->ApplicationID) }}" 
                           class="px-3 py-1 border rounded text-sm">
                           Review
                        </a>

                        <form action="{{ route('admin.applications.destroy', $app->ApplicationID) }}" method="POST" 
                              onsubmit="return confirm('Delete this application?');">
                            @csrf
                            @method('DELETE')
                            <button class="px-3 py-1 text-sm text-red-600">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <div class="p-6 text-center text-gray-500">No applicants yet.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
