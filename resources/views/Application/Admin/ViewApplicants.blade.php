@extends('layouts.admin')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<style>
    body {
        background-color: #F8F9FA;
        font-family: 'Inter', -apple-system, sans-serif;
        color: #1A1C1E;
        padding-top: 20px;
    }

    /* 1. Rounded Island Header - EXACT CLONE OF LIST PAGE */
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
    
    /* Radial Glow matching your branding */
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

    /* 2. Applicant Item Card - High Density */
    .applicant-island-card {
        background: #ffffff;
        border-radius: 20px;
        padding: 20px 32px;
        margin-bottom: 12px;
        border: 1px solid #F1F3F5;
        display: flex;
        align-items: center;
        transition: all 0.2s ease;
    }

    .applicant-island-card:hover {
        border-color: #800000;
        background: #fff;
        box-shadow: 0 10px 25px rgba(0,0,0,0.04);
    }

    /* 3. Initials Avatar */
    .avatar-box {
        width: 52px;
        height: 52px;
        background: #111827;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-weight: 800;
        font-size: 1.1rem;
        flex-shrink: 0;
    }

    /* 4. Status Tints */
    .status-badge {
        font-size: 0.65rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding: 6px 16px;
        border-radius: 50px;
    }

    .status-approved { background: #E6F4EA; color: #1E7E34; border: 1px solid #D1E7DD; }
    .status-rejected { background: #FCE8E6; color: #C5221F; border: 1px solid #F8D7DA; }
    .status-pending  { background: #FFF4E5; color: #B05E00; border: 1px solid #FFE5D0; }

    /* 5. Buttons */
    .btn-maroon-pill {
        background: #800000;
        color: #fff !important;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.75rem;
        padding: 8px 24px;
        border: none;
        transition: 0.3s;
    }

    .btn-outline-pill {
        background: transparent;
        color: #C5221F !important;
        border: 1px solid #F8D7DA;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.75rem;
        padding: 8px 24px;
        transition: 0.3s;
    }

    .btn-outline-pill:hover {
        background: #FCE8E6;
    }

    .meta-text {
        font-size: 0.65rem;
        font-weight: 700;
        color: #9CA3AF;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
</style>

<div class="container pb-5">

    {{-- HEADER ISLAND (Matches List/Edit perfectly) --}}
    <div class="premium-header-rounded">
        <div class="aura-glow"></div>
        <div class="row align-items-center position-relative">
            <div class="col-8">
                <div class="d-flex align-items-center gap-3">
                    <a href="{{ route('admin.events.list') }}" class="btn btn-outline-secondary btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 34px; height: 34px;">
                        <i class="bi bi-arrow-left"></i>
                    </a>
                    <div>
                        <h1 class="fw-bold text-dark mb-0" style="font-size: 1.75rem; letter-spacing: -0.02em;">
                            {{ $game->GameName }} <span style="color: #800000;">Applicants</span>
                        </h1>
                        <p class="text-muted small mb-0">Unified registry and selection control hub.</p>
                    </div>
                </div>
            </div>
            <div class="col-4 text-end">
                <div class="d-inline-flex align-items-center gap-2 bg-light px-3 py-2 rounded-3 border">
                    <span class="meta-text">Total</span>
                    <span class="fw-black h5 mb-0 text-dark">{{ sprintf('%02d', $applications->count()) }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- APPLICANTS LIST --}}
    <div class="max-w-7xl mx-auto">
        @forelse($applications as $app)
            @php
                $userName = optional($app->user)->Name ?? 'Student';
                $initials = strtoupper(substr($userName, 0, 1));
                $status   = $app->ApplicationStatus;
            @endphp

            <div class="applicant-island-card shadow-sm">
                
                {{-- Left: Profile Details --}}
                <div class="d-flex align-items-center gap-4 flex-grow-1">
                    <div class="avatar-box">{{ $initials }}</div>
                    <div>
                        <a href="{{ route('admin.applications.show', $app->ApplicationID) }}" class="h5 fw-bold text-dark mb-1 d-block text-decoration-none" onmouseover="this.style.color='#800000'" onmouseout="this.style.color='#1A1C1E'">
                            {{ $userName }}
                        </a>
                        <div class="d-flex align-items-center gap-2">
                            <span class="meta-text"><i class="bi bi-calendar-check me-1"></i>Applied: {{ \Carbon\Carbon::parse($app->DateApplied)->format('d M Y') }}</span>
                        </div>
                    </div>
                </div>

                {{-- Middle: Status Display --}}
                <div class="px-5 d-none d-lg-block text-center" style="min-width: 200px;">
                    @if($status === 'approved')
                        <span class="status-badge status-approved">Approved</span>
                    @elseif($status === 'rejected')
                        <span class="status-badge status-rejected">Rejected</span>
                    @elseif($status === 'withdrawn')
                        <span class="status-badge bg-light text-muted border">Withdrawn</span>
                    @else
                        <span class="status-badge status-pending">Pending Review</span>
                    @endif
                </div>

                {{-- Right: Decision Buttons --}}
                <div class="d-flex gap-2">
                    @if($status === 'pending')
                        <form method="POST" action="{{ route('admin.applications.select', $app->ApplicationID) }}">
                            @csrf @method('PUT')
                            <input type="hidden" name="action" value="approve">
                            <button type="submit" class="btn-maroon-pill">Approve</button>
                        </form>

                        <form method="POST" action="{{ route('admin.applications.select', $app->ApplicationID) }}">
                            @csrf @method('PUT')
                            <input type="hidden" name="action" value="reject">
                            <button type="submit" class="btn-outline-pill">Reject</button>
                        </form>
                    @else
                        <div class="px-4 d-flex align-items-center gap-2 text-muted">
                            <i class="bi bi-lock-fill small"></i>
                            <span class="meta-text">Decision Final</span>
                        </div>
                    @endif
                </div>

            </div>
        @empty
            <div class="text-center py-5 bg-white rounded-4 border border-dashed mt-4">
                <i class="bi bi-people text-light display-1"></i>
                <p class="text-muted fw-bold mt-3">No candidates registered for this discipline.</p>
            </div>
        @endforelse
    </div>

</div>
@endsection