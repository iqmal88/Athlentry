@extends('layouts.app')

@section('title', 'Sport Announcements')

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
        /* Updated to Teal Blue */
        background: radial-gradient(circle, rgba(0, 128, 128, 0.08) 0%, rgba(255, 255, 255, 0) 70%);
        border-radius: 50%;
        z-index: 0;
    }

    /* 2. Announcement Card System */
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
        /* Updated to Teal Blue Shadow */
        box-shadow: 0 20px 40px rgba(0, 128, 128, 0.1);
        border-color: #008080;
    }

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

    .card-body-custom {
        padding: 24px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .date-tag {
        font-size: 0.65rem;
        font-weight: 800;
        /* Updated to Teal Blue */
        color: #008080;
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

    .card-footer-custom {
        padding-top: 15px;
        border-top: 1px solid #F3F4F6;
        display: flex;
        justify-content: flex-end;
        align-items: center;
    }

    /* Updated Branding Color */
    .text-teal-blue { color: #008080 !important; }
    
    .btn-teal-link {
        color: #008080;
        text-decoration: none;
        font-weight: 700;
        font-size: 0.85rem;
        transition: color 0.2s;
    }
    
    .btn-teal-link:hover {
        color: #005656;
    }
</style>

<div class="container pb-5">
    <div class="premium-header-rounded">
        <div class="aura-glow"></div>
        <div class="row align-items-center position-relative">
            <div class="col-md-8">
                <h6 class="fw-bold text-uppercase tracking-widest mb-2 text-teal-blue" style="font-size: 0.7rem;">Student Portal</h6>
                <h1 class="fw-bold text-dark mb-1" style="font-size: 1.75rem; letter-spacing: -0.02em;">Live <span class="text-teal-blue">Announcements</span></h1>
                <p class="text-muted small mb-0">Stay updated with the latest sports news and recruitment notices.</p>
            </div>
            <div class="col-md-4 text-md-end d-none d-lg-block">
                {{-- Teal Badge --}}
                <span class="badge bg-info bg-opacity-10 text-teal-blue rounded-pill px-3 py-2 fw-bold border border-info border-opacity-25" style="font-size: 0.6rem; letter-spacing: 0.05em;">
                    <i class="bi bi-broadcast me-1"></i> LIVE UPDATES
                </span>
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
                                {{ $announce->Category ?? 'General' }}
                            </span>
                        </div>
                        
                        @if($announce->Image)
                            <img src="{{ asset('storage/' . $announce->Image) }}" alt="Announcement">
                        @else
                            <div class="w-100 h-100 d-flex align-items-center justify-content-center bg-light opacity-50">
                                <i class="bi bi-megaphone h3 text-muted"></i>
                            </div>
                        @endif
                    </div>

                    <div class="card-body-custom">
                        <div class="date-tag">
                            {{ \Carbon\Carbon::parse($announce->Date)->format('d F, Y') }}
                        </div>
                        <h3 class="announce-title">{{ $announce->Title }}</h3>
                        <p class="announce-excerpt">
                            {{ Str::limit(strip_tags($announce->Description), 100) }}
                        </p>

                        <div class="card-footer-custom mt-auto">
                            <a href="{{ route('student.announcements.show', $announce->AnnouncementID) }}" class="btn-teal-link">
                                Read More <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <div class="bg-white rounded-5 border border-dashed p-5">
                    <i class="bi bi-journal-x text-light h1"></i>
                    <p class="text-muted mt-3 fw-bold uppercase tracking-widest small">No announcements found at this time.</p>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection