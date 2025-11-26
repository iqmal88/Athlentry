@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10">

  {{-- Back + Header --}}
  <div class="mb-6 flex items-start justify-between">
    <div>
      <h1 class="mt-3 text-3xl font-bold text-gray-900">Game Information</h1>
      <p class="text-sm text-gray-500 mt-1">Grouped by event — click a game name to view full details.</p>
    </div>

    {{-- Small hint / count --}}
    <div class="text-right">
      <div class="text-sm text-gray-500">Events: <span class="font-medium">{{ $events->count() }}</span></div>
      <div class="text-sm text-gray-500 mt-1">Games total: <span class="font-medium">{{ $events->sum(fn($e)=>$e->games->count()) }}</span></div>
    </div>
  </div>

  {{-- Events & games (spacious cards) --}}
  <div class="space-y-8">

    @foreach($events as $event)
      <section class="relative">
        {{-- Event Card header with accent --}}
        <div class="rounded-2xl overflow-hidden border border-gray-100 shadow-sm">
          <div class="flex">
            <div class="w-1 bg-[#800000]"></div>
            <div class="flex-1 p-5">
              <div class="flex items-start justify-between gap-6">
                <div>
                  <h2 class="text-xl font-semibold text-gray-900">{{ $event->EventName }}</h2>
                  <p class="text-sm text-gray-500 mt-1">
                    {{ $event->StartDate ? \Carbon\Carbon::parse($event->StartDate)->format('d M Y') : '-' }}
                    — 
                    {{ $event->EndDate ? \Carbon\Carbon::parse($event->EndDate)->format('d M Y') : '-' }}
                  </p>
                </div>

                <div class="flex items-center gap-4">
                  <span class="inline-flex items-center px-3 py-1 rounded-full text-sm
                    @if($event->Status == 'Open') bg-green-50 text-green-700
                    @elseif($event->Status == 'Closed') bg-gray-100 text-gray-700
                    @else bg-red-50 text-red-700 @endif">
                    {{ $event->Status }}
                  </span>
                </div>
              </div>

              {{-- Divider --}}
              <div class="mt-5 border-t border-gray-100"></div>

              {{-- Games list --}}
              <div class="mt-4 grid gap-3">
                @forelse($event->games as $game)
                  <div class="flex items-center justify-between gap-4 bg-white rounded-lg border border-gray-100 p-4 hover:shadow-md transition">
                    <div class="flex items-center gap-4 min-w-0">
                      {{-- Initials avatar --}}
                      <div class="flex-none rounded-full bg-[#fdecea] text-[#800000] font-semibold w-10 h-10 flex items-center justify-center">
                        {{ strtoupper(substr($game->GameName,0,1) ?? '-') }}
                      </div>

                      <div class="min-w-0">
                        <a href="{{ route('admin.gameinfo.show', $game->GameID) }}" class="block text-lg font-semibold text-sky-700 hover:underline truncate">
                          {{ $game->GameName }}
                        </a>
                        <div class="mt-1 text-sm text-gray-500 flex flex-wrap gap-4">
                          <div>Category: <span class="font-medium text-gray-700">{{ $game->Category ?? '-' }}</span></div>
                          <div>Capacity: <span class="font-medium text-gray-700">{{ $game->Capacity ?? '-' }}</span></div>
                        </div>
                      </div>
                    </div>

                    {{-- Status + Edit --}}
                    <div class="flex items-center gap-3">
                      <div class="text-sm">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm
                          @if(strtolower($game->final_status) === 'open') bg-green-50 text-green-700
                          @elseif(strtolower($game->final_status) === 'closed') bg-gray-100 text-gray-700
                          @else bg-red-50 text-red-700 @endif">
                          {{ $game->final_status }}
                        </span>
                      </div>

                      <div class="flex-shrink-0">
                      </div>
                    </div>
                  </div>
                @empty
                  <div class="text-sm text-gray-500 p-4">No games for this event.</div>
                @endforelse
              </div>
            </div>
          </div>
        </div>
      </section>
    @endforeach

  </div>
</div>
@endsection
