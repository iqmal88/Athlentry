@extends('layouts.admin')

@section('title', 'Add Announcement')

@section('content')
<div class="min-h-screen bg-[#F8F9FA] pb-24 font-sans antialiased">
    
    {{-- Aesthetic Header Card --}}
    <div class="relative px-6 py-6">        
        <div class="max-w-7xl mx-auto bg-white border border-gray-100 shadow-sm rounded-[2rem] px-10 py-8 flex flex-col md:flex-row items-center justify-between gap-8 relative overflow-hidden">
            <div class="absolute -top-24 -right-24 w-64 h-64 bg-[#800000]/5 rounded-full blur-3xl"></div>

            <div class="relative z-10 flex items-center gap-5">
                <a href="{{ route('admin.announcements.index') }}" class="group flex items-center justify-center w-12 h-12 bg-gray-50 rounded-2xl hover:bg-[#800000] hover:text-white transition-all duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <div class="h-10 w-px bg-gray-100 hidden md:block"></div>
                <div>
                    <h1 class="text-3xl font-[900] text-gray-900 tracking-tight leading-none uppercase italic">CREATE <span class="text-[#800000] not-italic">ANNOUNCEMENT</span></h1>
                    <p class="text-[10px] uppercase tracking-[0.3em] text-gray-400 font-bold mt-2">Broadcast a new update to the student body</p>
                </div>
            </div>

            <div class="relative z-10 hidden md:block">
                <div class="px-5 py-2 bg-gray-50 rounded-xl border border-gray-100 text-[10px] font-black text-gray-400 tracking-widest uppercase">
                    New Broadcast Entry
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 mt-6 animate-in fade-in slide-in-from-bottom-4 duration-700">
        
        {{-- Notification Alerts --}}
        @if(session('success'))
            <div class="mb-8 p-5 rounded-[1.5rem] bg-green-50 border border-green-100 text-green-700 text-sm font-bold flex items-center gap-3">
                <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-8 p-8 rounded-[2rem] bg-red-50 border border-red-100 text-red-800">
                <p class="text-xs font-black uppercase tracking-widest mb-4 text-red-400">Validation Errors Detected</p>
                <ul class="list-disc pl-5 space-y-1 text-sm font-bold">
                    @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.announcements.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
                
                {{-- Left Column: Image & Meta --}}
                <div class="space-y-8">
                    {{-- Media Bento --}}
                    <div class="bg-white rounded-[2.5rem] p-8 border border-gray-100 shadow-sm space-y-6">
                        <label class="text-[10px] font-black uppercase tracking-[0.3em] text-[#800000]">Hero Media</label>
                        
                        <div id="dropzone" class="group relative flex flex-col items-center justify-center aspect-video rounded-3xl border-2 border-dashed border-gray-100 bg-gray-50/50 hover:bg-white hover:border-[#800000]/30 transition-all cursor-pointer overflow-hidden">
                            <input id="Image" name="Image" type="file" accept="image/*" class="hidden" />
                            
                            <div id="dz-empty" class="text-center p-6 transition-all group-hover:scale-105">
                                <div class="w-12 h-12 bg-white rounded-2xl shadow-sm flex items-center justify-center mx-auto mb-4 border border-gray-50">
                                    <svg class="w-6 h-6 text-gray-400 group-hover:text-[#800000] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                                <p class="text-[11px] font-bold text-gray-500 uppercase tracking-widest leading-tight">Drag & Drop Image</p>
                                <p class="text-[9px] text-gray-400 mt-2 italic font-medium">Recommended: 1200x600px • Max 2MB</p>
                            </div>

                            <div id="dz-preview" class="hidden absolute inset-0 w-full h-full">
                                <img id="preview-img" src="#" alt="preview" class="w-full h-full object-cover" />
                                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center backdrop-blur-sm">
                                    <p class="text-white text-[10px] font-black uppercase tracking-widest border border-white/20 px-4 py-2 rounded-full">Change Media</p>
                                </div>
                            </div>
                        </div>
                        @error('Image') <p class="text-[10px] font-bold text-red-500 italic">{{ $message }}</p> @enderror
                    </div>

                    {{-- Settings Bento --}}
                    <div class="bg-gray-900 rounded-[2.5rem] p-10 text-white shadow-2xl shadow-gray-200">
                        <label class="text-[10px] font-black uppercase tracking-[0.3em] text-gray-500">Logistics & Privacy</label>
                        
                        <div class="mt-8 space-y-8">
                            <div>
                                <label class="text-[9px] font-black text-gray-500 uppercase tracking-widest mb-3 block">Category</label>
                                <select name="Category" class="w-full bg-white/5 border-0 rounded-xl p-4 text-sm font-bold focus:ring-2 focus:ring-[#800000] transition-all appearance-none">
                                    <option value="General" class="text-black">General Update</option>
                                    <option value="Event" class="text-black">Event Alert</option>
                                    <option value="Notice" class="text-black">Important Notice</option>
                                </select>
                            </div>

                            <div>
                                <label class="text-[9px] font-black text-gray-500 uppercase tracking-widest mb-4 block">Target Visibility</label>
                                <div class="flex p-1 bg-white/5 rounded-2xl">
                                    <label class="flex-1 text-center py-3 rounded-xl cursor-pointer has-[:checked]:bg-[#800000] has-[:checked]:text-white transition-all">
                                        <input type="radio" name="visibility" value="public" checked class="hidden">
                                        <span class="text-[10px] font-black uppercase tracking-widest">Public</span>
                                    </label>
                                    <label class="flex-1 text-center py-3 rounded-xl cursor-pointer has-[:checked]:bg-[#800000] has-[:checked]:text-white transition-all text-gray-500">
                                        <input type="radio" name="visibility" value="private" class="hidden">
                                        <span class="text-[10px] font-black uppercase tracking-widest">Private</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Right Column: Content Fields --}}
                <div class="lg:col-span-2 space-y-8">
                    <div class="bg-white rounded-[2.5rem] p-10 md:p-12 border border-gray-100 shadow-sm space-y-8 relative overflow-hidden">
                        <div class="absolute -top-24 -right-24 w-48 h-48 bg-[#800000]/5 rounded-full blur-3xl"></div>

                        {{-- Title --}}
                        <div class="relative z-10">
                            <label for="Title" class="text-[10px] font-black uppercase tracking-[0.3em] text-[#800000] ml-1">Announcement Title</label>
                            <input id="Title" name="Title" type="text" required value="{{ old('Title') }}"
                                   placeholder="What's this update about?"
                                   class="mt-3 w-full rounded-2xl bg-gray-50 border-2 border-transparent p-5 text-xl font-bold text-gray-900 focus:outline-none focus:border-[#800000]/20 focus:bg-white transition-all shadow-sm" />
                        </div>

                        {{-- Logistics Grid --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <label for="Location" class="text-[10px] font-black uppercase tracking-[0.3em] text-gray-400 ml-1">Event Location</label>
                                <input id="Location" name="Location" type="text" value="{{ old('Location') }}"
                                       placeholder="Venue or 'Online'"
                                       class="mt-2 w-full rounded-xl bg-gray-50 border-0 p-4 font-bold text-gray-800 focus:ring-2 focus:ring-[#800000]/20" />
                            </div>
                            <div>
                                <label for="Date" class="text-[10px] font-black uppercase tracking-[0.3em] text-gray-400 ml-1">Broadcast Date</label>
                                <input id="Date" name="Date" type="date" value="{{ old('Date') }}"
                                       class="mt-2 w-full rounded-xl bg-gray-50 border-0 p-4 font-bold text-gray-800 focus:ring-2 focus:ring-[#800000]/20" />
                            </div>
                        </div>

                        {{-- Time Grid --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <label for="TimeFrom" class="text-[10px] font-black uppercase tracking-[0.3em] text-gray-400 ml-1">Time (From)</label>
                                <input id="TimeFrom" name="TimeFrom" type="time" value="{{ old('TimeFrom') }}"
                                       class="mt-2 w-full rounded-xl bg-gray-50 border-0 p-4 font-bold text-gray-800 focus:ring-2 focus:ring-[#800000]/20" />
                            </div>
                            <div>
                                <label for="TimeUntil" class="text-[10px] font-black uppercase tracking-[0.3em] text-gray-400 ml-1">Time (Until)</label>
                                <input id="TimeUntil" name="TimeUntil" type="time" value="{{ old('TimeUntil') }}"
                                       class="mt-2 w-full rounded-xl bg-gray-50 border-0 p-4 font-bold text-gray-800 focus:ring-2 focus:ring-[#800000]/20" />
                            </div>
                        </div>

                        {{-- Description --}}
                        <div>
                            <label for="Description" class="text-[10px] font-black uppercase tracking-[0.3em] text-gray-400 ml-1">Full Narrative</label>
                            <textarea id="Description" name="Description" rows="10" 
                                      placeholder="Write the message details here..."
                                      class="mt-3 w-full rounded-3xl bg-gray-50 border-2 border-transparent p-6 font-semibold text-gray-700 focus:outline-none focus:border-[#800000]/20 focus:bg-white transition-all leading-relaxed shadow-sm">{{ old('Description') }}</textarea>
                        </div>

                        {{-- Final Actions --}}
                        <div class="pt-6 flex flex-col md:flex-row items-center justify-end gap-4 border-t border-gray-50">
                            <a href="{{ route('admin.announcements.index') }}" class="w-full md:w-auto px-10 py-4 bg-white text-gray-400 text-center rounded-[1.5rem] text-[10px] font-black uppercase tracking-widest border border-gray-100 hover:bg-gray-50 transition-all">
                                Discard Edit
                            </a>
                            <button type="submit" class="w-full md:w-auto px-12 py-4 bg-[#800000] text-white rounded-[1.5rem] font-black uppercase tracking-widest shadow-xl shadow-red-900/20 hover:scale-[1.02] active:scale-[0.98] transition-all flex items-center justify-center gap-3">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                Blast Update
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const dropzone = document.getElementById('dropzone');
    const fileInput = document.getElementById('Image');
    const dzEmpty = document.getElementById('dz-empty');
    const dzPreview = document.getElementById('dz-preview');
    const previewImg = document.getElementById('preview-img');

    function showPreview(src) {
        previewImg.src = src;
        dzEmpty.classList.add('hidden');
        dzPreview.classList.remove('hidden');
    }

    dropzone.addEventListener('click', () => fileInput.click());

    fileInput.addEventListener('change', () => {
        const file = fileInput.files && fileInput.files[0];
        if (!file) return;
        if (!file.type.startsWith('image/')) { alert('Please select an image file'); fileInput.value = ''; return; }

        const reader = new FileReader();
        reader.onload = (e) => showPreview(e.target.result);
        reader.readAsDataURL(file);
    });

    dropzone.addEventListener('dragover', (e) => { e.preventDefault(); dropzone.classList.add('border-[#800000]/30', 'bg-white'); });
    dropzone.addEventListener('dragleave', () => { dropzone.classList.remove('border-[#800000]/30', 'bg-white'); });
    dropzone.addEventListener('drop', (e) => {
        e.preventDefault(); 
        dropzone.classList.remove('border-[#800000]/30', 'bg-white');
        const dt = e.dataTransfer;
        const file = dt.files && dt.files[0];
        if (!file || !file.type.startsWith('image/')) return;
        fileInput.files = dt.files;
        const reader = new FileReader();
        reader.onload = (ev) => showPreview(ev.target.result);
        reader.readAsDataURL(file);
    });
});
</script>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap');
    body { font-family: 'Plus Jakarta Sans', sans-serif; }
    
    input[type="date"]::-webkit-calendar-picker-indicator,
    input[type="time"]::-webkit-calendar-picker-indicator {
        filter: invert(15%) sepia(95%) saturate(6932%) hue-rotate(358deg) brightness(95%) contrast(107%);
        cursor: pointer;
    }
</style>
@endsection