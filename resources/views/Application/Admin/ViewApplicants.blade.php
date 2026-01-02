@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-[#F8F9FA] pb-24 font-sans antialiased">
    
    {{-- Aesthetic Header Card --}}
    <div class="relative px-6 py-6">        
        <div class="max-w-7xl mx-auto bg-white border border-gray-100 shadow-sm rounded-[2rem] px-10 py-8 flex flex-col md:flex-row items-center justify-between gap-8 relative overflow-hidden">
            {{-- Subtle Background Glow --}}
            <div class="absolute -top-24 -right-24 w-64 h-64 bg-[#800000]/5 rounded-full blur-3xl"></div>

            <div class="relative z-10 flex items-center gap-5">
                <a href="{{ route('admin.events.list') }}" class="group flex items-center justify-center w-12 h-12 bg-gray-50 rounded-2xl hover:bg-[#800000] hover:text-white transition-all duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <div class="h-10 w-px bg-gray-100 hidden md:block"></div>
                <div>
                    <h1 class="text-3xl font-black text-gray-900 tracking-tight leading-none uppercase italic">{{ $game->GameName }} <span class="text-[#800000] not-italic">APPLICANTS</span></h1>
                    <p class="text-[10px] uppercase tracking-[0.3em] text-gray-400 font-bold mt-2">Registry & Selection Protocol</p>
                </div>
            </div>
            
            <div class="relative z-10 flex items-center gap-12">
                <div class="text-right">
                    <span class="block text-[10px] font-black text-gray-400 uppercase tracking-widest leading-none mb-2">Applicants</span>
                    <span class="text-3xl font-black text-gray-900 leading-none tabular-nums">
                        {{ $applications->count() }}<span class="text-gray-300 text-xl font-medium">@if(isset($capacity))/{{ $capacity }}@endif</span>
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Content --}}
    <div class="max-w-7xl mx-auto px-6 mt-6">
        
        {{-- Feedback messages --}}
        @if(session('success'))
            <div class="mb-8 p-5 rounded-[1.5rem] bg-green-50 border border-green-100 text-green-700 text-sm font-bold flex items-center gap-3 animate-in fade-in slide-in-from-top-4">
                <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 gap-6">
            @forelse($applications as $app)
                @php
                    $userName = optional($app->user)->name ?? (optional($app->user)->FullName ?? 'User ' . $app->UserID);
                    $initials = strtoupper(substr($userName, 0, 1));
                    $isSelected = ($app->StatusID == 2);
                @endphp

                <div class="group relative bg-white rounded-[2rem] p-8 border border-gray-100 shadow-sm hover:shadow-[0_20px_50px_-15px_rgba(0,0,0,0.05)] transition-all duration-500 flex flex-col md:flex-row items-center justify-between gap-6 overflow-hidden">
                    
                    {{-- Initials Watermark Background --}}
                    <div class="absolute -left-4 -bottom-4 text-8xl font-black text-gray-50 pointer-events-none select-none italic opacity-50 group-hover:text-gray-100 transition-colors">
                        {{ $initials }}
                    </div>

                    {{-- Left: Profile Info --}}
                    <div class="relative z-10 flex items-center gap-6 flex-1 min-w-0">
                        <div class="w-16 h-16 rounded-2xl bg-gray-900 flex items-center justify-center text-white text-xl font-black italic shadow-lg group-hover:bg-[#800000] transition-colors">
                            {{ $initials }}
                        </div>
                        <div class="min-w-0">
                            <h3 class="text-xl font-black text-gray-900 uppercase tracking-tight truncate">{{ $userName }}</h3>
                            <div class="flex items-center gap-4 mt-1">
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest flex items-center gap-1.5">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    {{ \Carbon\Carbon::parse($app->DateApplied)->format('d M Y') }}
                                </p>
                                <span class="text-gray-200 text-xs">•</span>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest flex items-center gap-1.5">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    {{ \Carbon\Carbon::parse($app->DateApplied)->format('h:i A') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Center: Status Badge --}}
                    <div class="relative z-10">
                        @if($isSelected)
                            <div class="px-4 py-1.5 bg-green-50 border border-green-100 rounded-full flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>
                                <span class="text-[10px] font-black text-green-700 uppercase tracking-widest">Selected Athlete</span>
                            </div>
                        @else
                            <div class="px-4 py-1.5 bg-gray-50 border border-gray-100 rounded-full flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-gray-300"></span>
                                <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Pending Review</span>
                            </div>
                        @endif
                    </div>

                    {{-- Right: Selection Action --}}
                    <div class="relative z-10 w-full md:w-auto">
                        @if(!$isSelected)
                            <form method="POST" action="{{ route('admin.applications.select', $app->ApplicationID) }}">
                                @csrf
                                <input type="hidden" name="StatusID" value="2" />
                                <button type="submit" class="w-full md:w-auto px-8 py-3 bg-gray-900 text-white rounded-xl text-[10px] font-black uppercase tracking-widest shadow-xl shadow-gray-200 hover:bg-[#800000] hover:shadow-red-900/20 hover:scale-105 active:scale-95 transition-all">
                                    Select Entry
                                </button>
                            </form>
                        @else
                            <button disabled class="w-full md:w-auto px-8 py-3 bg-gray-50 text-gray-300 border border-gray-100 rounded-xl text-[10px] font-black uppercase tracking-widest cursor-not-allowed">
                                Confirmed
                            </button>
                        @endif
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-[3rem] border-2 border-dashed border-gray-100 p-20 flex flex-col items-center justify-center text-center">
                    <p class="text-gray-300 font-black uppercase tracking-[0.2em] text-[10px]">Registry is currently empty for this sport</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap');
    body { font-family: 'Plus Jakarta Sans', sans-serif; letter-spacing: -0.01em; }
    
    .animate-in {
        animation-delay: 0.1s;
        animation-fill-mode: both;
    }
</style>
@endsection