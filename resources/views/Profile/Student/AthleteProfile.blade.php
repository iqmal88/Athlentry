@extends('layouts.app')

@section('title', 'My Athlete Profile')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<style>
    body { background-color: #F2F4F7; font-family: 'Inter', sans-serif; color: #1A1C1E; }
    
    .premium-header-rounded {
        background: #fff; border-radius: 24px; padding: 24px 40px; margin-bottom: 30px;
        border: 1px solid #E5E7EB; position: relative; overflow: hidden;
        box-shadow: 0 4px 20px rgba(0,0,0,0.03);
    }

    .aura-glow {
        position: absolute; top: -100px; right: -30px; width: 350px; height: 350px;
        background: radial-gradient(circle, rgba(0, 128, 128, 0.05) 0%, rgba(255, 255, 255, 0) 70%);
        border-radius: 50%;
    }

    .info-block {
        background: #ffffff; border-radius: 20px; padding: 32px; margin-bottom: 30px;
        border: 1px solid #E5E7EB; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
    }

    .meta-label { font-size: 0.65rem; font-weight: 800; color: #9CA3AF; text-transform: uppercase; letter-spacing: 0.1em; }
    .data-value { font-weight: 700; color: #1A1C1E; font-size: 1rem; }
    .text-teal { color: #008080 !important; }
    
    .progress-custom { height: 8px; border-radius: 10px; background: #F3F4F6; overflow: hidden; }
    .progress-bar-teal { background: #008080; box-shadow: 0 0 10px rgba(0, 128, 128, 0.2); }
</style>

<div class="container pb-5">
    {{-- Header Matched to Game Info --}}
    <div class="premium-header-rounded">
        <div class="aura-glow"></div>
        <div class="row align-items-center position-relative">
            <div class="col-md-7">
                <h1 class="fw-bold mb-1" style="font-size:1.75rem;">
                    Athlete <span class="text-teal">Profile</span>
                </h1>
                <p class="text-muted small mb-0">Official Students Details & Verification</p>
            </div>
            <div class="col-md-5 text-md-end mt-3 mt-md-0">
                <a href="{{ route('student.profile.edit') }}" class="btn btn-dark fw-bold rounded-pill px-4 shadow-sm" style="font-size: 0.8rem; background: #1A1C1E;">
                    <i class="bi bi-pencil-square me-2"></i>Edit My Profile
                </a>
            </div>
        </div>
    </div>

    {{-- Progress Tracker Island --}}
    @php $status = auth()->user()->getCompletionStatus(); @endphp
    <div class="info-block">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h6 class="meta-label mb-2">Completion Progress</h6>
                <div class="progress-custom mt-3">
                    <div class="progress-bar progress-bar-teal" role="progressbar" style="width: {{ $status['percentage'] }}%"></div>
                </div>
            </div>
            <div class="col-md-4 text-md-end">
                <span class="h2 fw-black italic text-teal">{{ $status['percentage'] }}%</span>
                <p class="text-muted small fw-bold mb-0 uppercase tracking-widest" style="font-size: 0.6rem;">
                    {{ $status['is_complete'] ? 'Profile Verified' : 'Complete to apply for games' }}
                </p>
            </div>
        </div>
    </div>

    <div class="row g-4">
        {{-- Avatar & Basic Stats --}}
        <div class="col-lg-4">
            <div class="info-block text-center h-100">
                <div class="mx-auto mb-4 border-4 border-white shadow-lg overflow-hidden" 
                     style="width: 160px; height: 160px; border-radius: 40px;">
                    <img src="{{ $user->ProfilePhoto ? asset('storage/' . $user->ProfilePhoto) : 'https://ui-avatars.com/api/?name='.urlencode($user->Name).'&background=008080&color=fff&size=512' }}" 
                         class="w-100 h-100 object-cover" alt="Profile">
                </div>
                <h4 class="fw-bold mb-1 uppercase tracking-tight text-dark">{{ $user->Name }}</h4>
                <p class="text-teal fw-bold italic small mb-0">{{ $user->MatricNo }}</p>
                
                <div class="mt-4 pt-4 border-top">
                    <div class="row">
                        <div class="col-6 border-end">
                            <p class="meta-label mb-0">Role</p>
                            <p class="fw-bold small text-dark mb-0 uppercase">Student</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Details Island --}}
        <div class="col-lg-8">
            <div class="info-block h-100">
                <div class="row g-4">
                    <div class="col-md-6">
                        <p class="meta-label mb-1">Email Address</p>
                        <p class="data-value">{{ $user->Email }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="meta-label mb-1">Contact Number</p>
                        <p class="data-value">{{ $user->PhoneNumber ?? '-' }}</p>
                    </div>
                    <div class="col-12">
                        <div class="p-3 rounded-4 bg-light border border-dashed">
                            <p class="meta-label mb-2"><i class="bi bi-trophy-fill text-teal me-2"></i>Sports Achievement</p>
                            <p class="data-value small mb-0" style="white-space: pre-wrap;">{{ $user->Achievement ?? 'No achievements listed.' }}</p>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="p-3 rounded-4 bg-light border border-dashed">
                            <p class="meta-label mb-2"><i class="bi bi-heart-pulse-fill text-danger me-2"></i>Medical History</p>
                            <p class="data-value small mb-0" style="white-space: pre-wrap;">{{ $user->MedicalHistory ?? 'No medical history recorded.' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection