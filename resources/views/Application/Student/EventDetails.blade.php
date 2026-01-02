@extends('layouts.app')

@section('title', $event->EventName)

@section('content')
@php
    $dateRange = $event->StartDate
        ? \Carbon\Carbon::parse($event->StartDate)->format('d M Y') .
          ($event->EndDate ? ' – ' . \Carbon\Carbon::parse($event->EndDate)->format('d M Y') : '')
        : 'Date TBA';
@endphp

<div class="min-h-screen bg-[#F8FAFC] pb-24 font-sans antialiased">

    {{-- HERO --}}
    <div class="px-6 py-8">
        <div class="max-w-7xl mx-auto relative overflow-hidden rounded-[3rem] bg-white
                    border border-slate-100 shadow-sm">

            <div class="absolute -top-32 -right-32 w-96 h-96 bg-teal-500/5 rounded-full blur-3xl"></div>

            <div class="relative z-10 px-12 py-14">
                <a href="{{ route('student.application.index') }}"
                   class="inline-flex items-center gap-2 text-xs font-black uppercase tracking-widest
                          text-slate-400 hover:text-teal-600 transition mb-8">
                    ← Back to Events
                </a>

                <h1 class="text-4xl md:text-5xl font-black italic uppercase tracking-tight text-slate-900">
                    {{ $event->EventName }}
                </h1>

                <div class="mt-4 flex flex-wrap items-center gap-6 text-sm text-slate-600">
                    <span class="flex items-center gap-2">
                        📍 {{ $event->Location ?? 'Location TBA' }}
                    </span>
                    <span class="flex items-center gap-2">
                        📅 {{ $dateRange }}
                    </span>
                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest
                                 bg-emerald-50 text-emerald-700">
                        OPEN
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- CONTENT --}}
    <div class="max-w-7xl mx-auto px-6 mt-10 grid grid-cols-1 lg:grid-cols-12 gap-10">

        {{-- DESCRIPTION --}}
        <div class="lg:col-span-8">
            <div class="bg-white rounded-[3rem] border border-slate-100 shadow-sm p-10 md:p-14">

                <h2 class="text-[11px] font-black uppercase tracking-[0.35em] text-teal-600 mb-8">
                    Event Overview
                </h2>

                <div class="prose prose-lg max-w-none text-slate-700 leading-relaxed">
                    {!! nl2br(e($event->Description ?? 'No description provided.')) !!}
                </div>
            </div>
        </div>

        {{-- SIDEBAR --}}
        <div class="lg:col-span-4 space-y-8">

            <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm p-8">
                <h3 class="text-[11px] font-black uppercase tracking-[0.35em] text-slate-400 mb-6">
                    Event Info
                </h3>

                <div class="space-y-5 text-sm text-slate-700">
                    <div>
                        <p class="text-xs text-slate-400 uppercase font-bold">Location</p>
                        <p class="font-semibold">{{ $event->Location ?? 'TBA' }}</p>
                    </div>

                    <div>
                        <p class="text-xs text-slate-400 uppercase font-bold">Date</p>
                        <p class="font-semibold">{{ $dateRange }}</p>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- SPORTS --}}
    <div class="max-w-7xl mx-auto px-6 mt-20">

        <h2 class="text-2xl font-black italic uppercase tracking-tight text-slate-900 mb-8">
            Available <span class="text-teal-600 not-italic">Sports</span>
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">

            @foreach($event->games as $game)
                <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm
                            hover:shadow-[0_20px_50px_-15px_rgba(13,148,136,0.15)]
                            transition-all duration-500 hover:-translate-y-2
                            p-8 flex flex-col justify-between">

                    <span class="px-3 py-1 rounded-lg text-[9px] font-black uppercase tracking-widest
                                 bg-teal-50 text-teal-700 w-fit mb-6">
                        {{ strtoupper($game->Category ?? 'OPEN') }}
                    </span>

                    <div>
                        <h3 class="text-xl font-black text-slate-900">
                            {{ $game->GameName }}
                        </h3>
                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mt-2">
                            Intake: {{ $game->applied ?? 0 }} athletes
                        </p>
                    </div>

                    <div class="mt-6">
                        <p class="text-xs text-slate-400 uppercase font-bold">Capacity</p>
                        <p class="text-2xl font-black text-slate-900">
                            {{ $game->Capacity ?? '-' }}
                        </p>
                    </div>

                    <div class="mt-8">
                        @if($game->applied > 0)
                            <span class="block text-center py-3 rounded-xl
                                         bg-teal-100 text-teal-700
                                         text-xs font-black uppercase tracking-widest">
                                Applied
                            </span>
                        @else
                            <button
                                class="apply-btn block w-full text-center py-3 rounded-xl
                                       bg-teal-600 text-white
                                       text-xs font-black uppercase tracking-widest
                                       shadow-lg shadow-teal-600/20
                                       hover:brightness-110 transition"
                                data-url="{{ route('student.application.submit', $game->GameID) }}"
                                data-event="{{ $event->EventName }}"
                                data-game="{{ $game->GameName }}">
                                Apply
                            </button>
                        @endif
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</div>

@endsection
