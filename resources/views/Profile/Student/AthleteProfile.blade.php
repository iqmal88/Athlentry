@extends('layouts.app')

@section('title', 'My Athlete Profile')

@section('content')
<div class="min-h-screen bg-[#F8FAFC] pb-24 font-sans antialiased">

    {{-- HEADER --}}
    <div class="relative px-6 py-6">
        <div class="max-w-5xl mx-auto bg-white border border-slate-100 shadow-sm rounded-[2.5rem] px-10 py-8 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-black italic uppercase tracking-tight text-slate-900">
                    Athlete <span class="text-teal-600 not-italic">Profile</span>
                </h1>
                <p class="text-[10px] uppercase tracking-[0.3em] text-slate-400 font-bold mt-2">
                    Official Recruitment Identity
                </p>
            </div>

            <a href="{{ route('student.profile.edit') }}"
               class="px-8 py-3 rounded-2xl bg-teal-600 text-white text-xs font-black uppercase tracking-widest hover:brightness-110 transition shadow-lg shadow-teal-600/20">
                Edit Profile
            </a>
        </div>
    </div>

    <div class="max-w-5xl mx-auto px-6 mt-6 space-y-6">

        {{-- PROGRESS TRACKER --}}
        @php $status = auth()->user()->getCompletionStatus(); @endphp
        <div class="bg-white rounded-[2.5rem] p-10 border border-slate-100 shadow-sm">
            <div class="flex justify-between items-end mb-6">
                <div>
                    <h3 class="text-xs font-black uppercase tracking-widest text-slate-800">Completion Progress</h3>
                    <p class="text-[10px] font-bold text-slate-400 uppercase mt-1">
                        {{ $status['is_complete'] ? 'Profile verified' : 'Required for event applications' }}
                    </p>
                </div>
                <span class="text-3xl font-black italic text-teal-600">{{ $status['percentage'] }}%</span>
            </div>
            
            <div class="w-full bg-slate-100 rounded-full h-4 overflow-hidden shadow-inner">
                <div class="bg-teal-500 h-full transition-all duration-1000 ease-out shadow-[0_0_20px_rgba(20,184,166,0.4)]" 
                     style="width: {{ $status['percentage'] }}%"></div>
            </div>
        </div>

        {{-- MAIN INFO CARD --}}
        <div class="bg-white rounded-[3rem] p-10 md:p-14 border border-slate-100 shadow-sm grid grid-cols-1 md:grid-cols-3 gap-12">
            
            {{-- PROFILE PHOTO --}}
            <div class="flex flex-col items-center text-center">
                <div class="relative">
                    <img class="h-48 w-48 object-cover rounded-[2.5rem] border-8 border-slate-50 shadow-xl" 
                         src="{{ $user->ProfilePhoto ? asset('storage/' . $user->ProfilePhoto) : 'https://ui-avatars.com/api/?name='.urlencode($user->Name).'&background=0D9488&color=fff&size=512' }}" 
                         alt="Profile photo">
                    @if($status['is_complete'])
                        <div class="absolute -bottom-2 -right-2 bg-teal-500 text-white p-2 rounded-2xl shadow-lg border-4 border-white">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                    @endif
                </div>
                <h2 class="mt-6 text-2xl font-black text-slate-900 uppercase italic">{{ $user->Name }}</h2>
                <span class="mt-1 text-[10px] font-black uppercase tracking-widest text-teal-600 bg-teal-50 px-4 py-1.5 rounded-full border border-teal-100 italic">{{ $user->MatricNo }}</span>
            </div>

            {{-- DETAILS --}}
            <div class="md:col-span-2 space-y-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <label class="text-[10px] font-black uppercase tracking-widest text-slate-400">Email Address</label>
                        <p class="mt-2 text-slate-700 font-bold bg-slate-50 p-4 rounded-2xl border border-slate-100">{{ $user->Email }}</p>
                    </div>
                    <div>
                        <label class="text-[10px] font-black uppercase tracking-widest text-slate-400">Phone Number</label>
                        <p class="mt-2 text-slate-700 font-bold bg-slate-50 p-4 rounded-2xl border border-slate-100">{{ $user->PhoneNumber ?? 'Not set' }}</p>
                    </div>
                </div>

                <div>
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400">Sports Achievement</label>
                    <div class="mt-2 text-slate-700 font-medium bg-slate-50 p-6 rounded-2xl border border-slate-100 min-h-[100px]">
                        {{ $user->Achievement ?? 'No achievements listed yet.' }}
                    </div>
                </div>

                <div>
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400">Medical History</label>
                    <div class="mt-2 text-slate-700 font-medium bg-slate-50 p-6 rounded-2xl border border-slate-100 min-h-[100px]">
                        {{ $user->MedicalHistory ?? 'No medical history recorded.' }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection