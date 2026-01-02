@extends('layouts.admin')

@section('title', 'Events Hub')

@section('content')
<div class="min-h-screen bg-[#F8F9FA] pb-24 font-sans antialiased">
    
    {{-- Aesthetic Header Card --}}
    <div class="relative px-6 py-6">        
        <div class="max-w-7xl mx-auto bg-white border border-gray-100 shadow-sm rounded-[2rem] px-10 py-8 flex flex-col md:flex-row items-center justify-between gap-8 relative overflow-hidden">
            <div class="absolute -top-24 -right-24 w-64 h-64 bg-[#800000]/5 rounded-full blur-3xl"></div>

            <div class="relative z-10">
                <h1 class="text-3xl font-black text-gray-900 tracking-tight leading-none uppercase italic">EVENTS <span class="text-[#800000] not-italic">HUB</span></h1>
                <p class="text-[10px] uppercase tracking-[0.3em] text-gray-400 font-bold mt-2">Tournament Scheduling & Athlete In-take</p>
            </div>
            
            <div class="relative z-10 flex flex-wrap items-center gap-4">
                <div class="flex items-center gap-8 mr-4">
                    <div class="text-right">
                        <span class="block text-[10px] font-black text-gray-400 uppercase tracking-widest leading-none mb-2">Total Events</span>
                        <span class="text-3xl font-black text-gray-900 leading-none tabular-nums">{{ $events->count() }}</span>
                    </div>
                </div>
                <a href="{{ route('admin.events.create') }}" 
                   class="px-8 py-4 bg-[#800000] text-white text-[10px] font-black uppercase tracking-widest rounded-[1.5rem] shadow-xl shadow-red-900/20 hover:scale-105 active:scale-95 transition-all flex items-center gap-3">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                    Add New Event
                </a>
            </div>
        </div>
    </div>

    {{-- Filters Bar --}}
    <div class="max-w-7xl mx-auto px-10 mb-10 flex flex-col md:flex-row gap-4">
        <div class="relative flex-1 group">
            <div class="absolute inset-y-0 left-5 flex items-center pointer-events-none text-gray-400 group-focus-within:text-[#800000] transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <input id="searchInput" type="text" placeholder="Search events or specific games..." 
                   class="w-full bg-white border border-gray-100 rounded-2xl py-4 pl-12 pr-6 text-sm font-bold text-gray-900 focus:outline-none focus:ring-4 focus:ring-[#800000]/5 focus:border-[#800000]/20 transition-all shadow-sm placeholder:text-gray-300 placeholder:font-medium">
        </div>
        
        <div class="flex gap-4">
            <select id="statusFilter" class="bg-white border border-gray-100 rounded-2xl px-6 py-4 text-xs font-black uppercase tracking-widest text-gray-500 focus:outline-none focus:ring-4 focus:ring-[#800000]/5 transition-all shadow-sm appearance-none cursor-pointer min-w-[160px]">
                <option value="all">All Statuses</option>
                <option value="Open">Open</option>
                <option value="Closed">Closed</option>
                <option value="Cancelled">Cancelled</option>
            </select>
            
            <select id="categoryFilter" class="bg-white border border-gray-100 rounded-2xl px-6 py-4 text-xs font-black uppercase tracking-widest text-gray-500 focus:outline-none focus:ring-4 focus:ring-[#800000]/5 transition-all shadow-sm appearance-none cursor-pointer min-w-[160px]">
                <option value="all">All Categories</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Mixed">Mixed</option>
            </select>
        </div>
    </div>

    {{-- Events List --}}
    <div class="max-w-7xl mx-auto px-6">
        @if($events->isEmpty())
            <div class="bg-white rounded-[3rem] border-2 border-dashed border-gray-100 p-20 flex flex-col items-center justify-center text-center">
                <p class="text-gray-300 font-black uppercase tracking-[0.2em] text-[10px]">No active events in registry</p>
            </div>
        @else
            <div id="eventsGrid" class="space-y-16">
                @foreach($events as $event)
                    <article class="event-card animate-in fade-in slide-in-from-bottom-4 duration-700" 
                             data-event-name="{{ strtolower($event->EventName) }}" 
                             data-event-status="{{ $event->Status }}">
                        
                        {{-- Event Stage Header --}}
                        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-8 px-4">
                            <div class="flex items-center gap-6">
                                @php
                                    $statusColor = match($event->Status) {
                                        'Open' => 'bg-green-500',
                                        'Closed' => 'bg-gray-400',
                                        default => 'bg-red-500'
                                    };
                                @endphp
                                <div class="w-3 h-3 rounded-full {{ $statusColor }} {{ $event->Status == 'Open' ? 'animate-pulse' : '' }}"></div>
                                <h2 class="text-4xl font-black text-gray-900 tracking-tighter italic uppercase group-hover:text-[#800000] transition-colors">
                                    <a href="{{ route('admin.events.edit', $event->EventID) }}">{{ $event->EventName }}</a>
                                </h2>
                                <span class="text-[10px] font-black text-gray-300 uppercase tracking-widest px-3 py-1 bg-gray-50 rounded-lg border border-gray-100">
                                    {{ $event->Status }}
                                </span>
                            </div>
                            <div class="flex items-center gap-3 pb-1">
                                <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-tighter tabular-nums">
                                    {{ $event->StartDate ? \Carbon\Carbon::parse($event->StartDate)->format('M d') : '-' }} — 
                                    {{ $event->EndDate ? \Carbon\Carbon::parse($event->EndDate)->format('M d, Y') : '-' }}
                                </p>
                            </div>
                        </div>

                        {{-- Games Grid for this Event --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 px-4">
                            @foreach($event->games as $game)
                                @php
                                    $cat = $game->Category ?? 'Open';
                                    $catColor = match(strtolower($cat)) {
                                        'male', 'men' => 'text-blue-600 bg-blue-50',
                                        'female', 'women' => 'text-pink-600 bg-pink-50',
                                        default => 'text-yellow-600 bg-yellow-50'
                                    };
                                @endphp
                                <div class="game-row group relative bg-white rounded-[2.5rem] p-8 border border-gray-100 shadow-sm hover:shadow-[0_20px_60px_-15px_rgba(0,0,0,0.06)] transition-all duration-500 hover:-translate-y-2 flex flex-col justify-between"
                                     data-game-name="{{ strtolower($game->GameName) }}"
                                     data-game-category="{{ strtolower($cat) }}">
                                    
                                    {{-- Watermark --}}
                                    <div class="absolute -top-4 -right-2 text-7xl font-black text-gray-50 pointer-events-none select-none italic group-hover:text-gray-100 transition-colors">
                                        {{ strtoupper(substr($game->GameName, 0, 1)) }}
                                    </div>

                                    <div class="relative z-10">
                                        <div class="flex justify-between items-start mb-10">
                                            <span class="px-3 py-1 rounded-md text-[9px] font-black uppercase tracking-widest border border-current {{ $catColor }}">
                                                {{ $cat }}
                                            </p>
                                        </div>

                                        <h3 class="text-2xl font-black text-gray-900 leading-tight mb-2 group-hover:text-[#800000] transition-colors">
                                            {{ $game->GameName }}
                                        </h3>
                                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">In-take: {{ $game->applications_count ?? 0 }} Athletes</p>
                                    </div>

                                    <div class="mt-10 pt-6 border-t border-gray-50 flex items-center justify-between">
                                        <div>
                                            <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest leading-none mb-1">Capacity</p>
                                            <p class="text-lg font-black text-gray-800 tabular-nums">{{ $game->Capacity ?? '∞' }}</p>
                                        </div>
                                        
                                        <a href="{{ route('admin.games.applicants', $game->GameID) }}" 
                                           class="w-10 h-10 rounded-xl bg-gray-900 flex items-center justify-center text-white scale-90 opacity-0 group-hover:opacity-100 group-hover:scale-100 transition-all duration-300 shadow-lg">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </div>
</div>

<script>
(function () {
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    const categoryFilter = document.getElementById('categoryFilter');
    const eventCards = Array.from(document.querySelectorAll('.event-card'));

    function applyFilters() {
        const q = searchInput.value.toLowerCase().trim();
        const status = statusFilter.value.toLowerCase();
        const category = categoryFilter.value.toLowerCase();

        eventCards.forEach(card => {
            const eventName = card.dataset.eventName;
            const eventStatus = card.dataset.eventStatus.toLowerCase();
            
            let statusMatches = (status === 'all' || eventStatus === status);
            let eventMatches = (!q || eventName.includes(q));

            const games = Array.from(card.querySelectorAll('.game-row'));
            let matchedGamesCount = 0;

            games.forEach(game => {
                const gName = game.dataset.gameName;
                const gCat = game.dataset.gameCategory;
                
                const matchesText = (!q || gName.includes(q) || gCat.includes(q));
                const matchesCategory = (category === 'all' || gCat.includes(category));
                
                if (matchesText && matchesCategory) {
                    game.style.display = 'flex';
                    matchedGamesCount++;
                } else {
                    game.style.display = 'none';
                }
            });

            // Show event card if status matches and (header match OR at least one game inside matches)
            if (statusMatches && (eventMatches || matchedGamesCount > 0)) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    }

    [searchInput, statusFilter, categoryFilter].forEach(el => el.addEventListener('input', applyFilters));
})();
</script>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap');
    body { font-family: 'Plus Jakarta Sans', sans-serif; letter-spacing: -0.01em; }
    select { background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%239ca3af' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e"); background-position: right 1rem center; background-repeat: no-repeat; background-size: 1.5em 1.5em; }
</style>
@endsection