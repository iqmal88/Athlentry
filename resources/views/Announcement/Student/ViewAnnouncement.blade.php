@extends('layouts.app') {{-- or layouts.student if you prefer --}}

@section('title', $announcement->Title)

@section('content')
@php
    // fallback image - replace with your placeholder path if needed
    $fallbackImage = '/images/placeholder-announce.png';
    $imgSrc = $announcement->Image ? asset('storage/' . $announcement->Image) : $fallbackImage;

    // readable date/time
    $dateHuman = $announcement->Date ? \Carbon\Carbon::parse($announcement->Date)->format('d F, Y') : null;
    $timeFrom = $announcement->TimeFrom ? \Carbon\Carbon::parse($announcement->TimeFrom)->format('h:i A') : '';
    $timeUntil = $announcement->TimeUntil ? \Carbon\Carbon::parse($announcement->TimeUntil)->format('h:i A') : '';
@endphp

<!-- Page -->
<div class="min-h-screen bg-gray-50 py-8">
  <div class="max-w-6xl mx-auto px-4">

    <!-- Breadcrumbs / back -->
    <div class="mb-4">
      <a href="{{ route('student.announcements.index') }}" class="inline-flex items-center gap-2 text-sm text-gray-600 hover:text-[color:var(--brand)] transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
        Back to announcements
      </a>
    </div>

    <!-- HERO / header -->
    <header class="relative rounded-xl overflow-hidden shadow-md mb-6">
      <img src="{{ $imgSrc }}" alt="{{ $announcement->Title }}" class="w-full h-64 md:h-80 lg:h-96 object-cover">

      <!-- overlay -->
      <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-black/10 to-transparent"></div>

      <div class="absolute inset-0 flex items-end">
        <div class="max-w-6xl mx-auto px-6 py-6 md:py-8 w-full flex items-end justify-between gap-4">
          <div class="text-white max-w-2xl">
            <h1 class="text-2xl md:text-3xl lg:text-4xl font-extrabold leading-tight drop-shadow-sm">{{ $announcement->Title }}</h1>
            <div class="mt-2 text-sm text-white/90">
              @if($dateHuman) <span>{{ $dateHuman }}</span> &middot; @endif
              <span>{{ $announcement->Location ?? 'Location TBA' }}</span>
            </div>
          </div>

          <div class="flex items-center gap-2">
            <button id="shareBtn" class="inline-flex items-center gap-2 bg-white/90 text-gray-800 px-3 py-2 rounded-md shadow hover:brightness-95 transition" aria-label="Share announcement">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 12v.01M12 12v.01M20 12v.01M8 12a4 4 0 108 0 4 4 0 00-8 0z"/></svg>
              Share
            </button>

            <button id="addCalendarBtn" class="inline-flex items-center gap-2 bg-[color:var(--brand)] text-white px-3 py-2 rounded-md shadow hover:brightness-95 transition" aria-label="Add to calendar">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3M3 11h18M5 21h14a2 2 0 002-2V7"/></svg>
              Add to calendar
            </button>
          </div>
        </div>
      </div>
    </header>

    <!-- Main content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
      <!-- Left: description -->
      <main class="lg:col-span-2">
        <article class="bg-white rounded-xl shadow-md overflow-hidden">
          <div class="p-6 md:p-8">
            <h2 class="text-lg font-semibold text-gray-800 mb-3">About</h2>

            <div class="prose prose-lg max-w-none text-gray-700">
              {!! nl2br(e($announcement->Description ?? 'No additional details.')) !!}
            </div>

            <!-- Attachments -->
            @if(!empty($announcement->Attachments) && count($announcement->Attachments))
              <div class="mt-6">
                <h3 class="text-sm font-semibold text-gray-700 mb-2">Attachments</h3>
                <ul class="space-y-2">
                  @foreach($announcement->Attachments as $att)
                    <li>
                      <a href="{{ asset('storage/' . $att->path) }}" target="_blank" class="inline-flex items-center gap-2 text-[color:var(--brand)] hover:underline">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14m7-7H5"/></svg>
                        {{ $att->filename }}
                      </a>
                    </li>
                  @endforeach
                </ul>
              </div>
            @endif

            <!-- Actions at end -->
          </div>
        </article>
      </main>

      <!-- Right: info card -->
      <aside class="bg-white rounded-xl shadow-md p-5">
        <div class="border-b pb-4 mb-4">
          <h3 class="text-sm font-semibold text-gray-700">Event Info</h3>
        </div>

        <div class="space-y-4 text-sm text-gray-700">
          <!-- Date -->
          <div class="flex items-start gap-3">
            <div class="flex-shrink-0 mt-0.5">
              <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3M3 11h18M5 21h14a2 2 0 0 0 2-2V7"/></svg>
            </div>
            <div>
              <div class="text-xs text-gray-500">Date</div>
              <div class="font-medium">{{ $dateHuman ?? '-' }}</div>
            </div>
          </div>

          <!-- Time -->
          <div class="flex items-start gap-3">
            <div class="flex-shrink-0 mt-0.5">
              <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3M12 6a6 6 0 1 0 0 12 6 6 0 0 0 0-12z"/></svg>
            </div>
            <div>
              <div class="text-xs text-gray-500">Time</div>
              <div class="font-medium">
                @if($timeFrom || $timeUntil)
                  {{ $timeFrom }}@if($timeFrom && $timeUntil) &nbsp;–&nbsp;@endif{{ $timeUntil }}
                @else
                  -
                @endif
                <div class="text-xs text-gray-400 mt-1">({{ config('app.timezone') }})</div>
              </div>
            </div>
          </div>

          <!-- Location -->
          <div class="flex items-start gap-3">
            <div class="flex-shrink-0 mt-0.5">
              <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c1.657 0 3-1.343 3-3S13.657 5 12 5 9 6.343 9 8s1.343 3 3 3z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 21s8-4.5 8-10a8 8 0 10-16 0c0 5.5 8 10 8 10z"/></svg>
            </div>
            <div>
              <div class="text-xs text-gray-500">Location</div>
              <div class="font-medium">{{ $announcement->Location ?? '-' }}</div>
            </div>
          </div>

          <!-- Apply -->
          <div class="flex items-center justify-end gap-3">
          <a href="{{ route('student.application.index') }}" class="inline-flex items-center px-4 py-2 rounded-lg border border-gray-200 text-sm text-gray-700 bg-white hover:shadow">
            Apply
          </a>

          <!-- Organizer / contact (if present) -->
          @if(!empty($announcement->Organizer))
            <div class="flex items-start gap-3">
              <div class="flex-shrink-0 mt-0.5">
                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A11.955 11.955 0 0112 15c2.5 0 4.8.75 6.879 2.804"/></svg>
              </div>
              <div>
                <div class="text-xs text-gray-500">Organizer</div>
                <div class="font-medium">{{ $announcement->Organizer }}</div>
              </div>
            </div>
          @endif

        </div>
      </aside>
    </div>
  </div>
</div>

<!-- Small JS: share & add-to-calendar (.ics) -->
<script>
document.addEventListener('DOMContentLoaded', function() {
  const shareBtn = document.getElementById('shareBtn');
  const addCalendarBtn = document.getElementById('addCalendarBtn');

  // Copy link / Web Share API fallback
  shareBtn && shareBtn.addEventListener('click', async function() {
    const url = window.location.href;
    if (navigator.share) {
      try {
        await navigator.share({ title: document.title, url });
      } catch (e) {
        // ignore
      }
      return;
    }
    try {
      await navigator.clipboard.writeText(url);
      shareBtn.innerText = 'Copied';
      setTimeout(()=> shareBtn.innerText = 'Share', 1600);
    } catch (e) {
      alert('Could not copy link. Please copy manually: ' + url);
    }
  });

  // Create simple ICS and trigger download
  addCalendarBtn && addCalendarBtn.addEventListener('click', function() {
    const title = "{{ addslashes($announcement->Title) }}";
    const desc = `{{ addslashes(strip_tags($announcement->Description ?? '')) }}`;
    const location = "{{ addslashes($announcement->Location ?? '') }}";
    // build a simple DTSTART/DTEND from Date + TimeFrom/TimeUntil if provided
    const date = "{{ $announcement->Date ? \Carbon\Carbon::parse($announcement->Date)->format('Ymd') : '' }}";
    const tf = "{{ $announcement->TimeFrom ? \Carbon\Carbon::parse($announcement->TimeFrom)->format('Hi') : '' }}";
    const tu = "{{ $announcement->TimeUntil ? \Carbon\Carbon::parse($announcement->TimeUntil)->format('Hi') : '' }}";

    let dtstart = '';
    let dtend = '';
    if (date && tf) dtstart = date + 'T' + tf + '00';
    if (date && tu) dtend = date + 'T' + tu + '00';
    // fallback: use all-day if times not provided
    if (!dtstart) {
      const allDay = date || new Date().toISOString().slice(0,10).replace(/-/g,'');
      dtstart = allDay;
      dtend = allDay;
    } else if (!dtend) {
      // default to one hour
      dtend = dtstart.slice(0, -2); // remove seconds
      // simple increment by 1 hour (not robust for edge cases)
      const year = dtstart.slice(0,4), month = dtstart.slice(4,6), day = dtstart.slice(6,8), hour = dtstart.slice(9,11), min = dtstart.slice(11,13);
      const dt = new Date(`${year}-${month}-${day}T${hour}:${min}:00`);
      dt.setHours(dt.getHours() + 1);
      dtend = dt.toISOString().replace(/[-:]/g,'').split('.')[0];
    }

    let ics = 'BEGIN:VCALENDAR\\r\\nVERSION:2.0\\r\\nPRODID:-//Athlentry//EN\\r\\nBEGIN:VEVENT\\r\\n';
    ics += 'UID:' + Date.now() + '@athlentry.local\\r\\n';
    ics += 'SUMMARY:' + title + '\\r\\n';
    if (dtstart.length > 8 && dtstart.includes('T')) ics += 'DTSTART:' + dtstart + '\\r\\n';
    else ics += 'DTSTART;VALUE=DATE:' + dtstart + '\\r\\n';
    if (dtend.length > 8 && dtend.includes('T')) ics += 'DTEND:' + dtend + '\\r\\n';
    else ics += 'DTEND;VALUE=DATE:' + dtend + '\\r\\n';
    if (location) ics += 'LOCATION:' + location + '\\r\\n';
    if (desc) ics += 'DESCRIPTION:' + desc + '\\r\\n';
    ics += 'END:VEVENT\\r\\nEND:VCALENDAR';

    // convert escaped newlines
    ics = ics.replace(/\\\\r\\\\n/g, '\\r\\n').replace(/\\\\n/g, '\\n');

    const blob = new Blob([ics], { type: 'text/calendar;charset=utf-8' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = (document.title || 'event') + '.ics';
    document.body.appendChild(a);
    a.click();
    a.remove();
    URL.revokeObjectURL(url);
  });
});
</script>

<style>
/* subtle polish */
.prose p { color: #374151; }
</style>
@endsection