@extends('layouts.admin')

@section('title', 'Selection Panel')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<style>
    body {
        background-color: #F2F4F7;
        font-family: 'Inter', -apple-system, sans-serif;
        color: #1A1C1E;
        padding-top: 20px;
    }

    /* 1. Rounded Island Header */
    .premium-header-rounded {
        background: #fff;
        border-radius: 24px;
        padding: 24px 40px;
        margin-bottom: 30px;
        border: 1px solid #E5E7EB;
        position: relative;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
    }
    
    .aura-glow {
        position: absolute;
        top: -100px;
        right: -30px;
        width: 350px;
        height: 350px;
        background: radial-gradient(circle, rgba(128, 0, 0, 0.05) 0%, rgba(255, 255, 255, 0) 70%);
        border-radius: 50%;
        z-index: 0;
    }

    /* 2. Unified Master Container per Event */
    .selection-master-card {
        background: #ffffff;
        border-radius: 24px;
        padding: 0;
        margin-bottom: 40px;
        border: 1px solid #E5E7EB;
        box-shadow: 0 10px 40px rgba(0,0,0,0.03);
        overflow: hidden;
    }

    .event-strip {
        background: #ffffff;
        padding: 1.5rem 2rem;
        border-bottom: 1px solid #f1f1f1;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .event-title {
        font-weight: 800;
        font-size: 1.25rem;
        text-transform: uppercase;
        color: #111827;
        margin: 0;
    }

    /* 3. Sub-Header for Games */
    .game-section-header {
        background-color: #F9FAFB;
        padding: 0.75rem 2rem;
        border-bottom: 1px solid #F3F4F6;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .game-title-text {
        font-weight: 700;
        font-size: 0.85rem;
        color: #800000; /* Maroon theme */
        text-transform: uppercase;
        margin: 0;
    }

    /* 4. Table Styling */
    .table thead th {
        background-color: #fff;
        font-size: 0.65rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #9CA3AF;
        padding: 1rem 2rem;
        border-bottom: 1px solid #F3F4F6;
    }

    .table tbody td {
        padding: 1rem 2rem;
        vertical-align: middle;
        border-bottom: 1px solid #F9FAFB;
    }

    /* 5. Decision Buttons - UPDATED TO MAROON THEME */
    .btn-action-select {
        background-color: #800000; /* Primary Maroon */
        color: white;
        border: none;
        font-weight: 700;
        font-size: 0.65rem;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        text-transform: uppercase;
        transition: all 0.2s ease;
    }

    .btn-action-select:hover {
        background-color: #600000;
        transform: translateY(-1px);
        color: white;
    }

    .btn-action-reject {
        background-color: transparent;
        color: #6B7280;
        border: 1px solid #E5E7EB;
        font-weight: 700;
        font-size: 0.65rem;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        text-transform: uppercase;
        transition: all 0.2s ease;
    }

    .btn-action-reject:hover {
        background-color: #F9FAFB;
        color: #EF4444; /* Slight red tint on hover for rejection */
        border-color: #EF4444;
    }

    .status-pill {
        font-size: 0.6rem;
        font-weight: 800;
        padding: 0.3rem 0.7rem;
        border-radius: 4px;
        text-transform: uppercase;
    }

    .text-maroon {
        color: #800000;
    }
</style>

<div class="container">
    <div class="premium-header-rounded">
        <div class="aura-glow"></div>
        <div class="row align-items-center position-relative">
            <div class="col-md-8">
                <h1 class="fw-bold text-dark mb-1" style="font-size: 1.5rem; letter-spacing: -0.02em;">Selection <span class="text-maroon">Panel</span></h1>
                <p class="text-muted small mb-0">Review student applications and finalize team rosters.</p>
            </div>
        </div>
    </div>

    <div id="selectionList">
        @forelse($events as $event)
            @php 
                $validGames = $event->games->filter(fn($g) => $g->applications->count() > 0);
            @endphp

            @if($validGames->count() > 0)
            <div class="selection-master-card">
                
                <div class="event-strip">
                    <h2 class="event-title">{{ $event->EventName }}</h2>
                    <span class="text-muted small fw-bold uppercase">{{ $validGames->count() }} Games</span>
                </div>

                @foreach($validGames as $game)
                    <div class="game-section-header">
                        <i class="bi bi-tag-fill text-maroon" style="font-size: 0.8rem;"></i>
                        <h3 class="game-title-text">{{ $game->GameName }}</h3>
                        <span class="badge bg-white text-dark border ms-2" style="font-size: 0.6rem;">{{ $game->applications->count() }} Students</span>
                    </div>

                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th style="width: 40%">Student</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($game->applications as $app)
                                <tr>
                                    <td>
                                        <div class="fw-bold text-dark" style="font-size: 0.9rem;">{{ $app->user->Name }}</div>
                                        <div class="text-muted" style="font-size: 0.7rem;">Applied {{ \Carbon\Carbon::parse($app->DateApplied)->format('d M Y') }}</div>
                                    </td>
                                    <td class="text-center">
                                        @if($app->SelectionStatus === 'selected')
                                            <span class="status-pill bg-success bg-opacity-10 text-success">Selected</span>
                                        @elseif($app->SelectionStatus === 'rejected')
                                            <span class="status-pill bg-danger bg-opacity-10 text-danger">Rejected</span>
                                        @else
                                            <span class="status-pill bg-warning bg-opacity-10 text-warning">In Selection</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        @if($app->SelectionStatus === 'in_selection')
                                            <div class="d-flex justify-content-end gap-2">
                                                <form method="POST" action="{{ route('admin.selection.update', $app->ApplicationID) }}">
                                                    @csrf @method('PUT')
                                                    <input type="hidden" name="decision" value="selected">
                                                    <button class="btn-action-select">Select</button>
                                                </form>

                                                <form method="POST" action="{{ route('admin.selection.update', $app->ApplicationID) }}">
                                                    @csrf @method('PUT')
                                                    <input type="hidden" name="decision" value="rejected">
                                                    <button class="btn-action-reject">Reject</button>
                                                </form>
                                            </div>
                                        @else
                                            <span class="text-muted fw-bold" style="font-size: 0.65rem; text-transform: uppercase;">Finalised</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endforeach
            </div>
            @endif
        @empty
            <div class="text-center py-5 bg-white rounded-4 border border-dashed">
                <p class="text-muted fw-bold small uppercase">No data available</p>
            </div>
        @endforelse
    </div>
</div>
@endsection