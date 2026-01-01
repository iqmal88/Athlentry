@extends('layouts.admin')

@section('title', 'Profile')

@section('content')
<!-- Page (no colored background) -->
<div class="w-full min-h-[70vh] pb-12">
    <!-- top spacing to separate from main navbar -->
    <div class="pt-6"></div>

    <!-- Main layout: avatar card on left, large white info card on right -->
    <div class="max-w-6xl mx-auto px-6 lg:px-8">
        <h2 class="text-gray-900 dark:text-white font-semibold mb-6">Profile</h2>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
            <!-- Avatar card -->
            <div class="lg:col-span-3">
                <div class="bg-white dark:bg-neutral-900 rounded-lg shadow-md p-6 text-center border border-gray-100 dark:border-neutral-800">
                    <div class="mx-auto w-36 h-36 rounded-full bg-gray-100 dark:bg-neutral-800 overflow-hidden flex items-center justify-center">
                        @if(!empty($admin->photo_url))
                            <img src="{{ $admin->photo_url }}" alt="avatar" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-4xl font-semibold text-[color:var(--brand)]">
                                {{ strtoupper(substr($admin->Name ?? Auth::user()->Name ?? 'A', 0, 1)) }}
                            </div>
                        @endif
                    </div>

                    <div class="mt-4">
                        <form action="{{ '#' }}" method="POST" enctype="multipart/form-data" class="space-y-2">
                            @csrf
                            <label class="block">
                                <input type="file" name="photo" accept="image/*" class="hidden" id="photo-input">
                                <button type="button" onclick="document.getElementById('photo-input').click()"
                                        class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-[color:var(--brand)] text-white text-sm shadow hover:brightness-95 transition">
                                    <!-- camera icon -->
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M3 7h2l2-3h8l2 3h2v11a2 2 0 01-2 2H5a2 2 0 01-2-2V7zM12 11a3 3 0 100 6 3 3 0 000-6z"/>
                                    </svg>
                                    Change Photo
                                </button>
                            </label>

                            <button type="submit" class="hidden" id="photo-submit">Upload</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Info card (white) -->
            <div class="lg:col-span-9">
                <div class="relative bg-white dark:bg-neutral-900 rounded-lg shadow-md overflow-hidden border border-gray-100 dark:border-neutral-800">
                    <!-- subtle maroon accent strip at the top of the card -->
                    <div class="h-3 w-full bg-[color:var(--brand)]"></div>

                    <!-- Edit button top-right -->
                    <div class="absolute right-6 top-6">
                        <a href="{{ route('admin.profile.edit') }}" class="inline-flex items-center gap-2 bg-[color:var(--brand)] text-white px-4 py-2 rounded-full text-sm shadow hover:brightness-95 transition">
                            <!-- edit icon -->
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M15.232 5.232l3.536 3.536M9 11l6-6 3 3-6 6H9v-3z"/>
                            </svg>
                            Edit Profile
                        </a>
                    </div>

                    <!-- card content -->
                    <div class="p-8 lg:p-10">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Left column icons + labels -->
                            <div class="space-y-6">
                                <div class="flex items-start gap-4">
                                    <div class="w-10 text-[#333] pt-1">
                                        <!-- user icon -->
                                        <svg class="w-7 h-7 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M5.121 17.804A11.955 11.955 0 0112 15c2.5 0 4.8.75 6.879 2.804M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="text-xs text-gray-500 dark:text-neutral-400 font-semibold">Name</div>
                                        <div class="text-sm text-gray-900 dark:text-gray-200 font-medium">{{ $admin->Name ?? '-' }}</div>
                                    </div>
                                </div>

                                <div class="flex items-start gap-4">
                                    <div class="w-10 text-[#333] pt-1">
                                        <!-- id icon -->
                                        <svg class="w-7 h-7 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M16 7a4 4 0 00-8 0v3H5a2 2 0 00-2 2v4h18v-4a2 2 0 00-2-2h-3V7z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="text-xs text-gray-500 dark:text-neutral-400 font-semibold">Matric ID</div>
                                        <div class="text-sm text-gray-900 dark:text-gray-200 font-medium">{{ $admin->MatricNo ?? '-' }}</div>
                                    </div>
                                </div>

                                <div class="flex items-start gap-4">
                                    <div class="w-10 text-[#333] pt-1">
                                        <!-- mail icon -->
                                        <svg class="w-7 h-7 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M16 12H8m0 0l4-4m-4 4l4 4M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="text-xs text-gray-500 dark:text-neutral-400 font-semibold">Email</div>
                                        <div class="text-sm text-gray-900 dark:text-gray-200 font-medium break-all">{{ $admin->Email ?? '-' }}</div>
                                    </div>
                                </div>

                                <div class="flex items-start gap-4">
                                    <div class="w-10 text-[#333] pt-1">
                                        <!-- phone icon -->
                                        <svg class="w-7 h-7 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M3 5a2 2 0 012-2h2.2a1 1 0 01.95.68l.6 1.8a1 1 0 01-.27 1l-1.2 1.2a11 11 0 005 5l1.2-1.2a1 1 0 011-.27l1.8.6a1 1 0 01.68.95V19a2 2 0 01-2 2H5a2 2 0 01-2-2V5z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="text-xs text-gray-500 dark:text-neutral-400 font-semibold">Phone Number</div>
                                        <div class="text-sm text-gray-900 dark:text-gray-200 font-medium">{{ $admin->phone ?? '-' }}</div>
                                    </div>
                                </div>

                                <div class="flex items-start gap-4">
                                    <div class="w-10 text-[#333] pt-1">
                                        <!-- location icon -->
                                        <svg class="w-7 h-7 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M12 11c1.657 0 3-1.343 3-3S13.657 5 12 5 9 6.343 9 8s1.343 3 3 3z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M12 21s8-4.5 8-10a8 8 0 10-16 0c0 5.5 8 10 8 10z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="text-xs text-gray-500 dark:text-neutral-400 font-semibold">Location</div>
                                        <div class="text-sm text-gray-900 dark:text-gray-200 font-medium">{{ $admin->location ?? '-' }}</div>
                                    </div>
                                </div>

                                <div class="flex items-start gap-4">
                                    <div class="w-10 text-[#333] pt-1">
                                        <!-- lock icon -->
                                        <svg class="w-7 h-7 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M12 11V7a4 4 0 10-8 0v4M5 11h14v10H5z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="text-xs text-gray-500 dark:text-neutral-400 font-semibold">Password</div>
                                        <div class="text-sm text-gray-900 dark:text-gray-200 font-medium">********</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right column: extra info -->
                            <div class="space-y-6">
                                <div>
                                    <div class="text-xs text-gray-500 dark:text-neutral-400 font-semibold">Role</div>
                                    <div class="text-sm text-gray-900 dark:text-gray-200 font-medium mt-1">
                                        Administrator
                                    </div>
                                </div>

                                <div>
                                    <div class="text-xs text-gray-500 dark:text-neutral-400 font-semibold">Member since</div>
                                    <div class="text-sm text-gray-900 dark:text-gray-200 font-medium mt-1">
                                        {{ $admin->created_at->format('d M Y') }}
                                    </div>
                                </div>

                                <div>
                                    <div class="text-xs text-gray-500 dark:text-neutral-400 font-semibold">About</div>
                                    <div class="text-sm text-gray-700 dark:text-gray-300 mt-1">
                                        {{ $admin->bio ?? 'No bio provided.' }}
                                    </div>
                                </div>
                            </div>

                        </div> <!-- grid -->
                    </div> <!-- p-8 -->
                </div> <!-- white card -->
            </div> <!-- lg:col-span-9 -->
        </div> <!-- main grid -->
    </div> <!-- max-w -->
</div> <!-- page wrapper -->

<!-- Optional inline script to auto-submit photo after chosen (unobtrusive) -->
<script>
    (function(){
        const input = document.getElementById('photo-input');
        const submit = document.getElementById('photo-submit');
        if (input && submit) {
            input.addEventListener('change', function(){
                if (input.files && input.files.length) {
                    submit.click();
                }
            });
        }
    })();
</script>
@endsection