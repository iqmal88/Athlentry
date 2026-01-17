@extends('layouts.app')

@section('title', 'Athlete Recruitment')

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

    /* 1. Header (Matched to Game Info) */
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
        background: radial-gradient(circle, rgba(0, 128, 128, 0.05) 0%, rgba(255, 255, 255, 0) 70%);
        border-radius: 50%;
    }

    /* 2. Event Island (Matched to Game Info) */
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
        font-size: 1.5rem;
        letter-spacing: -0.02em;
        margin-bottom: 0;
    }

    /* 3. Game Recruit Card (Matched to Game Info Style) */
    .menu-item-card {
        background: #F9FAFB;
        border: 1px solid #F3F4F6;
        border-radius: 16px;
        padding: 20px;
        height: 100%;
        transition: all 0.2s ease;
        display: flex;
        flex-direction: column;
    }

    .menu-item-card:hover {
        background: #fff;
        border-color: #008080;
        box-shadow: 0 10px 25px rgba(0, 128, 128, 0.08);
        transform: translateY(-2px);
    }

    .item-icon-area {
        width: 40px;
        height: 40px;
        background: #fff;
        color: #008080;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 16px;
        border: 1px solid #E5E7EB;
        font-size: 1.2rem;
    }

    .item-name {
        font-weight: 700;
        font-size: 1rem;
        margin-bottom: 8px;
        line-height: 1.3;
    }

    .item-meta {
        font-size: 0.75rem;
        font-weight: 600;
        color: #6B7280;
        margin-bottom: 4px;
    }

    /* 4. Action Elements */
    .btn-apply-teal {
        background: #008080;
        color: #fff;
        border: none;
        padding: 10px;
        border-radius: 10px;
        font-weight: 800;
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        width: 100%;
        transition: 0.2s;
        margin-top: 16px;
    }

    .btn-apply-teal:hover {
        background: #111827;
        color: #fff;
    }

    .status-badge {
        font-size: 0.65rem;
        font-weight: 800;
        padding: 6px 12px;
        border-radius: 8px;
        text-transform: uppercase;
        display: inline-block;
        margin-top: 12px;
    }

    .status-pending { background: #FFF4E5; color: #B05E00; border: 1px solid #FFE5D0; }
    .status-approved { background: #E6F4EA; color: #1E7E34; border: 1px solid #D1E7DD; }
    .status-rejected { background: #FCE8E6; color: #C5221F; border: 1px solid #F8D7DA; }
    
    .meta-text-caps {
        font-size: 0.65rem;
        font-weight: 800;
        text-transform: uppercase;
        color: #9CA3AF;
        letter-spacing: 0.05em;
    }

    .text-teal { color: #008080 !important; }
</style>

<div class="container pb-5">

    {{-- Alerts --}}
    @if(session('success') || session('error'))
        <div class="mb-4">
            @if(session('success'))
                <div class="alert alert-success border-0 rounded-4 shadow-sm fw-bold">
                    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger border-0 rounded-4 shadow-sm fw-bold">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                </div>
            @endif
        </div>
    @endif

    {{-- HEADER --}}
    <div class="premium-header-rounded">
        <div class="aura-glow"></div>
        <div class="row align-items-center position-relative">
            <div class="col-8">
                <h1 class="fw-bold mb-1" style="font-size:1.75rem;">
                    Athlete <span class="text-teal">Recruitment</span>
                </h1>
                <p class="text-muted small mb-0">Discover competitive opportunities and secure your spot.</p>
            </div>
            <div class="col-4 text-end">
                <div class="d-inline-flex flex-column">
                    <span class="meta-text-caps">Active Events</span>
                    <span class="h4 fw-bold text-dark m-0">{{ sprintf('%02d', $events->count()) }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- EVENT BLOCKS --}}
    @foreach($events as $event)
    <div class="menu-category-block">

        <div class="category-header">
            <div>
                <h2 class="category-title text-dark mb-1">{{ $event->EventName }}</h2>
                <div class="d-flex gap-3">
                    <span class="meta-text-caps"><i class="bi bi-geo-alt text-teal me-1"></i>{{ $event->Location ?? 'Campus Grounds' }}</span>
                    <span class="meta-text-caps"><i class="bi bi-calendar3 text-teal me-1"></i>{{ \Carbon\Carbon::parse($event->StartDate)->format('d M') }} @if($event->EndDate) - {{ \Carbon\Carbon::parse($event->EndDate)->format('d M Y') }} @endif</span>
                </div>
            </div>
            <a href="{{ route('student.events.show', $event->EventID) }}" class="btn btn-light btn-sm fw-bold rounded-pill px-3 border" style="font-size: 0.7rem;">
                Event Intel
            </a>
        </div>

        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-3">
            @foreach($event->games as $game)
                @php
                    $application = $game->applications->where('UserID', auth()->id())->first();
                    $appliedCount = $game->applications->count();
                    $isFull = $game->Capacity !== null && $appliedCount >= $game->Capacity;
                @endphp

                <div class="col">
                    <div class="menu-item-card">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="item-icon-area">
                                <i class="bi bi-trophy"></i>
                            </div>
                            @if($application)
                                <span class="status-badge status-{{ strtolower($application->ApplicationStatus) }}">
                                    {{ $application->ApplicationStatus }}
                                </span>
                            @endif
                        </div>

                        <div class="text-teal fw-bold uppercase mb-1" style="font-size: 0.6rem; letter-spacing: 0.05em;">{{ $game->Category ?? 'OPEN CATEGORY' }}</div>
                        <h3 class="item-name text-dark">{{ $game->GameName }}</h3>

                        <div class="mt-auto">
                            <div class="item-meta">
                                <i class="bi bi-clock me-1"></i> {{ $game->TimeStart }} - {{ $game->TimeEnd }}
                            </div>
                            <div class="item-meta">
                                <i class="bi bi-people me-1"></i> Intake: <span class="text-dark">{{ $appliedCount }} / {{ $game->Capacity ?? '∞' }}</span>
                            </div>

                            @if(!$application && !$isFull && $event->Status === 'Open')
                                <button class="btn-apply-teal" data-bs-toggle="modal" data-bs-target="#confirmApply{{ $game->GameID }}">
                                    Apply Now
                                </button>
                            @elseif($application)
                                <div class="btn btn-light w-100 fw-bold disabled mt-3" style="font-size: 0.7rem; border-radius: 10px;">
                                    Application Logged
                                </div>
                            @else
                                <div class="btn btn-light w-100 fw-bold disabled mt-3" style="font-size: 0.7rem; border-radius: 10px; color: #9CA3AF;">
                                    Registration Closed
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- MODAL (Matched to Teal Style) --}}
                @if(!$application && !$isFull)
                <div class="modal fade" id="confirmApply{{ $game->GameID }}" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content rounded-5 border-0 shadow-lg">
                            <div class="modal-body text-center p-5">
                                <div class="bg-light text-teal rounded-circle d-flex align-items-center justify-content-center mx-auto mb-4" style="width: 70px; height: 70px; font-size: 1.75rem;">
                                    <i class="bi bi-send-fill"></i>
                                </div>
                                <h4 class="fw-bold mb-2">Submit Application?</h4>
                                <p class="text-muted small px-lg-4">
                                    You are requesting to join <strong>{{ $game->GameName }}</strong>. Please ensure your student profile is up to date.
                                </p>

                                <form method="POST" action="{{ route('student.application.submit', $game->GameID) }}">
                                    @csrf
                                    <div class="d-grid gap-2 mt-4">
                                        <button type="submit" class="btn-apply-teal py-3 m-0" style="font-size: 0.85rem;">
                                            Confirm Registration
                                        </button>
                                        <button type="button" class="btn btn-link text-muted fw-bold text-decoration-none small" data-bs-dismiss="modal">
                                            Go Back
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            @endforeach
        </div>
    </div>
    @endforeach
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection