<div class="bg-white rounded-lg shadow p-3">
    @if($announce->Image)
        <img src="{{ asset('uploads/'.$announce->Image) }}"
             class="w-full h-28 object-cover rounded mb-2">
    @endif

    <div>
        <h3 class="text-xs font-bold text-black mb-1">{{ $announce->Title }}</h3>

        @if($announce->Date)
        <p class="text-[11px] text-gray-600">
            {{ \Carbon\Carbon::parse($announce->Date)->format('d F Y, l') }}
        </p>
        @endif
    </div>
</div>
