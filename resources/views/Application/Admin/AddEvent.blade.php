@extends('layouts.admin')

@section('title', 'Add Event')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<style>
    body {
        background-color: #F8F9FA;
        font-family: 'Inter', -apple-system, sans-serif;
        color: #1A1C1E;
    }

    .premium-header-rounded {
        background: #fff;
        border-radius: 24px;
        padding: 32px 40px;
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
        background-color: #fff; border-color: #800000; box-shadow: 0 0 0 4px rgba(128, 0, 0, 0.05); outline: none;
    }

    .status-dropdown {
        appearance: none;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='white' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 1rem center;
        background-size: 16px 12px;
    }
    .status-open { background-color: #059669 !important; color: white !important; }
    .status-closed { background-color: #4B5563 !important; color: white !important; }
    .status-cancelled { background-color: #DC2626 !important; color: white !important; }

    .sport-item-card {
        background: #F9FAFB;
        border: 1px solid #F3F4F6;
        border-radius: 16px;
        padding: 24px;
        transition: all 0.3s ease;
        position: relative;
    }

    .btn-remove-game {
        position: absolute; top: 20px; right: 20px; width: 32px; height: 32px; border-radius: 8px; background: #fff; border: 1px solid #FEE2E2; color: #EF4444; display: flex; align-items: center; justify-content: center;
    }

    .btn-maroon-pill {
        background: #800000; color: #fff !important; border-radius: 50px; font-weight: 700; font-size: 0.85rem; padding: 12px 36px; border: none; transition: all 0.3s ease;
    }

    .btn-discard {
        background: transparent; color: #9CA3AF !important; font-weight: 700; font-size: 0.85rem; padding: 12px 24px; text-decoration: none;
    }

    .btn-add-discipline {
        background: #111827; color: #fff; font-weight: 700; font-size: 0.7rem; padding: 8px 20px; border-radius: 10px; text-transform: uppercase; border: none;
    }
</style>

<div class="container pb-5">
    <form action="{{ route('admin.events.store') }}" method="POST" id="eventAddForm">
        @csrf

        <div class="premium-header-rounded">
            <div class="aura-glow"></div>
            <div class="row align-items-center position-relative">
                <div class="col-md-12">
                    <div class="d-flex align-items-center gap-3">
                        <a href="{{ route('admin.events.list') }}" class="btn btn-outline-secondary btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                            <i class="bi bi-arrow-left"></i>
                        </a>
                        <div>
                            <h1 class="fw-bold text-dark mb-0" style="font-size: 1.75rem; letter-spacing: -0.02em;">Create <span style="color: #800000;">Event</span></h1>
                            <p class="text-muted small mb-0">Create New Sport Event and Games To Recruit Athlete.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-island-card">
            <div class="row g-5">
                <div class="col-lg-7">
                    <div class="mb-4">
                        <label class="form-label-studio">Event Name</label>
                        <input name="EventName" value="{{ old('EventName') }}" required class="form-control input-studio fw-bold" placeholder="e.g. Kejohanan Sukan Antara Fakulti ">
                    </div>

                    <div class="mb-4">
                        <label class="form-label-studio">Primary Location</label>
                        <input name="Location" value="{{ old('Location') }}" class="form-control input-studio" placeholder="UMPSA Pekan">
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6"><label class="form-label-studio">Start Date</label><input type="date" name="StartDate" value="{{ old('StartDate') }}" class="form-control input-studio"></div>
                        <div class="col-md-6"><label class="form-label-studio">End Date</label><input type="date" name="EndDate" value="{{ old('EndDate') }}" class="form-control input-studio"></div>
                    </div>

                    <div class="mb-5"><label class="form-label-studio">Event Description</label><textarea name="Description" rows="4" class="form-control input-studio">{{ old('Description') }}</textarea></div>

                    <div class="d-flex justify-content-between align-items-center mb-4 pt-4 border-top">
                        <h5 class="fw-bold mb-0">List Of<span class="text-muted">Games</span></h5>
                        <button type="button" id="addGameBtn" class="btn-add-discipline shadow-sm"><i class="bi bi-plus-lg me-1"></i> Add Games</button>
                    </div>
                    <div id="gamesContainer" class="row g-3"></div>
                </div>

                <div class="col-lg-5">
                    <div class="p-4 rounded-4 shadow-sm" id="statusBox" style="background: #111827; transition: all 0.3s ease;">
                        <label class="form-label-studio text-gray-500">Event Status</label>
                        <select name="Status" id="statusSelect" class="form-select input-studio border-0 status-dropdown fw-black">
                            <option value="Open" selected>OPEN</option>
                            <option value="Closed">CLOSED</option>
                            <option value="Cancelled">CANCELLED</option>
                        </select>
                    </div>

                    <div class="mt-4 p-4 border rounded-4 bg-light bg-opacity-50">
                        <label class="form-label-studio">Max Games Per Student</label>
                        <div class="d-flex align-items-center gap-3">
                            <i class="bi bi-shield-check text-maroon h4 mb-0"></i>
                            <input type="number" name="MaxGamesPerStudent" value="{{ old('MaxGamesPerStudent') }}" class="form-control input-studio" placeholder="Unlimited">
                        </div>
                    </div>
                </div>

                <div class="col-12 mt-5 pt-5 border-top d-flex justify-content-end align-items-center gap-3">
                    <a href="{{ route('admin.events.list') }}" class="btn-discard">Cancel</a>
                    <button type="submit" class="btn-maroon-pill shadow-lg"><i class="bi bi-cloud-plus-fill me-2"></i> Add Event</button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
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

    let idx = 0;
    function removeGameRow(btn) {
        const row = btn.closest('.game-row');
        row.style.opacity = '0';
        setTimeout(() => row.remove(), 300);
    }

    document.getElementById('addGameBtn').onclick = () => {
        const c = document.getElementById('gamesContainer');
        const newRow = `<div class="col-12 mb-3 game-row animate-in fade-in slide-in-from-top-2">
            <div class="sport-item-card border-maroon" style="border-style: dashed;">
                <button type="button" class="btn-remove-game" onclick="removeGameRow(this)"><i class="bi bi-x-lg"></i></button>
                <div class="row g-3">
                    <div class="col-md-8"><label class="text-[9px] fw-bold text-muted uppercase tracking-widest mb-1 d-block">Game Name</label><input name="games[${idx}][GameName]" class="form-control input-studio py-2 fw-bold" placeholder="e.g. Football"></div>
                    <div class="col-md-4"><label class="text-[9px] fw-bold text-muted uppercase tracking-widest mb-1 d-block">Game Category</label><select name="games[${idx}][Category]" class="form-select input-studio py-2"><option>Male</option><option>Female</option><option>Mixed</option><option selected>Open</option></select></div>
                    <div class="col-md-4"><label class="text-[9px] fw-bold text-muted uppercase tracking-widest mb-1 d-block">Capacity</label><input type="number" name="games[${idx}][Capacity]" class="form-control input-studio py-2" placeholder="Capacity"></div>
                    <div class="col-md-8"><div class="row g-2"><div class="col-4"><label class="text-[9px] fw-bold text-muted">Game Date</label><input type="date" name="games[${idx}][GameDate]" class="form-control input-studio py-2"></div><div class="col-4"><label class="text-[9px] fw-bold text-muted">TIme Start</label><input type="time" name="games[${idx}][TimeStart]" class="form-control input-studio py-2"></div><div class="col-4"><label class="text-[9px] fw-bold text-muted">Time End</label><input type="time" name="games[${idx}][TimeEnd]" class="form-control input-studio py-2"></div></div></div>
                </div>
            </div>
        </div>`;
        c.insertAdjacentHTML('afterbegin', newRow);
        idx++;
    };
    window.onload = () => document.getElementById('addGameBtn').click();
</script>
@endsection