@extends('layouts.admin')

@section('title', 'Manage Announcements')

@section('content')
<!-- Swiper CSS (CDN inline) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />

<style>
  /* layout polish */
  .swiper-wrapper { align-items: stretch; }
  .swiper-slide { display:flex; justify-content:center; }
  .announcement-slide { width:100%; max-width:380px; }
  @media (min-width:1024px) { .announcement-slide { max-width:420px; } }

  /* nav style */
  .swiper-button-prev, .swiper-button-next {
    width:36px; height:36px; border-radius:8px; background:rgba(0,0,0,0.06);
  }
  .swiper-pagination-bullet { background: rgba(0,0,0,0.35); opacity:0.8; }
</style>

<div class="max-w-7xl mx-auto px-4 py-8">
  <div class="flex items-center justify-between mb-6">
    <div>
      <h1 class="text-2xl font-semibold text-gray-800">Announcements</h1>
      <p class="text-sm text-gray-500">Manage announcements blasted to students.</p>
    </div>

    <a href="{{ route('admin.announcements.create') }}"
       class="inline-flex items-center px-4 py-2 bg-[#800000] text-white rounded-lg shadow">
      Add New Announcement
    </a>
  </div>

  @if(session('success'))
    <div class="mb-4 p-3 rounded bg-green-50 border border-green-200 text-green-800">
      {{ session('success') }}
    </div>
  @endif

  @if($announcements->isEmpty())
    <div class="bg-white rounded-lg shadow p-6 text-gray-600">
      No announcements yet. Click <span class="font-medium">Add New Announcement</span> to create one.
    </div>
  @else
    <div class="bg-transparent">
      <div class="swiper main-swiper" id="annSwiperAdmin">
        <div class="swiper-wrapper">
          @foreach($announcements as $announce)
            <div class="swiper-slide">
              <div class="announcement-slide">
                @include('Announcement.card', [
                'announce' => $announce,
                'detailRoute' => route('admin.announcements.show', $announce->AnnouncementID)
                ])
              </div>
            </div>
          @endforeach
        </div>

        <!-- navigation & pagination -->
        <div class="flex items-center justify-between mt-4 gap-4">
          <div class="flex items-center gap-4">
            <div class="swiper-button-prev" aria-label="Previous"></div>
            <div class="swiper-button-next" aria-label="Next"></div>
          </div>

          <div class="swiper-pagination"></div>
        </div>
      </div>
    </div>
  @endif
</div>

<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const swiper = new Swiper('#annSwiperAdmin .main-swiper, .main-swiper', {
      slidesPerView: 1,
      spaceBetween: 18,
      loop: true,
      grabCursor: true,
      pagination: { el: '.swiper-pagination', clickable: true },
      navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
      autoplay: { delay: 4200, disableOnInteraction: false },
      breakpoints: {
        640: { slidesPerView: 1.15 },
        768: { slidesPerView: 2 },
        1024: { slidesPerView: 3 }
      }
    });

    // Pause autoplay on hover, resume on leave
    const swiperEl = document.querySelector('#annSwiperAdmin .main-swiper') || document.querySelector('.main-swiper');
    if (swiperEl) {
      swiperEl.addEventListener('mouseenter', () => swiper.autoplay.stop());
      swiperEl.addEventListener('mouseleave', () => swiper.autoplay.start());
    }
  });
</script>
@endsection
