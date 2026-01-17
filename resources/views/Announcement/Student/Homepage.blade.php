@extends('layouts.app')

@section('title', 'Sport Announcements')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<style>
    body { background-color: #F8F9FA; font-family: 'Inter', sans-serif; padding-top: 20px; }
    .premium-header-rounded { background: #fff; border-radius: 24px; padding: 24px 40px; margin-bottom: 30px; border: 1px solid #E5E7EB; position: relative; overflow: hidden; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03); }
    .aura-glow { position: absolute; top: -100px; right: -30px; width: 350px; height: 350px; background: radial-gradient(circle, rgba(0, 128, 128, 0.08) 0%, rgba(255, 255, 255, 0) 70%); border-radius: 50%; z-index: 0; }
    .announce-card { background: #fff; border-radius: 20px; border: 1px solid #E5E7EB; overflow: hidden; height: 100%; transition: all 0.3s ease; display: flex; flex-direction: column; }
    .announce-card:hover { transform: translateY(-8px); box-shadow: 0 20px 40px rgba(0, 128, 128, 0.1); border-color: #008080; }
    .card-media { position: relative; height: 180px; overflow: hidden; background: #F3F4F6; }
    .card-media img { width: 100%; height: 100%; object-fit: cover; }
    .text-teal-blue { color: #008080 !important; }
    .btn-teal-link { color: #008080; text-decoration: none; font-weight: 700; font-size: 0.85rem; }
</style>

<div class="container pb-5">

    {{-- PROFILE WARNING ALERT --}}
    @if(auth()->user()->isStudent() && !auth()->user()->ProfileCompleted)
        @php $status = auth()->user()->getCompletionStatus(); @endphp
        <div class="premium-header-rounded border-warning border-opacity-25" style="background: #FFFDF5; margin-bottom: 20px;">
            <div class="row align-items-center">
                <div class="col-lg-9">
                    <div class="d-flex align-items-center mb-2">
                        <span class="p-2 bg-warning bg-opacity-10 rounded-circle me-3">
                            <i class="bi bi-shield-lock-fill text-warning h4 mb-0"></i>
                        </span>
                        <div>
                            <h6 class="fw-bold text-dark mb-0">Action Required: Profile Incomplete ({{ $status['percentage'] }}%)</h6>
                            <p class="text-muted small mb-0">Complete your athlete profile to unlock event applications.</p>
                        </div>
                    </div>
                    <div class="progress mt-3" style="height: 8px; border-radius: 10px; background: #FEF3C7;">
                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-warning" 
                             role="progressbar" 
                             style="width: {{ $status['percentage'] }}%"></div>
                    </div>
                </div>
                <div class="col-lg-3 text-lg-end mt-3 mt-lg-0">
                    <a href="{{ route('student.profile.show') }}" class="btn btn-dark rounded-pill px-4 fw-bold shadow-sm btn-sm">
                        Complete Profile <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    @endif

    {{-- MAIN HEADER --}}
    <div class="premium-header-rounded">
        <div class="aura-glow"></div>
        <div class="row align-items-center position-relative">
            <div class="col-md-8">
                <h6 class="fw-bold text-uppercase tracking-widest mb-2 text-teal-blue" style="font-size: 0.7rem;">Student Portal</h6>
                <h1 class="fw-bold text-dark mb-1" style="font-size: 1.75rem;">Live <span class="text-teal-blue">Announcements</span></h1>
                <p class="text-muted small mb-0">Stay updated with the latest sports news and recruitment notices.</p>
            </div>
        </div>
    </div>

    {{-- GRID --}}
    <div class="row g-4">
        @forelse($announcements as $announce)
            <div class="col-md-6 col-lg-4">
                <div class="announce-card">
                    <div class="card-media">
                        @if($announce->Image)
                            <img src="{{ asset('storage/' . $announce->Image) }}" alt="Announcement">
                        @else
                            <div class="w-100 h-100 d-flex align-items-center justify-content-center bg-light opacity-50">
                                <i class="bi bi-megaphone h3 text-muted"></i>
                            </div>
                        @endif
                    </div>
                    <div class="p-4 flex-grow-1 d-flex flex-column">
                        <div class="text-teal-blue fw-bold text-uppercase mb-1" style="font-size: 0.65rem;">
                            Closes: {{ \Carbon\Carbon::parse($announce->DateClose)->format('d M Y') }}
                        </div>
                        <h3 class="fw-bold h6 mb-2">{{ $announce->Title }}</h3>
                        <p class="text-muted small mb-4">{{ Str::limit(strip_tags($announce->Description), 90) }}</p>
                        <div class="mt-auto pt-3 border-top">
                            <a href="{{ route('student.announcements.show', $announce->AnnouncementID) }}" class="btn-teal-link">
                                View Details <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <p class="text-muted fw-bold">No announcements available.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection