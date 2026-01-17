@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-[#F8F9FA] pb-24 font-sans antialiased">
    
    {{-- Header --}}
    <div class="relative px-6 py-6">        
        <div class="max-w-7xl mx-auto bg-white border border-gray-100 shadow-sm rounded-[2rem] px-10 py-8 flex flex-col md:flex-row items-center justify-between gap-8 relative overflow-hidden">
            <div class="absolute -top-24 -right-24 w-64 h-64 bg-[#800000]/5 rounded-full blur-3xl"></div>

            <div class="relative z-10 flex items-center gap-5">
                <a href="{{ route('admin.gameinfo.index') }}"
                   class="group flex items-center justify-center w-12 h-12 bg-gray-50 rounded-2xl hover:bg-[#800000] hover:text-white transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                              d="M15 19l-7-7 7-7" />
                    </svg>
                </a>

                <div>
                    <h1 class="text-3xl font-black uppercase italic">
                        EDIT <span class="text-[#800000] not-italic">GAME</span>
                    </h1>
                    <p class="text-[10px] uppercase tracking-[0.3em] text-gray-400 font-bold mt-2">
                        Game ID #{{ $game->GameID }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Main --}}
    <div class="max-w-7xl mx-auto px-6 mt-6">

        {{-- Alerts --}}
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl text-green-700 font-bold">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 p-6 bg-red-50 border border-red-200 rounded-xl text-red-700">
                <ul class="list-disc pl-6 text-sm font-bold">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.gameinfo.update', $game->GameID) }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- LEFT --}}
                <div class="lg:col-span-2 space-y-8">

                    {{-- Game Identity --}}
                    <div class="bg-white rounded-[2rem] p-10 border shadow-sm space-y-6">

                        <input name="GameName" required
                               value="{{ old('GameName', $game->GameName) }}"
                               placeholder="Game Name"
                               class="w-full rounded-xl bg-gray-50 p-4 text-xl font-bold">

                        <select name="Category"
                                class="w-full rounded-xl bg-gray-50 p-4 font-bold">
                            @foreach(['Male','Female','Mixed','Open'] as $cat)
                                <option value="{{ $cat }}"
                                    {{ old('Category', $game->Category) === $cat ? 'selected' : '' }}>
                                    {{ $cat }}
                                </option>
                            @endforeach
                        </select>

                        <input type="number" name="Capacity" min="0"
                               value="{{ old('Capacity', $game->Capacity) }}"
                               placeholder="Capacity"
                               class="w-full rounded-xl bg-gray-50 p-4 font-bold">
                    </div>

                    {{-- Rules --}}
                    <div class="bg-white rounded-[2rem] p-10 border shadow-sm space-y-6">
                        <textarea name="Rules" rows="6"
                                  placeholder="Rules & Regulations"
                                  class="w-full rounded-2xl bg-gray-50 p-5 font-semibold">{{ old('Rules', $game->Rules) }}</textarea>

                        <textarea name="Description" rows="4"
                                  placeholder="Game Description"
                                  class="w-full rounded-2xl bg-gray-50 p-5">{{ old('Description', $game->Description) }}</textarea>
                    </div>
                </div>

                {{-- RIGHT --}}
                <div class="space-y-8">

                    {{-- Status --}}
                    <div class="bg-gray-900 rounded-[2rem] p-8 text-white">
                        <select name="Status"
                                class="w-full rounded-xl p-4 font-bold text-black">
                            @foreach(['Open','Closed','Cancelled'] as $st)
                                <option value="{{ $st }}"
                                    {{ old('Status', $game->Status) === $st ? 'selected' : '' }}>
                                    {{ strtoupper($st) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Schedule --}}
                    <div class="bg-white rounded-[2rem] p-8 border shadow-sm space-y-4">
                        <input type="date" name="GameDate"
                               value="{{ old('GameDate', $game->GameDate?->format('Y-m-d')) }}"
                               class="w-full rounded-xl bg-gray-50 p-4 font-bold">

                        <div class="grid grid-cols-2 gap-4">
                            <input type="time" name="TimeStart"
                                   value="{{ old('TimeStart', $game->TimeStart) }}"
                                   class="rounded-xl bg-gray-50 p-4 font-bold">

                            <input type="time" name="TimeEnd"
                                   value="{{ old('TimeEnd', $game->TimeEnd) }}"
                                   class="rounded-xl bg-gray-50 p-4 font-bold">
                        </div>
                    </div>

                    {{-- Logistics --}}
                    <div class="bg-white rounded-[2rem] p-8 border shadow-sm space-y-4">
                        <input name="SelectionPlace"
                               value="{{ old('SelectionPlace', $game->SelectionPlace) }}"
                               placeholder="Venue / Selection Place"
                               class="w-full rounded-xl bg-gray-50 p-4 font-bold">

                        <input name="CoachName"
                               value="{{ old('CoachName', $game->CoachName) }}"
                               placeholder="Coach Name"
                               class="w-full rounded-xl bg-gray-50 p-4 font-bold">

                        <input name="CoachPhone"
                               value="{{ old('CoachPhone', $game->CoachPhone) }}"
                               placeholder="Coach Phone"
                               class="w-full rounded-xl bg-gray-50 p-4 font-bold">
                    </div>

                    {{-- Actions --}}
                    <button type="submit"
                            class="w-full py-4 bg-[#800000] text-white rounded-xl font-black uppercase">
                        Save Changes
                    </button>

                    <a href="{{ route('admin.gameinfo.index') }}"
                       class="block text-center text-xs font-bold text-gray-400 mt-2">
                        Cancel
                    </a>

                </div>
            </div>
        </form>
    </div>
</div>
@endsection
