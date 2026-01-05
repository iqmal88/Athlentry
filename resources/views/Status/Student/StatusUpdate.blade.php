@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#F8F9FA] pb-24 font-sans antialiased">

    {{-- HEADER --}}
    <div class="px-6 py-6">
        <div class="max-w-6xl mx-auto bg-white rounded-[2rem] px-10 py-8 border border-gray-100 shadow-sm">
            <h1 class="text-3xl font-black uppercase italic">
                My <span class="text-[#800000] not-italic">Status Update</span>
            </h1>
            <p class="text-[10px] uppercase tracking-[0.3em] text-gray-400 font-bold mt-2">
                Application & Selection Status Overview
            </p>
        </div>
    </div>

    {{-- CONTENT --}}
    <div class="max-w-6xl mx-auto px-6 space-y-16">

        @forelse($events as $event)

            {{-- EVENT --}}
            <section>
                <h2 class="text-2xl font-black uppercase italic text-gray-900 mb-6">
                    {{ $event->EventName }}
                </h2>

                <div class="space-y-6">

                    @foreach($event->games as $game)
                        @foreach($game->applications as $app)

                            {{-- APPLICATION CARD --}}
                            <div class="bg-white rounded-[2rem] p-8 border border-gray-100 shadow-sm">

                                {{-- GAME HEADER --}}
                                <div class="flex justify-between items-start mb-6">
                                    <div>
                                        <h3 class="text-xl font-black text-gray-900">
                                            {{ $game->GameName }}
                                        </h3>
                                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                                            Applied {{ \Carbon\Carbon::parse($app->DateApplied)->format('d M Y') }}
                                        </p>
                                    </div>
                                </div>

                                {{-- STATUS GRID --}}
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                                    {{-- APPLICATION STATUS --}}
                                    <div>
                                        <p class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">
                                            Application Status
                                        </p>

                                        @switch($app->ApplicationStatus)
                                            @case('pending')
                                                <span class="px-4 py-2 bg-yellow-50 text-yellow-700 rounded-full text-xs font-black uppercase">
                                                    Under Review
                                                </span>
                                                @break

                                            @case('approved')
                                                <span class="px-4 py-2 bg-green-50 text-green-700 rounded-full text-xs font-black uppercase">
                                                    Approved
                                                </span>
                                                @break

                                            @case('rejected')
                                                <span class="px-4 py-2 bg-red-50 text-red-700 rounded-full text-xs font-black uppercase">
                                                    Rejected
                                                </span>
                                                @break

                                            @default
                                                <span class="px-4 py-2 bg-gray-100 text-gray-500 rounded-full text-xs font-black uppercase">
                                                    Withdrawn
                                                </span>
                                        @endswitch
                                    </div>

                                    {{-- SELECTION STATUS --}}
                                    <div>
                                        <p class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">
                                            Selection Status
                                        </p>

                                        @if($app->ApplicationStatus !== 'approved')
                                            <span class="text-xs font-bold text-gray-400">
                                                Not applicable
                                            </span>

                                        @elseif($app->SelectionStatus === 'in_selection')
                                            <span class="px-4 py-2 bg-yellow-50 text-yellow-700 rounded-full text-xs font-black uppercase">
                                                In Selection
                                            </span>

                                        @elseif($app->SelectionStatus === 'selected')
                                            <span class="px-4 py-2 bg-green-100 text-green-700 rounded-full text-xs font-black uppercase">
                                                🎉 Selected
                                            </span>

                                        @else
                                            <span class="px-4 py-2 bg-red-50 text-red-700 rounded-full text-xs font-black uppercase">
                                                Not Selected
                                            </span>
                                        @endif
                                    </div>

                                </div>
                            </div>

                        @endforeach
                    @endforeach

                </div>
            </section>

        @empty
            <div class="bg-white rounded-[2rem] p-20 border border-dashed border-gray-200 text-center">
                <p class="text-gray-400 font-black uppercase tracking-widest text-xs">
                    No applications submitted yet
                </p>
            </div>
        @endforelse

    </div>
</div>
@endsection
