@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-[#F8F9FA] pb-24 font-sans antialiased">
    
    {{-- Aesthetic Header Card: Consistent with Index Page --}}
    <div class="relative px-6 py-6">        
        <div class="max-w-7xl mx-auto bg-white border border-gray-100 shadow-sm rounded-[2rem] px-10 py-8 flex flex-col md:flex-row items-center justify-between gap-8 relative overflow-hidden">
            {{-- Subtle Background Glow --}}
            <div class="absolute -top-24 -right-24 w-64 h-64 bg-[#800000]/5 rounded-full blur-3xl"></div>

            <div class="relative z-10 flex items-center gap-5">
                <a href="{{ route('admin.gameinfo.index') }}" class="group flex items-center justify-center w-12 h-12 bg-gray-50 rounded-2xl hover:bg-[#800000] hover:text-white transition-all duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <div class="h-10 w-px bg-gray-100 hidden md:block"></div>
                <div>
                    <h1 class="text-3xl font-[900] text-gray-900 tracking-tight leading-none uppercase italic">EDIT <span class="text-[#800000] not-italic">GAME</span></h1>
                    <p class="text-[10px] uppercase tracking-[0.3em] text-gray-400 font-bold mt-2">Refining #{{ $game->GameID }} Parameters</p>
                </div>
            </div>

            <div class="relative z-10 hidden md:block">
                <div class="px-5 py-2 bg-gray-50 rounded-xl border border-gray-100 text-[10px] font-black text-gray-400 tracking-widest uppercase">
                    System Entry Asset
                </div>
            </div>
        </div>
    </div>

    {{-- Main Form Body: Standardized max-w-7xl to match Index --}}
    <div class="max-w-7xl mx-auto px-6 mt-6 animate-in fade-in slide-in-from-bottom-4 duration-700">
        
        {{-- Notification Alerts --}}
        @if(session('success'))
            <div class="mb-8 p-5 rounded-[1.5rem] bg-green-50 border border-green-100 text-green-700 text-sm font-bold flex items-center gap-3">
                <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-8 p-8 rounded-[2rem] bg-red-50 border border-red-100 text-red-800">
                <p class="text-xs font-black uppercase tracking-widest mb-4 text-red-400">Validation Errors Detected</p>
                <ul class="list-disc pl-5 space-y-1 text-sm font-bold">
                    @foreach($errors->all() as $err) <li>{{ $err }}</li> @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.gameinfo.update', $game->GameID) }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
                
                {{-- Left Column: Form Details --}}
                <div class="lg:col-span-2 space-y-8">
                    {{-- Primary Info Bento --}}
                    <div class="bg-white rounded-[2.5rem] p-10 md:p-12 border border-gray-100 shadow-sm space-y-10 relative overflow-hidden">
                        <div class="absolute -top-24 -right-24 w-48 h-48 bg-[#800000]/5 rounded-full blur-3xl"></div>

                        <div class="relative z-10">
                            <label class="text-[10px] font-black uppercase tracking-[0.3em] text-[#800000] ml-1">Game Identity</label>
                            <input name="GameName" type="text" required value="{{ old('GameName', $game->GameName) }}"
                                   placeholder="e.g. Football (Men)"
                                   class="mt-3 w-full rounded-2xl bg-gray-50 border-2 border-transparent p-5 text-xl font-bold text-gray-900 focus:outline-none focus:border-[#800000]/20 focus:bg-white transition-all shadow-sm" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 relative z-10">
                            <div>
                                <label class="text-[10px] font-black uppercase tracking-[0.3em] text-gray-400 ml-1">Category Group</label>
                                <div class="relative">
                                    <select name="Category" class="mt-3 w-full rounded-2xl bg-gray-50 border-2 border-transparent p-5 font-bold text-gray-700 focus:outline-none focus:border-[#800000]/20 focus:bg-white transition-all appearance-none shadow-sm">
                                        <option value="Male" {{ old('Category', $game->Category) == 'Male' ? 'selected':'' }}>Male</option>
                                        <option value="Female" {{ old('Category', $game->Category) == 'Female' ? 'selected':'' }}>Female</option>
                                        <option value="Mixed" {{ old('Category', $game->Category) == 'Mixed' ? 'selected':'' }}>Mixed</option>
                                        <option value="Open" {{ old('Category', $game->Category) == 'Open' ? 'selected':'' }}>Open</option>
                                    </select>
                                    <div class="absolute right-5 top-1/2 mt-1.5 pointer-events-none text-gray-400">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label class="text-[10px] font-black uppercase tracking-[0.3em] text-gray-400 ml-1">Seat Capacity</label>
                                <input name="Capacity" type="number" min="0" value="{{ old('Capacity', $game->Capacity) }}"
                                       class="mt-3 w-full rounded-2xl bg-gray-50 border-2 border-transparent p-5 font-bold text-gray-900 focus:outline-none focus:border-[#800000]/20 focus:bg-white transition-all shadow-sm" />
                            </div>
                        </div>
                    </div>

                    {{-- Requirements Bento --}}
                    <div class="bg-white rounded-[2.5rem] p-10 md:p-12 border border-gray-100 shadow-sm space-y-10">
                        <div>
                            <label class="text-[10px] font-black uppercase tracking-[0.3em] text-gray-400 ml-1">Rules & Regulations</label>
                            <textarea name="Rules" rows="6" class="mt-3 w-full rounded-3xl bg-gray-50 border-2 border-transparent p-6 font-semibold text-gray-700 focus:outline-none focus:border-[#800000]/20 focus:bg-white transition-all leading-relaxed shadow-sm">{{ old('Rules', $game->Rules) }}</textarea>
                            <div class="flex items-center gap-2 mt-4 ml-1">
                                <div class="w-1 h-1 rounded-full bg-[#800000]"></div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter italic text-opacity-70">Tip: New line for each rule to generate list.</p>
                            </div>
                        </div>
                        <div>
                            <label class="text-[10px] font-black uppercase tracking-[0.3em] text-gray-400 ml-1">Brief Description</label>
                            <textarea name="Description" rows="3" class="mt-3 w-full rounded-3xl bg-gray-50 border-2 border-transparent p-6 font-semibold text-gray-700 focus:outline-none focus:border-[#800000]/20 focus:bg-white transition-all shadow-sm">{{ old('Description', $game->Description) }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- Right Column: Side Settings --}}
                <div class="space-y-8">
                    {{-- Status Card --}}
                    <div class="bg-gray-900 rounded-[2.5rem] p-10 shadow-2xl shadow-gray-200">
                        <label class="text-[10px] font-black uppercase tracking-[0.3em] text-gray-500">Live Availability</label>
                        <div class="relative">
                            <select name="Status" class="mt-5 w-full rounded-2xl bg-white/5 border-0 p-5 font-bold text-white focus:outline-none focus:ring-2 focus:ring-[#800000] transition-all appearance-none">
                                <option class="text-black" value="Open" {{ old('Status', $game->Status) == 'Open' ? 'selected':'' }}>OPEN (Live)</option>
                                <option class="text-black" value="Closed" {{ old('Status', $game->Status) == 'Closed' ? 'selected':'' }}>CLOSED</option>
                                <option class="text-black" value="Cancelled" {{ old('Status', $game->Status) == 'Cancelled' ? 'selected':'' }}>CANCELLED</option>
                            </select>
                            <div class="absolute right-5 top-1/2 mt-2.5 pointer-events-none text-gray-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </div>
                        </div>
                    </div>

                    {{-- Logistics Card --}}
                    <div class="bg-white rounded-[2.5rem] p-10 border border-gray-100 shadow-sm space-y-8">
                        <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em]">Logistics</h3>
                        <div>
                            <label class="text-[10px] font-black uppercase tracking-widest text-gray-300">Venue</label>
                            <input name="SelectionPlace" type="text" value="{{ old('SelectionPlace', $game->SelectionPlace) }}"
                                   class="mt-2 w-full rounded-xl bg-gray-50 border-0 p-4 font-bold text-gray-800 focus:ring-2 focus:ring-[#800000]/20" />
                        </div>
                        <div>
                            <label class="text-[10px] font-black uppercase tracking-widest text-gray-300">Date</label>
                            <input name="GameDate" type="date" value="{{ old('GameDate', $game->GameDate ?? '') }}"
                                   class="mt-2 w-full rounded-xl bg-gray-50 border-0 p-4 font-bold text-gray-800 focus:ring-2 focus:ring-[#800000]/20" />
                        </div>
                    </div>

                    {{-- Staff Card --}}
                    <div class="bg-white rounded-[2.5rem] p-10 border border-gray-100 shadow-sm space-y-8">
                        <h3 class="text-[10px] font-black text-[#800000] uppercase tracking-[0.3em]">Personnel</h3>
                        <div>
                            <label class="text-[10px] font-black uppercase tracking-widest text-gray-300">Coach Name</label>
                            <input name="CoachName" type="text" value="{{ old('CoachName', $game->CoachName) }}"
                                   class="mt-2 w-full rounded-xl bg-gray-50 border-0 p-4 font-bold text-gray-800 focus:ring-2 focus:ring-[#800000]/20" />
                        </div>
                        <div>
                            <label class="text-[10px] font-black uppercase tracking-widest text-gray-300">Contact</label>
                            <input name="CoachPhone" type="text" value="{{ old('CoachPhone', $game->CoachPhone) }}"
                                   class="mt-2 w-full rounded-xl bg-gray-50 border-0 p-4 font-bold text-gray-800 focus:ring-2 focus:ring-[#800000]/20" />
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="pt-4 space-y-4">
                        <button type="submit" class="w-full py-5 bg-[#800000] text-white rounded-[1.5rem] font-black uppercase tracking-widest shadow-xl shadow-red-900/20 hover:scale-[1.02] active:scale-[0.98] transition-all">
                            Save Changes
                        </button>
                        <a href="{{ route('admin.gameinfo.index') }}" class="block w-full py-4 bg-white text-gray-400 text-center rounded-[1.5rem] text-[10px] font-black uppercase tracking-widest border border-gray-100 hover:bg-gray-50 transition-all">
                            Discard Edits
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap');
    body { font-family: 'Plus Jakarta Sans', sans-serif; }
    
    input[type="date"]::-webkit-calendar-picker-indicator {
        filter: invert(15%) sepia(95%) saturate(6932%) hue-rotate(358deg) brightness(95%) contrast(107%);
        cursor: pointer;
    }
</style>
@endsection