@extends('layouts.app')

@section('title', 'Student Announcements')

@section('content')
<div class="min-h-screen bg-[#F8FAFC] pb-24 font-sans antialiased">

    {{-- HEADER CARD (Student Style) --}}
    <div class="relative px-6 py-6">
        <div class="max-w-7xl mx-auto bg-white border border-slate-100 shadow-sm rounded-[2rem] px-10 py-8 flex flex-col md:flex-row items-center justify-between gap-8 relative overflow-hidden">

            {{-- Teal Glow --}}
            <div class="absolute -top-24 -right-24 w-64 h-64 bg-teal-500/5 rounded-full blur-3xl"></div>

            <div class="relative z-10">
                <h1 class="text-3xl font-black text-slate-900 tracking-tight leading-none uppercase italic">
                    STUDENT <span class="text-teal-600 not-italic">ANNOUNCEMENTS</span>
                </h1>
                <p class="text-[10px] uppercase tracking-[0.3em] text-slate-400 font-bold mt-2">
                    Campus Updates & Important Notices
                </p>
            </div>

            <div class="relative z-10 flex items-center gap-8 text-right">
                <div>
                    <span class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">
                        Available
                    </span>
                    <span class="text-3xl font-black text-slate-900 tabular-nums">
                        {{ $announcements->count() }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- CONTENT --}}
    <div class="max-w-7xl mx-auto px-6 mt-6">

        @if($announcements->isEmpty())
            <div class="bg-white rounded-[3rem] border-2 border-dashed border-slate-200 p-20 flex flex-col items-center text-center">
                <div class="w-20 h-20 bg-slate-50 rounded-3xl flex items-center justify-center mb-6">
                    <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2H7a2 2 0 00-2 2v2"/>
                    </svg>
                </div>
                <h3 class="text-xl font-black text-slate-900 uppercase">All Quiet</h3>
                <p class="text-slate-400 text-sm mt-2 max-w-xs font-medium">
                    No announcements available at the moment.
                </p>
            </div>
        @else
            {{-- ANNOUNCEMENT GRID --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($announcements as $announce)
                    <a href="{{ route('student.announcements.show', $announce->AnnouncementID) }}"
                       class="group relative bg-white rounded-[2.5rem] border border-slate-100 shadow-sm
                              hover:shadow-[0_20px_50px_-15px_rgba(13,148,136,0.15)]
                              transition-all duration-500 hover:-translate-y-2
                              flex flex-col h-full overflow-hidden">

                        {{-- IMAGE --}}
                        <div class="relative aspect-video overflow-hidden">
                            @if($announce->Image)
                                <img src="{{ asset('storage/'.$announce->Image) }}"
                                     class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            @else
                                <div class="w-full h-full bg-slate-100 flex items-center justify-center text-slate-300 italic text-xs font-bold uppercase tracking-widest">
                                    No Image
                                </div>
                            @endif

                            {{-- TAG --}}
                            <div class="absolute top-5 left-5">
                                <span class="px-3 py-1.5 bg-white/90 backdrop-blur-md rounded-xl
                                             text-[9px] font-black uppercase tracking-widest text-slate-900 shadow-sm">
                                    {{ $announce->Category ?? 'General' }}
                                </span>
                            </div>
                        </div>

                        {{-- CONTENT --}}
                        <div class="p-8 flex-1 flex flex-col">
                            <div class="mb-4">
                                <span class="text-[10px] font-black text-teal-600 uppercase tracking-widest opacity-70">
                                    {{ \Carbon\Carbon::parse($announce->Date)->format('d F Y') }}
                                </span>
                                <h3 class="text-xl font-black text-slate-900 mt-1 leading-tight line-clamp-2
                                           group-hover:text-teal-600 transition-colors">
                                    {{ $announce->Title }}
                                </h3>
                            </div>

                            <p class="text-sm text-slate-400 font-medium line-clamp-3 mb-8">
                                {{ Str::limit(strip_tags($announce->Description), 120) }}
                            </p>

                            <div class="mt-auto pt-6 border-t border-slate-100 flex justify-end">
                                <div class="text-[9px] font-black uppercase tracking-widest text-slate-300
                                            group-hover:text-teal-600 transition-colors flex items-center gap-2">
                                    View Details
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                              d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                    </svg>
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
</style>
@endsection
