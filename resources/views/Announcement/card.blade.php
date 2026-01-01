@php
  // Minimal helpers for display
  $img = $announce->Image ? asset('storage/' . $announce->Image) : '/images/placeholder-announce.png';
  $excerpt = Str::limit(strip_tags($announce->Description), 140);
  $date = $announce->Date ? \Carbon\Carbon::parse($announce->Date)->format('d M, Y') : '-';
@endphp

<div class="announcement-card-wrapper">
  <article class="announcement-card bg-white dark:bg-neutral-900 rounded-xl shadow hover:shadow-lg transform hover:-translate-y-1 transition overflow-hidden relative">
    <!-- image -->
    <a href="{{ $detailRoute }}" class="block h-44 md:h-48 overflow-hidden">
      <img src="{{ $img }}" alt="{{ $announce->Title }}" class="w-full h-full object-cover">
    </a>

    <!-- content -->
    <div class="p-4 md:p-5">
      <div class="flex items-start justify-between gap-3">
        <div class="flex-1 min-w-0">
          <a href="{{ $detailRoute }}" data-ann-title="{{ $announce->Title }}" data-ann-location="{{ $announce->Location ?? '' }}" class="block">
            <h3 class="text-base font-semibold text-gray-800 dark:text-gray-100 truncate">{{ $announce->Title }}</h3>
          </a>
          <p class="text-xs text-gray-500 mt-1">{{ $date }} • {{ $announce->Location ?? 'TBA' }}</p>
        </div>

        <div class="flex-shrink-0 ml-2">
          <!-- action menu (edit/delete) -->
          <div class="relative">
            <button class="p-1 rounded-md text-gray-500 hover:bg-gray-100" title="Actions" onclick="document.getElementById('actions-{{ $announce->AnnouncementID }}').classList.toggle('hidden')">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 12h.01M12 12h.01M18 12h.01"/></svg>
            </button>

            <div id="actions-{{ $announce->AnnouncementID }}" class="hidden absolute right-0 mt-2 w-40 bg-white dark:bg-neutral-900 rounded-md shadow-lg z-10 overflow-hidden">
              <a href="{{ route('admin.announcements.edit', $announce->AnnouncementID) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Edit</a>
              <form action="{{ route('admin.announcements.destroy', $announce->AnnouncementID) }}" method="POST" onsubmit="return confirm('Delete this announcement?');">
                @csrf @method('DELETE')
                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-50">Delete</button>
              </form>
            </div>
          </div>
        </div>
      </div>

      <p class="text-sm text-gray-700 dark:text-gray-300 mt-3 leading-relaxed">{{ $excerpt }}</p>

      <div class="mt-4 flex items-center justify-between gap-2">
        <a href="{{ $detailRoute }}" class="text-sm text-[color:var(--brand)] font-medium hover:underline">View details</a>
      </div>
    </div>
  </article>
</div>