@extends('layouts.app')

@section('title', 'Game Information')

@section('content')
<div class="min-h-screen bg-[#F8FAFC] pb-24 font-sans antialiased">

    {{-- Header --}}
    <div class="px-6 py-8">
        <div class="max-w-7xl mx-auto bg-white rounded-[2.5rem] border border-slate-100
                    px-10 py-8 flex items-center justify-between shadow-sm relative overflow-hidden">

            <div class="absolute -top-24 -right-24 w-72 h-72 bg-teal-500/5 rounded-full blur-3xl"></div>

            <div>
                <h1 class="text-3xl font-black italic uppercase tracking-tight text-slate-900">
                    Game <span class="text-teal-600 not-italic">Information</span>
                </h1>
                <p class="text-[10px] uppercase tracking-[0.35em] text-slate-400 font-bold mt-2">
                    View Game Details & Requirements
                </p>
            </div>

            <div class="text-right">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1">
                    Total Events
                </p>
                <p class="text-3xl font-black text-slate-900">
                    {{ $events->count() }}
                </p>
            </div>
        </div>
    </div>

    {{-- Content --}}
    <div class="max-w-7xl mx-auto px-6 space-y-24">

        @foreach($events as $event)
            <section>
                <div class="flex items-center gap-4 mb-8">
                    <span class="w-3 h-3 rounded-full bg-teal-400"></span>
                    <h2 class="text-3xl font-black italic uppercase tracking-tight text-slate-900">
                        {{ $event->EventName }}
                    </h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach($event->games as $game)
                        <a href="{{ route('student.gameinfo.show', $game->GameID) }}"
                           class="group bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-sm
                                  hover:shadow-[0_20px_50px_-15px_rgba(13,148,136,0.15)]
                                  transition-all duration-500 hover:-translate-y-2">

                            <span class="px-3 py-1 rounded-lg text-[9px] font-black uppercase tracking-widest
                                         bg-teal-50 text-teal-700">
                                {{ $game->Category ?? 'OPEN' }}
                            </span>

                            <h3 class="mt-6 text-xl font-black text-slate-900 group-hover:text-teal-600">
                                {{ $game->GameName }}
                            </h3>

                            <div class="mt-8 flex justify-between items-end">
                                <div>
                                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">
                                        Capacity
                                    </p>
                                    <p class="text-2xl font-black text-slate-900">
                                        {{ $game->Capacity ?? '-' }}
                                    </p>
                                </div>

                                <span class="text-teal-600 opacity-0 group-hover:opacity-100 transition">
                                    →
                                </span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </section>
        @endforeach

    </div>
</div>
@endsection
