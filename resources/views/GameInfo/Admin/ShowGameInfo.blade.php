@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-[#F8F9FA] pb-24 font-sans antialiased">

    {{-- Aesthetic Header: Floating Blur --}}
      <div class="relative px-6 py-4">        
          <div class="max-w-7xl mx-auto bg-white/70 backdrop-blur-xl border border-white/20 shadow-[0_8px_32px_0_rgba(0,0,0,0.05)] rounded-[2rem] px-8 py-6 flex flex-col md:flex-row items-center justify-between">   
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.gameinfo.index') }}" class="group flex items-center justify-center w-10 h-10 bg-white border border-gray-100 rounded-full shadow-sm hover:bg-[#800000] hover:text-white transition-all duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <div>
                    <h1 class="text-3xl font-[900] text-gray-900 tracking-tight italic uppercase">GAME <span class="text-[#800000] not-italic">DETAILS</span></h1>
                    <p class="text-[10px] uppercase tracking-[0.3em] text-gray-400 font-black mt-1">Detailed Oversight </p>
                </div>
            </div>

            <div class="flex items-center gap-3 mt-4 md:mt-0">
                <a href="{{ route('admin.gameinfo.edit', $game->GameID) }}" 
                   class="px-6 py-2.5 bg-[#800000] text-white text-xs font-black uppercase tracking-widest rounded-xl shadow-lg shadow-red-900/20 hover:scale-105 transition-all">
                    Modify Game
                </a>
                <form action="{{ route('admin.gameinfo.destroy', $game->GameID) }}" method="POST" onsubmit="return confirm('Delete this game?');">
                    @csrf @method('DELETE')
                    <button class="p-2.5 bg-red-50 text-red-600 rounded-xl hover:bg-red-600 hover:text-white transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Content Body --}}
    <div class="max-w-7xl mx-auto px-6 mt-12 animate-in fade-in slide-in-from-bottom-4 duration-700">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- Left Column: Content --}}
            <div class="lg:col-span-2 space-y-8">
                
                {{-- Hero Information Card --}}
                <div class="bg-white rounded-[3rem] p-10 md:p-14 border border-gray-100 shadow-sm relative overflow-hidden">
                    {{-- Decorative Watermark --}}
                    <div class="absolute -top-10 -right-10 text-[12rem] font-black text-gray-50 pointer-events-none select-none italic leading-none">
                        {{ substr($game->GameName, 0, 1) }}
                    </div>

                    <div class="relative z-10">
                        @php
                            $status = strtolower($game->final_status);
                            $badgeColor = $status === 'open' ? 'text-green-600 bg-green-50' : ($status === 'cancelled' ? 'text-red-600 bg-red-50' : 'text-gray-500 bg-gray-100');
                        @endphp
                        
                        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full {{ $badgeColor }} text-[10px] font-black uppercase tracking-widest mb-6">
                            @if($status === 'open') <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span> @endif
                            {{ $game->final_status }}
                        </div>

                        <h2 class="text-5xl font-black text-gray-900 tracking-tighter mb-4">{{ $game->GameName }}</h2>
                        <p class="text-gray-400 font-bold uppercase tracking-widest text-xs flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            {{ $game->event->EventName ?? 'Standalone Event' }}
                        </p>

                        <div class="mt-12 h-px bg-gray-100 w-full"></div>

                        <div class="mt-12">
                            <h3 class="text-[10px] font-black text-[#800000] uppercase tracking-[0.3em] mb-4">About the Game</h3>
                            <p class="text-xl text-gray-600 leading-relaxed font-light">
                                {{ $game->Description ?: 'No description has been provided for this game yet.' }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Rules Card --}}
                <div class="bg-white rounded-[3rem] p-10 md:p-14 border border-gray-100 shadow-sm">
                    <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em] mb-8">Game Regulations</h3>
                    
                    @if($game->Rules)
                        <div class="grid grid-cols-1 gap-4">
                            @foreach(explode("\n", $game->Rules) as $rule)
                                @if(trim($rule))
                                    <div class="flex items-start gap-4 p-5 rounded-2xl bg-gray-50 border border-gray-100 hover:border-[#800000]/20 transition-colors">
                                        <div class="w-6 h-6 shrink-0 rounded-full bg-[#800000] flex items-center justify-center text-[10px] font-bold text-white mt-0.5">
                                            {{ $loop->iteration }}
                                        </div>
                                        <p class="text-gray-700 font-medium leading-relaxed">{{ trim($rule) }}</p>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-10">
                            <p class="text-gray-400 italic">No rules provided.</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Right Column: Sidebar Specs --}}
            <div class="space-y-8">
                
                {{-- Logistics Bento Card --}}
                <div class="bg-black rounded-[3rem] p-10 text-white shadow-xl shadow-black/10 relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-8 opacity-10">
                        <svg class="w-20 h-20" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path></svg>
                    </div>
                    
                    <h3 class="text-[10px] font-black text-gray-500 uppercase tracking-[0.3em] mb-10">Selection Details</h3>
                    
                    <div class="space-y-8">
                        <div>
                            <p class="text-[10px] font-black text-red-500 uppercase tracking-widest mb-1">Venue</p>
                            <p class="text-2xl font-bold tracking-tight">{{ $game->SelectionPlace ?: 'TBA' }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-red-500 uppercase tracking-widest mb-1">Schedule</p>
                            <p class="text-2xl font-bold tracking-tight">
                                {{ $game->GameDate ? \Carbon\Carbon::parse($game->GameDate)->format('d M, Y') : 'TBA' }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Team/Staff Card --}}
                <div class="bg-white rounded-[3rem] p-10 border border-gray-100 shadow-sm">
                    <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em] mb-10">Personnel</h3>
                    
                    <div class="space-y-8">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-gray-50 flex items-center justify-center text-[#800000]">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Coach In-Charge</p>
                                <p class="text-lg font-bold text-gray-900 leading-tight">{{ $game->CoachName ?: 'Not Assigned' }}</p>
                                <p class="text-xs text-gray-500 font-medium mt-1">{{ $game->CoachPhone ?: '' }}</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-4 pt-8 border-t border-gray-50">
                            <div class="w-12 h-12 rounded-2xl bg-gray-50 flex items-center justify-center text-[#800000]">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Specifications</p>
                                <p class="text-lg font-bold text-gray-900 leading-tight">{{ $game->Category }}</p>
                                <p class="text-xs text-gray-500 font-medium mt-1">{{ $game->Capacity }} Max Seats</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap');
    body { font-family: 'Plus Jakarta Sans', sans-serif; }
</style>
@endsection