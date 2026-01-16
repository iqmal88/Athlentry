@extends('layouts.admin')

@section('title', 'Add Announcement')

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
        padding: 32px 40px;
        margin-bottom: 24px;
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

    /* 2. Form Island - Matches Header Width */
    .form-island-card {
        background: #fff;
        border-radius: 24px;
        border: 1px solid #E5E7EB;
        padding: 40px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        margin-bottom: 50px;
    }

    .form-label-custom {
        font-size: 0.7rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #800000;
        margin-bottom: 10px;
        display: block;
    }

    .input-custom {
        border-radius: 12px;
        padding: 14px 18px;
        border: 1px solid #E5E7EB;
        background-color: #F9FAFB;
        font-weight: 500;
        font-size: 0.95rem;
        transition: all 0.2s;
    }

    .input-custom:focus {
        background-color: #fff;
        border-color: #800000;
        box-shadow: 0 0 0 4px rgba(128, 0, 0, 0.05);
        outline: none;
    }

    /* 3. Media Upload Area */
    .dropzone-area {
        border: 2px dashed #E5E7EB;
        border-radius: 20px;
        background: #F9FAFB;
        padding: 30px;
        text-align: center;
        cursor: pointer;
        transition: 0.3s;
        min-height: 200px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .dropzone-area:hover {
        border-color: #800000;
        background: #fff;
    }

    /* 4. Buttons */
    .btn-maroon-pill {
        background: #800000;
        color: #fff !important;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.85rem;
        padding: 14px 36px;
        border: none;
        transition: all 0.3s ease;
    }

    .btn-maroon-pill:hover {
        background: #600000;
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(128, 0, 0, 0.15);
    }
</style>

<div class="container pb-5">
    <div class="premium-header-rounded">
        <div class="aura-glow"></div>
        <div class="row align-items-center position-relative">
            <div class="col-md-7">
                <div class="d-flex align-items-center gap-3">
                    <a href="{{ route('admin.announcements.index') }}" class="btn btn-outline-secondary btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                        <i class="bi bi-arrow-left"></i>
                    </a>
                    <div>
                        <h1 class="fw-bold text-dark mb-0" style="font-size: 1.75rem; letter-spacing: -0.02em;">Publish <span style="color: #800000;">Announcement</span></h1>
                        <p class="text-muted small mb-0">Fill in the parameters for the new broadcast.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-5 text-md-end d-none d-md-block">
                <span class="badge bg-light text-muted border px-3 py-2 fw-bold" style="font-size: 0.6rem; letter-spacing: 0.1em;">BROADCAST STUDIO</span>
            </div>
        </div>
    </div>

    <div class="form-island-card">
        <form action="{{ route('admin.announcements.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="row g-5">
                <div class="col-lg-7">
                    <div class="mb-4">
                        <label class="form-label-custom">Headline Title</label>
                        <input type="text" name="Title" class="form-control input-custom" required value="{{ old('Title') }}" placeholder="e.g. Annual Sport Fest Registration">
                    </div>

                    <div class="mb-0">
                        <label class="form-label-custom">Description</label>
                        <textarea name="Description" rows="12" class="form-control input-custom" required placeholder="Write the complete announcement details here...">{{ old('Description') }}</textarea>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="row g-4">
                        <div class="col-12">
                            <label class="form-label-custom">Close Date</label>
                            <input type="date" name="DateClose" class="form-control input-custom" required value="{{ old('DateClose') }}">
                        </div>

                        <div class="col-12">
                            <label class="form-label-custom">Close Time</label>
                            <input type="time" name="TimeClose" class="form-control input-custom" value="{{ old('TimeClose') }}">
                        </div>
                        <div class="col-12">
    <label class="form-label-custom">Location</label>
    <input type="text"
           name="Location"
           class="form-control input-custom"
           placeholder="e.g. UMP Sports Complex"
           value="{{ old('Location') }}">
</div>


                        <div class="col-12">
                            <label class="form-label-custom">Thumbnail Poster</label>
                            <div class="dropzone-area" onclick="document.getElementById('Image').click()">
                                <input type="file" name="Image" id="Image" class="d-none" accept="image/*">
                                <div id="image-preview-container">
                                    <i class="bi bi-cloud-arrow-up-fill text-gray-300 display-6"></i>
                                    <p class="text-muted small mt-3 mb-0" id="file-name-text">Click to upload JPG/PNG (Max 2MB)</p>
                                </div>
                                <img id="image-preview" src="#" class="d-none img-fluid rounded-3 shadow-sm" style="max-height: 180px; object-fit: cover;">
                            </div>
                            @error('Image')
                                <div class="text-danger small mt-2 fw-bold">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="col-12 text-end pt-5 border-top mt-5">
                    <a href="{{ route('admin.announcements.index') }}" class="btn btn-link text-muted text-decoration-none me-4 fw-bold small">Cancel Drafting</a>
                    <button type="submit" class="btn-maroon-pill">
                        <i class="bi bi-send-check-fill me-2"></i>Publish Broadcast
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    // Preview Image logic
    document.getElementById('Image').onchange = evt => {
        const [file] = document.getElementById('Image').files
        if (file) {
            document.getElementById('image-preview').src = URL.createObjectURL(file)
            document.getElementById('image-preview').classList.remove('d-none')
            document.getElementById('image-preview-container').classList.add('d-none')
            document.getElementById('file-name-text').innerText = file.name
        }
    }
</script>
@endsection