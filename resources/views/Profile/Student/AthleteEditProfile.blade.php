@extends('layouts.app')

@section('title', 'Edit Athlete Profile')

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
        background: radial-gradient(circle, rgba(0, 128, 128, 0.05) 0%, rgba(255, 255, 255, 0) 70%);
        border-radius: 50%;
    }

    .form-block {
        background: #ffffff; border-radius: 20px; padding: 32px; margin-bottom: 30px;
        border: 1px solid #E5E7EB; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
    }

    .form-label-caps { font-size: 0.65rem; font-weight: 800; color: #9CA3AF; text-transform: uppercase; letter-spacing: 0.1em; margin-left: 4px; }
    .custom-input { border-radius: 12px; padding: 14px 18px; border: 2px solid #F3F4F6; background: #F9FAFB; font-weight: 600; transition: all 0.2s; }
    .custom-input:focus { border-color: rgba(0, 128, 128, 0.2); background: #fff; box-shadow: none; outline: none; }
    .text-teal { color: #008080 !important; }
</style>

<div class="container pb-5">
    <form method="POST" action="{{ route('student.profile.update') }}" enctype="multipart/form-data">
        @csrf

        {{-- Header Matched to Game Info --}}
        <div class="premium-header-rounded">
            <div class="aura-glow"></div>
            <div class="row align-items-center position-relative">
                <div class="col-md-7">
                    <h1 class="fw-bold mb-1" style="font-size:1.75rem;">
                        Edit <span class="text-teal">Profile</span>
                    </h1>
                    <p class="text-muted small mb-0">Update your Profile Information</p>
                </div>
                <div class="col-md-5 text-md-end mt-3 mt-md-0">
                    <a href="{{ route('student.profile.show') }}" class="btn btn-light fw-bold rounded-pill px-4 border shadow-sm small">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-dark fw-bold rounded-pill px-4 shadow-sm ms-2" style="background: #008080; border: none;">
                        Save Changes
                    </button>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success border-0 rounded-4 shadow-sm mb-4 fw-bold">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            </div>
        @endif

        <div class="row g-4">
            {{-- Left Column: Avatar --}}
            <div class="col-lg-4">
                <div class="form-block text-center">
                    <h6 class="form-label-caps mb-4">Profile Picture</h6>
                    <div class="mx-auto mb-4 border-4 border-white shadow-lg overflow-hidden" 
                         style="width: 140px; height: 140px; border-radius: 40px;">
                        <img src="{{ $user->ProfilePhoto ? asset('storage/' . $user->ProfilePhoto) : 'https://ui-avatars.com/api/?name='.urlencode($user->Name).'&background=008080&color=fff' }}" 
                             class="w-100 h-100 object-cover" id="previewImg" alt="Profile">
                    </div>
                    <input type="file" name="ProfilePhoto" class="form-control form-control-sm border-0 bg-light rounded-3" 
                           onchange="previewFile(this)" style="font-size: 0.7rem;">
                    <p class="mt-3 text-muted" style="font-size: 0.65rem;">Recommended: Square image, Max 2MB</p>
                </div>
            </div>

            {{-- Right Column: Form Fields --}}
            <div class="col-lg-8">
                <div class="form-block">
                    <h6 class="form-label-caps text-teal mb-4">Personal Details</h6>
                    
                    <div class="row g-3">
                        <div class="col-md-6 mb-3">
                            <label class="form-label-caps">Full Name (Locked)</label>
                            <input type="text" value="{{ $user->Name }}" readonly class="form-control custom-input opacity-75">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label-caps">Matric Number (Locked)</label>
                            <input type="text" value="{{ $user->MatricNo }}" readonly class="form-control custom-input opacity-75">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label-caps">Email Address</label>
                            <input type="email" name="Email" value="{{ old('Email', $user->Email) }}" required class="form-control custom-input">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label-caps">Phone Number</label>
                            <input type="text" name="PhoneNumber" value="{{ old('PhoneNumber', $user->PhoneNumber) }}" required class="form-control custom-input">
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label-caps">Sports Achievement</label>
                            <textarea name="Achievement" rows="3" class="form-control custom-input" placeholder="List your relevant sports experience...">{{ old('Achievement', $user->Achievement) }}</textarea>
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label-caps text-danger">Medical History</label>
                            <textarea name="MedicalHistory" rows="3" class="form-control custom-input" placeholder="Specify any allergies or previous injuries...">{{ old('MedicalHistory', $user->MedicalHistory) }}</textarea>
                        </div>
                    </div>

                    <h6 class="form-label-caps text-teal mt-4 mb-4">Password</h6>
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label-caps">New Password (Leave blank to keep current)</label>
                            <input name="Password" type="password" class="form-control custom-input" placeholder="••••••••">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    function previewFile(input) {
        var file = input.files[0];
        if(file) {
            var reader = new FileReader();
            reader.onload = function(){
                document.getElementById("previewImg").src = reader.result;
            }
            reader.readAsDataURL(file);
        }
    }
</script>
@endsection