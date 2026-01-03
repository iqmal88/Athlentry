@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<div class="min-h-screen bg-[#F8FAFC] pb-24 font-sans antialiased">
    
    {{-- 1. PROFILE HEADER --}}
    <div class="relative px-6 py-6">        
        <div class="max-w-7xl mx-auto bg-white border border-slate-100 shadow-sm
                    rounded-[2.5rem] px-10 py-8 flex flex-col md:flex-row
                    items-center justify-between gap-8 relative overflow-hidden">

            {{-- Glow --}}
            <div class="absolute -top-24 -right-24 w-64 h-64 bg-teal-500/10 rounded-full blur-3xl"></div>

            <div class="relative z-10 flex items-center gap-6">
                <div>
                    <h1 class="text-3xl font-black text-slate-900 tracking-tight leading-none uppercase italic">
                        STUDENT <span class="text-teal-600 not-italic">PROFILE</span>
                    </h1>
                    <p class="text-[10px] uppercase tracking-[0.3em] text-slate-400 font-bold mt-2">
                        Athlete Identity & Personal Information
                    </p>
                </div>
            </div>

            <div class="relative z-10">
                <a href="{{ route('student.profile.edit') }}"
                   class="px-8 py-4 bg-slate-900 text-white
                          text-[10px] font-black uppercase tracking-widest
                          rounded-[1.5rem] shadow-xl
                          hover:bg-teal-600 hover:scale-105 transition-all
                          flex items-center gap-3">
                    ✏️ Edit Profile
                </a>
            </div>
        </div>
    </div>

    {{-- 2. MAIN CONTENT --}}
    <div class="max-w-7xl mx-auto px-6 mt-4 animate-fade-in">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

            {{-- LEFT: AVATAR --}}
            <div class="lg:col-span-4 space-y-8">

                <div class="bg-white rounded-[2.5rem] p-10 border border-slate-100
                            shadow-sm text-center relative overflow-hidden">

                    <div class="w-40 h-40 mx-auto rounded-[3rem] bg-teal-50
                                border-4 border-white shadow-xl
                                flex items-center justify-center text-6xl
                                font-black text-teal-600 italic">
                        {{ strtoupper(substr(Auth::user()->Name ?? 'S', 0, 1)) }}
                    </div>

                    <div class="mt-8">
                        <h2 class="text-2xl font-black text-slate-900 uppercase tracking-tight">
                            {{ Auth::user()->Name }}
                        </h2>
                        <p class="text-[10px] font-black text-teal-600 uppercase tracking-[0.2em] mt-1 italic">
                            Student Athlete
                        </p>
                    </div>

                    <div class="mt-8 pt-8 border-t border-slate-100
                                flex items-center justify-center gap-6">
                        <div class="text-center">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                Status
                            </p>
                            <p class="text-sm font-bold text-green-600 mt-1 flex items-center gap-1">
                                <span class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse"></span>
                                Active
                            </p>
                        </div>
                    </div>
                </div>

                {{-- MEMBER SINCE --}}
                <div class="bg-slate-900 rounded-[2.5rem] p-8 text-white shadow-2xl">
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">
                        Member Since
                    </p>
                    <p class="text-xl font-bold tracking-tight italic">
                        {{ Auth::user()->created_at->format('M d, Y') }}
                    </p>
                </div>
            </div>

            {{-- RIGHT: INFO --}}
            <div class="lg:col-span-8 space-y-8">

                {{-- ACCOUNT DETAILS --}}
                <div class="bg-white rounded-[3rem] p-10 md:p-14
                            border border-slate-100 shadow-sm">

                    <div class="flex items-center gap-4 mb-12">
                        <h3 class="text-[10px] font-black text-teal-600 uppercase tracking-[0.3em]">
                            Account Details
                        </h3>
                        <div class="flex-1 h-px bg-slate-100"></div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-12">

                        {{-- Name --}}
                        <div>
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2">
                                Full Name
                            </p>
                            <p class="text-lg font-bold text-slate-900">
                                {{ Auth::user()->Name }}
                            </p>
                        </div>

                        {{-- Matric --}}
                        <div>
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2">
                                Matric Number
                            </p>
                            <p class="text-lg font-bold text-slate-900">
                                {{ Auth::user()->MatricNo ?? '—' }}
                            </p>
                        </div>

                        {{-- Email --}}
                        <div>
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2">
                                Email Address
                            </p>
                            <p class="text-lg font-bold text-slate-900 break-all">
                                {{ Auth::user()->Email }}
                            </p>
                        </div>

                        {{-- Phone --}}
                        <div>
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2">
                                Phone Number
                            </p>
                            <p class="text-lg font-bold text-slate-900">
                                {{ Auth::user()->PhoneNumber ?? '—' }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- MEDICAL HISTORY --}}
                <div class="bg-white rounded-[3rem] p-10 border border-slate-100 shadow-sm">
                    <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mb-6">
                        Medical History
                    </h3>
                    <div class="bg-slate-50 rounded-2xl p-6 border border-slate-100
                                italic font-medium text-slate-600 leading-relaxed">
                        {{ Auth::user()->MedicalHistory ?? 'No medical history provided.' }}
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
