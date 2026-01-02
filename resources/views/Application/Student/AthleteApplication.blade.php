@extends('layouts.app')

@section('title', 'Athlete Applications')

@section('content')
<div class="min-h-screen bg-[#F8FAFC] pb-24 font-sans antialiased">

    {{-- HEADER --}}
    <div class="px-6 py-8">
        <div class="max-w-7xl mx-auto bg-white rounded-[2.5rem] border border-slate-100
                    px-10 py-8 flex items-center justify-between shadow-sm relative overflow-hidden">

            <div class="absolute -top-24 -right-24 w-72 h-72 bg-teal-500/5 rounded-full blur-3xl"></div>

            <div class="relative z-10">
                <h1 class="text-3xl font-black italic uppercase tracking-tight text-slate-900">
                    Events <span class="text-teal-600 not-italic">Hub</span>
                </h1>
                <p class="text-[10px] uppercase tracking-[0.35em] text-slate-400 font-bold mt-2">
                    Athlete Registration & Event Intake
                </p>
            </div>

            <div class="relative z-10 text-right">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1">
                    Total Events
                </p>
                <p class="text-3xl font-black text-slate-900">
                    {{ $events->count() }}
                </p>
            </div>
        </div>
    </div>

    {{-- ALERTS --}}
    <div class="max-w-7xl mx-auto px-6">
        @if(session('success'))
            <div class="mb-6 p-4 rounded-2xl bg-teal-50 border border-teal-100 text-teal-700 text-sm font-semibold">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 rounded-2xl bg-red-50 border border-red-100 text-red-700 text-sm font-semibold">
                {{ session('error') }}
            </div>
        @endif
    </div>

    {{-- EVENTS --}}
    <div class="max-w-7xl mx-auto px-6 space-y-14">

        @forelse($events as $event)

            {{-- EVENT TITLE --}}
            <div>
                <div class="flex items-center gap-4 mb-6">
                    <span class="w-3 h-3 rounded-full bg-emerald-400"></span>
                        <a href="{{ route('student.events.show', $event->EventID) }}"class="group inline-block">
                            <h2 class="text-2xl font-black italic uppercase tracking-tight text-slate-900 group-hover:text-teal-600 transition">{{ $event->EventName }}</h2>
                        </a>

                    <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest
                                 bg-emerald-50 text-emerald-700">
                        OPEN
                    </span>
                </div>

                {{-- GAMES GRID --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">

                    @foreach($event->games as $game)
                        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm
                                    hover:shadow-[0_20px_50px_-15px_rgba(13,148,136,0.15)]
                                    transition-all duration-500 hover:-translate-y-2
                                    p-8 flex flex-col justify-between">

                            {{-- CATEGORY --}}
                            <span class="px-3 py-1 rounded-lg text-[9px] font-black uppercase tracking-widest
                                         bg-teal-50 text-teal-700 w-fit mb-6">
                                {{ strtoupper($game->Category ?? 'OPEN') }}
                            </span>

                            {{-- GAME INFO --}}
                            <div>
                                <h3 class="text-xl font-black text-slate-900 tracking-tight">
                                    {{ $game->GameName }}
                                </h3>
                                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mt-2">
                                    Intake: {{ $game->applied ?? 0 }} athletes
                                </p>
                            </div>

                            {{-- CAPACITY --}}
                            <div class="mt-8">
                                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1">
                                    Capacity
                                </p>
                                <p class="text-2xl font-black text-slate-900">
                                    {{ $game->Capacity ?? '-' }}
                                </p>
                            </div>

                            {{-- ACTION --}}
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
                                        data-url="{{ route('student.application.submit',$game->GameID) }}"
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

        @empty
            <div class="bg-white rounded-[3rem] border-2 border-dashed border-slate-200
                        p-20 text-center">
                <h3 class="text-xl font-black uppercase text-slate-900">
                    No Events Available
                </h3>
                <p class="text-slate-400 text-sm mt-2 font-medium">
                    Please check back later for upcoming competitions.
                </p>
            </div>
        @endforelse

    </div>
</div>

{{-- APPLY MODAL --}}
<div id="applyModal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm"></div>

    <div class="relative min-h-screen flex items-center justify-center px-6">
        <div class="bg-white rounded-[2.5rem] w-full max-w-xl shadow-2xl">

            <div class="px-10 py-8 border-b border-slate-100">
                <h2 class="text-xl font-black uppercase italic text-slate-900">
                    Confirm <span class="text-teal-600 not-italic">Application</span>
                </h2>
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mt-2">
                    Athlete Registration
                </p>
            </div>

            <div class="px-10 py-10 space-y-6">
                <div>
                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Event</p>
                    <p id="modalEvent" class="text-lg font-bold text-slate-900"></p>
                </div>

                <div>
                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Sport</p>
                    <p id="modalGame" class="text-lg font-bold text-slate-900"></p>
                </div>

                <div class="rounded-2xl bg-teal-50 border border-teal-100 px-6 py-4">
                    <p class="text-sm text-teal-700 font-semibold">
                        Please confirm that you want to apply for this sport.
                    </p>
                </div>

                <form id="applyForm" method="POST">
                    @csrf
                    <div class="flex justify-between gap-4 pt-4">
                        <button type="button" id="cancelApply"
                                class="px-8 py-4 rounded-2xl bg-slate-100 text-slate-500
                                       text-xs font-black uppercase tracking-widest">
                            Cancel
                        </button>

                        <button type="submit"
                                class="px-10 py-4 rounded-2xl bg-teal-600 text-white
                                       text-xs font-black uppercase tracking-widest
                                       shadow-lg shadow-teal-600/25">
                            Confirm Apply
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

{{-- SCRIPT --}}
<script>
document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('applyModal');
    const modalEvent = document.getElementById('modalEvent');
    const modalGame = document.getElementById('modalGame');
    const cancelBtn = document.getElementById('cancelApply');
    const form = document.getElementById('applyForm');

    document.querySelectorAll('.apply-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            modalEvent.textContent = btn.dataset.event;
            modalGame.textContent = btn.dataset.game;
            form.action = btn.dataset.url; // ✅ Laravel-generated route
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        });
    });

    function closeModal() {
        modal.classList.add('hidden');
        document.body.style.overflow = '';
    }

    cancelBtn.addEventListener('click', closeModal);
    modal.querySelector('.absolute').addEventListener('click', closeModal);
});
</script>

<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap');
body {
    font-family: 'Plus Jakarta Sans', sans-serif;
    letter-spacing: -0.01em;
}
</style>
@endsection
