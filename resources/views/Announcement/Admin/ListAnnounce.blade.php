@extends('layouts.admin')

@section('title', 'Manage Announcements')

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

    /* 1. Rounded Island Header */
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

    /* 2. Announcement Grid Card */
    .announce-card {
        background: #fff;
        border-radius: 20px;
        border: 1px solid #E5E7EB;
        overflow: hidden;
        height: 100%;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        flex-direction: column;
    }

    .announce-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.06);
        border-color: #800000;
    }

    /* 3. Image Section with Badges */
    .card-media {
        position: relative;
        height: 180px;
        overflow: hidden;
        background: #F3F4F6;
    }

    .card-media img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .badge-overlay {
        position: absolute;
        top: 15px;
        left: 15px;
        z-index: 10;
    }

    .visibility-dot {
        position: absolute;
        top: 15px;
        right: 15px;
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(4px);
        width: 32px;
        height: 32px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    /* 4. Content Area */
    .card-body-custom {
        padding: 24px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .date-tag {
        font-size: 0.65rem;
        font-weight: 800;
        color: #800000;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 10px;
    }

    .announce-title {
        font-weight: 800;
        font-size: 1.1rem;
        margin-bottom: 12px;
        color: #111827;
        line-height: 1.3;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .announce-excerpt {
        font-size: 0.85rem;
        color: #6B7280;
        line-height: 1.5;
        margin-bottom: 20px;
    }

    /* 5. Footer Actions */
    .card-footer-custom {
        padding-top: 15px;
        border-top: 1px solid #F3F4F6;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .btn-action-icon {
        width: 34px;
        height: 34px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #E5E7EB;
        color: #4B5563;
        background: #fff;
        transition: 0.2s;
    }

    .btn-action-icon:hover {
        background: #800000;
        color: #fff;
        border-color: #800000;
    }

    .btn-maroon-pill {
        background: #800000;
        color: #fff;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.75rem;
        padding: 10px 24px;
        border: none;
        transition: all 0.3s ease;
    }
</style>

<div class="container pb-5">
    <div class="premium-header-rounded">
        <div class="aura-glow"></div>
        <div class="row align-items-center position-relative">
            <div class="col-md-7">
                <h1 class="fw-bold text-dark mb-1" style="font-size: 1.75rem; letter-spacing: -0.02em;">Manage <span style="color: #800000;">Announcements</span></h1>
                <p class="text-muted small mb-0">Make Announcement for Everything Related With Sport.</p>
            </div>
            <div class="col-md-5 text-md-end mt-3 mt-md-0">
                <a href="{{ route('admin.announcements.create') }}" class="btn btn-maroon-pill shadow-sm">
                    <i class="bi bi-plus-circle me-2"></i>New Announcement
                </a>
            </div>
        </div>
    </div>

    <div class="row g-4">
        @forelse($announcements as $announce)
            <div class="col-md-6 col-lg-4">
                <div class="announce-card">
                    <div class="card-media">
                        <div class="badge-overlay">
                            <span class="badge bg-white text-dark shadow-sm fw-bold uppercase" style="font-size: 0.6rem;">
                                {{ $announce->Category ?? 'News' }}
                            </span>
                        </div>
                        <div class="visibility-dot">
                            @if(strtolower($announce->visibility ?? 'public') == 'public')
                                <i class="bi bi-eye text-success" style="font-size: 0.9rem;"></i>
                            @else
                                <i class="bi bi-eye-slash text-secondary" style="font-size: 0.9rem;"></i>
                            @endif
                        </div>
                        @if($announce->Image)
                            <img src="{{ asset('storage/' . $announce->Image) }}" alt="Thumbnail">
                        @else
                            <div class="w-100 h-100 d-flex align-items-center justify-content-center bg-light opacity-50">
                                <i class="bi bi-image h3 text-muted"></i>
                            </div>
                        @endif
                    </div>

                    <div class="card-body-custom">
                        <div class="date-tag">
                            {{ \Carbon\Carbon::parse($announce->Date)->format('d M, Y') }}
                        </div>
                        <h3 class="announce-title">{{ $announce->Title }}</h3>
                        <p class="announce-excerpt">
                            {{ Str::limit($announce->Description, 100) }}
                        </p>

                        <div class="card-footer-custom mt-auto">
                            <a href="{{ route('admin.announcements.show', $announce->AnnouncementID) }}" class="text-maroon fw-bold text-decoration-none small">
                                Full Article <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <div class="bg-white rounded-5 border border-dashed p-5">
                    <i class="bi bi-chat-left-dots text-light h1"></i>
                    <p class="text-muted mt-3 fw-bold">No announcements in the registry yet.</p>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection