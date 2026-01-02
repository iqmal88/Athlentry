@extends('layouts.admin')

@section('title', 'Admin Profile')

@section('content')
<div class="min-h-screen bg-[#F8F9FA] pb-24 font-sans antialiased">
    
    {{-- 1. Aesthetic Profile Header (Standard Studio Card) --}}
    <div class="relative px-6 py-6">        
        <div class="max-w-7xl mx-auto bg-white border border-gray-100 shadow-sm rounded-[2rem] px-10 py-8 flex flex-col md:flex-row items-center justify-between gap-8 relative overflow-hidden">
            {{-- Subtle Background Glow --}}
            <div class="absolute -top-24 -right-24 w-64 h-64 bg-[#800000]/5 rounded-full blur-3xl"></div>

            <div class="relative z-10 flex items-center gap-6">
                <a href="{{ route('admin.announcements.index') }}" class="group flex items-center justify-center w-12 h-12 bg-gray-50 rounded-2xl hover:bg-[#800000] hover:text-white transition-all duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <div class="h-10 w-px bg-gray-100 hidden md:block"></div>
                <div>
                    <h1 class="text-3xl font-black text-gray-900 tracking-tight leading-none uppercase italic">USER <span class="text-[#800000] not-italic">PROFILE</span></h1>
                    <p class="text-[10px] uppercase tracking-[0.3em] text-gray-400 font-bold mt-2">Administrative Identity Management</p>
                </div>
            </div>
            
            <div class="relative z-10">
                <a href="{{ route('admin.profile.edit') }}" class="px-8 py-4 bg-gray-900 text-white text-[10px] font-black uppercase tracking-widest rounded-[1.5rem] shadow-xl hover:bg-[#800000] hover:scale-105 transition-all flex items-center gap-3">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                    Edit Profile
                </a>
            </div>
        </div>
    </div>

    {{-- 2. Main Profile Content --}}
    <div class="max-w-7xl mx-auto px-6 mt-4 animate-in fade-in slide-in-from-bottom-4 duration-700">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            {{-- Left: Avatar & Quick Info Bento --}}
            <div class="lg:col-span-4 space-y-8">
                {{-- Profile Image Card --}}
                <div class="bg-white rounded-[2.5rem] p-10 border border-gray-100 shadow-sm text-center relative overflow-hidden group">
                    <div class="relative inline-block">
                        <div class="w-44 h-44 rounded-[3rem] bg-gray-50 border-4 border-white shadow-xl overflow-hidden flex items-center justify-center mx-auto transition-transform group-hover:scale-105 duration-500">
                            @if(!empty($admin->photo_url))
                                <img src="{{ $admin->photo_url }}" alt="avatar" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-6xl font-black text-[#800000] italic">
                                    {{ strtoupper(substr($admin->Name ?? Auth::user()->Name ?? 'A', 0, 1)) }}
                                </div>
                            @endif
                        </div>
                        {{-- Floating Camera Action --}}
                        <form action="{{ '#' }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="photo" accept="image/*" class="hidden" id="photo-input">
                            <button type="button" onclick="document.getElementById('photo-input').click()" 
                                    class="absolute -bottom-2 -right-2 w-12 h-12 bg-white rounded-2xl shadow-lg border border-gray-100 flex items-center justify-center text-gray-400 hover:text-[#800000] transition-all">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </button>
                            <button type="submit" class="hidden" id="photo-submit"></button>
                        </form>
                    </div>

                    <div class="mt-8">
                        <h2 class="text-2xl font-black text-gray-900 uppercase tracking-tight">{{ $admin->Name ?? 'Administrator' }}</h2>
                        <p class="text-[10px] font-black text-[#800000] uppercase tracking-[0.2em] mt-1 italic">Master Admin</p>
                    </div>

                    <div class="mt-8 pt-8 border-t border-gray-50 flex items-center justify-center gap-6">
                        <div class="text-center">
                            <p class="text-[10px] font-black text-gray-300 uppercase tracking-widest leading-none">Access</p>
                            <p class="text-sm font-bold text-gray-900 mt-1">Level 4</p>
                        </div>
                        <div class="w-px h-6 bg-gray-100"></div>
                        <div class="text-center">
                            <p class="text-[10px] font-black text-gray-300 uppercase tracking-widest leading-none">Security</p>
                            <p class="text-sm font-bold text-green-600 mt-1 flex items-center gap-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span> Encrypted
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Status Meta Tile --}}
                <div class="bg-gray-900 rounded-[2.5rem] p-8 text-white shadow-2xl relative overflow-hidden">
                    <div class="absolute -bottom-10 -right-10 p-8 opacity-10 rotate-12">
                        <svg class="w-32 h-32 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 4.946-2.567 9.29-6.433 11.771l-.167.106-.167-.106a11.97 11.97 0 01-6.433-11.77c0-.682.057-1.35.166-2.002zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path></svg>
                    </div>
                    <div class="relative z-10">
                        <p class="text-[9px] font-black text-gray-500 uppercase tracking-widest mb-1">Authenticated Since</p>
                        <p class="text-xl font-bold tracking-tight italic">{{ $admin->created_at->format('M d, Y') }}</p>
                    </div>
                </div>
            </div>

            {{-- Right: Information Grid Bento --}}
            <div class="lg:col-span-8 grid grid-cols-1 md:grid-cols-2 gap-8 items-start">
                
                {{-- Account Details Card --}}
                <div class="md:col-span-2 bg-white rounded-[3rem] p-10 md:p-14 border border-gray-100 shadow-sm relative overflow-hidden min-h-[450px]">
                    <div class="flex items-center gap-4 mb-14">
                        <h3 class="text-[10px] font-black text-[#800000] uppercase tracking-[0.3em]">Credential Matrix</h3>
                        <div class="flex-1 h-px bg-gray-50"></div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-y-12 gap-x-12">
                        {{-- Data Point: Name --}}
                        <div class="group">
                            <p class="text-[9px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3 leading-none">Full Name</p>
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-gray-50 flex items-center justify-center text-gray-400 group-hover:text-[#800000] transition-colors"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg></div>
                                <p class="text-lg font-bold text-gray-900 truncate">{{ $admin->Name ?? 'N/A' }}</p>
                            </div>
                        </div>

                        {{-- Data Point: Matric --}}
                        <div class="group">
                            <p class="text-[9px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3 leading-none">Matric Identifier</p>
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-gray-50 flex items-center justify-center text-gray-400 group-hover:text-[#800000] transition-colors"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 012-2h2a2 2 0 012 2v1m-4 0h4"/></svg></div>
                                <p class="text-lg font-bold text-gray-900 tracking-tight tabular-nums">{{ $admin->MatricNo ?? 'N/A' }}</p>
                            </div>
                        </div>

                        {{-- Data Point: Email --}}
                        <div class="group">
                            <p class="text-[9px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3 leading-none">Secure Email</p>
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-gray-50 flex items-center justify-center text-gray-400 group-hover:text-[#800000] transition-colors"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg></div>
                                <p class="text-lg font-bold text-gray-900 break-all">{{ $admin->Email ?? 'N/A' }}</p>
                            </div>
                        </div>

                        {{-- Data Point: Phone --}}
                        <div class="group">
                            <p class="text-[9px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3 leading-none">Contact Link</p>
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-gray-50 flex items-center justify-center text-gray-400 group-hover:text-[#800000] transition-colors"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg></div>
                                <p class="text-lg font-bold text-gray-900 tabular-nums">{{ $admin->phone ?? 'Not Linked' }}</p>
                            </div>
                        </div>

                        {{-- Data Point: Location --}}
                        <div class="md:col-span-2 group">
                            <p class="text-[9px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3 leading-none">Operating Node</p>
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-gray-50 flex items-center justify-center text-gray-400 group-hover:text-[#800000] transition-colors"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg></div>
                                <p class="text-lg font-bold text-gray-900 italic tracking-tight">{{ $admin->location ?? 'Global / Undefined' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Bio Bento Tile --}}
                <div class="md:col-span-2 bg-white rounded-[3rem] p-10 md:p-12 border border-gray-100 shadow-sm">
                    <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em] mb-8">Personnel Bio</h3>
                    <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100 italic font-medium text-gray-600 leading-relaxed">
                        "{{ $admin->bio ?? 'The administrator has not provided a professional biography yet.' }}"
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    (function(){
        const input = document.getElementById('photo-input');
        const submit = document.getElementById('photo-submit');
        if (input && submit) {
            input.addEventListener('change', function(){
                if (input.files && input.files.length) {
                    submit.click();
                }
            });
        }
    })();
</script>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap');
    body { font-family: 'Plus Jakarta Sans', sans-serif; letter-spacing: -0.01em; }
</style>
@endsection