@extends('layouts.admin')

@section('title', 'Admin Profile')

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
        background: radial-gradient(circle, rgba(128,0,0,0.05) 0%, rgba(255,255,255,0) 70%);
        border-radius: 50%;
    }

    .info-block {
        background: #ffffff; border-radius: 16px; padding: 32px;
        border: 1px solid #E5E7EB; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
    }

    .meta-label { font-size: 0.7rem; font-weight: 800; color: #9CA3AF; text-transform: uppercase; letter-spacing: 0.05em; }
    .data-value { font-weight: 700; color: #1A1C1E; font-size: 1.1rem; }
    .text-maroon { color: #800000 !important; }
</style>

<div class="container pb-5">
    {{-- Header Matched to Game Info --}}
    <div class="premium-header-rounded">
        <div class="aura-glow"></div>
        <div class="row align-items-center position-relative">
            <div class="col-md-7">
                <h1 class="fw-bold mb-1" style="font-size:1.75rem;">
                    User <span class="text-maroon">Profile</span>
                </h1>
                <p class="text-muted small mb-0">Administrative Identity Management</p>
            </div>
            <div class="col-md-5 text-md-end mt-3 mt-md-0">
                <a href="{{ route('admin.profile.edit') }}" class="btn btn-dark fw-bold rounded-pill px-4 shadow-sm" style="font-size: 0.8rem; background: #1A1C1E;">
                    <i class="bi bi-pencil-square me-2"></i>Edit Profile
                </a>
            </div>
        </div>
    </div>

    <div class="row g-4">
        {{-- Avatar Section --}}
        <div class="col-lg-4">
            <div class="info-block text-center h-100">
                <div class="mx-auto mb-4 d-flex align-items-center justify-content-center border-4 border-white shadow-lg italic font-black text-white" 
                     style="width: 150px; height: 150px; border-radius: 40px; background: #800000; font-size: 4rem;">
                    {{ strtoupper(substr($admin->Name, 0, 1)) }}
                </div>
                <h3 class="fw-bold mb-1">{{ $admin->Name }}</h3>
                <span class="badge bg-danger bg-opacity-10 text-maroon rounded-pill px-3 py-2 fw-800 italic" style="font-size: 0.65rem; letter-spacing: 0.1em;">MASTER ADMIN</span>
                
                <div class="mt-4 pt-4 border-top">
                    <p class="meta-label mb-1">Account Active Since</p>
                    <p class="fw-bold text-dark">{{ $admin->created_at->format('M d, Y') }}</p>
                </div>
            </div>
        </div>

        {{-- Details Section --}}
        <div class="col-lg-8">
            <div class="info-block h-100">
                <div class="d-flex align-items-center gap-3 mb-4 pb-2 border-bottom">
                    <i class="bi bi-shield-lock text-maroon h4 mb-0"></i>
                    <h5 class="fw-800 text-uppercase mb-0" style="letter-spacing: 1px; font-size: 0.9rem;">Credential Information</h5>
                </div>

                <div class="row g-4 mt-2">
                    <div class="col-md-6">
                        <p class="meta-label mb-1">Full Name</p>
                        <p class="data-value">{{ $admin->Name }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="meta-label mb-1">Admin ID</p>
                        <p class="data-value text-maroon italic">{{ $admin->MatricNo }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="meta-label mb-1">Email</p>
                        <p class="data-value">{{ $admin->Email }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="meta-label mb-1">Contact Number</p>
                        <p class="data-value">{{ $admin->PhoneNumber ?? 'Not Linked' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection