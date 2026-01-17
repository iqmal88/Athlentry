@extends('layouts.admin')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<style>
    body {
        background-color: #F2F4F7;
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

    /* 2. Content Islands */
    .detail-island {
        background: #ffffff;
        border-radius: 24px;
        padding: 32px;
        border: 1px solid #E5E7EB;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        margin-bottom: 24px;
    }

    .bento-dark {
        background: #111827;
        color: #fff;
        border-radius: 24px;
        padding: 32px;
        position: relative;
        overflow: hidden;
    }

    /* 3. Typography & Badges */
    .meta-label {
        font-size: 0.65rem;
        font-weight: 800;
        color: #9CA3AF;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        margin-bottom: 4px;
        display: block;
    }

    .status-badge {
        font-size: 0.7rem;
        font-weight: 800;
        text-transform: uppercase;
        padding: 6px 16px;
        border-radius: 50px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .status-open { background: #E6F4EA; color: #1E7E34; border: 1px solid #D1E7DD; }
    .status-closed { background: #FCE8E6; color: #C5221F; border: 1px solid #F8D7DA; }

    /* 4. Action Buttons */
    .btn-maroon-pill {
        background: #800000;
        color: #fff !important;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.8rem;
        padding: 10px 24px;
        border: none;
        transition: 0.3s;
    }
    .btn-maroon-pill:hover { background: #600000; transform: translateY(-1px); }

    .rule-item {
        background: #F9FAFB;
        border: 1px solid #F3F4F6;
        border-radius: 16px;
        padding: 16px;
        transition: 0.2s;
    }
    .rule-item:hover { border-color: #800000; background: #fff; }

    .fw-black { font-weight: 900; }
    .text-maroon { color: #800000 !important; }
</style>

<div class="container py-4">

    {{-- HEADER ISLAND --}}
    <div class="premium-header-rounded">
        <div class="aura-glow"></div>
        <div class="row align-items-center position-relative">
            <div class="col-md-7">
                <div class="d-flex align-items-center gap-3">
                    <a href="{{ route('admin.gameinfo.index') }}" class="btn btn-outline-secondary btn-sm rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 40px; height: 40px; background: #fff;">
                        <i class="bi bi-arrow-left"></i>
                    </a>
                    <div>
                        <h1 class="fw-bold mb-0" style="font-size: 1.75rem; letter-spacing: -0.02em;">
                            Game <span class="text-maroon">Details</span>
                        </h1>
                        <p class="text-muted small mb-0 uppercase fw-bold tracking-wider" style="font-size: 0.65rem;">Unified Management Hub</p>
                    </div>
                </div>
            </div>
            <div class="col-md-5 text-md-end mt-3 mt-md-0 d-flex gap-2 justify-content-md-end">
                <a href="{{ route('admin.gameinfo.edit', $game->GameID) }}" class="btn-maroon-pill">
                    <i class="bi bi-pencil-square me-2"></i> Modify Game
                </a>
                <form action="{{ route('admin.gameinfo.destroy', $game->GameID) }}" method="POST" onsubmit="return confirm('Delete this game?');">
                    @csrf @method('DELETE')
                    <button class="btn btn-outline-danger rounded-pill px-4 fw-bold" style="font-size: 0.8rem;">
                        <i class="bi bi-trash"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="row g-4">
        {{-- LEFT COLUMN: Main Info --}}
        <div class="col-lg-8">
            {{-- HERO INFO CARD --}}
            <div class="detail-island position-relative overflow-hidden">
                <div class="position-absolute top-0 end-0 p-4 opacity-10">
                    <span class="fw-black italic display-1">{{ substr($game->GameName, 0, 1) }}</span>
                </div>

                <div class="position-relative z-1">
                    @php $status = strtolower($game->final_status); @endphp
                    <span class="status-badge {{ $status === 'open' ? 'status-open' : 'status-closed' }} mb-4">
                        <i class="bi {{ $status === 'open' ? 'bi-circle-fill' : 'bi-x-circle-fill' }} small"></i>
                        {{ $game->final_status }}
                    </span>

                    <h2 class="display-5 fw-black text-dark tracking-tighter mb-2">{{ $game->GameName }}</h2>
                    <p class="text-muted fw-bold text-uppercase tracking-widest small mb-5">
                        <i class="bi bi-collection-play text-maroon me-2"></i>
                        {{ $game->event->EventName ?? 'Standalone Event' }}
                    </p>

                    <div class="mb-5 pt-4 border-top">
                        <span class="meta-label">About the Game</span>
                        <p class="fs-5 text-secondary fw-light leading-relaxed">
                            {{ $game->Description ?: 'No description has been provided for this game yet.' }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- RULES CARD --}}
            <div class="detail-island">
                <div class="d-flex align-items-center gap-2 mb-4">
                    <i class="bi bi-shield-check text-maroon"></i>
                    <span class="meta-label mb-0">Game Regulations</span>
                </div>
                
                @if($game->Rules)
                    <div class="row g-3">
                        @foreach(explode("\n", $game->Rules) as $rule)
                            @if(trim($rule))
                                <div class="col-12">
                                    <div class="rule-item d-flex gap-3 align-items-center">
                                        <div class="flex-shrink-0 bg-dark text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 28px; height: 28px; font-size: 0.75rem;">
                                            {{ $loop->iteration }}
                                        </div>
                                        <p class="mb-0 fw-medium text-dark small">{{ trim($rule) }}</p>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4 bg-light rounded-4 border border-dashed">
                        <p class="text-muted small mb-0 italic">No specific rules provided.</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- RIGHT COLUMN: Sidebar --}}
        <div class="col-lg-4">
            {{-- LOGISTICS BENTO (VENUE & SCHEDULE) --}}
            <div class="bento-dark shadow-xl mb-4">
                <i class="bi bi-geo-alt position-absolute opacity-10" style="font-size: 5rem; bottom: -10px; right: -10px;"></i>
                
                <div class="mb-4">
                    <p class="meta-label text-danger">Game Venue</p>
                    <p class="h4 fw-bold tracking-tight text-white">{{ $game->GameVenue ?: 'To Be Announced' }}</p>
                </div>

                <div class="mb-0">
                    <p class="meta-label text-danger">Match Schedule</p>
                    <p class="h4 fw-bold tracking-tight mb-2 text-white">
                        {{ $game->GameDate ? \Carbon\Carbon::parse($game->GameDate)->format('d M, Y') : 'TBA' }}
                    </p>
                    <span class="badge rounded-pill px-3 py-2 fw-black" style="font-size: 0.75rem; background: #800000; color: white; border: 1px solid rgba(255,255,255,0.1);">
                        <i class="bi bi-clock me-1"></i> {{ $game->TimeStart }} – {{ $game->TimeEnd }}
                    </span>
                </div>
            </div>

            {{-- PERSONNEL CARD (PIC UPDATED) --}}
            <div class="detail-island">
                <div class="d-flex align-items-center gap-2 mb-4">
                    <i class="bi bi-people-fill text-maroon"></i>
                    <span class="meta-label mb-0">Personnel & Staffing</span>
                </div>
                
                <div class="d-flex align-items-center gap-3 p-3 rounded-4 bg-light border border-white shadow-sm mb-4">
                    <div class="bg-white text-maroon rounded-3 d-flex align-items-center justify-content-center shadow-sm" 
                         style="width: 52px; height: 52px; border: 1px solid #E5E7EB;">
                        <i class="bi bi-person-badge-fill" style="font-size: 1.5rem;"></i>
                    </div>
                    <div>
                        <span class="meta-label" style="font-size: 0.6rem; color: #800000;">Person In-Charge</span>
                        <p class="fw-black text-dark mb-0" style="font-size: 0.95rem; letter-spacing: -0.01em;">
                            {{ $game->PICName ?: 'Unassigned' }}
                        </p>
                        @if($game->PICPhone)
                            <p class="text-muted mb-0 small fw-bold">
                                <i class="bi bi-telephone me-1"></i> {{ $game->PICPhone }}
                            </p>
                        @endif
                    </div>
                </div>

                <hr class="my-4 opacity-50">

                <div class="row g-3">
                    <div class="col-6">
                        <div class="p-1">
                            <span class="meta-label">Specification</span>
                            <p class="fw-bold text-dark small mb-0">{{ $game->Category }}</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-1 border-start">
                            <span class="meta-label">Max Capacity</span>
                            <p class="fw-bold text-dark small mb-0">{{ $game->Capacity }} Pax</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- FOOTER HELP --}}
            <div class="text-center p-3 rounded-4 bg-white border border-dashed shadow-sm">
                <p class="text-muted small mb-0 fw-bold">
                    <i class="bi bi-info-circle me-1 text-maroon"></i> Live Oversight Active
                </p>
            </div>
        </div>
    </div>
</div>
@endsection