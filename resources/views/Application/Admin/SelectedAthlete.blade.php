@extends('layouts.admin')

@section('content')
<div class="max-w-3xl mx-auto p-6">

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold">Selected Athlete</h1>
        <div>
            <a href="{{ url()->previous() }}" class="text-sm text-gray-600 mr-3">Back</a>

            <form action="{{ route('admin.applications.destroy', $application->ApplicationID) }}" 
                  method="POST" 
                  class="inline"
                  onsubmit="return confirm('Delete this application?');">
                @csrf
                @method('DELETE')
                <button class="text-sm text-red-600">Delete</button>
            </form>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow p-6">

        <div class="grid grid-cols-1 gap-4">

            <div>
                <div class="text-sm text-gray-500">Name</div>
                <div class="font-medium">{{ $application->user->Name }}</div>
            </div>

            <div>
                <div class="text-sm text-gray-500">Matric ID</div>
                <div class="font-medium">{{ $application->user->MatricNo }}</div>
            </div>

            <div>
                <div class="text-sm text-gray-500">Game Applied</div>
                <div class="font-medium">{{ $application->game->GameName ?? $application->SnapshotGameName }}</div>
                <div class="text-xs text-gray-500">{{ optional($application->game->event)->EventName ?? $application->SnapshotEventName }}</div>
            </div>

            <div>
                <div class="text-sm text-gray-500">Achievements</div>
                <div class="mt-1 text-sm text-gray-900">{{ $application->Achievement ?? '-' }}</div>
            </div>

            <div>
                <div class="text-sm text-gray-500">Medical Notes</div>
                <div class="mt-1 text-sm text-gray-900">{{ $application->MedicalHistory ?? '-' }}</div>
            </div>

            <div>
                <div class="text-sm text-gray-500">Applied On</div>
                <div class="font-medium">{{ $application->DateApplied->format('d M Y, h:i A') }}</div>
            </div>

            {{-- Update Status --}}
            <div class="pt-4">
                <form action="{{ route('admin.applications.update', $application->ApplicationID) }}" method="POST" class="flex items-center gap-3">
                    @csrf
                    @method('PATCH')

                    <select name="StatusID" class="border p-2 rounded text-sm">
                        @foreach(\App\Models\Status::orderBy('StatusID')->get() as $s)
                            <option value="{{ $s->StatusID }}" @if($application->StatusID == $s->StatusID) selected @endif>
                                {{ $s->Name }}
                            </option>
                        @endforeach
                    </select>

                    <button class="px-4 py-2 bg-blue-600 text-white rounded">Update Status</button>
                </form>
            </div>

        </div>

    </div>
</div>
@endsection
