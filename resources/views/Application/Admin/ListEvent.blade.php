@extends('layouts.admin')

@section('title', 'Events Hub')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<style>
    body {
        background-color: #F2F4F7;
        font-family: 'Inter', -apple-system, sans-serif;
        color: #1A1C1E;
    }

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

    .menu-category-block {
        background: #ffffff;
        border-radius: 16px;
        padding: 24px;
        margin-bottom: 30px;
        border: 1px solid #E5E7EB;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }

    .category-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 12px;
        border-bottom: 1px solid #F3F4F6;
    }

    .category-title {
        font-weight: 800;
        font-size: 1.25rem;
        letter-spacing: -0.02em;
        text-transform: uppercase;
        color: #111827;
        margin-bottom: 0;
    }

    .details-link {
        font-size: 0.75rem;
        font-weight: 700;
        color: #800000;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .details-link:hover {
        color: #111827;
        text-decoration: underline;
    }

    .category-meta {
        font-size: 0.7rem;
        font-weight: 700;
        color: #9CA3AF;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .menu-item-card {
        background: #F9FAFB;
        border: 1px solid #F3F4F6;
        border-radius: 12px;
        padding: 16px;
        height: 100%;
        transition: all 0.2s ease;
        position: relative;
    }

    .menu-item-card:hover {
        background: #fff;
        border-color: #800000;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }

    .item-icon-area {
        width: 44px;
        height: 44px;
        background: #fff;
        color: #800000;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 12px;
        font-size: 1.25rem;
        border: 1px solid #E5E7EB;
    }

    .item-name {
        font-weight: 700;
        font-size: 0.9rem;
        margin-bottom: 4px;
        color: #111827;
    }

    .item-stats {
        font-size: 0.75rem;
        font-weight: 600;
        color: #6B7280;
        line-height: 1.5;
    }

    /* Minimal addition: Style for the minimal icons */
    .stat-icon {
        font-size: 0.85rem;
        color: #9CA3AF;
        margin-right: 4px;
    }

    .btn-mcd-action {
        position: absolute;
        bottom: 16px;
        right: 16px;
        width: 28px;
        height: 28px;
        background: #800000;
        color: #fff;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
    }

    .btn-mcd-action:hover {
        background: #111827;
        color: #fff;
    }

    .btn-new-events {
        background: #800000;
        color: #fff !important;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.75rem;
        padding: 10px 24px;
        border: none;
        transition: all 0.3s ease;
        text-transform: capitalize;
    }

    .badge-status {
        font-size: 0.6rem;
        font-weight: 800;
        padding: 4px 10px;
        border-radius: 4px;
        text-transform: uppercase;
    }
</style>

<div class="container">

    {{-- HEADER --}}
    <div class="premium-header-rounded">
        <div class="aura-glow"></div>
        <div class="row align-items-center position-relative">
            <div class="col-7">
                <h1 class="fw-bold mb-1" style="font-size:1.75rem;">
                    Sport <span style="color:#800000;">Events</span>
                </h1>
                <p class="text-muted small mb-0">
                    Manage New Event and Games To Recruit Athlete.
                </p>
            </div>
            <div class="col-md-5 text-md-end mt-3 mt-md-0">
                <a href="{{ route('admin.events.create') }}"
                   class="btn-new-events shadow-sm">
                    <i class="bi bi-plus-circle me-2"></i> New Event
                </a>
            </div>
        </div>
    </div>

    {{-- EVENTS --}}
    @foreach($events as $event)
    <div class="menu-category-block">

        {{-- EVENT HEADER --}}
        <div class="category-header">
            <div class="d-flex align-items-center gap-3 flex-wrap">
                <h2 class="category-title">{{ $event->EventName }}</h2>

                <span class="badge badge-status {{ $event->Status == 'Open' ? 'bg-success text-white' : 'bg-light text-muted border' }}">
                    {{ $event->Status }}
                </span>

                @if($event->MaxGamesPerStudent)
                    <div class="category-meta">
                        <i class="bi bi-shield-check me-1"></i>
                        Max {{ $event->MaxGamesPerStudent }} game(s) / student
                    </div>
                @endif
            </div>

            <a href="{{ route('admin.events.edit', $event->EventID) }}" class="details-link">
                More Details <i class="bi bi-chevron-right"></i>
            </a>
        </div>

        {{-- GAMES --}}
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-3">
            @foreach($event->games as $game)
            <div class="col">
                <div class="menu-item-card">

                    <div class="item-icon-area">
                        <i class="bi bi-trophy"></i>
                    </div>

                    <div class="category-meta mb-1 text-truncate">
                        <i class="bi bi-tag me-1"></i>{{ $game->Category ?? 'ALL' }}
                    </div>

                    <h3 class="item-name text-truncate">{{ $game->GameName }}</h3>

                    {{-- GAME DATE & TIME --}}
                    <div class="item-stats mt-2">
                        <div class="d-flex align-items-start">
                            <i class="bi bi-calendar2-week stat-icon"></i>
                            <span>{{ \Carbon\Carbon::parse($game->GameDate)->format('d M Y') }}</span>
                        </div>
                        <div class="d-flex align-items-start">
                            <i class="bi bi-clock stat-icon"></i>
                            <span>
                                {{ \Carbon\Carbon::parse($game->TimeStart)->format('H:i') }}
                                –
                                {{ \Carbon\Carbon::parse($game->TimeEnd)->format('H:i') }}
                            </span>
                        </div>
                    </div>

                    {{-- INTAKE --}}
                    <div class="item-stats mt-2">
                        <i class="bi bi-people stat-icon"></i>
                        Intake:
                        <span class="text-dark">{{ $game->applications_count ?? 0 }}</span>
                        / {{ $game->Capacity ?? '∞' }}
                    </div>

                    {{-- GAME STATUS --}}
                    @if($game->Status !== 'Open')
                        <span class="badge bg-light text-muted mt-2 border">
                            <i class="bi bi-lock me-1"></i>{{ $game->Status }}
                        </span>
                    @endif

                    <a href="{{ route('admin.games.applicants', $game->GameID) }}" class="btn-mcd-action shadow-sm">
                        <i class="bi bi-chevron-right"></i>
                    </a>

                </div>
            </div>
            @endforeach
        </div>

    </div>
    @endforeach

</div>
@endsection