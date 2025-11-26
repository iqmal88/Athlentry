{{-- resources/views/Announcement/Student/homepage.blade.php --}}
@extends('layouts.app') {{-- or student layout you use --}}

@section('title', 'Announcements')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
<style>
  .swiper-wrapper { align-items: stretch; }
  .swiper-slide { display:flex; justify-content:center; }
  .announcement-slide { width:100%; max-width:380px; }
  @media (min-width:1024px) { .announcement-slide { max-width:420px; } }
  .swiper-button-prev, .swiper-button-next { width:36px; height:36px; border-radius:8px; background:rgba(0,0,0,0.06); }
  .swiper-pagination-bullet { background: rgba(0,0,0,0.35); opacity:0.8; }
</style>

<div class="max-w-7xl mx-auto px-4 py-8">
  <h2 class="text-2xl font-semibold text-gray-800 mb-4">Featured Events</h2>

  @if($announcements->isEmpty())
    <p class="text-gray-600">No announcements at the moment.</p>
  @else
    <div class="swiper main-swiper" id="annSwiperStudent">
      <div class="swiper-wrapper">
        @foreach($announcements as $announce)
          <div class="swiper-slide">
            <div class="announcement-slide">
              {{-- pass the student detail route into the card so image/title are clickable --}}
              @include('Announcement.card', [
                  'announce' => $announce,
                  'detailRoute' => route('student.announcements.show', $announce->AnnouncementID ?? $announce->id ?? $announce)
              ])
            </div>
          </div>
        @endforeach
      </div>

      <div class="flex items-center justify-between mt-4 gap-4">
        <div class="flex items-center gap-4">
          <div class="swiper-button-prev" aria-label="Previous"></div>
          <div class="swiper-button-next" aria-label="Next"></div>
        </div>

        <div class="swiper-pagination"></div>
      </div>
    </div>
  @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    // initialize only the specific container to avoid double init issues
    const studentSwiper = new Swiper('#annSwiperStudent .main-swiper', {
      slidesPerView: 1,
      spaceBetween: 18,
      loop: true,
      pagination: { el: '.swiper-pagination', clickable: true },
      navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
      autoplay: { delay: 4200, disableOnInteraction: false },
      breakpoints: { 640: { slidesPerView: 1.15 }, 768: { slidesPerView: 2 }, 1024: { slidesPerView: 3 } }
    });

    const swiperEl = document.querySelector('#annSwiperStudent .main-swiper');
    if (swiperEl) {
      swiperEl.addEventListener('mouseenter', () => studentSwiper.autoplay.stop());
      swiperEl.addEventListener('mouseleave', () => studentSwiper.autoplay.start());
    }
  });
</script>
@endsection
