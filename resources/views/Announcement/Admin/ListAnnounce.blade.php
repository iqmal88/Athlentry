@extends('layouts.admin')

@section('title', 'Announcements')

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

    /* 2. Announcement Grid Card */
    .announce-card {
        background: #fff;
        border-radius: 24px;
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

    /* 3. Media Section */
    .card-media {
        position: relative;
        height: 200px;
        overflow: hidden;
        background: #F3F4F6;
    }

    .card-media img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .badge-category {
        position: absolute;
        top: 15px;
        left: 15px;
        background: rgba(255, 255, 255, 0.9);
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 0.6rem;
        font-weight: 800;
        text-transform: uppercase;
        color: #1A1C1E;
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
        margin-bottom: 12px;
    }

    .announce-title {
        font-weight: 800;
        font-size: 1.15rem;
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
        color: #6F767E;
        line-height: 1.6;
        margin-bottom: 20px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .btn-full-article {
        font-size: 0.75rem;
        font-weight: 700;
        color: #0066FF;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-full-article:hover {
        text-decoration: underline;
    }

    /* 5. Header Button */
    .btn-new-announcement {
        background: #800000;
        color: #fff !important;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.75rem;
        padding: 10px 24px;
        border: none;
        transition: all 0.3s ease;
        text-transform: capitalize;
    }

    .btn-new-announcement:hover {
        background: #600000;
        transform: translateY(-2px);
    }
</style>

<div class="container pb-5">
    <div class="premium-header-rounded">
        <div class="row align-items-center">
            <div class="col-md-7">
                <h1 class="fw-bold text-dark mb-1" style="font-size: 1.75rem; letter-spacing: -0.02em;">Announcements <span style="color: #800000;">Publisher</span></h1>
                <p class="text-muted small mb-0">Make Announcement for Everything Related With Sport and Athlete Recruitment.</p>
            </div>
            <div class="col-md-5 text-md-end mt-3 mt-md-0">
                <a href="{{ route('admin.announcements.create') }}" class="btn-new-announcement shadow-sm">
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
                        <div class="badge-category">NEWS</div>          
                        @if($announce->Image)
                            <img src="{{ asset('storage/' . $announce->Image) }}" alt="Thumbnail">
                        @else
                            <div class="w-100 h-100 d-flex align-items-center justify-content-center bg-light">
                                <i class="bi bi-image h3 text-muted"></i>
                            </div>
                        @endif
                    </div>

                    <div class="card-body-custom">
                        <div class="date-tag">Application Close Date: 
                            {{ \Carbon\Carbon::parse($announce->DateClose)->format('d M, Y') }}
                        </div>
                        <h3 class="announce-title">{{ $announce->Title }}</h3>
                        <p class="announce-excerpt">
                            {{ Str::limit($announce->Description, 120) }}
                        </p>

                        <div class="mt-auto pt-3 border-top">
                            <a href="{{ route('admin.announcements.show', $announce->AnnouncementID) }}" class="btn-full-article">
                                More Details <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <div class="bg-white rounded-5 border border-dashed p-5">
                    <i class="bi bi-megaphone text-light display-1"></i>
                    <p class="text-muted mt-3 fw-bold">No announcements have been made yet.</p>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection