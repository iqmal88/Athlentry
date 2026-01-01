@extends('layouts.admin')

@section('title', 'Add Announcement')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
  <!-- Header -->
  <div class="mb-6 flex items-center justify-between">
    <div>
      <h1 class="text-2xl font-semibold text-gray-800">Create Announcement</h1>
      <p class="text-sm text-gray-500">Write a short message to blast to students.</p>
    </div>
  </div>

  <!-- Flash / validation -->
  @if(session('success'))
    <div class="mb-4 rounded-md bg-green-50 border border-green-100 p-4 text-green-800">
      {{ session('success') }}
    </div>
  @endif

  @if ($errors->any())
    <div class="mb-4 rounded-md bg-red-50 border border-red-100 p-4 text-red-800">
      <strong class="block mb-1">Please fix the following:</strong>
      <ul class="list-disc pl-5 space-y-1 text-sm">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <!-- Card: two-column layout -->
  <div class="bg-white dark:bg-neutral-900 rounded-2xl shadow-md overflow-hidden">
    <form action="{{ route('admin.announcements.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-12 gap-6 p-6 lg:p-8">
      @csrf

      <!-- Left: image upload / preview -->
      <div class="lg:col-span-4 flex flex-col items-stretch gap-4">
        <div class="rounded-lg border border-gray-100 dark:border-neutral-800 p-4 flex-1 flex flex-col">
          <label class="text-sm font-medium text-gray-700 dark:text-neutral-300 mb-2">Hero Image (optional)</label>

          <div id="dropzone" class="flex-1 flex flex-col items-center justify-center gap-3 rounded-md border-2 border-dashed border-gray-200 dark:border-neutral-800 p-4 cursor-pointer hover:border-[color:var(--brand)] transition">
            <input id="Image" name="Image" type="file" accept="image/*" class="hidden" />
            <div id="dz-empty" class="text-center">
              <svg class="mx-auto w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V7M16 3v4M8 3v4M3 11h18"/>
              </svg>
              <p class="mt-2 text-sm text-gray-500">Drag & drop an image here, or click to browse</p>
              <p class="mt-1 text-xs text-gray-400">Recommended: 1200x600px • Max 2MB</p>
            </div>

            <div id="dz-preview" class="hidden w-full h-48 rounded-md overflow-hidden">
              <img id="preview-img" src="#" alt="preview" class="w-full h-full object-cover" />
            </div>
          </div>

          <p class="mt-3 text-xs text-gray-500">Image will be shown on announcement cards and detail page. Leave empty to use default placeholder.</p>
          @error('Image') <p class="mt-2 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        <!-- Quick meta -->
        <div class="rounded-lg border border-gray-100 dark:border-neutral-800 p-4">
          <h4 class="text-sm font-semibold text-gray-700 mb-3">Quick options</h4>

          <div class="space-y-3 text-sm text-gray-700">
            <div class="flex items-center justify-between">
              <span class="text-xs text-gray-500">Category</span>
              <select name="Category" class="ml-4 rounded-md border px-2 py-1 text-sm">
                <option value="General" selected>General</option>
                <option value="Event">Event</option>
                <option value="Notice">Notice</option>
              </select>
            </div>

            <div>
              <label class="text-xs text-gray-500">Visibility</label>
              <div class="mt-2 inline-flex items-center gap-3">
                <label class="inline-flex items-center gap-2 text-sm">
                  <input type="radio" name="visibility" value="public" checked class="text-[color:var(--brand)]">
                  <span>Public</span>
                </label>
                <label class="inline-flex items-center gap-2 text-sm">
                  <input type="radio" name="visibility" value="private" class="text-[color:var(--brand)]">
                  <span>Private</span>
                </label>
              </div>
            </div>
          </div>
        </div>

      </div>

      <!-- Right: main fields -->
      <div class="lg:col-span-8 space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <!-- Title -->
          <div class="md:col-span-2">
            <label for="Title" class="block text-sm font-medium text-gray-700 dark:text-neutral-300">Title <span class="text-red-500">*</span></label>
            <input id="Title" name="Title" type="text" required
                   value="{{ old('Title') }}"
                   placeholder="E.g. Inter-College Football Tournament Registration"
                   class="mt-1 block w-full px-4 py-3 rounded-lg border border-gray-200 dark:border-neutral-700 focus:outline-none focus:ring-2 focus:ring-[color:var(--brand)] transition" />
            @error('Title') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
          </div>

          <!-- Location -->
          <div>
            <label for="Location" class="block text-sm font-medium text-gray-700 dark:text-neutral-300">Location</label>
            <input id="Location" name="Location" type="text"
                   value="{{ old('Location') }}"
                   placeholder="Venue or 'Online'"
                   class="mt-1 block w-full px-4 py-3 rounded-lg border border-gray-200 dark:border-neutral-700 focus:outline-none focus:ring-2 focus:ring-[color:var(--brand)] transition" />
            @error('Location') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
          </div>

          <!-- Date -->
          <div>
            <label for="Date" class="block text-sm font-medium text-gray-700 dark:text-neutral-300">Date</label>
            <input id="Date" name="Date" type="date"
                   value="{{ old('Date') }}"
                   class="mt-1 block w-full px-4 py-3 rounded-lg border border-gray-200 dark:border-neutral-700 focus:outline-none focus:ring-2 focus:ring-[color:var(--brand)] transition" />
            @error('Date') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
          </div>

          <!-- Time from -->
          <div>
            <label for="TimeFrom" class="block text-sm font-medium text-gray-700 dark:text-neutral-300">Time (From)</label>
            <input id="TimeFrom" name="TimeFrom" type="time"
                   value="{{ old('TimeFrom') }}"
                   class="mt-1 block w-full px-4 py-3 rounded-lg border border-gray-200 dark:border-neutral-700 focus:outline-none focus:ring-2 focus:ring-[color:var(--brand)] transition" />
            @error('TimeFrom') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
          </div>

          <!-- Time until -->
          <div>
            <label for="TimeUntil" class="block text-sm font-medium text-gray-700 dark:text-neutral-300">Time (Until)</label>
            <input id="TimeUntil" name="TimeUntil" type="time"
                   value="{{ old('TimeUntil') }}"
                   class="mt-1 block w-full px-4 py-3 rounded-lg border border-gray-200 dark:border-neutral-700 focus:outline-none focus:ring-2 focus:ring-[color:var(--brand)] transition" />
            @error('TimeUntil') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
          </div>
        </div>

        <!-- Description -->
        <div>
          <label for="Description" class="block text-sm font-medium text-gray-700 dark:text-neutral-300">Description</label>
          <textarea id="Description" name="Description" rows="8"
                    placeholder="Write the announcement details here..."
                    class="mt-1 block w-full px-4 py-3 rounded-lg border border-gray-200 dark:border-neutral-700 focus:outline-none focus:ring-2 focus:ring-[color:var(--brand)] transition">{{ old('Description') }}</textarea>
          @error('Description') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-end gap-3">
          <a href="{{ route('admin.announcements.index') }}" class="inline-flex items-center px-4 py-2 rounded-lg border border-gray-200 text-sm text-gray-700 bg-white hover:shadow">
            Cancel
          </a>

          <button type="submit" class="inline-flex items-center gap-2 px-5 py-2 rounded-lg bg-[color:var(--brand)] text-white font-medium hover:brightness-95 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            Blast
          </button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Image preview + drag-drop script -->
<script>
document.addEventListener('DOMContentLoaded', () => {
  const dropzone = document.getElementById('dropzone');
  const fileInput = document.getElementById('Image');
  const dzEmpty = document.getElementById('dz-empty');
  const dzPreview = document.getElementById('dz-preview');
  const previewImg = document.getElementById('preview-img');

  function showPreview(src) {
    previewImg.src = src;
    dzEmpty.classList.add('hidden');
    dzPreview.classList.remove('hidden');
  }

  function clearPreview() {
    previewImg.src = '#';
    dzEmpty.classList.remove('hidden');
    dzPreview.classList.add('hidden');
  }

  // click to open file picker
  dropzone.addEventListener('click', () => fileInput.click());

  // handle file selection
  fileInput.addEventListener('change', () => {
    const file = fileInput.files && fileInput.files[0];
    if (!file) { clearPreview(); return; }
    if (!file.type.startsWith('image/')) { alert('Please select an image file'); fileInput.value = ''; return; }

    const reader = new FileReader();
    reader.onload = (e) => showPreview(e.target.result);
    reader.readAsDataURL(file);
  });

  // drag events
  dropzone.addEventListener('dragover', (e) => {
    e.preventDefault(); dropzone.classList.add('border-[color:var(--brand)]');
  });
  dropzone.addEventListener('dragleave', () => {
    dropzone.classList.remove('border-[color:var(--brand)]');
  });
  dropzone.addEventListener('drop', (e) => {
    e.preventDefault(); dropzone.classList.remove('border-[color:var(--brand)]');
    const dt = e.dataTransfer;
    const file = dt.files && dt.files[0];
    if (!file) return;
    if (!file.type.startsWith('image/')) { alert('Please drop an image file'); return; }
    fileInput.files = dt.files;
    const reader = new FileReader();
    reader.onload = (ev) => showPreview(ev.target.result);
    reader.readAsDataURL(file);
  });
});
</script>

<!-- Small polish -->
<style>
  /* ensure brand ring uses layout variable */
  :root { --brand-fallback: #800000; }
  input:focus, textarea:focus { outline: none; box-shadow: 0 0 0 3px rgba(128,0,0,0.08); }
</style>
@endsection