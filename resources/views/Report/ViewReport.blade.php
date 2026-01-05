@extends('layouts.admin')

@section('title', 'Reports & Analytics')

@section('content')
<div class="min-h-screen bg-[#F8F9FA] pb-24 font-sans antialiased">

    {{-- Header --}}
    <div class="relative px-6 py-6">
        <div class="max-w-7xl mx-auto bg-white border border-gray-100 shadow-sm rounded-[2rem] px-10 py-8 flex flex-col md:flex-row justify-between gap-6">
            <div>
                <h1 class="text-3xl font-black uppercase italic text-gray-900">
                    Reports <span class="text-[#800000] not-italic">& Analytics</span>
                </h1>
                <p class="text-[10px] uppercase tracking-[0.3em] text-gray-400 font-bold mt-2">
                    Athlete Recruitment Insights
                </p>
            </div>

            {{-- Download Buttons --}}
            <div class="flex flex-wrap gap-4 items-center">
                <a href="{{ route('admin.reports.export.applicants.csv', request()->query()) }}"
                   class="px-6 py-3 bg-gray-900 text-white text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-[#800000] transition">
                    Download Applicants (CSV)
                </a>

                <a href="{{ route('admin.reports.export.selected.csv', request()->query()) }}"
                   class="px-6 py-3 bg-green-600 text-white text-[10px] font-black uppercase tracking-widest rounded-xl hover:scale-105 transition">
                    Download Selected (CSV)
                </a>

                {{-- ✅ PDF FINAL SELECTED --}}
                <a href="{{ route('admin.reports.export.selected.pdf', request()->query()) }}"
                   class="px-6 py-3 bg-red-600 text-white text-[10px] font-black uppercase tracking-widest rounded-xl hover:scale-105 transition">
                    Download Final Selected (PDF)
                </a>
            </div>
        </div>
    </div>

    {{-- Summary Cards --}}
    <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mt-4">
        <div class="bg-white rounded-[2rem] p-6 border border-gray-100 shadow-sm">
            <p class="text-[10px] font-black uppercase tracking-widest text-gray-400">Total Applications</p>
            <p class="mt-2 text-3xl font-black text-gray-900">{{ $totalApplications }}</p>
        </div>

        <div class="bg-white rounded-[2rem] p-6 border border-gray-100 shadow-sm">
            <p class="text-[10px] font-black uppercase tracking-widest text-gray-400">Approved</p>
            <p class="mt-2 text-3xl font-black text-green-600">{{ $approvedApplications }}</p>
        </div>

        <div class="bg-white rounded-[2rem] p-6 border border-gray-100 shadow-sm">
            <p class="text-[10px] font-black uppercase tracking-widest text-gray-400">Rejected</p>
            <p class="mt-2 text-3xl font-black text-red-600">{{ $rejectedApplications }}</p>
        </div>

        <div class="bg-white rounded-[2rem] p-6 border border-gray-100 shadow-sm">
            <p class="text-[10px] font-black uppercase tracking-widest text-gray-400">Selected Athletes</p>
            <p class="mt-2 text-3xl font-black text-[#800000]">{{ $selectedAthletes }}</p>
        </div>
    </div>

    {{-- Filters --}}
    <div class="max-w-7xl mx-auto px-6 mt-10">
        <form method="GET" class="bg-white rounded-[2rem] p-6 border border-gray-100 shadow-sm flex flex-col md:flex-row gap-4">

            <select name="event"
                class="flex-1 rounded-xl border border-gray-200 px-4 py-3 text-xs font-black uppercase tracking-widest text-gray-600">
                <option value="">All Events</option>
                @foreach($events as $event)
                    <option value="{{ $event->EventID }}" @selected(request('event') == $event->EventID)>
                        {{ $event->EventName }}
                    </option>
                @endforeach
            </select>

            <select name="game"
                class="flex-1 rounded-xl border border-gray-200 px-4 py-3 text-xs font-black uppercase tracking-widest text-gray-600">
                <option value="">All Games</option>
                @foreach($games as $game)
                    <option value="{{ $game->GameID }}" @selected(request('game') == $game->GameID)>
                        {{ $game->GameName }}
                    </option>
                @endforeach
            </select>

            <button
                class="px-8 py-3 bg-[#800000] text-white text-[10px] font-black uppercase tracking-widest rounded-xl hover:scale-105 transition">
                Apply Filter
            </button>
        </form>
    </div>

    {{-- Charts --}}
    <div class="max-w-7xl mx-auto px-6 mt-12 grid grid-cols-1 lg:grid-cols-2 gap-8">

        {{-- Applications by Event --}}
        <div class="bg-white rounded-[2rem] p-8 border border-gray-100 shadow-sm">
            <h3 class="text-sm font-black uppercase tracking-widest text-gray-400 mb-6">
                Applications by Event
            </h3>
            <canvas id="applicationsByEventChart"></canvas>
        </div>

        {{-- Selection Outcome --}}
        <div class="bg-white rounded-[2rem] p-8 border border-gray-100 shadow-sm">
            <h3 class="text-sm font-black uppercase tracking-widest text-gray-400 mb-6">
                Selection Outcome
            </h3>
            <canvas id="selectionOutcomeChart"></canvas>
        </div>
    </div>

</div>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Applications by Event (Bar Chart)
    new Chart(document.getElementById('applicationsByEventChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($applicationsByEvent->pluck('event.EventName')) !!},
            datasets: [{
                label: 'Applications',
                data: {!! json_encode($applicationsByEvent->pluck('total')) !!},
                backgroundColor: '#800000'
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } }
        }
    });

    // Selection Outcome (Pie Chart)
    new Chart(document.getElementById('selectionOutcomeChart'), {
        type: 'pie',
        data: {
            labels: {!! json_encode($selectionStats->pluck('SelectionStatus')) !!},
            datasets: [{
                data: {!! json_encode($selectionStats->pluck('total')) !!},
                backgroundColor: ['#16a34a', '#dc2626', '#f59e0b']
            }]
        },
        options: {
            responsive: true
        }
    });
</script>
@endsection
