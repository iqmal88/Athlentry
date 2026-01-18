@extends('layouts.admin')

@section('title', $announcement->Title)

@section('content')
@php
    $fallbackImage = 'https://images.unsplash.com/photo-1501281668745-f7f57925c3b4?q=80&w=2070&auto=format&fit=crop';
    $imgSrc = $announcement->Image ? asset('storage/' . $announcement->Image) : $fallbackImage;

    $dateHuman = $announcement->DateClose
        ? \Carbon\Carbon::parse($announcement->DateClose)->format('D, d M Y')
        : 'TBA';

    $timeHuman = $announcement->TimeClose
        ? \Carbon\Carbon::parse($announcement->TimeClose)->format('h:i A')
        : 'Time not set';
@endphp

<style>
    .narrative-container {
        background: #ffffff;
        border-radius: 2.5rem;
        border: 1px solid #E5E7EB;
        padding: 3.5rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
    }
    .logistics-island {
        background: #111827; /* Dark High Contrast */
        border-radius: 2.5rem;
        padding: 2.5rem;
        color: #ffffff;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    }
    .field-label-caps {
        font-size: 0.65rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.15em;
        color: #6B7280;
    }
</style>

<div class="min-h-screen bg-[#F8F9FA] pb-24 font-sans antialiased">

    {{-- 1. HERO SECTION (Consistent with List/Add Preview) --}}
    <div class="px-6 py-6">
        <div class="max-w-7xl mx-auto relative h-[450px] w-full overflow-hidden rounded-[3.5rem] shadow-sm border border-white bg-gray-900">
            <img src="{{ $imgSrc }}" alt="{{ $announcement->Title }}" class="absolute inset-0 w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent"></div>

            {{-- Toolbar Actions --}}
            <div class="absolute top-10 left-10 right-10 flex items-center justify-between z-10">
                <a href="{{ route('admin.announcements.index') }}"
                   class="group flex items-center gap-3 bg-white/10 backdrop-blur-md border border-white/20 px-6 py-3 rounded-full text-white text-xs font-black uppercase tracking-widest hover:bg-white hover:text-gray-900 transition-all">
                    <i class="bi bi-arrow-left transition-transform group-hover:-translate-x-1"></i>
                    Back
                </a>
                <div class="flex items-center gap-3">
                    <button id="open-edit-modal"
                            class="bg-white px-8 py-3 rounded-full text-gray-900 text-xs font-black uppercase tracking-widest hover:bg-[#800000] hover:text-white transition-all shadow-xl">
                        EDIT ANNOUNCEMENT
                    </button>
                    <form action="{{ route('admin.announcements.destroy', $announcement->AnnouncementID) }}"
                          method="POST"
                          onsubmit="return confirm('Delete this broadcast permanently?');">
                        @csrf @method('DELETE')
                        <button class="p-3 bg-red-500/20 backdrop-blur-md border border-red-500/30 text-white rounded-full hover:bg-red-600 transition-all">
                            <i class="bi bi-trash3-fill"></i>
                        </button>
                    </form>
                </div>
            </div>

            {{-- Title Banner --}}
            <div class="absolute bottom-16 left-16 right-16">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-[#800000] rounded-lg text-white text-[10px] font-black uppercase tracking-widest mb-6">
                    <span class="w-2 h-2 rounded-full bg-white animate-pulse"></span>
                    {{ $announcement->Category ?? 'Announcement' }}
                </div>
                <h1 class="text-5xl md:text-7xl font-black text-white uppercase tracking-tighter leading-none drop-shadow-lg">
                    {{ $announcement->Title }}
                </h1>
            </div>
        </div>
    </div>

    {{-- 2. CONTENT GRID --}}
    <div class="max-w-7xl mx-auto px-6 mt-6">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">

            {{-- Narrative Body --}}
            <div class="lg:col-span-8">
                <div class="narrative-container">
                    <div class="flex items-center gap-4 mb-10">
                        <h3 class="field-label-caps text-[#800000]">Official Description</h3>
                        <div class="flex-1 h-px bg-gray-100"></div>
                    </div>

                    <div class="text-gray-600 text-lg font-medium leading-relaxed">
                        {!! nl2br(e($announcement->Description)) !!}
                    </div>
                </div>
            </div>

            {{-- Announcement Sidebar --}}
            <div class="lg:col-span-4 space-y-8">
                <div class="logistics-island relative overflow-hidden">
                    <div class="absolute -top-10 -right-10 w-40 h-40 bg-white/5 rounded-full blur-3xl"></div>
                    
                    <h3 class="field-label-caps mb-12 text-gray-400">Application Information</h3>

                    <div class="space-y-12">
                        <div class="flex items-center gap-6">
                            <div class="w-14 h-14 rounded-2xl bg-white/5 flex items-center justify-center text-red-500 border border-white/10">
                                <i class="bi bi-calendar-check h4 mb-0"></i>
                            </div>
                            <div>
                                <p class="field-label-caps mb-1">Application Close Date</p>
                                <p class="text-2xl font-bold tracking-tight">{{ $dateHuman }}</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-6">
                            <div class="w-14 h-14 rounded-2xl bg-white/5 flex items-center justify-center text-red-500 border border-white/10">
                                <i class="bi bi-clock h4 mb-0"></i>
                            </div>
                            <div>
                                <p class="field-label-caps mb-1">Application Close Time</p>
                                <p class="text-2xl font-bold tracking-tight">{{ $timeHuman }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- 3. EDIT MODAL (RE-DESIGNED) --}}
<div id="edit-modal" class="hidden fixed inset-0 z-[100] flex items-center justify-center p-6">
    <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-md transition-opacity" id="modal-overlay"></div>
    
    <div class="relative bg-white w-full max-w-2xl rounded-[3rem] shadow-2xl overflow-hidden animate-in zoom-in-95 duration-200">
        <div class="px-10 py-8 border-b border-gray-100 flex items-center justify-between">
            <div>
                <h3 class="text-xl font-black uppercase tracking-tight text-gray-900">Modify <span class="text-[#800000]">Entry</span></h3>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-1">Update broadcast parameters</p>
            </div>
            <button onclick="closeModal()" class="text-gray-400 hover:text-gray-900 transition-colors">
                <i class="bi bi-x-lg h4"></i>
            </button>
        </div>

        <form action="{{ route('admin.announcements.update', $announcement->AnnouncementID) }}"
              method="POST"
              enctype="multipart/form-data"
              class="p-10 space-y-6">
            @csrf @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="field-label-caps mb-2 block">Headline Title</label>
                    <input name="Title" value="{{ $announcement->Title }}" required class="w-full p-4 rounded-2xl bg-gray-50 border-0 focus:ring-2 focus:ring-[#800000]/20 font-bold text-gray-900">
                </div>

                <div>
                    <label class="field-label-caps mb-2 block">Application Close Date</label>
                    <input type="date" name="DateClose" value="{{ \Carbon\Carbon::parse($announcement->DateClose)->format('Y-m-d') }}" class="w-full p-4 rounded-2xl bg-gray-50 border-0 focus:ring-2 focus:ring-[#800000]/20 font-bold">
                </div>

                <div>
                    <label class="field-label-caps mb-2 block">Application Close Time</label>
                    <input type="time" name="TimeClose" value="{{ \Carbon\Carbon::parse($announcement->TimeClose)->format('H:i') }}" class="w-full p-4 rounded-2xl bg-gray-50 border-0 focus:ring-2 focus:ring-[#800000]/20 font-bold">
                </div>

                <div class="md:col-span-2">
                    <label class="field-label-caps mb-2 block">Description</label>
                    <textarea name="Description" rows="5" class="w-full p-5 rounded-3xl bg-gray-50 border-0 focus:ring-2 focus:ring-[#800000]/20 font-medium text-gray-700">{{ $announcement->Description }}</textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="field-label-caps mb-2 block">Replace Thumbnail Poster (Optional)</label>
                    <input type="file" name="Image" accept="image/*" class="w-full text-xs text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-[#800000]/10 file:text-[#800000] font-black uppercase tracking-widest">
                </div>
            </div>

            <div class="flex justify-end gap-4 pt-6 border-t border-gray-100">
                <button type="button" onclick="closeModal()" class="px-8 py-3 text-xs font-black uppercase tracking-widest text-gray-400 hover:text-gray-900 transition-colors">Discard</button>
                <button type="submit" class="px-10 py-3 bg-[#800000] text-white rounded-2xl text-xs font-black uppercase tracking-widest shadow-xl shadow-red-900/30 hover:scale-105 transition-all">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<script>
    const modal = document.getElementById('edit-modal');
    const overlay = document.getElementById('modal-overlay');

    function openModal() {
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        modal.classList.add('hidden');
        document.body.style.overflow = '';
    }

    document.getElementById('open-edit-modal')?.addEventListener('click', openModal);
    overlay?.addEventListener('click', closeModal);
</script>
@endsection