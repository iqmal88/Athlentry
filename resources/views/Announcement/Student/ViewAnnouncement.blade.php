@extends('layouts.app')

@section('title', $announcement->Title)

@section('content')
@php
  $fallbackImage = '/images/placeholder-announce.png';
  $imgSrc = $announcement->Image ? asset('storage/'.$announcement->Image) : $fallbackImage;

  $dateHuman = $announcement->Date
      ? \Carbon\Carbon::parse($announcement->Date)->format('D, d M Y')
      : 'TBA';

  $timeRange = ($announcement->TimeFrom || $announcement->TimeUntil)
      ? trim(
          ($announcement->TimeFrom ? \Carbon\Carbon::parse($announcement->TimeFrom)->format('h:i A') : '') .
          (($announcement->TimeFrom && $announcement->TimeUntil) ? ' — ' : '') .
          ($announcement->TimeUntil ? \Carbon\Carbon::parse($announcement->TimeUntil)->format('h:i A') : '')
        )
      : 'Time not set';
@endphp

<div class="min-h-screen bg-[#F8FAFC] pb-24 font-sans antialiased">

  {{-- HERO --}}
  <div class="px-6 py-6">
    <div class="max-w-7xl mx-auto relative h-[380px] w-full overflow-hidden rounded-[3rem] shadow-sm border border-slate-100">

      <img src="{{ $imgSrc }}" alt="{{ $announcement->Title }}"
           class="absolute inset-0 w-full h-full object-cover">

      <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-black/10"></div>

      {{-- TOP BAR --}}
      <div class="absolute top-8 left-8 right-8 flex items-center justify-between z-10">
        <a href="{{ route('student.announcements.index') }}"
           class="group flex items-center gap-3 bg-white/10 backdrop-blur-md border border-white/20
                  px-5 py-2.5 rounded-full text-white text-xs font-black uppercase tracking-widest
                  hover:bg-white hover:text-slate-900 transition-all">
          <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1"
               fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                  d="M15 19l-7-7 7-7"/>
          </svg>
          Back
        </a>

        <div class="flex items-center gap-3">
          <button id="shareBtn"
                  class="px-6 py-2.5 bg-white text-slate-900 rounded-full
                         text-xs font-black uppercase tracking-widest shadow-xl
                         hover:bg-teal-600 hover:text-white transition-all">
            Share
          </button>
        </div>
      </div>

      {{-- TITLE --}}
      <div class="absolute bottom-12 left-12 right-12">
        <div class="inline-flex items-center gap-2 px-3 py-1
                    bg-teal-600 rounded-lg text-white
                    text-[10px] font-black uppercase tracking-widest mb-6 shadow">
          <span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span>
          {{ $announcement->Category ?? 'Announcement' }}
        </div>

        <h1 class="text-4xl md:text-6xl font-black text-white
                   tracking-tighter leading-tight italic uppercase drop-shadow-lg">
          {{ $announcement->Title }}
        </h1>
      </div>

    </div>
  </div>

  {{-- CONTENT --}}
  <div class="max-w-7xl mx-auto px-6 mt-4 animate-in fade-in slide-in-from-bottom-4 duration-700">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

      {{-- MAIN NARRATIVE --}}
      <div class="lg:col-span-8">
        <div class="bg-white rounded-[3rem] p-10 md:p-14
                    border border-slate-100 shadow-sm min-h-[400px]">

          <div class="flex items-center gap-4 mb-12">
            <h3 class="text-[10px] font-black text-teal-600 uppercase tracking-[0.3em]">
              Full Details
            </h3>
            <div class="flex-1 h-px bg-slate-100"></div>
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">
              Student View
            </p>
          </div>

          <div class="prose prose-xl max-w-none text-slate-600 leading-relaxed font-medium italic">
            {!! nl2br(e($announcement->Description ?? 'No description provided.')) !!}
          </div>

          {{-- ATTACHMENTS --}}
          @if(!empty($announcement->Attachments) && count($announcement->Attachments))
            <div class="mt-12">
              <h4 class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-4">
                Attachments
              </h4>
              <ul class="space-y-2">
                @foreach($announcement->Attachments as $att)
                  <li>
                    <a href="{{ asset('storage/'.$att->path) }}" target="_blank"
                       class="inline-flex items-center gap-2 text-teal-600 font-bold hover:underline">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 5v14m7-7H5"/>
                      </svg>
                      {{ $att->filename }}
                    </a>
                  </li>
                @endforeach
              </ul>
            </div>
          @endif

        </div>
      </div>

      {{-- LOGISTICS SIDEBAR --}}
      <div class="lg:col-span-4 space-y-8">
        <div class="bg-slate-900 rounded-[2.5rem] p-10 text-white
                    shadow-2xl relative overflow-hidden">

          <h3 class="text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] mb-12">
            Event Logistics
          </h3>

          <div class="space-y-12">

            {{-- DATE --}}
            <div class="flex gap-6">
              <div class="w-12 h-12 rounded-2xl bg-white/5 flex items-center justify-center text-teal-400">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3M3 11h18M5 21h14a2 2 0 002-2V7"/>
                </svg>
              </div>
              <div>
                <p class="text-[9px] font-black text-slate-500 uppercase tracking-widest mb-1">
                  Date
                </p>
                <p class="text-xl font-bold tracking-tight text-white">
                  {{ $dateHuman }}
                </p>
              </div>
            </div>

            {{-- LOCATION --}}
            <div class="flex gap-6">
              <div class="w-12 h-12 rounded-2xl bg-white/5 flex items-center justify-center text-teal-400">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 11c1.657 0 3-1.343 3-3S13.657 5 12 5 9 6.343 9 8s1.343 3 3 3z"/>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 21s8-4.5 8-10a8 8 0 10-16 0c0 5.5 8 10 8 10z"/>
                </svg>
              </div>
              <div>
                <p class="text-[9px] font-black text-slate-500 uppercase tracking-widest mb-1">
                  Venue
                </p>
                <p class="text-xl font-bold tracking-tight text-white">
                  {{ $announcement->Location ?? 'TBA' }}
                </p>
              </div>
            </div>

            {{-- TIME --}}
            <div class="flex gap-6">
              <div class="w-12 h-12 rounded-2xl bg-white/5 flex items-center justify-center text-teal-400">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
              </div>
              <div>
                <p class="text-[9px] font-black text-slate-500 uppercase tracking-widest mb-1">
                  Schedule
                </p>
                <p class="text-xl font-bold tracking-tight text-white">
                  {{ $timeRange }}
                </p>
              </div>
            </div>

            {{-- APPLY --}}
            <div class="pt-6 border-t border-white/10">
              <a href="{{ route('student.application.index') }}"
                 class="block text-center px-8 py-4 rounded-2xl
                        bg-teal-600 text-white
                        text-xs font-black uppercase tracking-widest
                        shadow-lg hover:brightness-110 transition-all">
                Apply Now
              </a>
            </div>

          </div>
        </div>
      </div>

    </div>
  </div>
</div>

{{-- SHARE --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
  const shareBtn = document.getElementById('shareBtn');
  shareBtn?.addEventListener('click', async () => {
    const url = window.location.href;
    if (navigator.share) {
      try { await navigator.share({ title: document.title, url }); } catch {}
      return;
    }
    await navigator.clipboard.writeText(url);
    shareBtn.textContent = 'Copied';
    setTimeout(() => shareBtn.textContent = 'Share', 1400);
  });
});
</script>

<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap');
body { font-family: 'Plus Jakarta Sans', sans-serif; letter-spacing:-0.01em; }
.prose p { color:#475569; }
</style>
@endsection
