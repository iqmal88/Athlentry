@extends('layouts.admin')

@section('title', 'Admin Profile')

@section('content')
<div class="min-h-screen bg-[#F8F9FA] pb-24 font-sans antialiased">
    
    {{-- Header --}}
    <div class="relative px-6 py-6">        
        <div class="max-w-7xl mx-auto bg-white border border-gray-100 shadow-sm rounded-[2rem] px-10 py-8 flex flex-col md:flex-row items-center justify-between gap-8 relative overflow-hidden">
            <div class="absolute -top-24 -right-24 w-64 h-64 bg-[#800000]/5 rounded-full blur-3xl"></div>

            <div class="relative z-10 flex items-center gap-6">
                <a href="{{ route('admin.announcements.index') }}" class="group flex items-center justify-center w-12 h-12 bg-gray-50 rounded-2xl hover:bg-[#800000] hover:text-white transition-all duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" /></svg>
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

    <div class="max-w-7xl mx-auto px-6 mt-4">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            {{-- Left Bento --}}
            <div class="lg:col-span-4 space-y-8">
                <div class="bg-white rounded-[2.5rem] p-10 border border-gray-100 shadow-sm text-center relative overflow-hidden group">
                    <div class="w-44 h-44 rounded-[3rem] bg-gray-50 border-4 border-white shadow-xl overflow-hidden flex items-center justify-center mx-auto mb-6">
                        <div class="w-full h-full flex items-center justify-center text-6xl font-black text-[#800000] italic">
                            {{ strtoupper(substr($admin->Name, 0, 1)) }}
                        </div>
                    </div>
                    <h2 class="text-2xl font-black text-gray-900 uppercase tracking-tight">{{ $admin->Name }}</h2>
                    <p class="text-[10px] font-black text-[#800000] uppercase tracking-[0.2em] mt-1 italic">Master Admin</p>
                </div>

                <div class="bg-gray-900 rounded-[2.5rem] p-8 text-white shadow-2xl">
                    <p class="text-[9px] font-black text-gray-500 uppercase tracking-widest mb-1">Account Active Since</p>
                    <p class="text-xl font-bold tracking-tight italic">{{ $admin->created_at->format('M d, Y') }}</p>
                </div>
            </div>

            {{-- Right Bento --}}
            <div class="lg:col-span-8">
                <div class="bg-white rounded-[3rem] p-10 md:p-14 border border-gray-100 shadow-sm min-h-[450px]">
                    <div class="flex items-center gap-4 mb-14">
                        <h3 class="text-[10px] font-black text-[#800000] uppercase tracking-[0.3em]">Credential Matrix</h3>
                        <div class="flex-1 h-px bg-gray-50"></div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-y-12 gap-x-12">
                        <div>
                            <p class="text-[9px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3">Full Name</p>
                            <p class="text-lg font-bold text-gray-900">{{ $admin->Name }}</p>
                        </div>
                        <div>
                            <p class="text-[9px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3">Matric Identifier</p>
                            <p class="text-lg font-bold text-gray-900">{{ $admin->MatricNo }}</p>
                        </div>
                        <div>
                            <p class="text-[9px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3">Secure Email</p>
                            <p class="text-lg font-bold text-gray-900">{{ $admin->Email }}</p>
                        </div>
                        <div>
                            <p class="text-[9px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3">Contact Number</p>
                            <p class="text-lg font-bold text-gray-900">{{ $admin->PhoneNumber ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection