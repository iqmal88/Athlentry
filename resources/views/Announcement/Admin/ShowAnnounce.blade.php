{{-- resources/views/Announcement/Admin/ShowAnnouncement.blade.php --}}
@extends('layouts.admin')

@section('title', $announcement->Title)

@section('content')
@php
  // Fallback dev image
  $fallbackImage = '/mnt/data/a0b72737-0944-4be7-9875-4f13fc0c3094.png';
  $imgSrc = $announcement->Image ? asset('storage/' . $announcement->Image) : $fallbackImage;
@endphp

<div class="min-h-screen bg-gray-50 py-8">
  <div class="max-w-6xl mx-auto px-4">

    {{-- Header --}}
    <div class="mb-6 flex items-center justify-between">
      <div>
        <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900">{{ $announcement->Title }}</h1>
        <p class="text-sm text-gray-500 mt-1">Announcement details</p>
      </div>

      {{-- small meta at top right --}}
      <div class="text-right text-xs text-gray-500">
        <div>{{ $announcement->CreatedBy ? 'By admin' : '' }}</div>
        <div class="mt-1">{{ $announcement->created_at ? $announcement->created_at->format('d M Y') : '' }}</div>
      </div>
    </div>

    {{-- MAIN LAYOUT --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

      {{-- Left: big image + description --}}
      <div class="lg:col-span-2">
        <div class="bg-white rounded-xl overflow-hidden shadow-md">
          <img id="announce-image" src="{{ $imgSrc }}" alt="{{ $announcement->Title }}" class="w-full h-96 object-cover">

          <div class="p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-3">About</h2>

            {{-- VIEW BLOCK --}}
            <div id="view-block" class="prose text-gray-700">
              {!! nl2br(e($announcement->Description ?? 'No additional details.')) !!}
            </div>

            {{-- EDIT FORM (hidden until Update clicked) --}}
            <div id="edit-block" class="hidden mt-4">
              <form id="edit-form"
                    action="{{ route('admin.announcements.update', $announcement->AnnouncementID) }}"
                    method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <div>
                    <label class="block text-sm font-medium text-gray-700">Title</label>
                    <input name="Title" value="{{ old('Title', $announcement->Title) }}" class="mt-1 block w-full rounded-md border px-3 py-2" />
                  </div>

                  <div>
                    <label class="block text-sm font-medium text-gray-700">Location</label>
                    <input name="Location" value="{{ old('Location', $announcement->Location) }}" class="mt-1 block w-full rounded-md border px-3 py-2" />
                  </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                  <div>
                    <label class="block text-sm font-medium text-gray-700">Date</label>
                    <input type="date" name="Date" value="{{ old('Date', optional($announcement->Date)->format('Y-m-d')) }}" class="mt-1 block w-full rounded-md border px-3 py-2" />
                  </div>

                  <div>
                    <label class="block text-sm font-medium text-gray-700">Time From</label>
                    <input type="time" name="TimeFrom" value="{{ old('TimeFrom', isset($announcement->TimeFrom) ? \Carbon\Carbon::parse($announcement->TimeFrom)->format('H:i') : '') }}" class="mt-1 block w-full rounded-md border px-3 py-2" />
                  </div>

                  <div>
                    <label class="block text-sm font-medium text-gray-700">Time Until</label>
                    <input type="time" name="TimeUntil" value="{{ old('TimeUntil', isset($announcement->TimeUntil) ? \Carbon\Carbon::parse($announcement->TimeUntil)->format('H:i') : '') }}" class="mt-1 block w-full rounded-md border px-3 py-2" />
                  </div>
                </div>

                <div>
                  <label class="block text-sm font-medium text-gray-700">Image (optional)</label>
                  <input type="file" name="Image" accept="image/*" class="mt-1 block w-full" />
                  <p class="text-xs text-gray-400 mt-1">Leave empty to keep current image.</p>
                </div>

                <div>
                  <label class="block text-sm font-medium text-gray-700">Description</label>
                  <textarea name="Description" rows="6" class="mt-1 block w-full rounded-md border px-3 py-2">{{ old('Description', $announcement->Description) }}</textarea>
                </div>

                <div class="flex items-center gap-3 justify-end">
                  <button type="button" id="cancel-edit" class="px-4 py-2 rounded-md border bg-white">Cancel</button>
                  <button type="submit" class="px-4 py-2 rounded-md bg-[#800000] text-white">Save changes</button>
                </div>
              </form>
            </div>
            {{-- end edit-block --}}

          </div>
        </div>
      </div>

      {{-- Right: event info card with icons + actions --}}
      <aside class="bg-white rounded-xl shadow-md p-5">
        <div class="border-b pb-4 mb-4">
          <h3 class="text-sm font-semibold text-gray-700">Event Info</h3>
        </div>

        <div class="space-y-4 text-sm text-gray-700">
          <div class="flex items-start gap-3">
            <div class="flex-shrink-0 mt-0.5">
              <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M8 7V3m8 4V3M3 11h18M5 21h14a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2z"/>
              </svg>
            </div>
            <div>
              <div class="text-xs text-gray-500">Date</div>
              <div class="font-medium">{{ $announcement->Date ? \Carbon\Carbon::parse($announcement->Date)->format('d F, Y') : '-' }}</div>
            </div>
          </div>

          <div class="flex items-start gap-3">
            <div class="flex-shrink-0 mt-0.5">
              <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 8v4l3 3M12 6a6 6 0 1 0 0 12 6 6 0 0 0 0-12z"/>
              </svg>
            </div>
            <div>
              <div class="text-xs text-gray-500">Time</div>
              <div class="font-medium">
                @if($announcement->TimeFrom || $announcement->TimeUntil)
                  {{ $announcement->TimeFrom ? \Carbon\Carbon::parse($announcement->TimeFrom)->format('h:i A') : '' }}
                  @if($announcement->TimeFrom && $announcement->TimeUntil) &nbsp;–&nbsp; @endif
                  {{ $announcement->TimeUntil ? \Carbon\Carbon::parse($announcement->TimeUntil)->format('h:i A') : '' }}
                @else
                  -
                @endif
                <div class="text-xs text-gray-400 mt-1">({{ config('app.timezone') }})</div>
              </div>
            </div>
          </div>

          <div class="flex items-start gap-3">
            <div class="flex-shrink-0 mt-0.5">
              <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 11c1.657 0 3-1.343 3-3S13.657 5 12 5 9 6.343 9 8s1.343 3 3 3z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 21s8-4.5 8-10a8 8 0 1 0-16 0c0 5.5 8 10 8 10z"/>
              </svg>
            </div>
            <div>
              <div class="text-xs text-gray-500">Location</div>
              <div class="font-medium">{{ $announcement->Location ?? '-' }}</div>
            </div>
          </div>

          <div class="pt-2">
            <a href="#" class="text-sm text-[#e7542e] hover:underline">Add to my calendar</a>
          </div>
        </div>

        {{-- Actions (inline edit + delete) --}}
        <div class="mt-6 flex gap-3">
          <form action="{{ route('admin.announcements.destroy', $announcement->AnnouncementID) }}" method="POST" onsubmit="return confirm('Delete this announcement?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="w-full px-4 py-2 rounded-md border border-gray-200 bg-white text-gray-800 hover:shadow">Delete</button>
          </form>

          <button id="edit-toggle" class="px-4 py-2 rounded-md bg-[#800000] text-white">Update</button>
        </div>
      </aside>
    </div>
  </div>
</div>

{{-- Toggle script --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
  const editToggle = document.getElementById('edit-toggle');
  const editBlock = document.getElementById('edit-block');
  const viewBlock = document.getElementById('view-block');
  const cancelBtn = document.getElementById('cancel-edit');

  if (editToggle && editBlock && viewBlock) {
    editToggle.addEventListener('click', () => {
      viewBlock.classList.add('hidden');
      editBlock.classList.remove('hidden');
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });
  }

  if (cancelBtn && editBlock && viewBlock) {
    cancelBtn.addEventListener('click', () => {
      editBlock.classList.add('hidden');
      viewBlock.classList.remove('hidden');
    });
  }
});
</script>

<style>
/* subtle polish */
.prose p { color: #374151; }
.bg-white { background: linear-gradient(180deg,#ffffff,#fffaf9); }
</style>
@endsection
