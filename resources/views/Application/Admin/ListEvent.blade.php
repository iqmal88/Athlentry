@extends('layouts.admin')

@section('title', 'Events')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">

  {{-- DESIGN ONLY: improved UX visual styles (no markup/JS changed) --}}
  <style>
    :root {
      /* use layout brand if available, otherwise fallback */
      --local-brand: var(--brand, #800000);
      --local-brand-600: rgba(128,0,0,0.9);
      --muted-600: #6b7280;
      --card-bg: linear-gradient(180deg,#ffffff,#fbfbfb);
      --soft-border: rgba(15,23,42,0.06);
      --focus-ring: 0 0 0 4px rgba(128,0,0,0.08);
    }

    /* Page header */
    .max-w-7xl > .flex:first-child h1 {
      font-size: 1.6rem;
      line-height: 1.15;
      letter-spacing: -0.01em;
    }
    .max-w-7xl > .flex:first-child p {
      color: var(--muted-600);
      margin-top: .25rem;
    }

    /* Search: larger, clearer */
    #searchInput {
      background: white;
      border-radius: 12px;
      padding-left: 3.25rem;
      padding-right: .9rem;
      height:44px;
      box-shadow: 0 2px 8px rgba(15,23,42,0.04);
      border: 1px solid var(--soft-border);
      transition: box-shadow .12s ease, transform .12s ease;
      font-size: .95rem;
    }
    #searchInput:focus {
      outline: none;
      box-shadow: var(--focus-ring);
      transform: translateY(-1px);
    }
    #searchInput::placeholder { color: #9aa3ad; }

    /* Selects: pill look, larger tap area */
    #statusFilter, #categoryFilter {
      background: white;
      border-radius: 999px;
      padding: .55rem .85rem;
      height:44px;
      border: 1px solid var(--soft-border);
      box-shadow: 0 1px 2px rgba(15,23,42,0.03);
      font-size: .92rem;
    }

    /* Add Event button: prominent but friendly */
    a[href*="events.create"], .add-event-btn {
      background: linear-gradient(180deg, var(--local-brand), var(--local-brand-600));
      border-radius: 10px;
      padding: .5rem .9rem;
      display: inline-flex;
      align-items: center;
      gap: .5rem;
      color: white;
      box-shadow: 0 8px 20px rgba(107,13,13,0.12);
      font-weight: 600;
      transition: transform .12s ease, box-shadow .12s ease;
    }
    a[href*="events.create"]:hover, .add-event-btn:hover {
      transform: translateY(-2px);
      filter: brightness(1.03);
    }

    /* Event card: cleaner, larger touch targets */
    .event-card {
      border-radius: 14px;
      background: var(--card-bg);
      border: 1px solid var(--soft-border);
      box-shadow: 0 6px 18px rgba(15,23,42,0.04);
      transition: transform .15s ease, box-shadow .15s ease;
      overflow: hidden;
    }
    .event-card:hover { transform: translateY(-6px); box-shadow: 0 20px 48px rgba(15,23,42,0.07); }

    /* Thumbnail: keep consistent aspect & better placeholder */
    .event-card img {
      width:100%;
      height:100%;
      object-fit: cover;
      display:block;
      background: linear-gradient(180deg,#f3f3f3,#ffffff);
    }
    .event-card .md\\:col-span-3 { padding: 1.25rem; }
    .event-card .p-4 { padding: 1.15rem; }

    /* Title and metadata */
    .event-card a.text-lg { font-size: 1.05rem; }
    .event-card .text-sm { font-size: .92rem; }

    /* Action buttons: clearer primary / secondary */
    .event-card .inline-flex, .event-card button {
      border-radius: 10px;
      padding: .45rem .7rem;
      font-weight: 600;
      font-size: .92rem;
    }
    .event-card a.inline-flex:hover, .event-card button:hover { transform: translateY(-2px); }

    /* Games list: card-like rows with subtle separation */
    .games-list { padding: 0; margin-top: .6rem; }
    .game-row {
      background: white;
      border: 1px solid rgba(15,23,42,0.04);
      border-radius: 10px;
      padding: .72rem;
      display:flex;
      align-items:center;
      justify-content:space-between;
      transition: box-shadow .12s ease, transform .12s ease;
      gap:.75rem;
    }
    .game-row + .game-row { margin-top: .6rem; }
    .game-row:hover { box-shadow: 0 10px 30px rgba(15,23,42,0.04); transform: translateY(-3px); }

    /* Game icon */
    .game-row .w-10.h-10 { min-width:40px; min-height:40px; border-radius:8px; font-weight:700; }

    /* Badges: readable, slightly larger */
    .game-row .inline-flex.items-center.px-2 {
      background: rgba(0,0,0,0.04);
      border-radius: 999px;
      padding: .25rem .5rem;
      font-weight:700;
      font-size:.78rem;
    }

    /* Toggle games button: clearer affordance */
    .toggle-games {
      background: linear-gradient(180deg,#ffffff,#fbfbfb);
      border: 1px solid rgba(15,23,42,0.04);
      border-radius: 10px;
      padding: .55rem .8rem;
      display:flex;
      align-items:center;
      justify-content:space-between;
      gap:.5rem;
      width:100%;
      transition: background .12s ease, transform .12s ease;
    }
    .toggle-games:hover { transform: translateY(-2px); }
    .toggle-games .chev { transition: transform .18s ease; }

    /* Collapsed games on mobile: smoother animations */
    .games-list.hidden { display: none !important; }

    /* Focus states for accessibility */
    .event-card a:focus, .event-card button:focus, #searchInput:focus, #statusFilter:focus, #categoryFilter:focus {
      outline: none;
      box-shadow: var(--focus-ring);
    }

    /* Small screens: spacing & tap targets */
    @media (max-width: 767px) {
      #searchInput { width:100%; }
      #statusFilter, #categoryFilter { height:40px; padding:.45rem .6rem; font-size:.9rem; }
      .games-list.hidden { display: none; }
      .event-card .p-4 { padding: 1rem; }
      .game-row { padding:.65rem; }
    }

    /* util: use brand color for links */
    .text-sky-700 { color: var(--local-brand); }
    a.text-sky-700:hover { color: var(--local-brand-600); text-decoration: underline; }
  </style>

  {{-- Header / Controls --}}
  <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
    <div>
      <h1 class="text-2xl font-bold text-gray-900">Events</h1>
      <p class="text-sm text-gray-500 mt-1">Manage events and the games inside each event.</p>
    </div>

    <div class="flex items-center gap-3">
      <div class="relative">
        <input id="searchInput" type="search" placeholder="Search events or games..."
               class="w-72 md:w-96 pl-10 pr-3 py-2 rounded-lg border border-gray-200 shadow-sm focus:outline-none focus:ring-2 focus:ring-sky-500"
               aria-label="Search events and games">
        <svg class="w-5 h-5 absolute left-3 top-2.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M10.5 18A7.5 7.5 0 1 1 10.5 3a7.5 7.5 0 0 1 0 15z"/></svg>
      </div>

      <select id="statusFilter" class="rounded-md border border-gray-200 px-3 py-2 shadow-sm" aria-label="Filter by event status">
        <option value="all">All statuses</option>
        <option value="Open">Open</option>
        <option value="Closed">Closed</option>
        <option value="Cancelled">Cancelled</option>
      </select>

      <select id="categoryFilter" class="rounded-md border border-gray-200 px-3 py-2 shadow-sm" aria-label="Filter by game category">
        <option value="all">All categories</option>
        <option value="Male">Male</option>
        <option value="Female">Female</option>
        <option value="Mixed">Mixed</option>
        <option value="Open">Open</option>
      </select>

      <a href="{{ route('admin.events.create') }}"
         class="inline-flex items-center gap-2 px-4 py-2 bg-[#800000] text-white rounded-md shadow hover:opacity-95 text-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Add Event
      </a>
    </div>
  </div>

  {{-- No events empty state --}}
  @if($events->isEmpty())
    <div class="bg-white border border-dashed border-gray-200 rounded-lg p-8 text-center">
      <p class="text-lg font-medium text-gray-700">No events found</p>
      <p class="text-sm text-gray-500 mt-1">Create your first event to start accepting applications.</p>
      <div class="mt-4">
        <a href="{{ route('admin.events.create') }}" class="inline-flex px-4 py-2 bg-[#800000] text-white rounded-md">Create Event</a>
      </div>
    </div>
  @endif

  {{-- Events grid --}}
  <div id="eventsGrid" class="grid gap-6 mt-6">
    @foreach($events as $event)
      <article class="event-card bg-white rounded-xl border shadow-sm hover:shadow-md transition" data-event-name="{{ strtolower($event->EventName) }}" data-event-status="{{ $event->Status }}">
        <header class="p-4 flex items-start justify-between gap-4">
          <div class="flex-1 min-w-0">
            {{-- Event name → edit --}}
            <a href="{{ route('admin.events.edit', $event->EventID) }}" class="block text-lg font-semibold text-gray-900 hover:underline truncate">
              {{ $event->EventName }}
            </a>

            <div class="mt-1 flex items-center gap-3 text-sm text-gray-500">
              <div>
                <svg class="inline w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2z"/></svg>
                <span>{{ $event->StartDate ? \Carbon\Carbon::parse($event->StartDate)->format('d M Y') : '-' }} — {{ $event->EndDate ? \Carbon\Carbon::parse($event->EndDate)->format('d M Y') : '-' }}</span>
              </div>

              <div class="flex items-center gap-2">
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                    @if($event->Status == 'Open') bg-green-50 text-green-700
                    @elseif($event->Status == 'Closed') bg-gray-100 text-gray-700
                    @else bg-red-50 text-red-700 @endif">
                  {{ $event->Status }}
                </span>
              </div>
            </div>
          </div>
        </header>

        {{-- Games (collapsible) --}}
        <div class="border-t px-4 py-3">
          {{-- toggle control (mobile friendly) --}}
          <button class="toggle-games w-full flex items-center justify-between md:hidden text-sm text-gray-600 py-2">
            <span>Games ({{ $event->games->count() }})</span>
            <svg class="w-5 h-5 text-gray-500 transform transition" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
          </button>

          <ul class="games-list grid gap-3 md:grid-cols-1 mt-3">
            @foreach($event->games as $game)
              @php
                $cat = $game->Category ?? 'Unspecified';
                $catMap = ['Men'=>'Male','M'=>'Male','Women'=>'Female','F'=>'Female','Mixed'=>'Mixed','Open'=>'Open'];
                $catDisplay = $catMap[$cat] ?? $cat;
              @endphp

              <li class="game-row flex items-center justify-between gap-3 p-3 rounded-md hover:bg-gray-50 transition"
                  data-game-name="{{ strtolower($game->GameName) }}"
                  data-game-category="{{ strtolower($catDisplay) }}"
                  data-capacity="{{ $game->Capacity ?? '' }}">
                <div class="flex items-center gap-3 min-w-0">
                  {{-- optional small icon / avatar --}}
                  <div class="w-10 h-10 rounded-md bg-gradient-to-tr from-gray-100 to-gray-50 flex items-center justify-center text-sm font-semibold text-gray-700">
                    {{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($game->GameName,0,2)) }}
                  </div>

                  <div class="min-w-0">
                    <a href="{{ route('admin.games.applicants', $game->GameID) }}" class="block text-sm font-medium text-sky-700 hover:underline truncate">
                      {{ $game->GameName }}
                    </a>

                    <div class="flex items-center gap-3 text-xs text-gray-500 mt-0.5">
                      <span>Applicants: <span class="font-semibold text-gray-700">{{ $game->applications_count ?? 0 }}</span></span>
                      <span>Capacity: <span class="font-medium">{{ $game->Capacity ?? '-' }}</span></span>
                      <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                        @if(strtolower($catDisplay)=='male') bg-blue-100 text-blue-800
                        @elseif(strtolower($catDisplay)=='female') bg-pink-100 text-pink-800
                        @elseif(strtolower($catDisplay)=='mixed' || strtolower($catDisplay)=='open') bg-yellow-100 text-yellow-800
                        @else bg-gray-100 text-gray-800 @endif">
                        {{ $catDisplay }}
                      </span>
                    </div>
                  </div>
                </div>
              </li>
            @endforeach
          </ul>
        </div>
      </article>
    @endforeach
  </div>
</div>

{{-- Client-side filtering / UI behavior --}}
<script>
(function () {
  const searchInput = document.getElementById('searchInput');
  const statusFilter = document.getElementById('statusFilter');
  const categoryFilter = document.getElementById('categoryFilter');
  const eventCards = Array.from(document.querySelectorAll('.event-card'));

  // Toggle games on small screens
  document.querySelectorAll('.toggle-games').forEach(btn => {
    btn.addEventListener('click', function() {
      const parent = this.closest('.event-card');
      const list = parent.querySelector('.games-list');
      list.classList.toggle('hidden');
      const icon = this.querySelector('svg');
      icon.classList.toggle('rotate-180');
    });
  });

  function normalize(text) {
    return (text || '').toString().toLowerCase().trim();
  }

  function applyFilters() {
    const q = normalize(searchInput.value);
    const status = statusFilter.value;
    const category = categoryFilter.value.toLowerCase();

    eventCards.forEach(card => {
      const eventName = normalize(card.dataset.eventName);
      const eventStatus = normalize(card.dataset.eventStatus);

      // check event-level match
      let eventMatches = (!q || eventName.includes(q));
      let statusMatches = (status === 'all' || eventStatus === status.toLowerCase());

      // check games inside card
      const games = Array.from(card.querySelectorAll('.game-row'));
      let anyGameMatches = false;
      games.forEach(game => {
        const gName = normalize(game.dataset.gameName);
        const gCat = normalize(game.dataset.gameCategory);
        const capacity = normalize(game.dataset.capacity);
        const matchesText = (!q || gName.includes(q) || gCat.includes(q));
        const matchesCategory = (category === 'all' || category === '' || gCat === category);
        if (matchesText && matchesCategory) {
          anyGameMatches = true;
          // show matched game
          game.style.display = '';
        } else {
          // hide non-matching game
          game.style.display = 'none';
        }
      });

      // Event card is visible if status matches and (eventMatches or anyGameMatches)
      if (statusMatches && (eventMatches || anyGameMatches)) {
        card.style.display = '';
      } else {
        card.style.display = 'none';
      }
    });
  }

  // wire events
  [searchInput, statusFilter, categoryFilter].forEach(el => el.addEventListener('input', applyFilters));
  // initial run
  applyFilters();
})();
</script>
@endsection