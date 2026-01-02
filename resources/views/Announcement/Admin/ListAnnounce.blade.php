@extends('layouts.admin')

@section('title', 'Manage Announcements')

@section('content')
<div class="min-h-screen bg-[#F8F9FA] pb-24 font-sans antialiased">
    
    {{-- Aesthetic Header Card --}}
    <div class="relative px-6 py-6">        
        <div class="max-w-7xl mx-auto bg-white border border-gray-100 shadow-sm rounded-[2rem] px-10 py-8 flex flex-col md:flex-row items-center justify-between gap-8 relative overflow-hidden">
            {{-- Subtle Background Glow --}}
            <div class="absolute -top-24 -right-24 w-64 h-64 bg-[#800000]/5 rounded-full blur-3xl"></div>

            <div class="relative z-10">
                <h1 class="text-3xl font-black text-gray-900 tracking-tight leading-none uppercase italic">MANAGE <span class="text-[#800000] not-italic">ANNOUNCEMENTS</span></h1>
                <p class="text-[10px] uppercase tracking-[0.3em] text-gray-400 font-bold mt-2">Communication Hub & Student Broadcasts</p>
            </div>
            
            <div class="relative z-10 flex flex-wrap items-center gap-4">
                <div class="flex items-center gap-8 mr-4 text-right">
                    <div>
                        <span class="block text-[10px] font-black text-gray-400 uppercase tracking-widest leading-none mb-2">Published</span>
                        <span class="text-3xl font-black text-gray-900 leading-none tabular-nums">{{ $announcements->count() }}</span>
                    </div>
                </div>
                <a href="{{ route('admin.announcements.create') }}" 
                   class="px-8 py-4 bg-[#800000] text-white text-[10px] font-black uppercase tracking-widest rounded-[1.5rem] shadow-xl shadow-red-900/20 hover:scale-105 active:scale-95 transition-all flex items-center gap-3">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                    New Broadcast
                </a>
            </div>
        </div>
    </div>

    {{-- Main Content --}}
    <div class="max-w-7xl mx-auto px-6 mt-6">
        
        @if(session('success'))
            <div class="mb-8 p-5 rounded-[1.5rem] bg-green-50 border border-green-100 text-green-700 text-sm font-bold flex items-center gap-3 animate-in fade-in slide-in-from-top-4">
                <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                {{ session('success') }}
            </div>
        @endif

        @if($announcements->isEmpty())
            <div class="bg-white rounded-[3rem] border-2 border-dashed border-gray-100 p-20 flex flex-col items-center justify-center text-center">
                <div class="w-20 h-20 bg-gray-50 rounded-3xl flex items-center justify-center mb-6">
                    <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.297A2.457 2.457 0 0111 19.297V5.882z"/></svg>
                </div>
                <h3 class="text-xl font-black text-gray-900 uppercase">Silence in the Studio</h3>
                <p class="text-gray-400 text-sm mt-2 max-w-xs font-medium">No announcements have been broadcasted yet.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($announcements as $announce)
                    {{-- Clickable Card Link --}}
                    <a href="{{ route('admin.announcements.show', $announce->AnnouncementID) }}" 
                       class="group relative bg-white rounded-[2.5rem] border border-gray-100 shadow-sm hover:shadow-[0_20px_50px_-15px_rgba(128,0,0,0.1)] transition-all duration-500 hover:-translate-y-2 flex flex-col h-full overflow-hidden">
                        
                        {{-- Image/Header Section --}}
                        <div class="relative aspect-video overflow-hidden">
                            @if($announce->Image)
                                <img src="{{ asset('storage/' . $announce->Image) }}" alt="Hero" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            @else
                                <div class="w-full h-full bg-gray-100 flex items-center justify-center text-gray-300 italic text-xs font-bold uppercase tracking-widest">No Media Attached</div>
                            @endif
                            
                            {{-- Category Badge --}}
                            <div class="absolute top-5 left-5">
                                <span class="px-3 py-1.5 bg-white/90 backdrop-blur-md rounded-xl text-[9px] font-black uppercase tracking-widest text-gray-900 shadow-sm">
                                    {{ $announce->Category ?? 'General' }}
                                </span>
                            </div>

                            {{-- Visibility Icon --}}
                            <div class="absolute top-5 right-5 h-8 w-8 rounded-full bg-black/20 backdrop-blur-md flex items-center justify-center border border-white/20">
                                @if(strtolower($announce->visibility ?? 'public') == 'public')
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                @else
                                    <svg class="w-4 h-4 text-red-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                @endif
                            </div>
                        </div>

                        {{-- Content Section --}}
                        <div class="p-8 flex-1 flex flex-col">
                            <div class="mb-4">
                                <span class="text-[10px] font-black text-[#800000] uppercase tracking-widest opacity-60">
                                    {{ \Carbon\Carbon::parse($announce->Date)->format('d F Y') }}
                                </span>
                                <h3 class="text-xl font-black text-gray-900 mt-1 leading-tight line-clamp-2 group-hover:text-[#800000] transition-colors">
                                    {{ $announce->Title }}
                                </h3>
                            </div>

                            <p class="text-sm text-gray-400 font-medium line-clamp-3 mb-8">
                                {{ Str::limit($announce->Description, 120) }}
                            </p>

                            {{-- Subtle Hint Icon --}}
                            <div class="mt-auto pt-6 border-t border-gray-50 flex items-center justify-end">
                                <div class="text-[9px] font-black uppercase tracking-widest text-gray-300 group-hover:text-[#800000] transition-colors flex items-center gap-2">
                                    View Entry <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap');
    body { font-family: 'Plus Jakarta Sans', sans-serif; }
    
    .animate-in {
        animation-delay: 0.1s;
        animation-fill-mode: both;
    }
</style>
@endsection