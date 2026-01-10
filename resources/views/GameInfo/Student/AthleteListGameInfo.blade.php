@extends('layouts.app')

@section('title', 'Game Information')

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

    /* 1. Header (Ikut Admin) */
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
        /* Warna Glow Teal */
        background: radial-gradient(circle, rgba(0, 128, 128, 0.05) 0%, rgba(255, 255, 255, 0) 70%);
        border-radius: 50%;
    }

    /* 2. Event Island (Ikut Admin) */
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

    /* 3. Game Card (Ikut Admin - Warna Teal) */
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
        border-color: #008080; /* Teal Blue */
        box-shadow: 0 10px 15px -3px rgba(0, 128, 128, 0.1);
    }

    .item-icon-area {
        width: 44px;
        height: 44px;
        background: #fff;
        color: #008080; /* Teal Blue */
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

    /* Button Action (Ikut Admin - Warna Teal) */
    .btn-mcd-action {
        position: absolute;
        bottom: 16px;
        right: 16px;
        width: 28px;
        height: 28px;
        background: #008080; /* Teal Blue */
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

    .text-teal { color: #008080 !important; }
</style>

<div class="container pb-5">

    {{-- Header --}}
    <div class="premium-header-rounded">
        <div class="aura-glow"></div>
        <div class="row align-items-center position-relative">
            <div class="col-7">
                <h1 class="fw-bold mb-1" style="font-size:1.75rem;">
                    Game <span class="text-teal">Information</span>
                </h1>
                <p class="text-muted small mb-0">
                    View Game Details & Requirements.
                </p>
            </div>
            <div class="col-5 text-end">
                <p class="text-muted small fw-bold mb-1 uppercase tracking-widest" style="font-size: 0.6rem;">Total Events</p>
                <p class="h4 fw-bold text-dark m-0">{{ $events->count() }}</p>
            </div>
        </div>
    </div>

    {{-- Event Island Loops (Sama Macam Admin) --}}
    @foreach($events as $event)
    <div class="menu-category-block">

        <div class="category-header">
            <div class="d-flex align-items-center gap-3">
                <h2 class="category-title text-dark">{{ $event->EventName }}</h2>
                <div class="text-muted small fw-bold uppercase tracking-widest d-none d-md-block" style="font-size: 0.65rem;">
                    {{ $event->games->count() }} Games
                </div>
            </div>
        </div>

        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-3">
            @foreach($event->games as $game)
            <div class="col">
                <div class="menu-item-card">
                    <div class="item-icon-area">
                        <i class="bi bi-controller"></i>
                    </div>

                    <div class="text-teal fw-bold uppercase mb-1" style="font-size: 0.6rem;">{{ $game->Category ?? 'GAME' }}</div>
                    <h3 class="item-name text-dark">{{ $game->GameName }}</h3>

                    <div class="item-stats mt-2">
                        Capacity: <span class="text-dark">{{ $game->Capacity ?? '-' }}</span>
                    </div>

                    {{-- Link Ikut Function Student --}}
                    <a href="{{ route('student.gameinfo.show', $game->GameID) }}" class="btn-mcd-action">
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