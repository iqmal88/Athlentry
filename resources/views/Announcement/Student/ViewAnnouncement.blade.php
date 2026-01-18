@extends('layouts.app')

@section('title', $announcement->Title)

@section('content')
@php
  $fallbackImage = '/images/placeholder-announce.png';
  $imgSrc = $announcement->Image ? asset('storage/'.$announcement->Image) : $fallbackImage;

  $dateHuman = $announcement->DateClose
      ? \Carbon\Carbon::parse($announcement->DateClose)->format('D, d M Y')
      : 'TBA';

  $timeHuman = $announcement->TimeClose
      ? \Carbon\Carbon::parse($announcement->TimeClose)->format('h:i A')
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
          <svg class="w-4 h-4 group-hover:-translate-x-1"
               fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                  d="M15 19l-7-7 7-7"/>
          </svg>
          Back
        </a>

        <button id="shareBtn"
                class="px-6 py-2.5 bg-white text-slate-900 rounded-full
                       text-xs font-black uppercase tracking-widest shadow-xl
                       hover:bg-teal-600 hover:text-white transition-all">
          Share
        </button>
      </div>

      {{-- TITLE --}}
      <div class="absolute bottom-12 left-12 right-12">
        <div class="inline-flex items-center gap-2 px-3 py-1
                    bg-teal-600 rounded-lg text-white
                    text-[10px] font-black uppercase tracking-widest mb-6 shadow">
          <span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span>
          Announcement
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

      {{-- MAIN --}}
      <div class="lg:col-span-8">
        <div class="bg-white rounded-[3rem] p-10 md:p-14 border border-slate-100 shadow-sm min-h-[400px]">
          <h3 class="text-[10px] font-black text-teal-600 uppercase tracking-[0.3em] mb-12">
            Description
          </h3>

          <div class="prose prose-xl max-w-none text-slate-600 leading-relaxed font-medium">
            {!! nl2br(e($announcement->Description ?? 'No description provided.')) !!}
          </div>
        </div>
      </div>

      {{-- SIDEBAR --}}
      <div class="lg:col-span-4">
        <div class="bg-slate-900 rounded-[2.5rem] p-10 text-white shadow-2xl">

          <h3 class="text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] mb-12">
            Announcement Information
          </h3>

          <div class="space-y-12">

            {{-- DATE --}}
            <div>
              <p class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Application Closing Date</p>
              <p class="text-xl font-bold">{{ $dateHuman }}</p>
            </div>

            {{-- TIME --}}
            <div>
              <p class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Application Closing Time</p>
              <p class="text-xl font-bold">{{ $timeHuman }}</p>
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

{{-- SHARE SCRIPT --}}
<script>
document.addEventListener('DOMContentLoaded', () => {
  const shareBtn = document.getElementById('shareBtn');
  shareBtn?.addEventListener('click', async () => {
    const url = window.location.href;
    if (navigator.share) {
      try { await navigator.share({ title: document.title, url }); } catch {}
    } else {
      await navigator.clipboard.writeText(url);
      shareBtn.textContent = 'Copied';
      setTimeout(() => shareBtn.textContent = 'Share', 1200);
    }
  });
});
</script>
@endsection
