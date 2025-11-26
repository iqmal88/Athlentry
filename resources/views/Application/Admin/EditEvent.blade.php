@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10">

  {{-- Back link --}}
  <div class="mb-3">
    <a href="{{ route('admin.events.list') }}"
       class="inline-flex items-center gap-2 text-sm text-gray-600 hover:text-[#800000] transition">
      <svg xmlns="http://www.w3.org/2000/svg"
           class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M15 19l-7-7 7-7" />
      </svg>
      Back to Events
    </a>
  </div>

  {{-- Page header --}}
  <div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-900">Edit Event</h1>
    <p class="text-sm text-gray-500 mt-1">Update event details and the games included in this event.</p>
  </div>

  {{-- Single big form card --}}
  <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8">

    {{-- Flash / errors --}}
    @if(session('success'))
      <div class="mb-4 p-3 rounded bg-green-50 text-green-800 border border-green-100">
        {{ session('success') }}
      </div>
    @endif

    @if(session('error'))
      <div class="mb-4 p-3 rounded bg-red-50 text-red-800 border border-red-100">
        {{ session('error') }}
      </div>
    @endif

    @if($errors->any())
      <div class="mb-4 p-3 rounded bg-red-50 text-red-800 border border-red-100">
        <ul class="list-disc pl-5">
          @foreach($errors->all() as $err) <li>{{ $err }}</li> @endforeach
        </ul>
      </div>
    @endif

    <form id="editEventForm" action="{{ route('admin.events.update', $event->EventID) }}" method="POST">
      @csrf

      {{-- Main grid: left fields + right side quick guide/status --}}
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Left: primary fields --}}
        <div class="lg:col-span-2 space-y-6">
          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Event Name <span class="text-red-500">*</span></label>
            <input name="EventName" type="text" required value="{{ old('EventName', $event->EventName) }}"
                   placeholder="e.g. Interfaculty Sports Day 2026"
                   class="w-full rounded-lg border-2 border-gray-200 p-4 text-base focus:outline-none focus:ring-2 focus:ring-[#800000]">
          </div>

          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Location</label>
            <input name="Location" type="text" value="{{ old('Location', $event->Location) }}"
                   placeholder="Venue, hall or field"
                   class="w-full rounded-lg border-2 border-gray-200 p-4 text-base focus:outline-none focus:ring-2 focus:ring-[#800000]">
          </div>

          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-2">Start Date</label>
              <input name="StartDate" type="date" value="{{ old('StartDate', $event->StartDate ? $event->StartDate->format('Y-m-d') : '') }}"
                     class="w-full rounded-lg border-2 border-gray-200 p-3 text-base focus:outline-none focus:ring-2 focus:ring-[#800000]">
            </div>

            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-2">End Date</label>
              <input name="EndDate" type="date" value="{{ old('EndDate', $event->EndDate ? $event->EndDate->format('Y-m-d') : '') }}"
                     class="w-full rounded-lg border-2 border-gray-200 p-3 text-base focus:outline-none focus:ring-2 focus:ring-[#800000]">
            </div>
          </div>

          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
            <textarea name="Description" rows="4"
                      class="w-full rounded-lg border-2 border-gray-200 p-4 text-base focus:outline-none focus:ring-2 focus:ring-[#800000]">{{ old('Description', $event->Description) }}</textarea>
          </div>
        </div>

        {{-- Right: status + quick guide --}}
        <div class="space-y-6">
          <div class="rounded-lg border-2 border-gray-200 p-4 bg-white">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
            <select name="Status" class="w-full rounded-lg border p-3 focus:ring-2 focus:ring-[#800000]">
              <option value="Open" {{ old('Status', $event->Status) == 'Open' ? 'selected' : '' }}>Open</option>
              <option value="Closed" {{ old('Status', $event->Status) == 'Closed' ? 'selected' : '' }}>Closed</option>
              <option value="Cancelled" {{ old('Status', $event->Status) == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
            <p class="text-xs text-gray-400 mt-2">Open → students can apply.</p>
          </div>

          <div class="rounded-lg border-2 border-gray-200 p-4 bg-white">
            <h3 class="text-sm font-semibold text-gray-800 mb-2">Quick Guide</h3>
            <ul class="text-sm text-gray-600 space-y-2">
              <li><strong>Event name</strong> — include faculty or year.</li>
              <li><strong>Dates</strong> — set correct start/end dates.</li>
              <li><strong>Games</strong> — edit existing or add new below.</li>
            </ul>
          </div>
        </div>

      </div> {{-- end main grid --}}

      {{-- Divider --}}
      <div class="my-6 border-t border-gray-200"></div>

      {{-- Games header --}}
      <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-semibold text-gray-800">Games in this Event</h2>
        <div class="flex items-center gap-2">
          <button type="button" id="addGameBtn" class="inline-flex items-center gap-2 px-4 py-2 bg-[#800000] text-white rounded-md shadow-sm">Add Game</button>
        </div>
      </div>

      <p class="text-sm text-gray-500 mb-4">Edit existing games or add new minimal game entries (Name, Category, Capacity).</p>

      {{-- Games container: clear rows with accent --}}
      <div id="gamesContainer" class="space-y-4">
        @foreach($event->games as $i => $game)
          <div class="relative flex items-start bg-white border-2 border-gray-300 rounded-lg p-4 shadow-sm">
            <div class="w-1 bg-[#800000] rounded h-full mr-4"></div>

            <div class="flex-1 grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
              <input type="hidden" name="games[{{ $i }}][GameID]" value="{{ $game->GameID }}">

              <div>
                <label class="text-sm font-medium text-gray-700">Game Name <span class="text-red-500">*</span></label>
                <input name="games[{{ $i }}][GameName]" type="text" required
                       value="{{ old("games.{$i}.GameName", $game->GameName) }}"
                       class="w-full rounded-md border p-3 focus:ring-2 focus:ring-[#800000]">
              </div>

              <div>
                <label class="text-sm font-medium text-gray-700">Category</label>
                <select name="games[{{ $i }}][Category]" class="w-full rounded-md border p-3 focus:ring-2 focus:ring-[#800000]">
                  <option value="">Select</option>
                  <option value="Male" {{ old("games.{$i}.Category", $game->Category) == 'Male' ? 'selected' : '' }}>Male</option>
                  <option value="Female" {{ old("games.{$i}.Category", $game->Category) == 'Female' ? 'selected' : '' }}>Female</option>
                  <option value="Mixed" {{ old("games.{$i}.Category", $game->Category) == 'Mixed' ? 'selected' : '' }}>Mixed</option>
                  <option value="Open" {{ old("games.{$i}.Category", $game->Category) == 'Open' ? 'selected' : '' }}>Open</option>
                </select>
              </div>

              <div>
                <label class="text-sm font-medium text-gray-700">Capacity</label>
                <input name="games[{{ $i }}][Capacity]" type="number" min="0"
                       value="{{ old("games.{$i}.Capacity", $game->Capacity) }}"
                       class="w-full rounded-md border p-3 focus:ring-2 focus:ring-[#800000]">
              </div>
            </div>

            <button type="button" class="remove-game absolute top-3 right-3 text-sm text-red-600 hover:text-red-800">Remove</button>
          </div>
        @endforeach
      </div>

      {{-- Template for new game --}}
      <template id="gameTemplate">
        <div class="relative flex items-start bg-white border-2 border-gray-300 rounded-lg p-4 shadow-sm">
          <div class="w-1 bg-[#800000] rounded h-full mr-4"></div>

          <div class="flex-1 grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
              <label class="text-sm font-medium text-gray-700">Game Name <span class="text-red-500">*</span></label>
              <input name="__GNAME__" type="text" required class="w-full rounded-md border p-3 focus:ring-2 focus:ring-[#800000]">
            </div>

            <div>
              <label class="text-sm font-medium text-gray-700">Category</label>
              <select name="__GCAT__" class="w-full rounded-md border p-3 focus:ring-2 focus:ring-[#800000]">
                <option value="">Select</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Mixed">Mixed</option>
                <option value="Open">Open</option>
              </select>
            </div>

            <div>
              <label class="text-sm font-medium text-gray-700">Capacity</label>
              <input name="__GCAP__" type="number" min="0" class="w-full rounded-md border p-3 focus:ring-2 focus:ring-[#800000]">
            </div>
          </div>

          <button type="button" class="remove-game absolute top-3 right-3 text-sm text-red-600 hover:text-red-800">Remove</button>
        </div>
      </template>

      {{-- Actions --}}
      <div class="mt-8 flex items-center justify-end gap-3">
        <a href="{{ route('admin.events.list') }}" class="px-5 py-3 bg-white border rounded-md text-gray-700">Cancel</a>
        <button type="submit" class="px-6 py-3 bg-[#800000] text-white rounded-md shadow">Save Update</button>
      </div>

    </form>
  </div>
</div>

{{-- JS: Add/Remove Game Rows --}}
<script>
(function(){
  const container = document.getElementById('gamesContainer');
  const template = document.getElementById('gameTemplate').innerHTML;
  const addBtn = document.getElementById('addGameBtn');

  // start idx after existing games count
  let idx = {{ $event->games->count() }};

  function addRow(data = {}) {
    let html = template
      .replace(/__GNAME__/g, `games[${idx}][GameName]`)
      .replace(/__GCAT__/g, `games[${idx}][Category]`)
      .replace(/__GCAP__/g, `games[${idx}][Capacity]`);

    const wrapper = document.createElement('div');
    wrapper.innerHTML = html;
    container.appendChild(wrapper.firstElementChild);

    const last = container.lastElementChild;

    if (Object.keys(data).length) {
      if (data.GameName) last.querySelector(`[name="games[${idx}][GameName]"]`).value = data.GameName;
      if (data.Category) last.querySelector(`[name="games[${idx}][Category]"]`).value = data.Category;
      if (typeof data.Capacity !== 'undefined') last.querySelector(`[name="games[${idx}][Capacity]"]`).value = data.Capacity;
    }

    last.querySelector('.remove-game').addEventListener('click', function(){ this.closest('.relative').remove(); });
    idx++;
  }

  // attach handlers for pre-existing remove buttons
  document.querySelectorAll('.remove-game').forEach(btn => btn.addEventListener('click', function(){ this.closest('.relative').remove(); }));

  addBtn.addEventListener('click', function(){ addRow(); });

})();
</script>
@endsection
