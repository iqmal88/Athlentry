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
                    <h1 class="text-3xl font-black text-gray-900 tracking-tight leading-none uppercase italic">EDIT <span class="text-[#800000] not-italic">EVENT</span></h1>
                    <p class="text-[10px] uppercase tracking-[0.3em] text-gray-400 font-bold mt-2">Modifying: {{ $event->EventName }}</p>
                </div>
            </div>

            <div class="relative z-10 hidden md:block">
                <div class="px-5 py-2 bg-gray-50 rounded-xl border border-gray-100 text-[10px] font-black text-gray-400 tracking-widest uppercase">
                    ID: #{{ $event->EventID }}
                </div>
            </div>
        </div>
    </div>

    {{-- Main Content Container --}}
    <div class="max-w-7xl mx-auto px-6 mt-4 animate-in fade-in slide-in-from-bottom-4 duration-700">
        
        {{-- Notification Alerts --}}
        @if(session('success'))
            <div class="mb-8 p-5 rounded-[1.5rem] bg-green-50 border border-green-100 text-green-700 text-sm font-bold flex items-center gap-3">
                <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                {{ session('success') }}
            </div>
        @endif

        <form id="editEventForm" action="{{ route('admin.events.update', $event->EventID) }}" method="POST">
            @csrf
            @method('POST') {{-- Adjust to @method('PUT') if your route expects PUT --}}

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">

                {{-- Left Column: Event Core Details --}}
                <div class="lg:col-span-2 space-y-8">
                    <div class="bg-white rounded-[2.5rem] p-10 md:p-12 border border-gray-100 shadow-sm space-y-10 relative overflow-hidden">
                        <div class="absolute -top-24 -right-24 w-48 h-48 bg-[#800000]/5 rounded-full blur-3xl"></div>

                        <div class="relative z-10">
                            <label class="text-[10px] font-black uppercase tracking-[0.3em] text-[#800000] ml-1">Event Name</label>
                            <input name="EventName" type="text" required value="{{ old('EventName', $event->EventName) }}"
                                   class="mt-3 w-full rounded-2xl bg-gray-50 border-2 border-transparent p-5 text-xl font-bold text-gray-900 focus:outline-none focus:border-[#800000]/20 focus:bg-white transition-all shadow-sm">
                        </div>

                        <div class="relative z-10">
                            <label class="text-[10px] font-black uppercase tracking-[0.3em] text-gray-400 ml-1">Location / Venue</label>
                            <input name="Location" type="text" value="{{ old('Location', $event->Location) }}"
                                   class="mt-3 w-full rounded-2xl bg-gray-50 border-2 border-transparent p-4 font-bold text-gray-900 focus:outline-none focus:border-[#800000]/20 focus:bg-white transition-all shadow-sm">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 relative z-10">
                            <div>
                                <label class="text-[10px] font-black uppercase tracking-[0.3em] text-gray-400 ml-1">Commencement Date</label>
                                <input name="StartDate" type="date" value="{{ old('StartDate', $event->StartDate ? $event->StartDate->format('Y-m-d') : '') }}"
                                       class="mt-3 w-full rounded-2xl bg-gray-50 border-2 border-transparent p-4 font-bold text-gray-900 focus:outline-none focus:border-[#800000]/20 focus:bg-white transition-all shadow-sm">
                            </div>
                            <div>
                                <label class="text-[10px] font-black uppercase tracking-[0.3em] text-gray-400 ml-1">Conclusion Date</label>
                                <input name="EndDate" type="date" value="{{ old('EndDate', $event->EndDate ? $event->EndDate->format('Y-m-d') : '') }}"
                                       class="mt-3 w-full rounded-2xl bg-gray-50 border-2 border-transparent p-4 font-bold text-gray-900 focus:outline-none focus:border-[#800000]/20 focus:bg-white transition-all shadow-sm">
                            </div>
                        </div>

                        <div class="relative z-10">
                            <label class="text-[10px] font-black uppercase tracking-[0.3em] text-gray-400 ml-1">Narrative Description</label>
                            <textarea name="Description" rows="5"
                                      class="mt-3 w-full rounded-3xl bg-gray-50 border-2 border-transparent p-5 font-medium text-gray-700 focus:outline-none focus:border-[#800000]/20 focus:bg-white transition-all leading-relaxed shadow-sm">{{ old('Description', $event->Description) }}</textarea>
                        </div>
                    </div>

                    {{-- Dynamic Games Section --}}
                    <div class="space-y-6">
                        <div class="flex items-center justify-between px-4">
                            <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em]">Included Sport Components</h3>
                            <button type="button" id="addGameBtn" class="flex items-center gap-2 px-6 py-2.5 bg-gray-900 text-white text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-[#800000] transition-all shadow-lg">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                                Add Component
                            </button>
                        </div>

                        <div id="gamesContainer" class="space-y-4">
                            @foreach($event->games as $i => $game)
                                <div class="relative group bg-white border border-gray-100 rounded-[2rem] p-8 shadow-sm transition-all hover:border-[#800000]/10">
                                    <input type="hidden" name="games[{{ $i }}][GameID]" value="{{ $game->GameID }}">
                                    <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-end">
                                        <div class="md:col-span-5">
                                            <label class="text-[9px] font-black uppercase tracking-widest text-gray-400 mb-2 block ml-1">Sport Name</label>
                                            <input name="games[{{ $i }}][GameName]" type="text" required value="{{ old("games.{$i}.GameName", $game->GameName) }}"
                                                   class="w-full rounded-xl bg-gray-50 border-0 p-4 font-bold text-gray-900 focus:ring-2 focus:ring-[#800000]/20 transition-all">
                                        </div>
                                        <div class="md:col-span-4">
                                            <label class="text-[9px] font-black uppercase tracking-widest text-gray-400 mb-2 block ml-1">Category</label>
                                            <select name="games[{{ $i }}][Category]" class="w-full rounded-xl bg-gray-50 border-0 p-4 font-bold text-gray-700 focus:ring-2 focus:ring-[#800000]/20 transition-all">
                                                <option value="Male" {{ old("games.{$i}.Category", $game->Category) == 'Male' ? 'selected' : '' }}>Male</option>
                                                <option value="Female" {{ old("games.{$i}.Category", $game->Category) == 'Female' ? 'selected' : '' }}>Female</option>
                                                <option value="Mixed" {{ old("games.{$i}.Category", $game->Category) == 'Mixed' ? 'selected' : '' }}>Mixed</option>
                                                <option value="Open" {{ old("games.{$i}.Category", $game->Category) == 'Open' ? 'selected' : '' }}>Open</option>
                                            </select>
                                        </div>
                                        <div class="md:col-span-2">
                                            <label class="text-[9px] font-black uppercase tracking-widest text-gray-400 mb-2 block ml-1">Cap.</label>
                                            <input name="games[{{ $i }}][Capacity]" type="number" min="0" value="{{ old("games.{$i}.Capacity", $game->Capacity) }}"
                                                   class="w-full rounded-xl bg-gray-50 border-0 p-4 font-bold text-gray-900 focus:ring-2 focus:ring-[#800000]/20 transition-all">
                                        </div>
                                        <div class="md:col-span-1 flex justify-center pb-1">
                                            <button type="button" class="remove-game p-3 text-gray-300 hover:text-red-600 transition-colors">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Right Column: Status & Sidebar --}}
                <div class="space-y-8">
                    {{-- Status Card --}}
                    <div class="bg-gray-900 rounded-[2.5rem] p-10 shadow-2xl shadow-gray-200">
                        <label class="text-[10px] font-black uppercase tracking-[0.3em] text-gray-500">Live Registry Status</label>
                        <div class="relative">
                            <select name="Status" class="mt-5 w-full rounded-2xl bg-white/5 border-0 p-5 font-bold text-white focus:outline-none focus:ring-2 focus:ring-[#800000] transition-all appearance-none">
                                <option value="Open" {{ old('Status', $event->Status)=='Open' ? 'selected' : '' }} class="text-black">OPEN (Active)</option>
                                <option value="Closed" {{ old('Status', $event->Status)=='Closed' ? 'selected' : '' }} class="text-black">CLOSED</option>
                                <option value="Cancelled" {{ old('Status', $event->Status)=='Cancelled' ? 'selected' : '' }} class="text-black">CANCELLED</option>
                            </select>
                            <div class="absolute right-5 top-1/2 mt-2.5 pointer-events-none text-gray-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </div>
                        </div>
                    </div>

                    {{-- Quick Info Card --}}
                    <div class="bg-white rounded-[2.5rem] p-10 border border-gray-100 shadow-sm">
                        <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em] mb-6">Editing Protocol</h3>
                        <ul class="space-y-6">
                            <li class="flex gap-4">
                                <span class="w-5 h-5 rounded-full bg-gray-50 text-[10px] font-black flex items-center justify-center shrink-0">1</span>
                                <p class="text-xs text-gray-500 font-medium leading-relaxed">Ensure <span class="text-gray-900 font-bold">Temporal Sync</span> between start and end dates.</p>
                            </li>
                            <li class="flex gap-4">
                                <span class="w-5 h-5 rounded-full bg-gray-50 text-[10px] font-black flex items-center justify-center shrink-0">2</span>
                                <p class="text-xs text-gray-500 font-medium leading-relaxed">Updating <span class="text-gray-900 font-bold">Capacity</span> will affect future intake immediately.</p>
                            </li>
                        </ul>
                    </div>

                    {{-- Form Actions --}}
                    <div class="pt-4 space-y-4">
                        <button type="submit" class="w-full py-5 bg-[#800000] text-white rounded-[1.5rem] font-black uppercase tracking-widest shadow-xl shadow-red-900/20 hover:scale-[1.02] active:scale-[0.98] transition-all">
                            Save Parameters
                        </button>
                        <a href="{{ route('admin.events.list') }}" class="block w-full py-4 bg-white text-gray-400 text-center rounded-[1.5rem] text-[10px] font-black uppercase tracking-widest border border-gray-100 hover:bg-gray-50 transition-all">
                            Discard Changes
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Template for new game --}}
<template id="gameTemplate">
    <div class="relative group bg-white border border-gray-100 rounded-[2rem] p-8 shadow-sm animate-in fade-in zoom-in-95 duration-300">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-end">
            <div class="md:col-span-5">
                <label class="text-[9px] font-black uppercase tracking-widest text-gray-400 mb-2 block ml-1">Sport Name</label>
                <input name="__GNAME__" type="text" required placeholder="e.g. Volleyball"
                       class="w-full rounded-xl bg-gray-50 border-0 p-4 font-bold text-gray-900 focus:ring-2 focus:ring-[#800000]/20 transition-all">
            </div>
            <div class="md:col-span-4">
                <label class="text-[9px] font-black uppercase tracking-widest text-gray-400 mb-2 block ml-1">Category</label>
                <select name="__GCAT__" class="w-full rounded-xl bg-gray-50 border-0 p-4 font-bold text-gray-700 focus:ring-2 focus:ring-[#800000]/20 transition-all">
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Mixed">Mixed</option>
                    <option value="Open">Open</option>
                </select>
            </div>
            <div class="md:col-span-2">
                <label class="text-[9px] font-black uppercase tracking-widest text-gray-400 mb-2 block ml-1">Cap.</label>
                <input name="__GCAP__" type="number" min="0" placeholder="0"
                       class="w-full rounded-xl bg-gray-50 border-0 p-4 font-bold text-gray-900 focus:ring-2 focus:ring-[#800000]/20 transition-all">
            </div>
            <div class="md:col-span-1 flex justify-center pb-1">
                <button type="button" class="remove-game p-3 text-gray-300 hover:text-red-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
(function(){
    const container = document.getElementById('gamesContainer');
    const template = document.getElementById('gameTemplate').innerHTML;
    const addBtn = document.getElementById('addGameBtn');

    let idx = {{ $event->games->count() }};

    function addRow() {
        let html = template
            .replace(/__GNAME__/g, `games[${idx}][GameName]`)
            .replace(/__GCAT__/g, `games[${idx}][Category]`)
            .replace(/__GCAP__/g, `games[${idx}][Capacity]`);

        const wrapper = document.createElement('div');
        wrapper.innerHTML = html;
        container.appendChild(wrapper.firstElementChild);

        const last = container.lastElementChild;
        last.querySelector('.remove-game').addEventListener('click', function(){ 
            last.classList.add('fade-out', 'zoom-out-95');
            setTimeout(() => last.remove(), 200);
        });
        idx++;
    }

    document.querySelectorAll('.remove-game').forEach(btn => {
        btn.addEventListener('click', function(){ 
            const row = this.closest('.relative');
            row.classList.add('fade-out', 'zoom-out-95');
            setTimeout(() => row.remove(), 200);
        });
    });

    addBtn.addEventListener('click', addRow);
})();
</script>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap');
    body { font-family: 'Plus Jakarta Sans', sans-serif; letter-spacing: -0.01em; }
    
    input[type="date"]::-webkit-calendar-picker-indicator {
        filter: invert(15%) sepia(95%) saturate(6932%) hue-rotate(358deg) brightness(95%) contrast(107%);
        cursor: pointer;
    }
</style>
@endsection