@extends('layouts.app')

@section('title', 'Athlete Applications')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<style>
    body { background-color: #F2F4F7; font-family: 'Inter', sans-serif; color: #1A1C1E; padding-top: 20px; }
    
    .premium-header-rounded {
        background: #fff; border-radius: 24px; padding: 24px 40px; margin-bottom: 30px;
        border: 1px solid #E5E7EB; position: relative; overflow: hidden; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
    }
    
    .aura-glow {
        position: absolute; top: -100px; right: -30px; width: 350px; height: 350px;
        background: radial-gradient(circle, rgba(0, 128, 128, 0.05) 0%, rgba(255, 255, 255, 0) 70%);
        border-radius: 50%; z-index: 0;
    }

    .menu-category-block {
        background: #ffffff; border-radius: 16px; padding: 24px; margin-bottom: 30px;
        border: 1px solid #E5E7EB; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }

    .category-header {
        display: flex; justify-content: space-between; align-items: center;
        margin-bottom: 20px; padding-bottom: 12px; border-bottom: 1px solid #F3F4F6;
    }

    .category-title { font-weight: 800; font-size: 1.25rem; text-transform: uppercase; color: #111827; margin-bottom: 0; }

    /* More Details Link (Sama seperti Admin) */
    .details-link {
        font-size: 0.75rem;
        font-weight: 700;
        color: #008080; /* Teal Blue */
        text-decoration: none;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .details-link:hover {
        color: #111827;
        text-decoration: underline;
    }

    .menu-item-card {
        background: #F9FAFB; border: 1px solid #F3F4F6; border-radius: 12px; padding: 16px;
        height: 100%; transition: all 0.2s ease; position: relative; display: flex; flex-direction: column;
    }

    .menu-item-card:hover { background: #fff; border-color: #008080; box-shadow: 0 10px 15px -3px rgba(0, 128, 128, 0.1); }

    .item-icon-area {
        width: 44px; height: 44px; background: #fff; color: #008080; border-radius: 10px;
        display: flex; align-items: center; justify-content: center; margin-bottom: 12px; border: 1px solid #E5E7EB;
    }

    .item-name { font-weight: 700; font-size: 0.9rem; margin-bottom: 4px; color: #111827; }

    .status-badge {
        font-size: 0.6rem; font-weight: 800; padding: 4px 8px; border-radius: 6px; text-transform: uppercase; width: fit-content;
    }
    .status-pending { background: #FFF4E5; color: #B05E00; }
    .status-approved { background: #E6F4EA; color: #1E7E34; }
    .status-rejected { background: #FCE8E6; color: #C5221F; }

    .btn-apply-teal {
        background: #008080; color: white; border: none; padding: 8px 16px; 
        border-radius: 8px; font-weight: 700; font-size: 0.75rem; text-transform: uppercase; width: 100%; transition: 0.2s;
    }
    .btn-apply-teal:hover { background: #006666; transform: translateY(-1px); }

    .text-teal { color: #008080 !important; }
</style>

<div class="container pb-5">
    {{-- Alerts --}}
    @if(session('success'))
        <div class="alert alert-success rounded-4 border-0 shadow-sm mb-4 fw-bold small">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger rounded-4 border-0 shadow-sm mb-4 fw-bold small">
            <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
        </div>
    @endif

    {{-- Header --}}
    <div class="premium-header-rounded">
        <div class="aura-glow"></div>
        <div class="row align-items-center position-relative">
            <div class="col-7">
                <h1 class="fw-bold text-dark mb-1" style="font-size: 1.75rem;">Athlete <span class="text-teal">Recruitment</span></h1>
                <p class="text-muted small mb-0">Apply for events and track your application progress.</p>
            </div>
            <div class="col-5 text-end">
                 <p class="text-muted small fw-bold mb-1 uppercase tracking-widest" style="font-size: 0.6rem;">Total Events</p>
                 <p class="h4 fw-bold text-dark m-0">{{ $events->count() }}</p>
            </div>
        </div>
    </div>

    {{-- Events Feed --}}
    <div id="eventsGrid">
        @foreach($events as $event)
        <div class="menu-category-block">
            <div class="category-header">
                <div class="d-flex align-items-center gap-3">
                    {{-- Nama Event tidak lagi boleh diklik --}}
                    <h2 class="category-title">{{ $event->EventName }}</h2>
                    <div class="text-muted small fw-bold uppercase tracking-widest d-none d-md-block" style="font-size: 0.65rem;">
                        Registration Open
                    </div>
                </div>

                {{-- Butang More Details diletakkan di sini --}}
                <div class="text-end">
                    <a href="{{ route('student.events.show', $event->EventID) }}" class="details-link">
                        More Details <i class="bi bi-chevron-right" style="font-size: 0.6rem;"></i>
                    </a>
                </div>
            </div>

            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-3">
                @foreach($event->games as $game)
                <div class="col">
                    <div class="menu-item-card">
                        <div class="item-icon-area"><i class="bi bi-person-badge"></i></div>
                        
                        <div class="text-muted uppercase mb-1" style="font-size: 0.6rem; font-weight: 800;">{{ $game->Category ?? 'SPORT' }}</div>
                        <h3 class="item-name">{{ $game->GameName }}</h3>
                        
                        <div class="mt-2 mb-3">
                            @php
                                $application = $game->applications->first(); 
                                $isFull = $game->Capacity !== null && $game->total_applied >= $game->Capacity;
                            @endphp

                            @if($application)
                                @if($application->ApplicationStatus == 'pending')
                                    <span class="status-badge status-pending"><i class="bi bi-clock-history me-1"></i> Pending Review</span>
                                @elseif($application->ApplicationStatus == 'approved')
                                    <span class="status-badge status-approved"><i class="bi bi-check-circle me-1"></i> Approved</span>
                                @elseif($application->ApplicationStatus == 'rejected')
                                    <span class="status-badge status-rejected"><i class="bi bi-x-circle me-1"></i> Rejected</span>
                                @endif
                            @elseif($isFull)
                                <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 rounded-pill px-2 py-1 uppercase" style="font-size: 0.55rem; font-weight: 800;">
                                    Full Capacity
                                </span>
                            @else
                                <div class="text-muted small fw-bold uppercase" style="font-size: 0.55rem;">
                                    Intake: {{ $game->total_applied }} / {{ $game->Capacity ?? '∞' }}
                                </div>
                            @endif
                        </div>

                        <div class="mt-auto pt-3 border-top">
                            @if(!$application && !$isFull)
                                <button type="button" class="btn-apply-teal" data-bs-toggle="modal" data-bs-target="#confirmApply{{ $game->GameID }}">
                                    Apply Now
                                </button>
                            @elseif($application)
                                <button class="btn btn-light btn-sm w-100 disabled text-muted fw-bold" style="font-size: 0.65rem;">
                                    ALREADY APPLIED
                                </button>
                            @else
                                <button class="btn btn-danger btn-sm w-100 disabled fw-bold" style="font-size: 0.65rem;">
                                    INTAKE CLOSED
                                </button>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Modal --}}
                @if(!$application && !$isFull)
                <div class="modal fade" id="confirmApply{{ $game->GameID }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-0 shadow-lg" style="border-radius: 24px;">
                            <div class="modal-body p-5 text-center">
                                <i class="bi bi-question-circle text-teal display-4 mb-4"></i>
                                <h4 class="fw-bold mb-3">Confirm Application</h4>
                                <p class="text-muted">You are applying for <strong>{{ $game->GameName }}</strong> in the <strong>{{ $event->EventName }}</strong>.</p>
                                
                                <form action="{{ route('student.application.submit', $game->GameID) }}" method="POST" class="mt-4">
                                    @csrf
                                    <div class="d-flex gap-2">
                                        <button type="button" class="btn btn-light flex-fill fw-bold rounded-pill" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn-apply-teal flex-fill fw-bold rounded-pill py-2">Confirm Apply</button>
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
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection