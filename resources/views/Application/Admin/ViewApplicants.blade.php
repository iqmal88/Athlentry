@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-[#F8F9FA] pb-24 font-sans antialiased">
    
    {{-- Aesthetic Header Card --}}
    <div class="relative px-6 py-6">        
        <div class="max-w-7xl mx-auto bg-white border border-gray-100 shadow-sm rounded-[2rem] px-10 py-8 flex flex-col md:flex-row items-center justify-between gap-8 relative overflow-hidden">
            <div class="absolute -top-24 -right-24 w-64 h-64 bg-[#800000]/5 rounded-full blur-3xl"></div>

            <div class="relative z-10 flex items-center gap-5">
                <a href="{{ route('admin.events.list') }}"
                   class="group flex items-center justify-center w-12 h-12 bg-gray-50 rounded-2xl hover:bg-[#800000] hover:text-white transition-all duration-300">
                    ←
                </a>
                <div>
                    <h1 class="text-3xl font-black text-gray-900 tracking-tight leading-none uppercase italic">
                        {{ $game->GameName }}
                        <span class="text-[#800000] not-italic">APPLICANTS</span>
                    </h1>
                    <p class="text-[10px] uppercase tracking-[0.3em] text-gray-400 font-bold mt-2">
                        Registry & Selection Protocol
                    </p>
                </div>
            </div>

            <div class="relative z-10 text-right">
                <span class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">
                    Applicants
                </span>
                <span class="text-3xl font-black text-gray-900">
                    {{ $applications->count() }}
                </span>
            </div>
        </div>
    </div>

    {{-- Main Content --}}
    <div class="max-w-7xl mx-auto px-6 mt-6">
        @foreach($applications as $app)
            @php
                $userName = optional($app->user)->Name ?? 'Student';
                $initials = strtoupper(substr($userName, 0, 1));
                $status   = $app->ApplicationStatus;
            @endphp

            <div class="group relative bg-white rounded-[2rem] p-8 border border-gray-100 shadow-sm flex flex-col md:flex-row items-center justify-between gap-6 mb-4">

                {{-- Profile --}}
                <div class="flex items-center gap-6 flex-1">
                    <div class="w-16 h-16 rounded-2xl bg-gray-900 flex items-center justify-center text-white text-xl font-black italic">
                        {{ $initials }}
                    </div>
                    <div>
                        <a href="{{ route('admin.applications.show', $app->ApplicationID) }}"
                           class="text-xl font-black uppercase hover:text-[#800000]">
                            {{ $userName }}
                        </a>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-1">
                            {{ \Carbon\Carbon::parse($app->DateApplied)->format('d M Y') }}
                        </p>
                    </div>
                </div>

                {{-- STATUS BADGE (APPLICATION STATUS) --}}
                <div>
                    @if($status === 'approved')
                        <div class="px-4 py-1.5 bg-green-50 border border-green-100 rounded-full">
                            <span class="text-[10px] font-black text-green-700 uppercase tracking-widest">
                                Approved (Selection)
                            </span>
                        </div>
                    @elseif($status === 'rejected')
                        <div class="px-4 py-1.5 bg-red-50 border border-red-100 rounded-full">
                            <span class="text-[10px] font-black text-red-700 uppercase tracking-widest">
                                Rejected
                            </span>
                        </div>
                    @elseif($status === 'withdrawn')
                        <div class="px-4 py-1.5 bg-gray-100 border border-gray-200 rounded-full">
                            <span class="text-[10px] font-black text-gray-500 uppercase tracking-widest">
                                Withdrawn
                            </span>
                        </div>
                    @else
                        <div class="px-4 py-1.5 bg-gray-50 border border-gray-100 rounded-full">
                            <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">
                                Pending
                            </span>
                        </div>
                    @endif
                </div>

                {{-- ACTION (QUICK APPROVE / REJECT) --}}
                <div>
                    @if($status === 'pending')
                        <div class="flex gap-2">
                            {{-- APPROVE --}}
                            <form method="POST"
                                  action="{{ route('admin.applications.select', $app->ApplicationID) }}">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="action" value="approve">
                                <button class="px-8 py-3 bg-gray-900 text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-[#800000] transition">
                                    Approve
                                </button>
                            </form>

                            {{-- REJECT --}}
                            <form method="POST"
                                  action="{{ route('admin.applications.select', $app->ApplicationID) }}">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="action" value="reject">
                                <button class="px-8 py-3 bg-red-600 text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-red-700 transition">
                                    Reject
                                </button>
                            </form>
                        </div>
                    @else
                        <button disabled
                            class="px-8 py-3 bg-gray-50 text-gray-300 border border-gray-100 rounded-xl text-[10px] font-black uppercase cursor-not-allowed">
                            Finalised
                        </button>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
