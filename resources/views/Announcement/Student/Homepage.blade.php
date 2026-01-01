@extends('layouts.app') {{-- or layouts.student if you prefer --}}

@section('title', 'Announcements')

@section('content')
<!-- Swiper CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />

@php
  // Ensure we have a Collection (works if $announcements is a paginator or array/collection)
  if ($announcements instanceof \Illuminate\Pagination\LengthAwarePaginator || $announcements instanceof \Illuminate\Pagination\Paginator) {
      $annCollection = collect($announcements->items());
  } else {
      $annCollection = collect($announcements);
  }

  $carouselCount = 3; // number of items to show in carousel
  $carouselItems = $annCollection->take($carouselCount);
  $gridItems = $annCollection->slice($carouselCount);
@endphp

<style>
  /* Carousel sizing + card polish */
  .ann-wrapper { --card-w: 380px; }
  @media (min-width:1024px) { .ann-wrapper { --card-w: 420px; } }

  .swiper-container { padding-bottom: 1.25rem; } /* space for pagination */
  .swiper-slide { display: flex; justify-content: center; }
  .announcement-slide { width: 100%; max-width: var(--card-w); }

  /* make the card inside look nicer for students */
  .announcement-card {
    border-radius: 12px;
    overflow: hidden;
    background: linear-gradient(180deg,#ffffff,#fffaf8);
    box-shadow: 0 10px 30px rgba(15,23,42,0.06);
    transition: transform .16s ease, box-shadow .16s ease;
    display: flex;
    flex-direction: column;
    height: 100%;
  }
  .announcement-card:hover { transform: translateY(-6px); box-shadow: 0 24px 48px rgba(15,23,42,0.09); }

  .announcement-card .media {
    width: 100%;
    height: 200px;
    background: #f3f3f3;
  }
  .announcement-card .media img { width:100%; height:100%; object-fit:cover; display:block; }

  .announcement-card .body {
    padding: 1rem 1.15rem;
    display:flex;
    flex-direction:column;
    gap:.5rem;
    flex:1;
  }
  .announcement-card h3 { font-size:1.05rem; line-height:1.2; margin:0; color:#0f172a; }
  .announcement-card .meta { font-size:.85rem; color:#6b7280; }

  .announcement-card .excerpt { color:#374151; font-size:.93rem; margin-top:.5rem; flex:1; }

  .announcement-card .cta-row {
    display:flex; align-items:center; justify-content:space-between; gap:.5rem; margin-top:.75rem;
  }

  .btn-view {
    background: linear-gradient(180deg,var(--brand, #0f766e), rgba(0,0,0,0.08));
    color: #fff;
    padding: .45rem .75rem;
    border-radius: 10px;
    font-weight:600;
    text-decoration:none;
    font-size:.9rem;
  }
  .btn-view:hover { filter:brightness(.97); transform: translateY(-1px); }

  .muted-link {
    color: #6b7280;
    font-size:.86rem;
    text-decoration:underline;
  }

  /* nav controls */
  .swiper-button-prev, .swiper-button-next {
    width:40px; height:40px; border-radius:10px; background:rgba(0,0,0,0.06); display:flex; align-items:center; justify-content:center;
  }
  .swiper-pagination-bullet { background: rgba(0,0,0,0.28); opacity:0.9; }

  /* grid: quick browsable list for the rest */
  .ann-grid { display:grid; grid-template-columns: repeat(1,1fr); gap:1rem; margin-top:1.25rem; }
  @media(min-width:640px){ .ann-grid { grid-template-columns: repeat(2,1fr); } }
  @media(min-width:1024px){ .ann-grid { grid-template-columns: repeat(3,1fr); } }

  /* Empty state */
  .empty-state { border-radius:12px; padding:2rem; background:linear-gradient(180deg,#fff,#fbfbfb); text-align:center; box-shadow:0 6px 20px rgba(15,23,42,0.04); }
</style>

<div class="max-w-7xl mx-auto px-4 py-8 ann-wrapper">
  <div class="flex items-center justify-between mb-4 gap-4">
    <div>
      <h2 class="text-2xl font-semibold text-gray-800">Featured Announcements</h2>
      <p class="text-sm text-gray-500 mt-1">Latest events, notices and important updates for students.</p>
    </div>

    <div class="flex items-center gap-3">
      <a href="{{ route('student.announcements.index') }}" class="muted-link">View all announcements</a>
    </div>
  </div>

  @if($annCollection->isEmpty())
    <div class="empty-state">
      <p class="text-gray-700 text-lg font-medium">No announcements yet</p>
      <p class="text-gray-500 mt-1">Check back later for events and updates.</p>
    </div>
  @else
    {{-- CAROUSEL: only show if there are carousel items --}}
    @if($carouselItems->isNotEmpty())
      <div class="swiper-container" id="annSwiperStudent" role="region" aria-label="Featured announcements carousel">
        <div class="swiper main-swiper">
          <div class="swiper-wrapper">
            @foreach($carouselItems as $announce)
              @php
                $detail = route('student.announcements.show', $announce->AnnouncementID ?? $announce->id ?? $announce);
                $img = $announce->Image ? asset('storage/'.$announce->Image) : '/images/placeholder-announce.png';
                $excerpt = \Illuminate\Support\Str::limit(strip_tags($announce->Description ?? ''), 120);
                $date = $announce->Date ? \Carbon\Carbon::parse($announce->Date)->format('d M Y') : null;
              @endphp

              <div class="swiper-slide" role="group" aria-roledescription="slide" aria-label="{{ $announce->Title }}">
                <div class="announcement-slide">
                  <article class="announcement-card" tabindex="0" aria-labelledby="ann-{{ $announce->AnnouncementID }}-title">
                    <a id="media-{{ $announce->AnnouncementID }}" href="{{ $detail }}" class="media" aria-hidden="true">
                      <img loading="lazy" src="{{ $img }}" alt="{{ $announce->Title }}">
                    </a>

                    <div class="body">
                      <div>
                        <a id="ann-{{ $announce->AnnouncementID }}-title" href="{{ $detail }}" class="block">
                          <h3>{{ $announce->Title }}</h3>
                        </a>
                        <div class="meta mt-1">
                          @if($date) <span>{{ $date }}</span> &middot; @endif
                          <span>{{ $announce->Location ?? 'Location TBA' }}</span>
                        </div>
                      </div>

                      <p class="excerpt">{{ $excerpt ?: 'No additional details.' }}</p>
                    </div>
                  </article>
                </div>
              </div>
            @endforeach
          </div>

          <!-- Controls -->
          <div class="flex items-center justify-between mt-4 gap-4">
            <div class="flex items-center gap-4">
              <div class="swiper-button-prev" aria-label="Previous slide"></div>
              <div class="swiper-button-next" aria-label="Next slide"></div>
            </div>

            <div class="swiper-pagination" aria-hidden="false" role="navigation"></div>
          </div>
        </div>
      </div>
    @endif

    {{-- GRID: show remaining items (no duplicates) --}}
    @if($gridItems->isNotEmpty())
      <div class="ann-grid mt-6" aria-live="polite">
        @foreach($gridItems as $announce)
          @php
            $detail = route('student.announcements.show', $announce->AnnouncementID ?? $announce->id ?? $announce);
            $img = $announce->Image ? asset('storage/'.$announce->Image) : '/images/placeholder-announce.png';
            $excerpt = \Illuminate\Support\Str::limit(strip_tags($announce->Description ?? ''), 140);
            $date = $announce->Date ? \Carbon\Carbon::parse($announce->Date)->format('d M Y') : null;
          @endphp

          <div class="announcement-card">
            <a href="{{ $detail }}" class="media" aria-hidden="true">
              <img loading="lazy" src="{{ $img }}" alt="{{ $announce->Title }}">
            </a>

            <div class="body">
              <a href="{{ $detail }}" class="block">
                <h3>{{ $announce->Title }}</h3>
              </a>
              <div class="meta">
                @if($date) <span>{{ $date }}</span> &middot; @endif <span>{{ $announce->Location ?? 'TBA' }}</span>
              </div>

              <p class="excerpt mt-2">{{ $excerpt ?: 'No additional details.' }}</p>

              <div class="cta-row">
                <a href="{{ $detail }}" class="btn-view">View details</a>
                <a href="#" class="muted-link">Share</a>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    @endif
  @endif
</div>

<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
  const container = document.getElementById('annSwiperStudent');
  if (!container) return;

  const swiperEl = container.querySelector('.main-swiper');
  const swiper = new Swiper(swiperEl, {
    slidesPerView: 1,
    spaceBetween: 20,
    loop: true,
    grabCursor: true,
    pagination: { el: container.querySelector('.swiper-pagination'), clickable: true },
    navigation: { nextEl: container.querySelector('.swiper-button-next'), prevEl: container.querySelector('.swiper-button-prev') },
    autoplay: { delay: 4800, disableOnInteraction: false },
    breakpoints: {
      640: { slidesPerView: 1.15 },
      768: { slidesPerView: 2 },
      1024: { slidesPerView: 3 }
    }
  });

  // Pause autoplay on hover/focus (accessibility)
  swiperEl.addEventListener('mouseenter', () => swiper.autoplay.stop());
  swiperEl.addEventListener('mouseleave', () => swiper.autoplay.start());
  swiperEl.addEventListener('focusin', () => swiper.autoplay.stop());
  swiperEl.addEventListener('focusout', () => swiper.autoplay.start());
});
</script>
@endsection