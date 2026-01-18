@extends('layouts.app')

@section('title', 'Selection Status')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<style>
    body {
        background-color: #F2F4F7;
        font-family: 'Inter', -apple-system, sans-serif;
        color: #1A1C1E;
    }

    /* 1. Premium Header (Consistent with Portal) */
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
        background: radial-gradient(circle, rgba(0, 128, 128, 0.05) 0%, rgba(255, 255, 255, 0) 70%);
        border-radius: 50%;
        z-index: 0;
    }

    /* 2. Event Island Card */
    .menu-category-block {
        background: #ffffff;
        border-radius: 20px;
        padding: 32px;
        margin-bottom: 30px;
        border: 1px solid #E5E7EB;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
    }

    .category-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        padding-bottom: 16px;
        border-bottom: 1px solid #F3F4F6;
    }
    
    .category-title {
        font-weight: 800;
        font-size: 1.25rem;
        letter-spacing: -0.02em;
        text-transform: uppercase;
        margin-bottom: 0;
    }

    /* 3. Status Rows (High Density) */
    .status-item-card {
        background: #F9FAFB;
        border-radius: 16px;
        padding: 16px 24px;
        margin-bottom: 12px;
        border: 1px solid #F1F3F5;
        display: flex;
        align-items: center;
        transition: all 0.2s ease;
    }

    .status-item-card:hover {
        border-color: #008080;
        background: #fff;
        transform: translateX(4px);
        box-shadow: 0 10px 20px rgba(0,128,128,0.05);
    }

    .game-icon-box {
        width: 48px;
        height: 48px;
        background: #fff;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #008080;
        border: 1px solid #E5E7EB;
        font-size: 1.25rem;
        flex-shrink: 0;
    }

    /* 4. Badges & Labels */
    .meta-text {
        font-size: 0.65rem;
        font-weight: 800;
        color: #9CA3AF;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .status-pill {
        font-size: 0.65rem;
        font-weight: 800;
        text-transform: uppercase;
        padding: 8px 16px;
        border-radius: 50px;
        letter-spacing: 0.02em;
    }

    .pill-pending { background: #FFF4E5; color: #B05E00; border: 1px solid #FFE5D0; }
    .pill-success { background: #E6F4EA; color: #1E7E34; border: 1px solid #D1E7DD; }
    .pill-danger  { background: #FCE8E6; color: #C5221F; border: 1px solid #F8D7DA; }
    .pill-neutral { background: #F3F4F6; color: #6B7280; border: 1px solid #E5E7EB; }

    .text-teal { color: #008080 !important; }
    .fw-black { font-weight: 900; }
</style>

<div class="container pb-5">

    {{-- HEADER ISLAND --}}
    <div class="premium-header-rounded">
        <div class="aura-glow"></div>
        <div class="row align-items-center position-relative">
            <div class="col-md-8">
                <h1 class="fw-bold text-dark mb-1" style="font-size: 1.75rem; letter-spacing: -0.02em;">
                    Selection <span class="text-teal">Status</span>
                </h1>
                <p class="text-muted small mb-0">Track your sporting journey and final recruitment results.</p>
            </div>
            <div class="col-md-4 text-md-end d-none d-md-block">
                <div class="d-inline-flex align-items-center gap-2 bg-light px-3 py-2 rounded-3 border">
                    <span class="meta-text">Applications</span>
                    <span class="fw-black h5 mb-0 text-dark">{{ sprintf('%02d', $events->sum(fn($e) => $e->games->sum(fn($g) => $g->applications->count()))) }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- EVENTS LOOP --}}
    @forelse($events as $event)
        <div class="menu-category-block">
            <div class="category-header">
                <div>
                    <h2 class="category-title text-dark mb-1">{{ $event->EventName }}</h2>
                </div>
            </div>

            <div class="status-list">
                @foreach($event->games as $game)
                    @foreach($game->applications as $app)
                        <div class="status-item-card">
                            {{-- Icon --}}
                            <div class="game-icon-box me-4">
                                <i class="bi bi-trophy"></i>
                            </div>

                            {{-- Game Info --}}
                            <div class="flex-grow-1">
                                <span class="meta-text text-teal">{{ $game->Category ?? 'General' }}</span>
                                <h3 class="fw-bold h6 mb-1 text-dark">{{ $game->GameName }}</h3>
                                <div class="d-flex align-items-center gap-3">
                                    <span class="meta-text" style="font-size: 0.6rem;">
                                        <i class="bi bi-clock me-1"></i> Applied {{ \Carbon\Carbon::parse($app->DateApplied)->format('d M Y') }}
                                    </span>
                                </div>
                            </div>

                            {{-- Selection Status Display --}}
                            <div class="text-end">
                                @if($app->ApplicationStatus !== 'approved')
                                    <span class="status-pill pill-neutral">
                                        <i class="bi bi-shield-lock me-1"></i> Application Review
                                    </span>
                                @elseif($app->SelectionStatus === 'in_selection')
                                    <span class="status-pill pill-pending">
                                        <i class="bi bi-hourglass-split me-1"></i> In Selection
                                    </span>
                                @elseif($app->SelectionStatus === 'selected')
                                    <span class="status-pill pill-success">
                                        <i class="bi bi-check-all me-1"></i> Selected
                                    </span>
                                @else
                                    <span class="status-pill pill-danger">
                                        <i class="bi bi-x-circle me-1"></i> Not Selected
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @endforeach
            </div>
        </div>
    @empty
        {{-- EMPTY STATE --}}
        <div class="text-center py-5 bg-white rounded-5 border border-dashed mt-4">
            <div class="bg-light text-teal rounded-circle d-flex align-items-center justify-content-center mx-auto mb-4" style="width: 80px; height: 80px; font-size: 2rem;">
                <i class="bi bi-clipboard-x"></i>
            </div>
            <h3 class="fw-black text-dark h5 mb-2">No Active Records Found</h3>
            <p class="text-muted small px-lg-5">You haven't submitted any sports applications yet. Visit the recruitment page to begin your registration.</p>
            <a href="{{ route('student.application.index') }}" class="btn btn-dark rounded-pill px-4 py-2 fw-bold mt-3" style="font-size: 0.75rem;">
                Browse Available Sports
            </a>
        </div>
    @endforelse
</div>

@endsection