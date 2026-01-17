@extends('layouts.app')

@section('title', $event->EventName)

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<style>
    body { background-color: #F8F9FA; font-family: 'Inter', sans-serif; color: #1A1C1E; padding-top: 20px; }

    /* 1. Rounded Island Header */
    .premium-header-rounded {
        background: #fff;
        border-radius: 24px;
        padding: 32px 40px;
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

    /* 2. Content Island Card */
    .details-island-card {
        background: #fff;
        border-radius: 24px;
        border: 1px solid #E5E7EB;
        padding: 32px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02);
        margin-bottom: 40px;
    }

    .section-label-studio {
        font-size: 0.7rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.15em;
        color: #008080;
        margin-bottom: 20px;
        display: block;
    }

    /* 3. Sport Grid Cards (MATCHED TO RECRUITMENT PAGE) */
    .sport-grid-card {
        background: #F9FAFB;
        border: 1px solid #F3F4F6;
        border-radius: 18px;
        padding: 24px;
        height: 100%;
        display: flex;
        flex-direction: column;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .sport-grid-card:hover {
        background: #fff;
        border-color: #008080;
        transform: translateY(-4px);
        box-shadow: 0 15px 30px rgba(0, 128, 128, 0.1);
    }

    .meta-label-studio {
        font-size: 0.65rem;
        font-weight: 800;
        text-transform: uppercase;
        color: #9CA3AF;
        letter-spacing: 0.08em;
    }

    .status-badge-studio {
        font-size: 0.65rem;
        font-weight: 800;
        padding: 6px 14px;
        border-radius: 50px;
        text-transform: uppercase;
        display: inline-block;
        letter-spacing: 0.05em;
    }

    .status-pending { background: #FFF4E5; color: #B05E00; }
    .status-approved { background: #E6F4EA; color: #1E7E34; }
    .status-rejected { background: #FCE8E6; color: #C5221F; }

    .text-teal { color: #008080 !important; }
</style>

<div class="container pb-5">

    {{-- HEADER ISLAND --}}
    <div class="premium-header-rounded">
        <div class="aura-glow"></div>
        <div class="row align-items-center position-relative">
            <div class="col-md-8">
                <div class="d-flex align-items-center gap-4">
                    <a href="{{ route('student.application.index') }}" 
                       class="btn btn-outline-secondary btn-sm rounded-circle d-flex align-items-center justify-content-center shadow-sm" 
                       style="width: 40px; height: 40px; border-color: #E5E7EB; background: #fff;">
                        <i class="bi bi-arrow-left text-dark"></i>
                    </a>
                    <div>
                        <h1 class="fw-bold mb-1" style="font-size:1.75rem;">
                            {{ $event->EventName }}
                        </h1>
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
                </div>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <div class="px-4 py-1 bg-dark rounded-pill d-inline-block shadow-lg">
                    <span class="text-[10px] font-bold text-white uppercase tracking-widest" style="font-size: 0.65rem;">Registry {{ $event->Status }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        {{-- LEFT: OVERVIEW --}}
        <div class="col-lg-8">
            <div class="details-island-card">
                <span class="section-label-studio">Event Overview</span>
                <div class="text-secondary leading-relaxed" style="font-size: 0.95rem; white-space: pre-line;">
                    {!! nl2br(e($event->Description ?? 'No description provided for this tournament.')) !!}
                </div>
            </div>
        </div>

        {{-- RIGHT: SIDEBAR INFO --}}
        <div class="col-lg-4">
            <div class="details-island-card">
                <span class="section-label-studio">Technical Data</span>
                <div class="space-y-4">
                    <div class="mb-4">
                        <p class="meta-label-studio mb-1">Max Disciplines Allowed</p>
                        <p class="fw-bold text-dark mb-0 h5">{{ $event->MaxGamesPerStudent ?? 'Unlimited' }}</p>
                        <small class="text-muted" style="font-size: 0.7rem;">Allowed per athlete registration</small>
                    </div>
                    <div class="mb-2">
                        <p class="meta-label-studio mb-1">Commencement Venue</p>
                        <p class="fw-bold text-dark mb-0">{{ $event->Location ?? 'TBA' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- SPORTS GRID --}}
    <div class="mt-2">
        <h2 class="fw-black text-dark mb-4" style="font-size: 1.5rem; letter-spacing: -0.02em;">
            Available <span class="text-teal">Sports</span>
        </h2>

        <div class="row g-4">
            @foreach($event->games as $game)
                @php
                    $application = $game->applications->where('UserID', auth()->id())->first();
                    $appliedCount = $game->applications->count();
                @endphp

                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="sport-grid-card shadow-sm">
                        <div class="mb-3 d-flex justify-content-between align-items-start">
                            <span class="meta-label-studio text-teal">{{ $game->Category ?? 'OPEN' }}</span>
                            @if($application)
                                <span class="status-badge-studio status-{{ strtolower($application->ApplicationStatus) }}" style="font-size: 0.55rem;">
                                    {{ $application->ApplicationStatus }}
                                </span>
                            @endif
                        </div>
                        
                        <h3 class="fw-bold text-dark mb-3" style="font-size: 1.1rem;">{{ $game->GameName }}</h3>
                        
                        <div class="mb-4">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <i class="bi bi-calendar4-event text-muted"></i>
                                <span class="small fw-bold text-secondary">
                                    {{ \Carbon\Carbon::parse($game->GameDate)->format('d M Y') }}
                                </span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-clock text-muted"></i>
                                <span class="small text-muted">{{ $game->TimeStart }} – {{ $game->TimeEnd }}</span>
                            </div>
                        </div>

                        <div class="mt-auto pt-3 border-top">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="meta-label-studio">Current Intake</span>
                                <span class="small fw-bold">{{ $appliedCount }} / {{ $game->Capacity ?? '∞' }}</span>
                            </div>
                            <div class="progress" style="height: 6px; border-radius: 10px; background: #E9ECEF;">
                                @php $percent = $game->Capacity ? ($appliedCount / $game->Capacity) * 100 : 0; @endphp
                                <div class="progress-bar" style="width: {{ $percent }}%; background: #008080; border-radius: 10px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection