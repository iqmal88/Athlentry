@extends('layouts.app')

@section('title', $game->GameName)

@section('content')
@php
    $event = $game->event;
    $date = $game->GameDate
        ? \Carbon\Carbon::parse($game->GameDate)->format('d F Y')
        : 'To be announced';

    $time = $game->GameTime
        ? \Carbon\Carbon::parse($game->GameTime)->format('h:i A')
        : 'TBA';
@endphp

<div class="min-h-screen bg-[#F8FAFC] pb-24 font-sans antialiased">

    {{-- HERO --}}
    <div class="px-6 py-8">
        <div class="max-w-7xl mx-auto bg-white rounded-[3rem] border border-slate-100
                    px-12 py-12 shadow-sm relative overflow-hidden">

            <div class="absolute -top-24 -right-24 w-96 h-96 bg-teal-500/5 rounded-full blur-3xl"></div>

            <a href="{{ route('student.gameinfo.index') }}"
               class="inline-flex items-center gap-3 text-xs font-black uppercase tracking-widest
                      text-slate-400 hover:text-teal-600 transition mb-8">
                ← Back to Games
            </a>

            <div class="relative z-10">
                <span class="inline-block px-4 py-1 rounded-full text-[10px] font-black uppercase tracking-widest
                             bg-teal-50 text-teal-700 mb-6">
                    {{ $game->Category ?? 'OPEN' }}
                </span>

                <h1 class="text-4xl md:text-5xl font-black italic uppercase tracking-tight text-slate-900">
                    {{ $game->GameName }}
                </h1>

                <p class="mt-3 text-sm text-slate-500 font-medium">
                    Event: <span class="font-semibold text-slate-700">{{ $event->EventName }}</span>
                </p>
            </div>
        </div>
    </div>

    {{-- CONTENT --}}
    <div class="max-w-7xl mx-auto px-6 mt-10 grid grid-cols-1 lg:grid-cols-12 gap-10">

        {{-- LEFT: DESCRIPTION --}}
        <div class="lg:col-span-8">
            <div class="bg-white rounded-[3rem] border border-slate-100 shadow-sm p-12">

                <div class="flex items-center gap-4 mb-10">
                    <h2 class="text-[10px] font-black uppercase tracking-[0.35em] text-teal-600">
                        Game Overview
                    </h2>
                    <div class="flex-1 h-px bg-slate-100"></div>
                </div>

                <div class="prose prose-lg max-w-none text-slate-600 leading-relaxed">
                    {!! nl2br(e($game->Description ?? 'No description provided for this game.')) !!}
                </div>

                @if($game->Rules)
                    <div class="mt-12">
                        <h3 class="text-sm font-black uppercase tracking-widest text-slate-700 mb-3">
                            Rules & Requirements
                        </h3>
                        <div class="bg-slate-50 rounded-2xl p-6 text-sm text-slate-600 leading-relaxed">
                            {!! nl2br(e($game->Rules)) !!}
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- RIGHT: INFO PANEL --}}
        <div class="lg:col-span-4 space-y-8">

            <div class="bg-slate-900 rounded-[2.5rem] p-10 text-white shadow-xl relative overflow-hidden">
                <div class="absolute -bottom-24 -right-24 w-72 h-72 bg-teal-500/10 rounded-full blur-3xl"></div>

                <h3 class="text-[10px] font-black uppercase tracking-[0.35em] text-slate-400 mb-10">
                    Game Details
                </h3>

                <div class="space-y-10 relative z-10">

                    {{-- DATE --}}
                    <div class="flex gap-5">
                        <div class="w-12 h-12 rounded-2xl bg-white/5 flex items-center justify-center text-teal-400">
                            📅
                        </div>
                        <div>
                            <p class="text-[9px] font-black uppercase tracking-widest text-slate-400 mb-1">
                                Date
                            </p>
                            <p class="text-lg font-bold">{{ $date }}</p>
                        </div>
                    </div>

                    {{-- TIME --}}
                    <div class="flex gap-5">
                        <div class="w-12 h-12 rounded-2xl bg-white/5 flex items-center justify-center text-teal-400">
                            ⏰
                        </div>
                        <div>
                            <p class="text-[9px] font-black uppercase tracking-widest text-slate-400 mb-1">
                                Time
                            </p>
                            <p class="text-lg font-bold">{{ $time }}</p>
                        </div>
                    </div>

                    {{-- LOCATION --}}
                    <div class="flex gap-5">
                        <div class="w-12 h-12 rounded-2xl bg-white/5 flex items-center justify-center text-teal-400">
                            📍
                        </div>
                        <div>
                            <p class="text-[9px] font-black uppercase tracking-widest text-slate-400 mb-1">
                                Selection Venue
                            </p>
                            <p class="text-lg font-bold">
                                {{ $game->SelectionPlace ?? 'TBA' }}
                            </p>
                        </div>
                    </div>

                    {{-- CAPACITY --}}
                    <div class="flex gap-5">
                        <div class="w-12 h-12 rounded-2xl bg-white/5 flex items-center justify-center text-teal-400">
                            👥
                        </div>
                        <div>
                            <p class="text-[9px] font-black uppercase tracking-widest text-slate-400 mb-1">
                                Capacity
                            </p>
                            <p class="text-lg font-bold">
                                {{ $game->Capacity ?? '-' }} Athletes
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- APPLY --}}
            <div class="bg-white rounded-[2rem] border border-slate-100 p-8 shadow-sm">
                <a href="{{ route('student.application.index') }}"
                   class="block w-full text-center py-4 rounded-2xl
                          bg-teal-600 text-white
                          text-xs font-black uppercase tracking-widest
                          shadow-lg shadow-teal-600/30
                          hover:brightness-110 transition">
                    Apply for This Game
                </a>
            </div>

        </div>
    </div>
</div>
@endsection
