@extends('layouts.admin')

@section('content')
<div class="container">
    <h3 class="mb-4">Athlete Selection Status</h3>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Student Name</th>
                <th>Event</th>
                <th>Sport</th>
                <th>Current Status</th>
                <th>Update Selection</th>
            </tr>
        </thead>
        <tbody>
        @forelse($applications as $index => $app)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $app->user->name }}</td>
                <td>{{ $app->event->EventName }}</td>
                <td>{{ $app->game->GameName }}</td>

                <td>
                    <span class="badge bg-info">
                        {{ $app->status->StatusName ?? 'Pending' }}
                    </span>
                </td>

                <td>
                    <form action="{{ route('selection.status.update', $app->ApplicationID) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="d-flex gap-2">
                            <select name="StatusID" class="form-control" required>
                                @foreach($statuses as $status)
                                    <option value="{{ $status->StatusID }}"
                                        {{ $app->StatusID == $status->StatusID ? 'selected' : '' }}>
                                        {{ $status->StatusName }}
                                    </option>
                                @endforeach
                            </select>

                            <button type="submit" class="btn btn-success btn-sm">
                                Update
                            </button>
                        </div>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center">
                    No athlete applications found.
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection
