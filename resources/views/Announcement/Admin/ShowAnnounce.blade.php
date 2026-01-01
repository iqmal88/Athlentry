@extends('layouts.admin')

@section('title', $announcement->Title)

@section('content')
@php
  // Fallback dev image
  $fallbackImage = '/mnt/data/a0b72737-0944-4be7-9875-4f13fc0c3094.png';
  $imgSrc = $announcement->Image ? asset('storage/' . $announcement->Image) : $fallbackImage;

  // Helpers
  $dateHuman = $announcement->Date ? \Carbon\Carbon::parse($announcement->Date)->format('d F, Y') : '-';
  $timeFrom = $announcement->TimeFrom ? \Carbon\Carbon::parse($announcement->TimeFrom)->format('h:i A') : '';
  $timeUntil = $announcement->TimeUntil ? \Carbon\Carbon::parse($announcement->TimeUntil)->format('h:i A') : '';
@endphp

<div class="space-y-6">

  <!-- HERO: image with overlay, title & meta -->
  <header class="relative rounded-xl overflow-hidden shadow-lg">
    <img id="announce-image" src="{{ $imgSrc }}" alt="{{ $announcement->Title }}" class="w-full h-64 md:h-72 lg:h-96 object-cover">

    <!-- dark gradient overlay for text legibility -->
    <div class="absolute inset-0 bg-gradient-to-b from-black/30 via-black/10 to-white/20"></div>

    <div class="absolute inset-0 flex items-end">
      <div class="max-w-7xl mx-auto px-6 py-6 md:py-8 w-full flex items-center justify-between gap-4">
        <div class="text-white">
          <h1 class="text-2xl md:text-3xl lg:text-4xl font-extrabold leading-tight drop-shadow-sm">
            {{ $announcement->Title }}
          </h1>
          <p class="text-sm md:text-base text-white/90 mt-1">Announcement • {{ $announcement->Category ?? 'General' }}</p>
        </div>

        <div class="flex items-center gap-3">
          <div class="text-right text-white text-xs md:text-sm">
            <div class="font-medium">{{ $announcement->CreatedBy ? 'By admin' : ( $announcement->AuthorName ?? '-' ) }}</div>
            <div class="mt-1 text-white/80">{{ $announcement->created_at ? $announcement->created_at->format('d M Y') : '' }}</div>
          </div>

          <!-- Actions: Edit (opens modal) | Delete -->
          <div class="flex items-center gap-2">
            <button id="open-edit-modal" class="inline-flex items-center gap-2 px-3 py-2 rounded-full bg-[color:var(--brand)] text-white shadow hover:brightness-95 transition">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 11l6-6"/></svg>
              Edit
            </button>

            <form action="{{ route('admin.announcements.destroy', $announcement->AnnouncementID) }}" method="POST" onsubmit="return confirm('Delete this announcement?');">
              @csrf
              @method('DELETE')
              <button type="submit" class="inline-flex items-center gap-2 px-3 py-2 rounded-full bg-white/90 text-gray-800 hover:shadow transition">
                <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 7h12M10 11v6M14 11v6M9 7V5a2 2 0 012-2h2a2 2 0 012 2v2"/></svg>
                Delete
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </header>

  <!-- MAIN GRID -->
  <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-6 px-6">

    <!-- Left: main card (spans two columns on large) -->
    <article class="lg:col-span-2 bg-white dark:bg-neutral-900 rounded-xl shadow p-6 md:p-8">
      <div class="flex items-center justify-between mb-6">
        <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100">About</h2>

        <!-- small quick actions -->
        <div class="flex items-center gap-2">
          <a href="#" onclick="window.print(); return false;" class="text-sm text-gray-600 hover:text-[color:var(--brand)] transition">Print</a>
          <a href="#" class="text-sm text-gray-600 hover:text-[color:var(--brand)] transition">Share</a>
        </div>
      </div>

      <div id="view-block" class="prose prose-sm max-w-none text-gray-700 dark:text-gray-300">
        {!! nl2br(e($announcement->Description ?? 'No additional details.')) !!}
      </div>

      <!-- Optional attachments / gallery area -->
      @if($announcement->Attachments && count($announcement->Attachments ?? []) > 0)
        <div class="mt-6">
          <h3 class="text-sm font-medium text-gray-700 mb-3">Attachments</h3>
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
    </article>

    <!-- Right: info card -->
    <aside class="bg-white dark:bg-neutral-900 rounded-xl shadow p-6">
      <div class="mb-4 border-b pb-4">
        <h3 class="text-sm font-semibold text-gray-700">Event info</h3>
      </div>

      <div class="space-y-4 text-sm text-gray-700 dark:text-gray-300">
        <div class="flex items-start gap-3">
          <div class="flex-shrink-0 mt-0.5">
            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3M3 11h18M5 21h14a2 2 0 0 0 2-2V7"/></svg>
          </div>
          <div>
            <div class="text-xs text-gray-500">Date</div>
            <div class="font-medium">{{ $dateHuman }}</div>
          </div>
        </div>

        <div class="flex items-start gap-3">
          <div class="flex-shrink-0 mt-0.5">
            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3M12 6a6 6 0 100 12 6 6 0 000-12z"/></svg>
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

        <div class="flex items-start gap-3">
          <div class="flex-shrink-0 mt-0.5">
            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c1.657 0 3-1.343 3-3S13.657 5 12 5 9 6.343 9 8s1.343 3 3 3z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 21s8-4.5 8-10a8 8 0 10-16 0c0 5.5 8 10 8 10z"/></svg>
          </div>
          <div>
            <div class="text-xs text-gray-500">Location</div>
            <div class="font-medium">{{ $announcement->Location ?? '-' }}</div>
          </div>
        </div>

        <div class="pt-2">
          <a href="#" class="inline-flex items-center gap-2 text-sm text-[color:var(--brand)] hover:underline">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v4l3 3M13 18h8"/></svg>
            Add to calendar
          </a>
        </div>
      </div>

      <!-- Secondary actions -->
      <div class="mt-6 space-y-2">
        <a href="{{ route('admin.announcements.index') }}" class="block text-center px-4 py-2 rounded-md border border-gray-200 bg-white text-sm hover:bg-gray-50">Back to list</a>
        <button id="edit-toggle" class="w-full px-4 py-2 rounded-md bg-[color:var(--brand)] text-white">Update</button>
      </div>
    </aside>
  </div>
</div>

<!-- EDIT MODAL (modern) -->
<div id="edit-modal" class="fixed inset-0 z-50 hidden">
  <div class="absolute inset-0 bg-black/40"></div>
  <div class="relative max-w-3xl mx-auto mt-20 rounded-lg overflow-hidden bg-white dark:bg-neutral-900 shadow-xl">
    <div class="flex items-center justify-between px-6 py-4 border-b dark:border-neutral-800">
      <h3 class="text-lg font-semibold">Edit Announcement</h3>
      <button id="close-edit-modal" class="p-2 rounded-md hover:bg-gray-100 dark:hover:bg-neutral-800">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
      </button>
    </div>

    <form id="edit-form" action="{{ route('admin.announcements.update', $announcement->AnnouncementID) }}" method="POST" enctype="multipart/form-data" class="px-6 py-6 space-y-4">
      @csrf
      @method('PUT')

      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-neutral-300">Title</label>
          <input name="Title" value="{{ old('Title', $announcement->Title) }}" class="mt-1 block w-full rounded-md border px-3 py-2" />
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-neutral-300">Location</label>
          <input name="Location" value="{{ old('Location', $announcement->Location) }}" class="mt-1 block w-full rounded-md border px-3 py-2" />
        </div>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-neutral-300">Date</label>
          <input type="date" name="Date" value="{{ old('Date', optional($announcement->Date)->format('Y-m-d')) }}" class="mt-1 block w-full rounded-md border px-3 py-2" />
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-neutral-300">Time From</label>
          <input type="time" name="TimeFrom" value="{{ old('TimeFrom', isset($announcement->TimeFrom) ? \Carbon\Carbon::parse($announcement->TimeFrom)->format('H:i') : '') }}" class="mt-1 block w-full rounded-md border px-3 py-2" />
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-neutral-300">Time Until</label>
          <input type="time" name="TimeUntil" value="{{ old('TimeUntil', isset($announcement->TimeUntil) ? \Carbon\Carbon::parse($announcement->TimeUntil)->format('H:i') : '') }}" class="mt-1 block w-full rounded-md border px-3 py-2" />
        </div>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-neutral-300">Image (optional)</label>
        <input id="image-input" type="file" name="Image" accept="image/*" class="mt-1 block w-full" />
        <p class="text-xs text-gray-400 mt-1">Leave empty to keep current image.</p>

        <div id="image-preview" class="mt-3 hidden">
          <p class="text-xs text-gray-500 mb-2">Preview</p>
          <img src="#" alt="preview" class="w-full h-40 object-cover rounded-md" />
        </div>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-neutral-300">Description</label>
        <textarea name="Description" rows="6" class="mt-1 block w-full rounded-md border px-3 py-2">{{ old('Description', $announcement->Description) }}</textarea>
      </div>

      <div class="flex items-center justify-end gap-3">
        <button type="button" id="cancel-edit" class="px-4 py-2 rounded-md border bg-white">Cancel</button>
        <button type="submit" class="px-4 py-2 rounded-md bg-[color:var(--brand)] text-white">Save changes</button>
      </div>
    </form>
  </div>
</div>

<!-- SCRIPTS: toggles, modal, preview -->
<script>
document.addEventListener('DOMContentLoaded', function () {
  // open inline edit block (legacy button) — keep for compatibility
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

  // Modal edit pattern
  const openModalBtn = document.getElementById('open-edit-modal');
  const modal = document.getElementById('edit-modal');
  const closeModalBtn = document.getElementById('close-edit-modal');
  const modalCancel = document.getElementById('cancel-edit');

  function openModal() { modal.classList.remove('hidden'); document.body.style.overflow = 'hidden'; }
  function closeModal() { modal.classList.add('hidden'); document.body.style.overflow = ''; }

  openModalBtn && openModalBtn.addEventListener('click', (e) => {
    e.preventDefault();
    openModal();
  });
  closeModalBtn && closeModalBtn.addEventListener('click', closeModal);
  modalCancel && modalCancel.addEventListener('click', closeModal);

  // image preview
  const imageInput = document.getElementById('image-input');
  const imagePreviewWrap = document.getElementById('image-preview');
  const imagePreviewImg = imagePreviewWrap ? imagePreviewWrap.querySelector('img') : null;

  if (imageInput && imagePreviewWrap && imagePreviewImg) {
    imageInput.addEventListener('change', function () {
      const file = this.files && this.files[0];
      if (!file) { imagePreviewWrap.classList.add('hidden'); imagePreviewImg.src = '#'; return; }
      const reader = new FileReader();
      reader.onload = function (e) {
        imagePreviewImg.src = e.target.result;
        imagePreviewWrap.classList.remove('hidden');
      };
      reader.readAsDataURL(file);
    });
  }
});
</script>

<style>
/* Slightly larger prose for readability; subtle card backgrounds */
.prose { color: #374151; }
.prose a { color: var(--brand); text-decoration: underline; }
</style>
@endsection