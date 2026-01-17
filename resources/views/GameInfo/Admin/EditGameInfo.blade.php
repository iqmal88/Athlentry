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

    /* 1. Header Styling (Matched to Show Page) */
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

    /* 3. Input Styling */
    .meta-label {
        font-size: 0.65rem;
        font-weight: 800;
        color: #9CA3AF;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        margin-bottom: 8px;
        display: block;
    }

    .form-control-island, .form-select-island {
        background-color: #F9FAFB;
        border: 1px solid #F3F4F6;
        border-radius: 12px;
        padding: 12px 16px;
        font-weight: 600;
        font-size: 0.9rem;
        transition: 0.2s;
    }

    .form-control-island:focus, .form-select-island:focus {
        background-color: #fff;
        border-color: #800000;
        box-shadow: 0 0 0 4px rgba(128, 0, 0, 0.05);
        outline: none;
    }

    /* 4. Action Buttons */
    .btn-maroon-pill {
        background: #800000;
        color: #fff !important;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.85rem;
        padding: 14px 32px;
        border: none;
        transition: 0.3s;
        width: 100%;
    }
    .btn-maroon-pill:hover { background: #600000; transform: translateY(-1px); }

    .btn-back-circle {
        width: 40px; height: 40px; 
        background: #fff; 
        border: 1px solid #E5E7EB; 
        border-radius: 50%; 
        display: flex; 
        align-items: center; 
        justify-content: center;
        color: #1A1C1E;
        text-decoration: none;
        transition: 0.2s;
    }
    .btn-back-circle:hover { background: #800000; color: #fff; border-color: #800000; }
    
    .text-maroon { color: #800000 !important; }
</style>

<div class="container py-4">

    {{-- HEADER ISLAND --}}
    <div class="premium-header-rounded">
        <div class="aura-glow"></div>
        <div class="row align-items-center position-relative">
            <div class="col-md-7">
                <div class="d-flex align-items-center gap-3">
                    <a href="{{ route('admin.gameinfo.show', $game->GameID) }}" class="btn-back-circle shadow-sm">
                        <i class="bi bi-arrow-left"></i>
                    </a>
                    <div>
                        <h1 class="fw-bold mb-0" style="font-size: 1.75rem; letter-spacing: -0.02em;">
                            Edit <span class="text-maroon">Game</span>
                        </h1>
                        <p class="text-muted small mb-0 uppercase fw-bold tracking-wider" style="font-size: 0.65rem;">Registry Control Hub / ID #{{ $game->GameID }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ALERTS --}}
    @if($errors->any())
        <div class="alert alert-danger border-0 rounded-4 shadow-sm mb-4 p-4">
            <ul class="mb-0 fw-bold small">
                @foreach($errors->all() as $err) <li>{{ $err }}</li> @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.gameinfo.update', $game->GameID) }}" method="POST">
        @csrf
        <div class="row g-4">
            
            {{-- LEFT COLUMN: Identity & Content --}}
            <div class="col-lg-8">
                
                {{-- IDENTITY CARD --}}
                <div class="detail-island">
                    <span class="meta-label text-maroon mb-4">Core Identity</span>
                    
                    <div class="row g-4">
                        <div class="col-12">
                            <label class="meta-label">Game Title</label>
                            <input type="text" name="GameName" required class="form-control form-control-island" 
                                   value="{{ old('GameName', $game->GameName) }}" placeholder="e.g. Badminton Singles">
                        </div>

                        <div class="col-md-6">
                            <label class="meta-label">Category</label>
                            <select name="Category" class="form-select form-select-island">
                                @foreach(['Male','Female','Mixed','Open'] as $cat)
                                    <option value="{{ $cat }}" {{ old('Category', $game->Category) === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="meta-label">Max Capacity</label>
                            <input type="number" name="Capacity" min="0" class="form-control form-control-island" 
                                   value="{{ old('Capacity', $game->Capacity) }}" placeholder="Total Participants">
                        </div>
                    </div>
                </div>

                {{-- DOCUMENTATION CARD --}}
                <div class="detail-island">
                    <span class="meta-label text-maroon mb-4">Documentation</span>
                    
                    <div class="mb-4">
                        <label class="meta-label">About the Game</label>
                        <textarea name="Description" rows="4" class="form-control form-control-island" 
                                  placeholder="Briefly describe the game proceedings...">{{ old('Description', $game->Description) }}</textarea>
                    </div>

                    <div>
                        <label class="meta-label">Rules & Regulations (One per line)</label>
                        <textarea name="Rules" rows="6" class="form-control form-control-island" 
                                  placeholder="1. Regulation One&#10;2. Regulation Two...">{{ old('Rules', $game->Rules) }}</textarea>
                    </div>
                </div>
            </div>

            {{-- RIGHT COLUMN: Logistics & Status --}}
            <div class="col-lg-4">
                
                {{-- STATUS BENTO --}}
                <div class="bento-dark shadow-xl mb-4">
                    <span class="meta-label text-secondary mb-4">Publishing Status</span>
                    <select name="Status" class="form-select form-select-island bg-white text-dark border-0">
                        @foreach(['Open','Closed','Cancelled'] as $st)
                            <option value="{{ $st }}" {{ old('Status', $game->Status) === $st ? 'selected' : '' }}>{{ strtoupper($st) }}</option>
                        @endforeach
                    </select>
                    <p class="small text-muted mt-3 mb-0 opacity-75">Status updates reflect immediately in the athlete portal.</p>
                </div>

                {{-- LOGISTICS ISLAND --}}
                <div class="detail-island">
                    <span class="meta-label text-maroon mb-4">Logistics & Timing</span>
                    
                    <div class="mb-4">
                        <label class="meta-label">Game Venue</label>
                        <input type="text" name="GameVenue" class="form-control form-control-island" 
                               value="{{ old('GameVenue', $game->GameVenue) }}" placeholder="e.g. Sports Hall A">
                    </div>

                    <div class="mb-4">
                        <label class="meta-label">Competition Date</label>
                        <input type="date" name="GameDate" class="form-control form-control-island" 
                               value="{{ old('GameDate', $game->GameDate?->format('Y-m-d')) }}">
                    </div>

                    <div class="row g-2">
                        <div class="col-6">
                            <label class="meta-label">Start Time</label>
                            <input type="time" name="TimeStart" class="form-control form-control-island" 
                                   value="{{ old('TimeStart', substr($game->TimeStart, 0, 5)) }}">
                        </div>
                        <div class="col-6">
                            <label class="meta-label">End Time</label>
                            <input type="time" name="TimeEnd" class="form-control form-control-island" 
                                   value="{{ old('TimeEnd', substr($game->TimeEnd, 0, 5)) }}">
                        </div>
                    </div>
                </div>

                {{-- PERSONNEL ISLAND (REDESIGNED PIC SECTION) --}}
                <div class="detail-island">
                    <div class="d-flex align-items-center gap-2 mb-4">
                        <i class="bi bi-people-fill text-maroon"></i>
                        <span class="meta-label mb-0 text-maroon">Personnel & Staffing</span>
                    </div>
                    
                    <div class="mb-4 p-3 rounded-4 bg-light border border-white shadow-sm">
                        <div class="mb-3">
                            <label class="meta-label" style="font-size: 0.6rem;">Person In-Charge Name</label>
                            <input type="text" name="PICName" class="form-control form-control-island bg-white shadow-sm" 
                                   value="{{ old('PICName', $game->PICName) }}" placeholder="Full Name">
                        </div>

                        <div class="mb-0">
                            <label class="meta-label" style="font-size: 0.6rem;">PIC Contact Number</label>
                            <input type="text" name="PICPhone" class="form-control form-control-island bg-white shadow-sm" 
                                   value="{{ old('PICPhone', $game->PICPhone) }}" placeholder="+60...">
                        </div>
                    </div>

                    <div class="row g-3 pt-2">
                        <div class="col-6">
                            <span class="meta-label" style="font-size: 0.55rem;">Specification</span>
                            <p class="fw-bold text-dark small mb-0">{{ $game->Category }}</p>
                        </div>
                        <div class="col-6 border-start">
                            <span class="meta-label" style="font-size: 0.55rem;">Current Cap</span>
                            <p class="fw-bold text-dark small mb-0">{{ $game->Capacity }} Pax</p>
                        </div>
                    </div>
                </div>

                {{-- FINAL ACTIONS --}}
                <div class="mt-4">
                    <button type="submit" class="btn-maroon-pill shadow-lg mb-3">
                        <i class="bi bi-cloud-arrow-up-fill me-2"></i> Commit Changes
                    </button>
                    <a href="{{ route('admin.gameinfo.show', $game->GameID) }}" class="btn btn-link w-100 text-muted fw-bold text-decoration-none small">
                        Discard Edits
                    </a>
                </div>

            </div>
        </div>
    </form>
</div>
@endsection