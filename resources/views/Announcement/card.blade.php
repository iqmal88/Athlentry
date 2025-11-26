@props([
    'announce',
    'detailRoute' => '#'
])

@php
    // fallback image (your uploaded example image)
    $fallbackImage = '/mnt/data/13e09b8c-2dd4-4b71-9753-8d23c458532b.png';

    // actual image path
    $imgSrc = $announce->Image
        ? asset('storage/' . $announce->Image)
        : $fallbackImage;
@endphp

<div class="group bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-md transition">
    
    {{-- IMAGE (clickable) --}}
    <a href="{{ $detailRoute }}" class="block">
        <img src="{{ $imgSrc }}"
             alt="{{ $announce->Title }}"
             class="w-full h-44 sm:h-56 md:h-48 lg:h-56 object-cover transition-transform duration-300 group-hover:scale-105" />
    </a>

    <div class="p-4 md:p-5">

        {{-- TITLE (clickable) --}}
        <h3 class="text-sm sm:text-base md:text-lg font-semibold text-gray-900 mb-2 leading-tight">
            <a href="{{ $detailRoute }}" class="hover:underline">
                {{ $announce->Title }}
            </a>
        </h3>

        {{-- META: date / time / location --}}
        <div class="flex flex-wrap items-center gap-4 text-xs text-gray-500">

            {{-- DATE --}}
            @if($announce->Date)
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M8 7V3m8 4V3M3 11h18M5 21h14a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2z"/>
                </svg>
                <span>{{ \Carbon\Carbon::parse($announce->Date)->format('j M Y') }}</span>
            </div>
            @endif

            {{-- TIME --}}
            @if($announce->TimeFrom || $announce->TimeUntil)
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M12 8v4l3 3M12 6a6 6 0 1 0 0 12 6 6 0 0 0 0-12z"/>
                </svg>
                <span>
                    @if($announce->TimeFrom)
                        {{ \Carbon\Carbon::parse($announce->TimeFrom)->format('h:i A') }}
                    @endif

                    @if($announce->TimeFrom && $announce->TimeUntil)
                        –
                    @endif

                    @if($announce->TimeUntil)
                        {{ \Carbon\Carbon::parse($announce->TimeUntil)->format('h:i A') }}
                    @endif
                </span>
            </div>
            @endif

            {{-- LOCATION --}}
            @if($announce->Location)
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M12 11c1.657 0 3-1.343 3-3S13.657 5 12 5 9 6.343 9 8s1.343 3 3 3z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M12 21s8-4.5 8-10a8 8 0 1 0-16 0c0 5.5 8 10 8 10z"/>
                </svg>
                <span>{{ $announce->Location }}</span>
            </div>
            @endif

        </div>
    </div>
</div>
