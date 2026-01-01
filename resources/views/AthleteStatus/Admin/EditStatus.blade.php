@extends('layouts.admin')

@section('content')
<div class="container">
    <h3 class="mb-4">Edit Athlete Selection Status</h3>

    <div class="card">
        <div class="card-body">
            <p><strong>Student Name:</strong> {{ $application->user->name }}</p>
            <p><strong>Event:</strong> {{ $application->event->EventName }}</p>
            <p><strong>Sport:</strong> {{ $application->game->GameName }}</p>

            <form action="{{ route('selection.status.update', $application->ApplicationID) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Selection Status</label>
                    <select name="StatusID" class="form-control" required>
                        @foreach($statuses as $status)
                            <option value="{{ $status->StatusID }}"
                                {{ $application->StatusID == $status->StatusID ? 'selected' : '' }}>
                                {{ $status->StatusName }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button class="btn btn-success">Update Status</button>
                <a href="{{ route('selection.status.index') }}" class="btn btn-secondary">
                    Back
                </a>
            </form>
        </div>
    </div>
</div>
@endsection
