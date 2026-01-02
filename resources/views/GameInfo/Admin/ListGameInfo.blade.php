@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-[#F8F9FA] pb-24 font-sans antialiased">
    
    {{-- Aesthetic Header: Floating Blur --}}
      <div class="relative px-6 py-4">        
          <div class="max-w-7xl mx-auto bg-white/70 backdrop-blur-xl border border-white/20 shadow-[0_8px_32px_0_rgba(0,0,0,0.05)] rounded-[2rem] px-8 py-6 flex flex-col md:flex-row items-center justify-between">   
            <div>
                <h1 class="text-3xl font-[900] text-gray-900 tracking-tight italic">GAME <span class="text-[#800000] not-italic">INFORMATION</span></h1>
                <p class="text-xs uppercase tracking-[0.3em] text-gray-400 font-bold mt-1">STORE EVERY GAME INFORMATION HERE</p>
            </div>
            
            <div class="flex items-center gap-8 mt-4 md:mt-0">
                <div class="text-right">
                    <span class="block text-[10px] font-black text-gray-400 uppercase tracking-widest leading-none">Total Events</span>
                    <span class="text-2xl font-black text-gray-900 leading-none">{{ $events->count() }}</span>
                </div>
                <div class="w-px h-8 bg-gray-100"></div>
                <div class="text-right">
                    <span class="block text-[10px] font-black text-gray-400 uppercase tracking-widest leading-none">Total Games</span>
                    <span class="text-2xl font-black text-[#800000] leading-none">{{ $events->sum(fn($e)=>$e->games->count()) }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Body --}}
    <div class="max-w-7xl mx-auto px-6 mt-12">
        <div class="space-y-32">
            
            @foreach($events as $event)
                <section class="animate-in fade-in slide-in-from-bottom-4 duration-700">
                    {{-- Section Label --}}
                    <div class="flex items-center gap-4 mb-8">
                        <div class="flex-none px-4 py-1 bg-black text-white text-[10px] font-black uppercase tracking-[0.2em] rounded-full">
                            {{ $event->Status }}
                        </div>
                        <h2 class="text-4xl font-black text-gray-900 tracking-tighter">{{ $event->EventName }}</h2>
                        <div class="flex-1 h-[2px] bg-gradient-to-r from-gray-100 to-transparent"></div>
                        <p class="text-sm font-medium text-gray-400 font-mono">
                            {{ \Carbon\Carbon::parse($event->StartDate)->format('M.y') }} — {{ \Carbon\Carbon::parse($event->EndDate)->format('M.y') }}
                        </p>
                    </div>

                    {{-- Bento Grid Layout --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @forelse($event->games as $game)
                            @php
                                $status = strtolower($game->final_status);
                                // Define dynamic styles based on status
                                $statusConfig = [
                                    'open' => ['color' => 'text-green-600', 'bg' => 'bg-green-500', 'label' => 'OPEN', 'border' => 'border-green-100'],
                                    'closed' => ['color' => 'text-gray-500', 'bg' => 'bg-gray-400', 'label' => 'CLOSED', 'border' => 'border-gray-200'],
                                    'canceled' => ['color' => 'text-red-600', 'bg' => 'bg-red-500', 'label' => 'CANCELED', 'border' => 'border-red-100'],
                                ];
                                $currentStyle = $statusConfig[$status] ?? ['color' => 'text-gray-400', 'bg' => 'bg-gray-300', 'label' => strtoupper($status), 'border' => 'border-gray-100'];
                            @endphp

                            <a href="{{ route('admin.gameinfo.show', $game->GameID) }}" 
                               class="group relative overflow-hidden bg-white rounded-[2.5rem] p-8 border border-gray-100 shadow-sm hover:shadow-[0_20px_60px_-15px_rgba(0,0,0,0.1)] transition-all duration-500 hover:-translate-y-2">
                                
                                {{-- Background "Glow" --}}
                                <div class="absolute -top-24 -right-24 w-48 h-48 bg-[#800000]/5 rounded-full blur-3xl group-hover:bg-[#800000]/10 transition-colors"></div>

                                <div class="relative z-10">
                                    {{-- Game Header: Category & Dynamic Status --}}
                                    <div class="flex justify-between items-start mb-12">
                                        <div class="px-3 py-1 bg-gray-50 text-gray-500 text-[10px] font-bold uppercase tracking-widest rounded-lg border border-gray-100">
                                            {{ $game->Category ?? 'Game' }}
                                        </div>

                                        {{-- Corrected Dynamic Status Badge --}}
                                        <div class="flex items-center gap-1.5">
                                            @if($status === 'open')
                                                <span class="relative flex h-2 w-2">
                                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full {{ $currentStyle['bg'] }} opacity-75"></span>
                                                    <span class="relative inline-flex rounded-full h-2 w-2 {{ $currentStyle['bg'] }}"></span>
                                                </span>
                                            @else
                                                <span class="h-2 w-2 rounded-full {{ $currentStyle['bg'] }}"></span>
                                            @endif
                                            <span class="text-[10px] font-black {{ $currentStyle['color'] }} uppercase tracking-tighter">
                                                {{ $currentStyle['label'] }}
                                            </span>
                                        </div>
                                    </div>

                                    <h3 class="text-2xl font-black text-gray-900 leading-tight group-hover:text-[#800000] transition-colors">
                                        {{ $game->GameName }}
                                    </h3>
                                    
                                    <div class="mt-8 flex items-end justify-between">
                                        <div>
                                            <p class="text-[10px] font-black text-gray-300 uppercase tracking-widest">Capacity</p>
                                            <p class="text-xl font-bold text-gray-800">{{ $game->Capacity }} <span class="text-xs font-medium text-gray-400 italic">person</span></p>
                                        </div>
                                        
                                        <div class="w-12 h-12 rounded-full bg-black flex items-center justify-center text-white scale-75 opacity-0 group-hover:opacity-100 group-hover:scale-100 transition-all duration-300 shadow-xl shadow-black/20">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div class="col-span-full py-20 rounded-[3rem] border-2 border-dashed border-gray-100 flex flex-col items-center">
                                <span class="text-4xl text-gray-200">empty_</span>
                                <p class="text-gray-400 font-medium mt-2 uppercase tracking-widest text-[10px]">No games found in this quadrant</p>
                            </div>
                        @endforelse
                    </div>
                </section>
            @endforeach

        </div>
    </div>
</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap');
    body { font-family: 'Plus Jakarta Sans', sans-serif; }
</style>
@endsection