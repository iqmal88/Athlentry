@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-10">

  {{-- Back --}}
  <div class="mb-4">
    <a href="{{ route('admin.gameinfo.index') }}" class="inline-flex items-center gap-2 text-sm text-gray-600 hover:text-[#800000] transition">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
      </svg>
      Back to Games
    </a>
  </div>

  {{-- Page header --}}
  <div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Edit Game</h1>
    <p class="text-sm text-gray-500 mt-1">Update this game's details. Changes will reflect for applicants and listings.</p>
  </div>

  {{-- Form card --}}
  <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8">

    @if(session('success'))
      <div class="mb-4 p-3 rounded bg-green-50 text-green-800 border border-green-100">
        {{ session('success') }}
      </div>
    @endif

    @if($errors->any())
      <div class="mb-4 p-3 rounded bg-red-50 text-red-800 border border-red-100">
        <ul class="list-disc pl-5">
          @foreach($errors->all() as $err) <li>{{ $err }}</li> @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('admin.gameinfo.update', $game->GameID) }}" method="POST">
      @csrf

      <div class="grid grid-cols-1 gap-6">

        {{-- Row: Game name --}}
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-2">Game Name</label>
          <input name="GameName" type="text" required value="{{ old('GameName', $game->GameName) }}"
                 placeholder="e.g. Football (Men)"
                 class="w-full rounded-lg border-2 border-gray-200 p-3 text-base focus:outline-none focus:ring-2 focus:ring-[#800000]" />
        </div>

        {{-- Row: Category --}}
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-2">Category</label>
          <select name="Category" class="w-full rounded-lg border-2 border-gray-200 p-3 text-base focus:outline-none focus:ring-2 focus:ring-[#800000]">
            <option value="">Select</option>
            <option value="Male" {{ old('Category', $game->Category) == 'Male' ? 'selected':'' }}>Male</option>
            <option value="Female" {{ old('Category', $game->Category) == 'Female' ? 'selected':'' }}>Female</option>
            <option value="Mixed" {{ old('Category', $game->Category) == 'Mixed' ? 'selected':'' }}>Mixed</option>
            <option value="Open" {{ old('Category', $game->Category) == 'Open' ? 'selected':'' }}>Open</option>
          </select>
        </div>

        {{-- Row: Capacity --}}
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-2">Capacity</label>
          <input name="Capacity" type="number" min="0" value="{{ old('Capacity', $game->Capacity) }}"
                 class="w-full rounded-lg border-2 border-gray-200 p-3 text-base focus:outline-none focus:ring-2 focus:ring-[#800000]" />
        </div>

        {{-- Row: Selection place --}}
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-2">Selection Place</label>
          <input name="SelectionPlace" type="text" value="{{ old('SelectionPlace', $game->SelectionPlace) }}"
                 class="w-full rounded-lg border-2 border-gray-200 p-3 text-base focus:outline-none focus:ring-2 focus:ring-[#800000]" />
        </div>

        {{-- Two-column row: Selection Date & Coach Name --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Selection Date</label>
            <input name="GameDate" type="date"
                   value="{{ old('GameDate', $game->GameDate ?? '') }}"
                   class="w-full rounded-lg border-2 border-gray-200 p-3 text-base focus:outline-none focus:ring-2 focus:ring-[#800000]" />
          </div>

          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Coach Name</label>
            <input name="CoachName" type="text" value="{{ old('CoachName', $game->CoachName) }}"
                   class="w-full rounded-lg border-2 border-gray-200 p-3 text-base focus:outline-none focus:ring-2 focus:ring-[#800000]" />
          </div>
        </div>

        {{-- Coach phone --}}
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-2">Coach Phone</label>
          <input name="CoachPhone" type="text" value="{{ old('CoachPhone', $game->CoachPhone) }}"
                 class="w-full rounded-lg border-2 border-gray-200 p-3 text-base focus:outline-none focus:ring-2 focus:ring-[#800000]" />
        </div>

        {{-- Rules --}}
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-2">Rules</label>
          <textarea name="Rules" rows="4" class="w-full rounded-lg border-2 border-gray-200 p-3 text-base focus:outline-none focus:ring-2 focus:ring-[#800000]">{{ old('Rules', $game->Rules) }}</textarea>
          <p class="text-xs text-gray-400 mt-2">Put each rule on a new line. It will be rendered as a list on the details page.</p>
        </div>

        {{-- Description --}}
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
          <textarea name="Description" rows="3" class="w-full rounded-lg border-2 border-gray-200 p-3 text-base focus:outline-none focus:ring-2 focus:ring-[#800000]">{{ old('Description', $game->Description) }}</textarea>
        </div>

        {{-- Status --}}
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
          <select name="Status" class="w-full rounded-lg border-2 border-gray-200 p-3 text-base focus:outline-none focus:ring-2 focus:ring-[#800000]">
            <option value="Open" {{ old('Status', $game->Status) == 'Open' ? 'selected':'' }}>Open</option>
            <option value="Closed" {{ old('Status', $game->Status) == 'Closed' ? 'selected':'' }}>Closed</option>
            <option value="Cancelled" {{ old('Status', $game->Status) == 'Cancelled' ? 'selected':'' }}>Cancelled</option>
          </select>
        </div>

      </div> {{-- end grid --}}

      {{-- Actions --}}
      <div class="mt-8 flex items-center justify-end gap-3">
        <a href="{{ route('admin.gameinfo.index') }}" class="px-5 py-3 bg-white border rounded-md text-gray-700">Cancel</a>
        <button type="submit" class="px-6 py-3 bg-[#800000] text-white rounded-md shadow">Save Update</button>
      </div>
    </form>

  </div> {{-- end card --}}
</div>
@endsection
