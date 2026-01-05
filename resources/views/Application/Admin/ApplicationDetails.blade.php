@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-[#F8F9FA] pb-24 font-sans antialiased">

    {{-- Header --}}
    <div class="relative px-6 py-6">
        <div class="max-w-6xl mx-auto bg-white border border-gray-100 shadow-sm rounded-[2rem] px-10 py-8 flex items-center justify-between">
            <div class="flex items-center gap-5">
                <a href="{{ route('admin.games.applicants', $application->GameID) }}"
                   class="w-12 h-12 bg-gray-50 rounded-2xl flex items-center justify-center hover:bg-[#800000] hover:text-white transition">
                    ←
                </a>

                <div>
                    <h1 class="text-3xl font-black uppercase italic">
                        Application
                        <span class="text-[#800000] not-italic">Details</span>
                    </h1>
                    <p class="text-[10px] uppercase tracking-widest text-gray-400 font-bold mt-2">
                        Applicant Review Panel
                    </p>
                </div>
            </div>

            {{-- STATUS BADGE (APPLICATION STATUS) --}}
            @php $status = $application->ApplicationStatus; @endphp

            <div>
                @if($status === 'approved')
                    <span class="px-5 py-2 bg-green-50 text-green-700 text-[10px] font-black uppercase rounded-full">
                        Approved (Selection Stage)
                    </span>
                @elseif($status === 'rejected')
                    <span class="px-5 py-2 bg-red-50 text-red-700 text-[10px] font-black uppercase rounded-full">
                        Rejected
                    </span>
                @elseif($status === 'withdrawn')
                    <span class="px-5 py-2 bg-gray-100 text-gray-500 text-[10px] font-black uppercase rounded-full">
                        Withdrawn
                    </span>
                @else
                    <span class="px-5 py-2 bg-gray-100 text-gray-500 text-[10px] font-black uppercase rounded-full">
                        Pending
                    </span>
                @endif
            </div>
        </div>
    </div>

    {{-- Content --}}
    <div class="max-w-6xl mx-auto px-6 mt-6 grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- LEFT: Student Info --}}
        <div class="bg-white rounded-[2rem] p-8 border border-gray-100 shadow-sm">
            <h3 class="text-sm font-black uppercase tracking-widest text-gray-400 mb-6">
                Student Profile
            </h3>

            <p class="text-xl font-black uppercase">
                {{ $application->user->Name ?? 'Student' }}
            </p>

            <p class="text-xs text-gray-400 font-bold mt-1">
                Matric No: {{ $application->user->MatricNo ?? '-' }}
            </p>

            <div class="mt-6 space-y-2 text-xs font-medium">
                <p><span class="text-gray-400">Email:</span> {{ $application->user->Email ?? '-' }}</p>
                <p><span class="text-gray-400">Role:</span> {{ ucfirst($application->user->Role) }}</p>
                <p><span class="text-gray-400">Applied At:</span>
                    {{ \Carbon\Carbon::parse($application->DateApplied)->format('d M Y, h:i A') }}
                </p>
            </div>
        </div>

        {{-- RIGHT: Application Info --}}
        <div class="bg-white rounded-[2rem] p-8 border border-gray-100 shadow-sm lg:col-span-2">
            <h3 class="text-sm font-black uppercase tracking-widest text-gray-400 mb-6">
                Application Information
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
                <div>
                    <p class="text-gray-400 font-bold text-xs uppercase">Event</p>
                    <p class="font-black">{{ $application->event->EventName ?? '-' }}</p>
                </div>

                <div>
                    <p class="text-gray-400 font-bold text-xs uppercase">Sport</p>
                    <p class="font-black">{{ $application->game->GameName ?? '-' }}</p>
                </div>

                <div>
                    <p class="text-gray-400 font-bold text-xs uppercase">Sport Type</p>
                    <p class="font-medium">{{ $application->SportType ?? '-' }}</p>
                </div>

                <div>
                    <p class="text-gray-400 font-bold text-xs uppercase">Application Status</p>
                    <p class="font-black capitalize">
                        {{ $status }}
                    </p>
                </div>
            </div>

            <div class="mt-8">
                <p class="text-gray-400 font-bold text-xs uppercase mb-2">
                    Achievement
                </p>
                <div class="bg-gray-50 border border-gray-100 rounded-xl p-4 text-sm">
                    {{ $application->Achievement ?? 'No achievement provided.' }}
                </div>
            </div>

            <div class="mt-6">
                <p class="text-gray-400 font-bold text-xs uppercase mb-2">
                    Medical History
                </p>
                <div class="bg-gray-50 border border-gray-100 rounded-xl p-4 text-sm">
                    {{ $application->MedicalHistory ?? 'No medical history provided.' }}
                </div>
            </div>

            {{-- ACTION BUTTONS --}}
            @if($status === 'pending')
                <div class="mt-10 flex flex-col md:flex-row gap-4">

                    {{-- APPROVE --}}
                    <form method="POST"
                          action="{{ route('admin.applications.select', $application->ApplicationID) }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="action" value="approve">
                        <button
                            class="px-10 py-3 bg-gray-900 text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-[#800000] transition">
                            Approve Application
                        </button>
                    </form>

                    {{-- REJECT --}}
                    <form method="POST"
                          action="{{ route('admin.applications.select', $application->ApplicationID) }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="action" value="reject">
                        <button
                            class="px-10 py-3 bg-red-600 text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-red-700 transition">
                            Reject Application
                        </button>
                    </form>
                </div>
            @else
                <div class="mt-10 text-sm text-gray-400 font-bold">
                    This application has been finalised. No further action allowed.
                </div>
            @endif

        </div>
    </div>
</div>
@endsection
