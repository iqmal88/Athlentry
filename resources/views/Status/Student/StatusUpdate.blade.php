@extends('layouts.app')

@section('title', 'Selection Status')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<style>
    body {
        background-color: #F8F9FA;
        font-family: 'Inter', -apple-system, sans-serif;
        color: #1A1D1F;
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
        background: radial-gradient(circle, rgba(0, 128, 128, 0.08) 0%, rgba(255, 255, 255, 0) 70%);
        border-radius: 50%;
        z-index: 0;
    }

    /* 2. Event Island (Admin Style) */
    .event-island {
        background: #ffffff;
        border-radius: 28px;
        padding: 32px;
        margin-bottom: 40px;
        border: 1px solid #E5E7EB;
        box-shadow: 0 10px 40px rgba(0,0,0,0.02);
    }

    .event-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        padding-bottom: 15px;
        border-bottom: 1px solid #F3F5F7;
    }

    .event-name {
        font-weight: 800;
        font-size: 1.4rem;
        text-transform: uppercase;
        color: #111827;
        margin: 0;
    }

    /* 3. Status Rows */
    .status-row {
        background: #F9FAFB;
        border-radius: 20px;
        padding: 20px 28px;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        transition: all 0.3s ease;
        border: 1px solid transparent;
    }

    .status-row:hover {
        background: #fff;
        border-color: #008080;
        transform: translateX(5px);
    }

    .game-info-box {
        display: flex;
        flex-direction: column;
    }

    .game-title {
        font-weight: 800;
        font-size: 1.1rem;
        color: #111827;
        margin: 0;
    }

    .apply-date {
        font-size: 0.7rem;
        font-weight: 700;
        color: #9CA3AF;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    /* 4. Selection Status Badges */
    .badge-status {
        font-size: 0.75rem;
        font-weight: 800;
        padding: 8px 20px;
        border-radius: 12px;
        text-transform: uppercase;
        letter-spacing: 0.02em;
    }

    .bg-teal-light { background: rgba(0, 128, 128, 0.1); color: #008080; }
    .bg-pending { background: #FFF4E5; color: #B05E00; }
    .bg-success-light { background: #E6F4EA; color: #1E7E34; }
    .bg-danger-light { background: #FCE8E6; color: #C5221F; }

    .text-teal { color: #008080 !important; }
</style>

<div class="container pb-5 mt-4">
    <div class="premium-header-rounded">
        <div class="aura-glow"></div>
        <div class="row align-items-center position-relative">
            <div class="col-md-8">
                <h1 class="fw-bold text-dark mb-1" style="font-size: 1.75rem; letter-spacing: -0.02em;">Selection <span class="text-teal">Status</span></h1>
                <p class="text-muted small mb-0">Track the final results of your sports recruitment applications.</p>
            </div>
            <div class="col-md-4 text-md-end d-none d-lg-block">
            </div>
        </div>
    </div>

    @forelse($events as $event)
        <div class="event-island">
            <div class="event-header">
                <h2 class="event-name">{{ $event->EventName }}</h2>
            </div>

            <div class="status-container">
                @foreach($event->games as $game)
                    @foreach($game->applications as $app)
                        <div class="status-row shadow-sm">
                            <div class="game-info-box">
                                <span class="apply-date mb-1">Applied: {{ \Carbon\Carbon::parse($app->DateApplied)->format('d M Y') }}</span>
                                <h3 class="game-title">{{ $game->GameName }}</h3>
                            </div>

                            <div class="status-badge-box">

                            @if($app->ApplicationStatus !== 'approved')
                                    <span class="badge-status bg-light text-muted border">Application Processing</span>

                                @elseif($app->SelectionStatus === 'in_selection')
                                    <span class="badge-status bg-pending">
                                        <i class="bi bi-hourglass-split me-1"></i> In Selection
                                    </span>

                                @elseif($app->SelectionStatus === 'selected')
                                    <span class="badge-status bg-success-light">
                                        <i class="bi bi-trophy-fill me-1"></i> Selected
                                    </span>

                                @else
                                    <span class="badge-status bg-danger-light">
                                        <i class="bi bi-x-circle-fill me-1"></i> Not Selected
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @endforeach
            </div>
        </div>
    @empty
        <div class="bg-white rounded-[2.5rem] border-2 border-dashed border-slate-200 p-20 text-center">
            <i class="bi bi-info-circle text-gray-300 h1 mb-3"></i>
            <h3 class="text-xl font-black uppercase text-gray-900">No Status Available</h3>
            <p class="text-gray-400 text-sm mt-2 font-medium">You haven't submitted any applications yet.</p>
        </div>
    @endforelse
</div>

@endsection