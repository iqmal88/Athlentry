@extends('layouts.admin')

@section('title', $announcement->Title)

@section('content')
@php
    $fallbackImage = 'https://images.unsplash.com/photo-1501281668745-f7f57925c3b4?q=80&w=2070&auto=format&fit=crop';
    $imgSrc = $announcement->Image ? asset('storage/' . $announcement->Image) : $fallbackImage;
    $dateHuman = $announcement->Date ? \Carbon\Carbon::parse($announcement->Date)->format('D, d M Y') : 'TBA';
    $timeRange = ($announcement->TimeFrom || $announcement->TimeUntil) 
        ? \Carbon\Carbon::parse($announcement->TimeFrom)->format('h:i A') . ' — ' . \Carbon\Carbon::parse($announcement->TimeUntil)->format('h:i A')
        : 'Time not set';
@endphp

<div class="min-h-screen bg-[#F8F9FA] pb-24 font-sans antialiased">
    
    {{-- 1. Hero Media Section --}}
    <div class="px-6 py-6">
        <div class="max-w-7xl mx-auto relative h-[400px] w-full overflow-hidden rounded-[3rem] shadow-sm border border-white">
            <img src="{{ $imgSrc }}" alt="{{ $announcement->Title }}" class="absolute inset-0 w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-black/20"></div>

            <div class="absolute top-8 left-8 right-8 flex items-center justify-between z-10">
                <a href="{{ route('admin.announcements.index') }}" class="group flex items-center gap-3 bg-white/10 backdrop-blur-md border border-white/20 px-5 py-2.5 rounded-full text-white text-xs font-black uppercase tracking-widest hover:bg-white hover:text-gray-900 transition-all">
                    <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                    Back to Hub
                </a>
                <div class="flex items-center gap-3">
                    <button id="open-edit-modal" class="bg-white px-6 py-2.5 rounded-full text-gray-900 text-xs font-black uppercase tracking-widest hover:bg-[#800000] hover:text-white transition-all shadow-xl">
                        Modify Entry
                    </button>
                    <form action="{{ route('admin.announcements.destroy', $announcement->AnnouncementID) }}" method="POST" onsubmit="return confirm('Delete this blast?');">
                        @csrf @method('DELETE')
                        <button class="p-2.5 bg-red-500/20 backdrop-blur-md border border-red-500/30 text-red-100 rounded-full hover:bg-red-600 transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </form>
                </div>
            </div>

            <div class="absolute bottom-12 left-12 right-12">
                <div class="inline-flex items-center gap-2 px-3 py-1 bg-[#800000] rounded-lg text-white text-[10px] font-black uppercase tracking-widest mb-6">
                    <span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span>
                    {{ $announcement->Category ?? 'Announcement' }}
                </div>
                <h1 class="text-4xl md:text-6xl font-black text-white tracking-tighter leading-none italic uppercase drop-shadow-lg leading-tight">
                    {{ $announcement->Title }}
                </h1>
            </div>
        </div>
    </div>

    {{-- 2. Content Layout --}}
    <div class="max-w-7xl mx-auto px-6 mt-4 animate-in fade-in slide-in-from-bottom-4 duration-700">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <div class="lg:col-span-8">
                <div class="bg-white rounded-[3rem] p-10 md:p-14 border border-gray-100 shadow-sm relative min-h-[400px]">
                    <div class="flex items-center gap-4 mb-12">
                        <h3 class="text-[10px] font-black text-[#800000] uppercase tracking-[0.3em]">Full Narrative</h3>
                        <div class="flex-1 h-px bg-gray-50"></div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ $announcement->visibility ?? 'Public' }} Access</p>
                    </div>

                    <div class="prose prose-xl max-w-none text-gray-600 leading-relaxed font-medium italic">
                        {!! nl2br(e($announcement->Description ?? 'No description provided.')) !!}
                    </div>
                </div>
            </div>

            <div class="lg:col-span-4 space-y-8">
                <div class="bg-gray-900 rounded-[2.5rem] p-10 text-white shadow-2xl relative overflow-hidden">
                    <h3 class="text-[10px] font-black text-gray-500 uppercase tracking-[0.3em] mb-12">Logistics Center</h3>
                    <div class="space-y-12 relative z-10">
                        <div class="flex gap-6">
                            <div class="w-12 h-12 rounded-2xl bg-white/5 flex items-center justify-center text-red-500"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg></div>
                            <div><p class="text-[9px] font-black text-gray-500 uppercase tracking-widest mb-1">Target Date</p><p class="text-xl font-bold tracking-tight text-white">{{ $dateHuman }}</p></div>
                        </div>
                        <div class="flex gap-6">
                            <div class="w-12 h-12 rounded-2xl bg-white/5 flex items-center justify-center text-red-500"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg></div>
                            <div><p class="text-[9px] font-black text-gray-500 uppercase tracking-widest mb-1">Venue</p><p class="text-xl font-bold tracking-tight text-white">{{ $announcement->Location ?? 'TBA' }}</p></div>
                        </div>
                        <div class="flex gap-6">
                            <div class="w-12 h-12 rounded-2xl bg-white/5 flex items-center justify-center text-red-500"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
                            <div><p class="text-[9px] font-black text-gray-500 uppercase tracking-widest mb-1">Schedule</p><p class="text-xl font-bold tracking-tight text-white">{{ $timeRange }}</p></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- MODAL: FULL CORRECTED EDIT FORM --}}
<div id="edit-modal" class="fixed inset-0 z-[100] hidden overflow-y-auto">
    <div class="min-h-screen px-4 flex items-center justify-center">
        <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" id="modal-overlay"></div>
        
        <div class="relative bg-white dark:bg-neutral-900 w-full max-w-4xl rounded-[3rem] overflow-hidden shadow-2xl animate-in zoom-in-95 duration-200">
            <div class="px-10 py-8 border-b border-gray-50 flex items-center justify-between">
                <div>
                    <h3 class="text-2xl font-black italic uppercase tracking-tighter text-gray-900">Modify <span class="text-[#800000]">Entry</span></h3>
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mt-1">Full parameter refinement</p>
                </div>
                <button id="close-edit-modal" class="p-3 hover:bg-gray-50 rounded-full transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <form action="{{ route('admin.announcements.update', $announcement->AnnouncementID) }}" method="POST" enctype="multipart/form-data" class="p-10 space-y-8">
                @csrf @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    {{-- Title --}}
                    <div class="md:col-span-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-[#800000] ml-1">Headline Title</label>
                        <input name="Title" value="{{ old('Title', $announcement->Title) }}" required class="mt-2 w-full rounded-2xl bg-gray-50 border-0 p-5 font-bold text-gray-900 focus:ring-2 focus:ring-[#800000]/20" />
                    </div>

                    {{-- Location --}}
                    <div>
                        <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1">Venue / Location</label>
                        <input name="Location" value="{{ old('Location', $announcement->Location) }}" class="mt-2 w-full rounded-2xl bg-gray-50 border-0 p-4 font-bold text-gray-900 focus:ring-2 focus:ring-[#800000]/20" />
                    </div>

                    {{-- Date --}}
                    <div>
                        <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1">Broadcast Date</label>
                        <input type="date" name="Date" value="{{ old('Date', optional($announcement->Date)->format('Y-m-d')) }}" class="mt-2 w-full rounded-2xl bg-gray-50 border-0 p-4 font-bold text-gray-900 focus:ring-2 focus:ring-[#800000]/20" />
                    </div>

                    {{-- Time From --}}
                    <div>
                        <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1">Time (From)</label>
                        <input type="time" name="TimeFrom" value="{{ old('TimeFrom', $announcement->TimeFrom ? \Carbon\Carbon::parse($announcement->TimeFrom)->format('H:i') : '') }}" class="mt-2 w-full rounded-2xl bg-gray-50 border-0 p-4 font-bold text-gray-900 focus:ring-2 focus:ring-[#800000]/20" />
                    </div>

                    {{-- Time Until --}}
                    <div>
                        <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1">Time (Until)</label>
                        <input type="time" name="TimeUntil" value="{{ old('TimeUntil', $announcement->TimeUntil ? \Carbon\Carbon::parse($announcement->TimeUntil)->format('H:i') : '') }}" class="mt-2 w-full rounded-2xl bg-gray-50 border-0 p-4 font-bold text-gray-900 focus:ring-2 focus:ring-[#800000]/20" />
                    </div>
                </div>

                {{-- Image Upload --}}
                <div>
                    <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1">Replace Media (Optional)</label>
                    <input type="file" name="Image" accept="image/*" class="mt-2 w-full text-xs text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:font-black file:uppercase file:bg-gray-100 file:text-gray-600 hover:file:bg-gray-200" />
                </div>

                {{-- Description --}}
                <div>
                    <label class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1">Narrative Body</label>
                    <textarea name="Description" rows="8" required class="mt-2 w-full rounded-3xl bg-gray-50 border-0 p-5 font-medium text-gray-700 focus:ring-2 focus:ring-[#800000]/20 leading-relaxed">{{ old('Description', $announcement->Description) }}</textarea>
                </div>

                <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-50">
                    <button type="button" id="cancel-edit" class="px-8 py-4 rounded-2xl text-gray-400 text-xs font-black uppercase tracking-widest hover:bg-gray-50">Discard</button>
                    <button type="submit" class="px-12 py-4 bg-[#800000] text-white rounded-2xl text-xs font-black uppercase tracking-widest shadow-lg shadow-red-900/20 hover:scale-105 active:scale-95 transition-all">Update Entry</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('edit-modal');
    const openBtn = document.getElementById('open-edit-modal');
    const closeBtn = document.getElementById('close-edit-modal');
    const cancelBtn = document.getElementById('cancel-edit');
    const overlay = document.getElementById('modal-overlay');

    function openModal() { modal.classList.remove('hidden'); document.body.style.overflow = 'hidden'; }
    function closeModal() { modal.classList.add('hidden'); document.body.style.overflow = ''; }

    openBtn?.addEventListener('click', openModal);
    [closeBtn, cancelBtn, overlay].forEach(el => el?.addEventListener('click', closeModal));
});
</script>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap');
    body { font-family: 'Plus Jakarta Sans', sans-serif; letter-spacing: -0.01em; }
</style>
@endsection