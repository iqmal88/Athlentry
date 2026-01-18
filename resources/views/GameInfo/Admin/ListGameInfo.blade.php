@extends('layouts.admin')

@section('title', 'Game Information Hub')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<style>
    body {
        background-color: #F2F4F7;
        font-family: 'Inter', -apple-system, sans-serif;
        color: #1A1C1E;
    }

    /* Header */
    .premium-header-rounded {
        background: #fff;
        border-radius: 24px;
        padding: 24px 40px;
        margin-bottom: 30px;
        border: 1px solid #E5E7EB;
        position: relative;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0,0,0,0.03);
    }

    .aura-glow {
        position: absolute;
        top: -100px;
        right: -30px;
        width: 350px;
        height: 350px;
        background: radial-gradient(circle, rgba(128,0,0,0.05) 0%, rgba(255,255,255,0) 70%);
        border-radius: 50%;
    }

    /* Event Block */
    .menu-category-block {
        background: #ffffff;
        border-radius: 16px;
        padding: 24px;
        margin-bottom: 30px;
        border: 1px solid #E5E7EB;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
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
        margin-bottom: 0;
    }

    .category-meta {
        font-size: 0.7rem;
        font-weight: 700;
        color: #9CA3AF;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    /* Game Card */
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
        box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
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
        border: 1px solid #E5E7EB;
    }

    .item-name {
        font-weight: 700;
        font-size: 0.9rem;
        margin-bottom: 4px;
        line-height: 1.2;
    }

    .item-stats {
        font-size: 0.75rem;
        font-weight: 600;
        color: #6B7280;
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
        transition: 0.2s;
    }

    .btn-mcd-action:hover {
        background: #111827;
        color: #fff;
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

    {{-- Header --}}
    <div class="premium-header-rounded">
        <div class="aura-glow"></div>
        <div class="row align-items-center position-relative">
            <div class="col-7">
                <h1 class="fw-bold mb-1" style="font-size:1.75rem;">
                    Game <span style="color:#800000;">Information</span>
                </h1>
                <p class="text-muted small mb-0">
                    Manage and monitor all games grouped by event.
                </p>
            </div>
            <div class="col-5 text-end">
                <span class="text-muted small fw-bold">
                    Total Events: {{ $events->count() }} |
                    Total Games: {{ $events->sum(fn($e)=>$e->games->count()) }}
                </span>
            </div>
        </div>
    </div>

    {{-- Event → Games --}}
    @foreach($events as $event)
    <div class="menu-category-block">

        <div class="category-header">
            <div class="d-flex align-items-center gap-3">
                <h2 class="category-title">{{ $event->EventName }}</h2>
                <span class="badge badge-status {{ $event->Status == 'Open' ? 'bg-success text-white' : 'bg-light text-muted border' }}">
                    {{ $event->Status }}
                </span>
                <div class="category-meta d-none d-md-block">
                    {{ \Carbon\Carbon::parse($event->StartDate)->format('M d') }} –
                    {{ \Carbon\Carbon::parse($event->EndDate)->format('d, Y') }}
                </div>
            </div>
        </div>

        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-3">
            @forelse($event->games as $game)
            <div class="col">
                <div class="menu-item-card">
                    <div class="item-icon-area">
                        <i class="bi bi-controller"></i>
                    </div>

                    <div class="category-meta mb-1">{{ $game->Category ?? 'GAME' }}</div>
                    <h3 class="item-name">{{ $game->GameName }}</h3>

                    <div class="item-stats mt-2">
                        Capacity: <span class="text-dark">{{ $game->Capacity }}</span>
                    </div>

                    <a href="{{ route('admin.gameinfo.show', $game->GameID) }}" class="btn-mcd-action">
                        <i class="bi bi-chevron-right"></i>
                    </a>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-4 text-muted small fw-bold">
                No games registered for this event.
            </div>
            @endforelse
        </div>

    </div>
    @endforeach

</div>
@endsection
