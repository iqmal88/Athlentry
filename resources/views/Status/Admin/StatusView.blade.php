@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-[#F8F9FA] pb-24 font-sans antialiased">

    {{-- HEADER --}}
    <div class="px-6 py-6">
        <div class="max-w-7xl mx-auto bg-white rounded-[2rem] px-10 py-8 border border-gray-100 shadow-sm">
            <h1 class="text-3xl font-black uppercase italic">
                Selection <span class="text-[#800000] not-italic">Panel</span>
            </h1>
            <p class="text-[10px] uppercase tracking-[0.3em] text-gray-400 font-bold mt-2">
                Athlete Evaluation & Final Selection
            </p>
        </div>
    </div>

    {{-- CONTENT --}}
    <div class="max-w-7xl mx-auto px-6 space-y-20">

        @forelse($events as $event)
            @if($event->games->count() > 0)

            {{-- EVENT --}}
            <section>
                <h2 class="text-2xl font-black uppercase italic text-gray-900 mb-6">
                    {{ $event->EventName }}
                </h2>

                <div class="space-y-10">

                    @foreach($event->games as $game)
                        @if($game->applications->count() > 0)

                        {{-- GAME CARD --}}
                        <div class="bg-white rounded-[2rem] p-8 border border-gray-100 shadow-sm">

                            {{-- GAME HEADER --}}
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-xl font-black text-gray-900">
                                    {{ $game->GameName }}
                                </h3>

                                <span class="text-[10px] font-black uppercase tracking-widest text-gray-400">
                                    {{ $game->applications->count() }} Candidates
                                </span>
                            </div>

                            {{-- APPLICANTS --}}
                            <div class="space-y-4">
                                @foreach($game->applications as $app)

                                    <div
                                        class="grid grid-cols-[auto_1fr_auto_auto] items-center bg-gray-50 rounded-xl px-6 py-4">

                                        {{-- NAME --}}
                                        <div>
                                            <p class="font-black uppercase text-gray-900">
                                                {{ $app->user->Name }}
                                            </p>
                                            <p class="text-[10px] font-bold text-gray-400 uppercase">
                                                Applied {{ \Carbon\Carbon::parse($app->DateApplied)->format('d M Y') }}
                                            </p>
                                        </div>

                                        {{-- SPACER --}}
                                        <div></div>

                                        {{-- STATUS BADGE --}}
                                        <div class="flex justify-center pr-6">
                                            @if($app->SelectionStatus === 'selected')
                                                <span
                                                    class="px-4 py-1 bg-green-100 text-green-700 text-[10px] font-black rounded-full uppercase">
                                                    Selected
                                                </span>
                                            @elseif($app->SelectionStatus === 'rejected')
                                                <span
                                                    class="px-4 py-1 bg-red-100 text-red-700 text-[10px] font-black rounded-full uppercase">
                                                    Rejected
                                                </span>
                                            @else
                                                <span
                                                    class="px-4 py-1 bg-yellow-50 text-yellow-700 text-[10px] font-black rounded-full uppercase">
                                                    In Selection
                                                </span>
                                            @endif
                                        </div>

                                        {{-- ACTION --}}
                                        <div class="flex justify-end">
                                            @if($app->SelectionStatus === 'in_selection')
                                                <div class="flex gap-2">

                                                    {{-- SELECT --}}
                                                    <form method="POST"
                                                          action="{{ route('admin.selection.update', $app->ApplicationID) }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="decision" value="selected">
                                                        <button
                                                            class="px-6 py-2 bg-green-600 text-white rounded-lg text-[10px] font-black uppercase hover:bg-green-700 transition">
                                                            Select
                                                        </button>
                                                    </form>

                                                    {{-- REJECT --}}
                                                    <form method="POST"
                                                          action="{{ route('admin.selection.update', $app->ApplicationID) }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="decision" value="rejected">
                                                        <button
                                                            class="px-6 py-2 bg-red-600 text-white rounded-lg text-[10px] font-black uppercase hover:bg-red-700 transition">
                                                            Reject
                                                        </button>
                                                    </form>
                                                </div>
                                            @else
                                                <button disabled
                                                    class="px-6 py-2 bg-gray-200 text-gray-400 rounded-lg text-[10px] font-black uppercase cursor-not-allowed">
                                                    Finalised
                                                </button>
                                            @endif
                                        </div>

                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    @endforeach

                </div>
            </section>
            @endif
        @empty
            <div class="bg-white rounded-[2rem] p-20 border border-dashed border-gray-200 text-center">
                <p class="text-gray-400 font-black uppercase tracking-widest text-xs">
                    No approved applicants for selection
                </p>
            </div>
        @endforelse

    </div>
</div>
@endsection
