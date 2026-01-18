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
    }

    /* 1. Progress Alert (Keeping your specific logic) */
    .progress-alert {
        background: #FFFDF5;
        border-radius: 24px;
        padding: 24px 40px;
        margin-bottom: 25px;
        border: 1px solid rgba(255, 193, 7, 0.3);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.02);
    }

    /* 2. Header Island (Matched to Game Info) */
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

    /* 3. Event Category Block */
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

    /* 4. Game Cards (Matched to Game Info) */
    .menu-item-card {
        background: #F9FAFB;
        border: 1px solid #F3F4F6;
        border-radius: 12px;
        padding: 16px;
        height: 100%;
        transition: all 0.2s ease;
        position: relative;
        display: flex;
        flex-direction: column;
    }

    .menu-item-card:hover {
        background: #fff;
        border-color: #008080;
        box-shadow: 0 10px 15px -3px rgba(0, 128, 128, 0.1);
    }

    .item-icon-area {
        width: 44px;
        height: 44px;
        background: #fff;
        color: #008080;
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
        margin-bottom: 2px;
    }

    /* 5. Application Specific Styles */
    .status-badge {
        position: absolute;
        top: 16px;
        right: 16px;
        font-size: 0.6rem;
        font-weight: 800;
        padding: 4px 10px;
        border-radius: 6px;
        text-transform: uppercase;
    }

    .status-pending { background: #FFF4E5; color: #B05E00; border: 1px solid #FFE5D0; }
    .status-approved { background: #E6F4EA; color: #1E7E34; border: 1px solid #D1E7DD; }
    .status-rejected { background: #FCE8E6; color: #C5221F; border: 1px solid #F8D7DA; }

    .btn-apply-teal {
        background: #008080;
        color: #fff;
        border: none;
        padding: 8px;
        border-radius: 8px;
        font-weight: 800;
        font-size: 0.7rem;
        text-transform: uppercase;
        width: 100%;
        transition: 0.2s;
        margin-top: 12px;
    }

    .btn-apply-teal:hover { background: #111827; color: #fff; }

    .btn-locked {
        background: #F3F4F6;
        color: #9CA3AF;
        border: 1px solid #E5E7EB;
        padding: 8px;
        border-radius: 8px;
        font-weight: 800;
        font-size: 0.7rem;
        text-transform: uppercase;
        width: 100%;
        margin-top: 12px;
        text-align: center;
        text-decoration: none;
    }

    .text-teal { color: #008080 !important; }
    .meta-text-caps { font-size: 0.65rem; font-weight: 800; text-transform: uppercase; color: #9CA3AF; letter-spacing: 0.05em; }
</style>

<div class="container pb-5">

    {{-- 1. PROGRESS WARNING ALERT --}}
    @if(auth()->user()->isStudent() && !auth()->user()->ProfileCompleted)
        @php $status = auth()->user()->getCompletionStatus(); @endphp
        <div class="progress-alert">
            <div class="row align-items-center">
                <div class="col-lg-9">
                    <div class="d-flex align-items-center mb-2">
                        <span class="p-2 bg-warning bg-opacity-10 rounded-circle me-3">
                            <i class="bi bi-lock-fill text-warning h5 mb-0"></i>
                        </span>
                        <div>
                            <h6 class="fw-bold text-dark mb-0">Applications Locked ({{ $status['percentage'] }}%)</h6>
                            <p class="text-muted small mb-0">Please complete your profile to enable registration.</p>
                        </div>
                    </div>
                    <div class="progress mt-3" style="height: 6px; border-radius: 10px; background: #FEF3C7;">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $status['percentage'] }}%"></div>
                    </div>
                </div>
                <div class="col-lg-3 text-lg-end mt-3 mt-lg-0">
                    <a href="{{ route('student.profile.show') }}" class="btn btn-dark rounded-pill px-4 fw-bold btn-sm">
                        Complete Profile
                    </a>
                </div>
            </div>
        </div>
    @endif

    {{-- 2. MAIN HEADER --}}
    <div class="premium-header-rounded">
        <div class="aura-glow"></div>
        <div class="row align-items-center position-relative">
            <div class="col-8">
                <h1 class="fw-bold mb-1" style="font-size:1.75rem;">
                    Athlete <span class="text-teal">Recruitment</span>
                </h1>
                <p class="text-muted small mb-0">Explore competitive opportunities and secure your spot.</p>
            </div>
            <div class="col-4 text-end">
                <p class="meta-text-caps mb-1">Active Events</p>
                <p class="h4 fw-bold text-dark m-0">{{ sprintf('%02d', $events->count()) }}</p>
            </div>
        </div>
    </div>

    {{-- 3. EVENT LISTING --}}
    @foreach($events as $event)
    <div class="menu-category-block">
        <div class="category-header">
            <div class="d-flex align-items-center gap-3">
                <h2 class="category-title text-dark">{{ $event->EventName }}</h2>
                <div class="d-flex gap-3 d-none d-md-flex">
                    <span class="meta-text-caps"><i class="bi bi-geo-alt text-teal me-1"></i>{{ $event->Location ?? 'TBA' }}</span>
                </div>
            </div>
            <a href="{{ route('student.events.show', $event->EventID) }}" class="btn btn-light btn-sm fw-bold rounded-pill px-3 border" style="font-size: 0.65rem;">
                EVENT INTEL
            </a>
        </div>

        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-3">
            @foreach($event->games as $game)
                @php
                    $application = $game->applications->where('UserID', auth()->id())->first();
                    $appliedCount = $game->total_applied ?? $game->applications->count();
                    $isFull = $game->Capacity !== null && $appliedCount >= $game->Capacity;
                    $profileReady = auth()->user()->ProfileCompleted;
                @endphp

                <div class="col">
                    <div class="menu-item-card">
                        {{-- Icon Area --}}
                        <div class="item-icon-area">
                            <i class="bi bi-trophy"></i>
                        </div>

                        {{-- Status Badge (Top Right) --}}
                        @if($application)
                            <span class="status-badge status-{{ strtolower($application->ApplicationStatus) }}">
                                {{ $application->ApplicationStatus }}
                            </span>
                        @endif

                        {{-- Game Info --}}
                        <div class="text-teal fw-bold uppercase mb-1" style="font-size: 0.6rem;">{{ $game->Category ?? 'OPEN' }}</div>
                        <h3 class="item-name text-dark">{{ $game->GameName }}</h3>

                        <div class="mt-auto">
                            <div class="item-stats">
                                <i class="bi bi-clock me-1"></i> {{ $game->TimeStart }}
                            </div>
                            <div class="item-stats">
                                <i class="bi bi-people me-1"></i> Intake: <span class="text-dark">{{ $appliedCount }}/{{ $game->Capacity ?? '∞' }}</span>
                            </div>

                            {{-- Button Logic --}}
                            @if(!$application && !$isFull && $event->Status === 'Open')
                                @if($profileReady)
                                    <button class="btn-apply-teal" data-bs-toggle="modal" data-bs-target="#confirmApply{{ $game->GameID }}">
                                        Apply Now
                                    </button>
                                @else
                                    <a href="{{ route('student.profile.show') }}" class="btn-locked">
                                        <i class="bi bi-lock-fill me-1"></i> Profile Required
                                    </a>
                                @endif
                            @elseif($application)
                                <div class="btn btn-light w-100 fw-bold disabled mt-2" style="font-size: 0.65rem; border-radius: 8px;">
                                    APPLIED
                                </div>
                            @else
                                <div class="btn btn-light w-100 fw-bold disabled mt-2" style="font-size: 0.65rem; border-radius: 8px; color: #9CA3AF;">
                                    CLOSED
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- MODAL REMAINS THE SAME --}}
                @if(!$application && !$isFull && $profileReady)
                <div class="modal fade" id="confirmApply{{ $game->GameID }}" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content rounded-5 border-0 shadow-lg">
                            <div class="modal-body text-center p-5">
                                <div class="bg-light text-teal rounded-circle d-flex align-items-center justify-content-center mx-auto mb-4" style="width: 70px; height: 70px; font-size: 1.75rem;">
                                    <i class="bi bi-send-check-fill"></i>
                                </div>
                                <h4 class="fw-bold mb-2">Submit Application?</h4>
                                <p class="text-muted small">Apply for <strong>{{ $game->GameName }}</strong>?</p>

                                <form method="POST" action="{{ route('student.application.submit', $game->GameID) }}">
                                    @csrf
                                    <div class="d-grid gap-2 mt-4">
                                        <button type="submit" class="btn-apply-teal py-3 m-0" style="font-size: 0.8rem;">Confirm Registration</button>
                                        <button type="button" class="btn btn-link text-muted fw-bold text-decoration-none small" data-bs-dismiss="modal">Cancel</button>
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