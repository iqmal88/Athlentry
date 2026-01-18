@extends('layouts.admin')

@section('title', 'Edit Event')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<style>
    body {
        background-color: #F8F9FA;
        font-family: 'Inter', -apple-system, sans-serif;
        color: #1A1C1E;
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

    /* 2. Content Island Card */
    .form-island-card {
        background: #fff;
        border-radius: 24px;
        border: 1px solid #E5E7EB;
        padding: 40px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
        margin-bottom: 50px;
    }

    .form-label-studio {
        font-size: 0.7rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #800000;
        margin-bottom: 10px;
        display: block;
    }

    .input-studio {
        border-radius: 12px;
        padding: 12px 16px;
        border: 1px solid #E5E7EB;
        background-color: #F9FAFB;
        font-weight: 500;
        font-size: 0.95rem;
        transition: all 0.2s;
    }

    .input-studio:focus {
        background-color: #fff;
        border-color: #800000;
        box-shadow: 0 0 0 4px rgba(128, 0, 0, 0.05);
        outline: none;
    }

    /* Professional Status Dropdown */
    .status-dropdown {
        appearance: none;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='white' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 1rem center;
        background-size: 16px 12px;
        transition: all 0.3s ease;
    }
    .status-open { background-color: #059669 !important; color: white !important; }
    .status-closed { background-color: #4B5563 !important; color: white !important; }
    .status-cancelled { background-color: #DC2626 !important; color: white !important; }

    /* 3. Sport Item Card */
    .sport-item-card {
        background: #F9FAFB;
        border: 1px solid #F3F4F6;
        border-radius: 16px;
        padding: 24px;
        transition: all 0.3s ease;
        position: relative;
    }

    .sport-item-card:hover {
        background: #fff;
        border-color: #800000;
        box-shadow: 0 10px 20px rgba(0,0,0,0.05);
    }

    .btn-remove-game {
        position: absolute;
        top: 20px;
        right: 20px;
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: #fff;
        border: 1px solid #FEE2E2;
        color: #EF4444;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: 0.2s;
    }

    .btn-remove-game:hover {
        background: #EF4444;
        color: #fff;
        border-color: #EF4444;
    }

    /* 4. Action Buttons */
    .btn-maroon-pill {
        background: #800000;
        color: #fff !important;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.85rem;
        padding: 12px 36px;
        border: none;
        transition: all 0.3s ease;
    }

    .btn-maroon-pill:hover {
        background: #600000;
        transform: translateY(-2px);
    }

    .btn-discard {
        background: transparent;
        color: #9CA3AF !important;
        font-weight: 700;
        font-size: 0.85rem;
        padding: 12px 24px;
        border: none;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .btn-discard:hover {
        color: #1A1C1E !important;
        text-decoration: underline;
    }

    .btn-add-discipline {
        background: #111827;
        color: #fff;
        font-weight: 700;
        font-size: 0.7rem;
        padding: 8px 20px;
        border-radius: 10px;
        text-transform: uppercase;
        border: none;
    }
</style>

<div class="container pb-5">
    <form action="{{ route('admin.events.update', $event->EventID) }}" method="POST" id="eventEditForm">
        @csrf
        @method('PUT')

        {{-- HEADER ISLAND --}}
        <div class="premium-header-rounded">
            <div class="aura-glow"></div>
            <div class="row align-items-center position-relative">
                <div class="col-md-12">
                    <div class="d-flex align-items-center gap-3">
                        <a href="{{ route('admin.events.list') }}" class="btn btn-outline-secondary btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                            <i class="bi bi-arrow-left"></i>
                        </a>
                        <div>
                            <h1 class="fw-bold text-dark mb-0" style="font-size: 1.75rem; letter-spacing: -0.02em;">Edit <span style="color: #800000;">Event</span></h1>
                            <p class="text-muted small mb-0">Events: {{ $event->EventName }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- FORM BODY --}}
        <div class="form-island-card">
            @if ($errors->any())
                <div class="alert alert-danger rounded-4 border-0 mb-5">
                    <ul class="mb-0 small fw-bold">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="row g-5">
                
                {{-- Left: Primary Event Data --}}
                <div class="col-lg-7">
                    <div class="mb-4">
                        <label class="form-label-studio">Event Name</label>
                        <input name="EventName" value="{{ old('EventName',$event->EventName) }}" required class="form-control input-studio fw-bold">
                    </div>

                    <div class="mb-4">
                        <label class="form-label-studio">Location</label>
                        <input name="Location" value="{{ old('Location',$event->Location) }}" class="form-control input-studio">
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label-studio">Start Date</label>
                            <input type="date" name="StartDate" value="{{ optional($event->StartDate)->format('Y-m-d') }}" class="form-control input-studio">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-studio">End Date</label>
                            <input type="date" name="EndDate" value="{{ optional($event->EndDate)->format('Y-m-d') }}" class="form-control input-studio">
                        </div>
                    </div>

                    <div class="mb-5">
                        <label class="form-label-studio">Event Description</label>
                        <textarea name="Description" rows="4" class="form-control input-studio">{{ old('Description',$event->Description) }}</textarea>
                    </div>

                    {{-- Sports Disciplines List --}}
                    <div class="d-flex justify-content-between align-items-center mb-4 pt-4 border-top">
                        <h5 class="fw-bold mb-0">List Of <span class="text-muted">Games</span></h5>
                        <button type="button" id="addGameBtn" class="btn-add-discipline shadow-sm">
                            <i class="bi bi-plus-lg me-1"></i> Add Games
                        </button>
                    </div>

                    <div id="gamesContainer" class="row g-3">
                        @foreach($event->games as $i => $game)
                        <div class="col-12 game-row">
                            <div class="sport-item-card">
                                <input type="hidden" name="games[{{ $i }}][GameID]" value="{{ $game->GameID }}">
                                
                                <button type="button" class="btn-remove-game" onclick="removeGameRow(this)">
                                    <i class="bi bi-trash3"></i>
                                </button>

                                <div class="row g-3">
                                    <div class="col-md-8">
                                        <label class="text-[9px] fw-bold text-muted uppercase tracking-widest mb-1 d-block">Sport Name</label>
                                        <input name="games[{{ $i }}][GameName]" value="{{ $game->GameName }}" class="form-control input-studio py-2 fw-bold" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="text-[9px] fw-bold text-muted uppercase tracking-widest mb-1 d-block">Category</label>
                                        <select name="games[{{ $i }}][Category]" class="form-select input-studio py-2">
                                            @foreach(['Male','Female','Mixed','Open'] as $c)
                                                <option value="{{ $c }}" {{ $game->Category==$c?'selected':'' }}>{{ $c }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="text-[9px] fw-bold text-muted uppercase tracking-widest mb-1 d-block">Intake Limit</label>
                                        <input type="number" name="games[{{ $i }}][Capacity]" value="{{ $game->Capacity }}" class="form-control input-studio py-2">
                                    </div>
                                    <div class="col-md-8">
                                        <div class="row g-2">
                                            <div class="col-4">
                                                <label class="text-[9px] fw-bold text-muted mb-1">Date</label>
                                                <input type="date" name="games[{{ $i }}][GameDate]" value="{{ $game->GameDate?->format('Y-m-d') }}" class="form-control input-studio py-2" required>
                                            </div>
                                            <div class="col-4">
                                                <label class="text-[9px] fw-bold text-muted mb-1">Start</label>
                                                <input type="time" name="games[{{ $i }}][TimeStart]" value="{{ $game->TimeStart }}" class="form-control input-studio py-2" required>
                                            </div>
                                            <div class="col-4">
                                                <label class="text-[9px] fw-bold text-muted mb-1">End</label>
                                                <input type="time" name="games[{{ $i }}][TimeEnd]" value="{{ $game->TimeEnd }}" class="form-control input-studio py-2" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Right: Side Rules --}}
                <div class="col-lg-5">
                    <div class="p-4 rounded-4 shadow-sm" id="statusBox" style="background: #111827; transition: all 0.3s ease;">
                        <label class="form-label-studio text-gray-500">Event Status</label>
                        <select name="Status" id="statusSelect" class="form-select input-studio border-0 status-dropdown fw-black">
                            @foreach(['Open','Closed','Cancelled'] as $s)
                                <option value="{{ $s }}" {{ $event->Status==$s?'selected':'' }}>{{ strtoupper($s) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mt-4 p-4 border rounded-4 bg-light bg-opacity-50">
                        <label class="form-label-studio">Max Games Per Student</label>
                        <div class="d-flex align-items-center gap-3">
                            <i class="bi bi-shield-check text-maroon h4 mb-0"></i>
                            <input type="number" name="MaxGamesPerStudent" value="{{ old('MaxGamesPerStudent',$event->MaxGamesPerStudent) }}" class="form-control input-studio">
                        </div>
                    </div>
                </div>

                {{-- FORM ACTIONS (Inside the Island Card) --}}
                <div class="col-12 mt-5 pt-5 border-top d-flex justify-content-end align-items-center gap-3">
                    <a href="{{ route('admin.events.list') }}" class="btn-discard" onclick="return confirm('Discard all unsaved changes?')">
                        Discard Changes
                    </a>
                    <button type="submit" class="btn-maroon-pill shadow-lg">
                        <i class="bi bi-cloud-check-fill me-2"></i> Save Changes
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    // Status Dropdown Logic
    const statusSelect = document.getElementById('statusSelect');
    function updateStatusUI() {
        const val = statusSelect.value.toLowerCase();
        statusSelect.classList.remove('status-open', 'status-closed', 'status-cancelled');
        if (val === 'open') statusSelect.classList.add('status-open');
        else if (val === 'closed') statusSelect.classList.add('status-closed');
        else if (val === 'cancelled') statusSelect.classList.add('status-cancelled');
    }
    statusSelect.addEventListener('change', updateStatusUI);
    window.addEventListener('load', updateStatusUI);

    // Dynamic Rows Logic
    let idx = {{ $event->games->count() }};
    function removeGameRow(btn) {
        if(confirm('Are you sure you want to remove this discipline?')) {
            const row = btn.closest('.game-row');
            row.style.opacity = '0';
            row.style.transform = 'scale(0.95)';
            setTimeout(() => row.remove(), 300);
        }
    }

    document.getElementById('addGameBtn').onclick = () => {
        const c = document.getElementById('gamesContainer');
        const newRow = `
        <div class="col-12 mb-3 game-row animate-in fade-in slide-in-from-top-2">
            <div class="sport-item-card border-maroon" style="border-style: dashed;">
                <button type="button" class="btn-remove-game" onclick="removeGameRow(this)">
                    <i class="bi bi-x-lg"></i>
                </button>
                <div class="row g-3">
                    <div class="col-md-8"><label class="text-[9px] fw-bold text-muted uppercase tracking-widest mb-1 d-block">Sport Name</label><input name="games[${idx}][GameName]" class="form-control input-studio py-2 fw-bold" placeholder="New Sport Name"></div>
                    <div class="col-md-4"><label class="text-[9px] fw-bold text-muted uppercase tracking-widest mb-1 d-block">Category</label><select name="games[${idx}][Category]" class="form-select input-studio py-2"><option>Male</option><option>Female</option><option>Mixed</option><option selected>Open</option></select></div>
                    <div class="col-md-4"><label class="text-[9px] fw-bold text-muted uppercase tracking-widest mb-1 d-block">Intake Limit</label><input type="number" name="games[${idx}][Capacity]" class="form-control input-studio py-2" placeholder="Capacity"></div>
                    <div class="col-md-8"><div class="row g-2"><div class="col-4"><input type="date" name="games[${idx}][GameDate]" class="form-control input-studio py-2"></div><div class="col-4"><input type="time" name="games[${idx}][TimeStart]" class="form-control input-studio py-2"></div><div class="col-4"><input type="time" name="games[${idx}][TimeEnd]" class="form-control input-studio py-2"></div></div></div>
                </div>
            </div>
        </div>`;
        c.insertAdjacentHTML('afterbegin', newRow);
        idx++;
    };
</script>
@endsection