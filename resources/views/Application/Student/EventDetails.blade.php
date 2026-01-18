@extends('layouts.app')

@section('title', $event->EventName)

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<style>
    body { 
        background-color: #F2F4F7; 
        font-family: 'Inter', -apple-system, sans-serif; 
        color: #1A1C1E; 
    }

    /* 1. Premium Header */
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

    /* 2. Detail Islands */
    .details-island-card {
        background: #fff;
        border-radius: 20px;
        border: 1px solid #E5E7EB;
        padding: 32px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        height: 100%;
    }

    .section-label-studio {
        font-size: 0.65rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: #008080;
        margin-bottom: 20px;
        display: block;
    }

    /* 3. Sport Cards */
    .menu-item-card {
        background: #F9FAFB;
        border: 1px solid #F3F4F6;
        border-radius: 16px;
        padding: 24px;
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
    }

    /* 4. Status & UI Elements */
    .status-badge-studio {
        font-size: 0.6rem;
        font-weight: 800;
        padding: 4px 12px;
        border-radius: 6px;
        text-transform: uppercase;
    }
    .status-pending { background: #FFF4E5; color: #B05E00; border: 1px solid #FFE5D0; }
    .status-approved { background: #E6F4EA; color: #1E7E34; border: 1px solid #D1E7DD; }
    .status-rejected { background: #FCE8E6; color: #C5221F; border: 1px solid #F8D7DA; }

    .progress-minimal {
        height: 6px;
        border-radius: 10px;
        background: #E9ECEF;
        margin-top: 8px;
    }

    .meta-text {
        font-size: 0.7rem;
        font-weight: 700;
        color: #9CA3AF;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .fw-black { font-weight: 900; }
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
                       class="btn btn-outline-secondary btn-sm rounded-circle d-flex align-items-center justify-content-center" 
                       style="width: 44px; height: 44px; border: 1px solid #E5E7EB; background: #fff;">
                        <i class="bi bi-arrow-left text-dark"></i>
                    </a>
                    <div>
                        <h1 class="fw-bold mb-1" style="font-size:1.85rem; letter-spacing: -0.02em;">
                            {{ $event->EventName }}
                        </h1>
                        <div class="d-flex align-items-center gap-3">
                            <span class="meta-text">
                                <i class="bi bi-calendar3 text-teal me-1"></i> 
                                {{ \Carbon\Carbon::parse($event->StartDate)->format('d M Y') }}
                                @if($event->EndDate) — {{ \Carbon\Carbon::parse($event->EndDate)->format('d M Y') }} @endif
                            </span>
                            <span class="meta-text">
                                <i class="bi bi-geo-alt text-teal me-1"></i> 
                                {{ $event->Location ?? 'Main Campus' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <div class="d-inline-flex align-items-center gap-2 bg-dark px-3 py-2 rounded-3 shadow-sm">
                    <div class="rounded-circle bg-success" style="width: 8px; height: 8px;"></div>
                    <span class="text-white fw-bold uppercase tracking-widest" style="font-size: 0.6rem;">Status: {{ $event->Status }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-5">
        {{-- LEFT: DESCRIPTION --}}
        <div class="col-lg-8">
            <div class="details-island-card">
                <span class="section-label-studio">Tournament Prospectus</span>
                <div class="text-dark leading-relaxed" style="font-size: 1rem; line-height: 1.7; white-space: pre-line; opacity: 0.85;">
                    {!! nl2br(e($event->Description ?? 'Specific event details and tournament rules will be briefed by the coordinator during the opening ceremony.')) !!}
                </div>
            </div>
        </div>

        {{-- RIGHT: SIDEBAR (TECHNICAL DATA - REDESIGNED) --}}
        <div class="col-lg-4">
            <div class="details-island-card">
                <span class="section-label-studio">Technical Data</span>
                
                <div class="d-flex flex-column gap-4">
                    
                    {{-- 1. DURATION BOX (Bento Style) --}}
                    <div class="p-3 rounded-4 bg-light border border-white shadow-sm">
                        <p class="meta-text mb-3" style="color: #6B7280;">Tournament Duration</p>
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-white text-teal rounded-3 d-flex align-items-center justify-content-center shadow-sm" style="width: 48px; height: 48px; border: 1px solid #E5E7EB;">
                                <i class="bi bi-calendar-check-fill" style="font-size: 1.25rem;"></i>
                            </div>
                            <div>
                                <div class="d-flex flex-column">
                                    <span class="fw-black text-dark" style="font-size: 0.95rem;">{{ \Carbon\Carbon::parse($event->StartDate)->format('d M Y') }}</span>
                                    @if($event->EndDate)
                                        <div class="d-flex align-items-center gap-2 mt-1">
                                            <div style="width: 4px; height: 4px; background: #D1D5DB; border-radius: 50%;"></div>
                                            <span class="fw-bold text-muted" style="font-size: 0.85rem;">{{ \Carbon\Carbon::parse($event->EndDate)->format('d M Y') }}</span>
                                        </div>
                                    @else
                                        <span class="text-teal fw-bold" style="font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.05em;">One-Day Event</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- 2. VENUE BOX --}}
                    <div class="p-3">
                        <p class="meta-text mb-2" style="color: #6B7280;">Primary Venue</p>
                        <div class="d-flex align-items-start gap-3">
                            <i class="bi bi-geo-alt-fill text-teal mt-1"></i>
                            <div>
                                <p class="fw-bold text-dark mb-1" style="font-size: 0.95rem;">{{ $event->Location ?? 'Venue TBA' }}</p>
                            </div>
                        </div>
                    </div>

                    <hr class="my-0 opacity-10">

                    {{-- 3. QUOTA BOX (Impact Style) --}}
                    <div class="p-3 rounded-4" style="background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%); border: 1px dashed #E5E7EB;">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <p class="meta-text mb-1" style="color: #6B7280;">Max Entries</p>
                                <p class="text-muted mb-0" style="font-size: 0.75rem;">Limit per athlete.</p>
                            </div>
                            <div class="col-4 text-end">
                                <span class="display-6 fw-black text-teal">{{ $event->MaxGamesPerStudent ?? '∞' }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- 4. CONTACT FOOTER --}}
                    <div class="text-center pt-2">
                        <span class="d-flex align-items-center justify-content-center gap-2" style="font-size: 0.7rem; color: #9CA3AF; font-weight: 600;">
                            <i class="bi bi-info-circle"></i>
                            Event details are subject to change
                        </span>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- SPORTS GRID SECTION --}}
    <div class="mt-2">
        <div class="d-flex align-items-center gap-3 mb-4">
            <h2 class="fw-bold text-dark mb-0" style="font-size: 1.5rem; letter-spacing: -0.02em;">
                Available <span class="text-teal">Disciplines</span>
            </h2>
            <div class="px-2 py-1 bg-light border rounded text-muted fw-bold" style="font-size: 0.7rem;">
                {{ $event->games->count() }} OPTIONS
            </div>
        </div>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-3">
            @foreach($event->games as $game)
                @php
                    $application = $game->applications->where('UserID', auth()->id())->first();
                    $appliedCount = $game->applications()->count();
                    $percent = $game->Capacity ? ($appliedCount / $game->Capacity) * 100 : 0;
                @endphp

                <div class="col">
                    <div class="menu-item-card">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="item-icon-area">
                                <i class="bi bi-controller"></i>
                            </div>
                            @if($application)
                                <span class="status-badge-studio status-{{ strtolower($application->ApplicationStatus) }}">
                                    {{ $application->ApplicationStatus }}
                                </span>
                            @endif
                        </div>
                        
                        <span class="text-teal fw-bold mb-1" style="font-size: 0.6rem; letter-spacing: 0.05em;">{{ strtoupper($game->Category ?? 'OPEN') }}</span>
                        <h3 class="fw-bold text-dark mb-3" style="font-size: 1.05rem; line-height: 1.3;">{{ $game->GameName }}</h3>
                        
                        <div class="mt-auto">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <i class="bi bi-clock-history text-muted small"></i>
                                <span class="small fw-bold text-secondary">{{ $game->TimeStart }} – {{ $game->TimeEnd }}</span>
                            </div>

                            <div class="pt-3 border-top mt-2">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="meta-text" style="font-size: 0.6rem;">Intake Progress</span>
                                    <span class="small fw-black text-dark" style="font-size: 0.7rem;">{{ $appliedCount }} / {{ $game->Capacity ?? '∞' }}</span>
                                </div>
                                <div class="progress progress-minimal">
                                    <div class="progress-bar" style="width: {{ $percent }}%; background: #008080;"></div>
                                </div>
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