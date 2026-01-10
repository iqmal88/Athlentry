@extends('layouts.admin')

@section('title', 'Reports & Analytics')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<style>
    body {
        background-color: #F2F4F7;
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

    /* 2. Professional Stat Cards */
    .stat-card {
        background: #fff;
        border-radius: 20px;
        padding: 24px;
        border: 1px solid #E5E7EB;
        box-shadow: 0 10px 40px rgba(0,0,0,0.03);
        transition: transform 0.2s ease;
    }
    
    .stat-label {
        font-size: 0.65rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #9CA3AF;
        margin-bottom: 8px;
    }
    .stat-value {
        font-size: 1.75rem;
        font-weight: 800;
        color: #111827;
        margin-bottom: 0;
    }

    /* 3. Unified Filter & Export Bar */
    .action-container {
        background: #fff;
        border-radius: 24px;
        padding: 30px;
        border: 1px solid #E5E7EB;
        margin-bottom: 30px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.02);
    }

    .form-select-custom {
        border-radius: 12px !important;
        font-weight: 600;
        font-size: 0.85rem;
        border: 1px solid #E5E7EB;
        padding: 12px 15px;
        background-color: #F9FAFB;
    }

    .btn-maroon {
        background: #800000;
        color: #fff;
        border-radius: 12px;
        font-weight: 700;
        font-size: 0.85rem;
        padding: 12px 24px;
        border: none;
        transition: all 0.2s ease;
    }
    .btn-maroon:hover { background: #600000; color: #fff; transform: translateY(-1px); }

    .export-section {
        background: #FDF2F2; /* Subtle maroon tint */
        border-radius: 16px;
        padding: 20px;
        border: 1px solid #F9EAEA;
    }

    /* 4. Chart Containers */
    .chart-box {
        background: #fff;
        border-radius: 24px;
        padding: 30px;
        border: 1px solid #E5E7EB;
        height: 100%;
    }
    .chart-title {
        font-weight: 800;
        font-size: 0.85rem;
        text-transform: uppercase;
        color: #111827;
        letter-spacing: 0.05em;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .text-maroon { color: #800000; }
</style>

<div class="container">
    {{-- Header --}}
    <div class="premium-header-rounded">
        <div class="aura-glow"></div>
        <div class="row align-items-center position-relative">
            <div class="col-md-8">
                <h1 class="fw-bold text-dark mb-1" style="font-size: 1.75rem; letter-spacing: -0.02em;">Reports <span class="text-maroon">& Analytics</span></h1>
                <p class="text-muted small mb-0">Monitor application trends and generate official reports.</p>
            </div>
        </div>
    </div>

    {{-- Combined Action Center --}}
    <div class="action-container">
        <div class="mb-4">
            <div class="stat-label mb-3 text-dark">Step 1: Filter Report Data</div>
            <form method="GET" id="filterForm" class="row g-3 align-items-end">
                <div class="col-md-5">
                    <select name="event" id="eventSelect" class="form-select form-select-custom shadow-none">
                        <option value="">All Events</option>
                        @foreach($events as $event)
                            <option value="{{ $event->EventID }}" @selected(request('event') == $event->EventID)>
                                {{ $event->EventName }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-5">
                    <select name="game" id="gameSelect" class="form-select form-select-custom shadow-none">
                        <option value="">All Games</option>
                        @foreach($games as $game)
                            <option value="{{ $game->GameID }}" data-event-id="{{ $game->EventID }}" @selected(request('game') == $game->GameID) class="game-option">
                                {{ $game->GameName }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-dark w-100 rounded-3 shadow-none fw-bold py-2" style="font-size: 0.8rem;">
                        UPDATE VIEW
                    </button>
                </div>
            </form>
        </div>

        <div class="export-section">
            <div class="stat-label mb-3 text-maroon"><i class="bi bi-download me-2"></i>Step 2: Generate Types of Reports</div>
            <div class="row g-3 align-items-center">
                <div class="col-md-8">
                    <select id="exportType" class="form-select form-select-custom shadow-none border-maroon border-opacity-25">
                        <option value="" disabled selected>-- Choose Report Type --</option>
                        <option value="{{ route('admin.reports.export.applicants.csv', request()->query()) }}">Full List of Applicants (CSV)</option>
                        <option value="{{ route('admin.reports.export.selected.csv', request()->query()) }}">Selected Athletes List (CSV)</option>
                        <option value="{{ route('admin.reports.export.selected.pdf', request()->query()) }}">Final Selection Roster (Official PDF)</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <button type="button" id="generateBtn" class="btn btn-maroon w-100 shadow-sm d-flex align-items-center justify-content-center gap-2">
                        <span>GENERATE REPORT</span>
                        <i class="bi bi-arrow-right-short h5 mb-0"></i>
                    </button>
                </div>
            </div>
            <p class="text-muted mb-0 mt-3" style="font-size: 0.7rem;">
                <i class="bi bi-info-circle me-1"></i> Reports will respect the filters applied in Step 1.
            </p>
        </div>
    </div>

    {{-- Summary Cards --}}
    <div class="row g-4 mb-5">
        <div class="col-6 col-md-3">
            <div class="stat-card">
                <p class="stat-label">Total Volume</p>
                <p class="stat-value">{{ $totalApplications }}</p>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card border-success border-opacity-25">
                <p class="stat-label text-success">Approved</p>
                <p class="stat-value text-success">{{ $approvedApplications }}</p>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card border-danger border-opacity-25">
                <p class="stat-label text-danger">Rejected</p>
                <p class="stat-value text-danger">{{ $rejectedApplications }}</p>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card border-primary border-opacity-25">
                <p class="stat-label text-maroon">Selected</p>
                <p class="stat-value text-maroon">{{ $selectedAthletes }}</p>
            </div>
        </div>
    </div>

    {{-- Charts --}}
    <div class="row g-4 pb-5">
        <div class="col-lg-7">
            <div class="chart-box shadow-sm">
                <h3 class="chart-title"><i class="bi bi-bar-chart-fill text-maroon"></i> Applications by Event</h3>
                <canvas id="applicationsByEventChart"></canvas>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="chart-box shadow-sm">
                <h3 class="chart-title"><i class="bi bi-pie-chart-fill text-maroon"></i> Selection Report</h3>
                <div class="px-4">
                    <canvas id="selectionOutcomeChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Scripts --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // 1. Dependent Dropdown Logic
        const eventSelect = document.getElementById('eventSelect');
        const gameSelect = document.getElementById('gameSelect');
        const gameOptions = gameSelect.querySelectorAll('.game-option');

        function filterGames() {
            const selectedEventId = eventSelect.value;
            gameOptions.forEach(option => {
                const gameEventId = option.getAttribute('data-event-id');
                if (selectedEventId === "" || gameEventId === selectedEventId) {
                    option.style.display = 'block';
                    option.disabled = false;
                } else {
                    option.style.display = 'none';
                    option.disabled = true;
                    if (option.selected) gameSelect.value = "";
                }
            });
        }
        eventSelect.addEventListener('change', filterGames);
        filterGames();

        // 2. Export Button Logic
        const generateBtn = document.getElementById('generateBtn');
        const exportType = document.getElementById('exportType');

        generateBtn.addEventListener('click', function() {
            const url = exportType.value;
            if (url) {
                window.location.href = url;
            } else {
                alert('Please select a report type first.');
            }
        });

        // 3. Charts
        new Chart(document.getElementById('applicationsByEventChart'), {
            type: 'bar',
            data: {
                labels: {!! json_encode($applicationsByEvent->pluck('event.EventName')) !!},
                datasets: [{
                    label: 'Applications',
                    data: {!! json_encode($applicationsByEvent->pluck('total')) !!},
                    backgroundColor: '#800000',
                    borderRadius: 6
                }]
            },
            options: { responsive: true, plugins: { legend: { display: false } } }
        });

        new Chart(document.getElementById('selectionOutcomeChart'), {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($selectionStats->pluck('SelectionStatus')) !!},
                datasets: [{
                    data: {!! json_encode($selectionStats->pluck('total')) !!},
                    backgroundColor: ['#10B981', '#EF4444', '#F59E0B'],
                    borderWidth: 0
                }]
            },
            options: { responsive: true, cutout: '75%', plugins: { legend: { position: 'bottom' } } }
        });
    });
</script>
@endsection