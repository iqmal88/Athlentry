@extends('layouts.app')

@section('title', 'Athlete Applications')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<style>
    body {
        background-color: #F8F9FA;
        font-family: 'Inter', sans-serif;
        color: #1A1C1E;
        padding-top: 20px;
    }

    .premium-header-rounded {
        background: #fff;
        border-radius: 24px;
        padding: 32px 40px;
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
        z-index: 0;
    }

    .event-container-island {
        background: #ffffff;
        border-radius: 24px;
        padding: 32px;
        margin-bottom: 40px;
        border: 1px solid #E5E7EB;
        box-shadow: 0 10px 30px rgba(0,0,0,0.02);
    }

    .game-recruit-card {
        background: #F9FAFB;
        border: 1px solid #F3F4F6;
        border-radius: 18px;
        padding: 20px;
        height: 100%;
        display: flex;
        flex-direction: column;
        transition: 0.3s;
    }

    .game-recruit-card:hover {
        background: #fff;
        border-color: #008080;
        transform: translateY(-4px);
        box-shadow: 0 15px 30px rgba(0,128,128,0.1);
    }

    .btn-apply-action {
        background: #008080;
        color: #fff;
        border: none;
        padding: 12px;
        border-radius: 12px;
        font-weight: 800;
        font-size: 0.75rem;
        text-transform: uppercase;
        width: 100%;
    }

    .btn-apply-action:hover {
        background: #006666;
    }

    .status-pill {
        font-size: 0.65rem;
        font-weight: 800;
        padding: 6px 14px;
        border-radius: 50px;
        text-transform: uppercase;
        display: inline-block;
    }

    .status-pending { background: #FFF4E5; color: #B05E00; }
    .status-approved { background: #E6F4EA; color: #1E7E34; }
    .status-rejected { background: #FCE8E6; color: #C5221F; }

    .meta-label-studio {
        font-size: 0.65rem;
        font-weight: 800;
        text-transform: uppercase;
        color: #9CA3AF;
        letter-spacing: 0.08em;
    }

    .text-teal { color: #008080 !important; }
</style>

<div class="container pb-5">

    {{-- Alerts --}}
    @if(session('success'))
        <div class="alert alert-success fw-bold rounded-4 shadow-sm">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger fw-bold rounded-4 shadow-sm">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
        </div>
    @endif

    {{-- UPDATED HEADER ISLAND --}}
    <div class="premium-header-rounded">
        <div class="aura-glow"></div>
        <div class="row align-items-center position-relative">
            <div class="col-7">
                <h1 class="fw-bold mb-1" style="font-size:1.75rem;">
                    Athlete <span class="text-teal">Recruitment</span>
                </h1>
                <p class="text-muted small mb-0">
                    Apply for available sports and track your application status.
                </p>
            </div>
            <div class="col-5 text-end">
                <p class="text-muted small fw-bold mb-1 uppercase tracking-widest" style="font-size: 0.6rem;">Active Events</p>
                <p class="h4 fw-bold text-dark m-0">{{ sprintf('%02d', $events->count()) }}</p>
            </div>
        </div>
    </div>

    {{-- Events --}}
    @foreach($events as $event)
    <div class="event-container-island">

        <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
            <div>
                <h3 class="fw-bold mb-1">{{ $event->EventName }}</h3>
                <div class="d-flex gap-3">
                    <span class="meta-label-studio">
                        <i class="bi bi-calendar-range text-teal me-1"></i>
                        {{ \Carbon\Carbon::parse($event->StartDate)->format('d M Y') }} 
                        @if($event->EndDate) — {{ \Carbon\Carbon::parse($event->EndDate)->format('d M Y') }} @endif
                    </span>
                    <span class="meta-label-studio">
                        <i class="bi bi-geo-alt text-teal me-1"></i>
                        {{ $event->Location ?? 'TBA' }}
                    </span>
                </div>
            </div>
            <a href="{{ route('student.events.show', $event->EventID) }}" class="btn btn-outline-secondary btn-sm fw-bold rounded-pill px-3" style="font-size: 0.7rem;">
                More Details
            </a>
        </div>

        <div class="row g-4">
            @foreach($event->games as $game)
                @php
                    $application = $game->applications->where('UserID', auth()->id())->first();
                    $appliedCount = $game->applications->count();
                    $isFull = $game->Capacity !== null && $appliedCount >= $game->Capacity;
                @endphp

                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="game-recruit-card">

                        <span class="text-muted text-uppercase fw-bold small">{{ $game->Category }}</span>
                        <h5 class="fw-bold mt-2">{{ $game->GameName }}</h5>

                        <div class="small text-muted mt-2">
                            <i class="bi bi-calendar"></i>
                            {{ \Carbon\Carbon::parse($game->GameDate)->format('d M Y') }}
                        </div>

                        <div class="small text-muted">
                            <i class="bi bi-clock"></i>
                            {{ $game->TimeStart }} - {{ $game->TimeEnd }}
                        </div>

                        <div class="mt-3">
                            @if($application)
                                <span class="status-pill status-{{ strtolower($application->ApplicationStatus) }}">
                                    {{ strtoupper($application->ApplicationStatus) }}
                                </span>
                            @elseif($isFull)
                                <span class="status-pill status-rejected">FULL</span>
                            @else
                                <small class="text-muted fw-bold">
                                    Intake: {{ $appliedCount }} / {{ $game->Capacity ?? '∞' }}
                                </small>
                            @endif
                        </div>

                        {{-- ACTION --}}
                        <div class="mt-auto pt-3">
                            @if(!$application && !$isFull && $event->Status === 'Open')
                                <button class="btn-apply-action"
                                        data-bs-toggle="modal"
                                        data-bs-target="#confirmApply{{ $game->GameID }}">
                                    Apply Now
                                </button>
                            @else
                                <button class="btn btn-light w-100 fw-bold disabled">
                                    {{ $application ? 'Entry Logged' : 'Not Available' }}
                                </button>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- CONFIRM APPLY MODAL --}}
                @if(!$application && !$isFull)
                <div class="modal fade" id="confirmApply{{ $game->GameID }}" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content rounded-4 border-0 shadow">
                            <div class="modal-body text-center p-5">
                                <div class="w-20 h-20 bg-light text-teal rounded-circle d-flex align-items-center justify-content-center mx-auto mb-4" style="width: 80px; height: 80px; font-size: 2rem;">
                                    <i class="bi bi-send-check"></i>
                                </div>
                                <h5 class="fw-bold mb-2">Confirm Application?</h5>
                                <p class="text-muted small">
                                    You are applying for <strong>{{ $game->GameName }}</strong><br>
                                    Event: <strong>{{ $event->EventName }}</strong>
                                </p>

                                <form method="POST"
                                      action="{{ route('student.application.submit', $game->GameID) }}">
                                    @csrf
                                    <div class="d-grid gap-2 mt-4">
                                        <button type="submit" class="btn-apply-action py-3">
                                            Confirm Submission
                                        </button>
                                        <button type="button" class="btn btn-link text-muted fw-bold text-decoration-none" data-bs-dismiss="modal">
                                            Cancel
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