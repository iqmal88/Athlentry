@extends('layouts.admin')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<style>
    body {
        background-color: #F8F9FA;
        font-family: 'Inter', -apple-system, sans-serif;
        color: #1A1C1E;
    }

    /* 1. Header Styling */
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
        background: radial-gradient(circle, rgba(128, 0, 0, 0.05) 0%, rgba(255, 255, 255, 0) 70%);
        border-radius: 50%;
        z-index: 0;
    }

    /* 2. Detail Island Cards */
    .detail-card {
        background: #ffffff;
        border-radius: 24px;
        padding: 32px;
        border: 1px solid #E5E7EB;
        height: 100%;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }

    /* 3. Initials Avatar (Matching List View) */
    .avatar-box {
        width: 64px;
        height: 64px;
        background: #111827;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-weight: 800;
        font-size: 1.5rem;
        margin-bottom: 20px;
    }

    /* 4. Status Badges */
    .status-badge {
        font-size: 0.7rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding: 8px 20px;
        border-radius: 50px;
        display: inline-block;
    }
    .status-approved { background: #E6F4EA; color: #1E7E34; border: 1px solid #D1E7DD; }
    .status-rejected { background: #FCE8E6; color: #C5221F; border: 1px solid #F8D7DA; }
    .status-pending  { background: #FFF4E5; color: #B05E00; border: 1px solid #FFE5D0; }

    /* 5. UI Elements */
    .meta-label {
        font-size: 0.65rem;
        font-weight: 800;
        color: #9CA3AF;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        margin-bottom: 4px;
        display: block;
    }

    .info-value {
        font-weight: 700;
        color: #1A1C1E;
        font-size: 0.95rem;
    }

    .content-box {
        background: #F8F9FA;
        border-radius: 16px;
        padding: 20px;
        border: 1px solid #F1F3F5;
        font-size: 0.9rem;
        line-height: 1.6;
    }

    /* Buttons */
    .btn-maroon-pill {
        background: #800000;
        color: #fff !important;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.8rem;
        padding: 12px 32px;
        border: none;
        transition: 0.3s;
    }

    .btn-outline-pill {
        background: transparent;
        color: #6B7280 !important;
        border: 1px solid #E5E7EB;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.8rem;
        padding: 12px 32px;
        transition: 0.3s;
    }

    .btn-maroon-pill:hover { background: #600000; transform: translateY(-1px); }
</style>

<div class="container py-4">

    {{-- HEADER ISLAND --}}
    <div class="premium-header-rounded">
        <div class="aura-glow"></div>
        <div class="row align-items-center position-relative">
            <div class="col-md-8">
                <div class="d-flex align-items-center gap-3">
                    <a href="{{ route('admin.games.applicants', $application->GameID) }}" class="btn btn-outline-secondary btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                        <i class="bi bi-arrow-left"></i>
                    </a>
                    <div>
                        <h1 class="fw-bold text-dark mb-0" style="font-size: 1.75rem; letter-spacing: -0.02em;">
                            Application <span style="color: #800000;">Details</span>
                        </h1>
                        <p class="text-muted small mb-0 uppercase fw-bold tracking-wider" style="font-size: 0.65rem;">Applicant Review Panel</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                @php $status = $application->ApplicationStatus; @endphp
                @if($status === 'approved')
                    <span class="status-badge status-approved">Approved (Selection Stage)</span>
                @elseif($status === 'rejected')
                    <span class="status-badge status-rejected">Application Rejected</span>
                @else
                    <span class="status-badge status-pending">Pending Review</span>
                @endif
            </div>
        </div>
    </div>

    <div class="row g-4">
        {{-- LEFT: Student Profile --}}
        <div class="col-lg-4">
            <div class="detail-card text-center">
                @php
                    $userName = optional($application->user)->Name ?? 'Student';
                    $initials = strtoupper(substr($userName, 0, 1));
                @endphp
                
                <div class="d-flex justify-content-center">
                    <div class="avatar-box">{{ $initials }}</div>
                </div>
                
                <h3 class="fw-black text-uppercase mb-1" style="font-size: 1.25rem;">{{ $userName }}</h3>
                <p class="text-muted small fw-bold mb-4">Matric: {{ $application->user->MatricNo ?? '-' }}</p>

                <hr class="my-4 opacity-50">

                <div class="text-start space-y-3">
                    <div class="mb-3">
                        <span class="meta-label">Phone Number</span>
                        <span class="info-value">{{ $application->user->PhoneNumber ?? '-' }}</span>
                    </div>
                    <div class="mb-3">
                        <span class="meta-label">User Role</span>
                        <span class="info-value">{{ ucfirst($application->user->Role) }}</span>
                    </div>
                    <div class="mb-0">
                        <span class="meta-label">Submission Date</span>
                        <span class="info-value text-muted">
                            <i class="bi bi-calendar3 me-1"></i>
                            {{ \Carbon\Carbon::parse($application->DateApplied)->format('d M Y') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- RIGHT: Application Info --}}
        <div class="col-lg-8">
            <div class="detail-card">
                <div class="d-flex align-items-center gap-2 mb-4">
                    <i class="bi bi-info-circle-fill text-maroon" style="color: #800000;"></i>
                    <h5 class="fw-bold mb-0 text-uppercase tracking-tighter">Information Summary</h5>
                </div>

                <div class="row g-4 mb-5">
                    <div class="col-md-6">
                        <span class="meta-label">Event Name</span>
                        <p class="info-value mb-0">{{ $application->event->EventName ?? '-' }}</p>
                    </div>
                    <div class="col-md-6">
                        <span class="meta-label">Sporting Discipline</span>
                        <p class="info-value mb-0">{{ $application->game->GameName ?? '-' }}</p>
                    </div>
                    <div class="col-md-6">
                        <span class="meta-label">Competition Category</span>
                        <p class="info-value mb-0">{{ $application->game->Category ?? '-' }}</p>
                    </div>
                    <div class="col-md-6">
                        <span class="meta-label">Current Status</span>
                        <p class="info-value mb-0 capitalize text-maroon" style="color: #800000;">{{ $status }}</p>
                    </div>
                </div>

                <div class="mb-4">
                    <span class="meta-label">Sporting Achievements</span>
                    <div class="content-box mt-2">
                        {{ $application->user->Achievement ?? 'No recorded achievements provided.' }}
                    </div>
                </div>

                <div class="mb-5">
                    <span class="meta-label">Medical History / Declarations</span>
                    <div class="content-box mt-2">
                        {{ $application->user->MedicalHistory ?? 'No medical history disclosed.' }}
                    </div>
                </div>

                {{-- ACTIONS --}}
                <div class="pt-3 border-top">
                    @if($status === 'pending')
                        <div class="d-flex flex-wrap gap-3">
                            <form method="POST" action="{{ route('admin.applications.select', $application->ApplicationID) }}">
                                @csrf @method('PUT')
                                <input type="hidden" name="action" value="approve">
                                <button type="submit" class="btn-maroon-pill">
                                    <i class="bi bi-check-lg me-2"></i>Approve Candidate
                                </button>
                            </form>

                            <form method="POST" action="{{ route('admin.applications.select', $application->ApplicationID) }}">
                                @csrf @method('PUT')
                                <input type="hidden" name="action" value="reject">
                                <button type="submit" class="btn btn-outline-danger px-4 py-2 rounded-pill fw-bold" style="font-size: 0.8rem;">
                                    Reject Application
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="d-flex align-items-center gap-2 text-muted bg-light p-3 rounded-4 border border-dashed">
                            <i class="bi bi-lock-fill"></i>
                            <span class="small fw-bold text-uppercase tracking-widest">Decision finalized. No further modifications permitted.</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection