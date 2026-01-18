@extends('layouts.admin')

@section('title', 'Edit Profile')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<style>
    body { background-color: #F2F4F7; font-family: 'Inter', sans-serif; color: #1A1C1E; }
    
    .premium-header-rounded {
        background: #fff; border-radius: 24px; padding: 24px 40px; margin-bottom: 30px;
        border: 1px solid #E5E7EB; position: relative; overflow: hidden;
        box-shadow: 0 4px 20px rgba(0,0,0,0.03);
    }

    .aura-glow {
        position: absolute; top: -100px; right: -30px; width: 350px; height: 350px;
        background: radial-gradient(circle, rgba(128,0,0,0.05) 0%, rgba(255,255,255,0) 70%);
        border-radius: 50%;
    }

    .info-block {
        background: #ffffff; border-radius: 16px; padding: 32px;
        border: 1px solid #E5E7EB; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
    }

    .form-label-caps { font-size: 0.65rem; font-weight: 800; color: #9CA3AF; text-transform: uppercase; letter-spacing: 0.1em; margin-left: 4px; }
    .custom-input { border-radius: 12px; padding: 14px 18px; border: 2px solid #F3F4F6; background: #F9FAFB; font-weight: 600; transition: all 0.2s; }
    .custom-input:focus { border-color: rgba(128, 0, 0, 0.2); background: #fff; box-shadow: none; outline: none; }
    .text-maroon { color: #800000 !important; }
</style>

<div class="container pb-5">
    <form action="{{ route('admin.profile.update') }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Header Matched to Game Info --}}
        <div class="premium-header-rounded">
            <div class="aura-glow"></div>
            <div class="row align-items-center position-relative">
                <div class="col-md-7">
                    <h1 class="fw-bold mb-1" style="font-size:1.75rem;">
                        Edit <span class="text-maroon">Profile</span>
                    </h1>
                    <p class="text-muted small mb-0">Update Administrative Credentials</p>
                </div>
                <div class="col-md-5 text-md-end mt-3 mt-md-0">
                    <a href="{{ route('admin.profile.view') }}" class="btn btn-light fw-bold rounded-pill px-4 border shadow-sm small">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-dark fw-bold rounded-pill px-4 shadow-sm ms-2" style="background: #800000; border: none;">
                        Save Changes
                    </button>
                </div>
            </div>
        </div>

        <div class="row g-4">
            {{-- Personal Identity --}}
            <div class="col-lg-8">
                <div class="info-block">
                    <h6 class="form-label-caps text-maroon mb-4">Admin Details</h6>
                    
                    <div class="row g-3">
                        <div class="col-12 mb-3">
                            <label class="form-label-caps">Full Name</label>
                            <input name="name" type="text" value="{{ old('name', $admin->Name) }}" required class="form-control custom-input">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label-caps">Email</label>
                            <input name="email" type="email" value="{{ old('email', $admin->Email) }}" required class="form-control custom-input">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label-caps">Contact Number</label>
                            <input name="phone" type="text" value="{{ old('phone', $admin->PhoneNumber) }}" class="form-control custom-input">
                        </div>
                    </div>

                    <h6 class="form-label-caps text-maroon mt-4 mb-4">Password</h6>
                    <div class="row g-3">
                        <div class="col-md-6 position-relative">
                            <label class="form-label-caps">New Password</label>
                            <input id="password" name="password" type="password" class="form-control custom-input">
                            <button type="button" onclick="togglePass('password')" class="btn border-0 position-absolute end-0 bottom-0 mb-2 me-2 text-muted"><i class="bi bi-eye"></i></button>
                        </div>
                        <div class="col-md-6 position-relative">
                            <label class="form-label-caps">Confirm Password</label>
                            <input id="password_confirmation" name="password_confirmation" type="password" class="form-control custom-input">
                            <button type="button" onclick="togglePass('password_confirmation')" class="btn border-0 position-absolute end-0 bottom-0 mb-2 me-2 text-muted"><i class="bi bi-eye"></i></button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sidebar Health --}}
            <div class="col-lg-4">
                <div class="info-block h-100" style="background: #111827;">
                    <label class="form-label-caps text-secondary">Account Health</label>
                    <div class="d-flex align-items-center gap-3 mt-4 text-white">
                        <div class="bg-success bg-opacity-20 text-success rounded-3 d-flex align-items-center justify-content-center shadow-sm" style="width: 48px; height: 48px;">
                            <i class="bi bi-shield-check h4 mb-0"></i>
                        </div>
                        <div>
                            <p class="fw-bold mb-0" style="font-size: 0.9rem;">Status: Secure</p>
                            <p class="text-secondary small mb-0">Active Administrator Session</p>
                        </div>
                    </div>
                    <div class="mt-5 border-top border-secondary border-opacity-20 pt-4">
                        <p class="text-secondary small italic mb-0">
                            * Updating your email address will require you to log back in using the new credentials.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    function togglePass(id) {
        const el = document.getElementById(id);
        el.type = el.type === 'password' ? 'text' : 'password';
    }
</script>
@endsection