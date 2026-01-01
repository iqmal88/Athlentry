@extends('layouts.admin')

@section('title', 'Edit Profile')

@section('content')
<div class="w-full px-6 sm:px-8 lg:px-10 py-8">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white dark:bg-neutral-900 border border-gray-100 dark:border-neutral-800 rounded-xl shadow-md overflow-hidden">
            <!-- Header -->
            <div class="px-6 py-4 flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Edit Admin Profile</h3>
                    <p class="text-sm text-gray-500 dark:text-neutral-400 mt-1">Update your account details</p>
                </div>
            </div>

            <form action="{{ route('admin.profile.update') }}" method="POST" class="px-6 pb-6">
                @csrf
                @method('PUT')

                <!-- Full name -->
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-neutral-300">Full name</label>
                    <input id="name" name="name" type="text"
                           value="{{ old('name', $admin->name ?? $admin->Name ?? '') }}"
                           required
                           class="mt-1 block w-full rounded-md border border-gray-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 px-3 py-2 text-sm text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-[color:var(--brand)] transition" />
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-neutral-300">Email</label>
                    <input id="email" name="email" type="email"
                           value="{{ old('email', $admin->email ?? $admin->Email ?? '') }}"
                           required
                           class="mt-1 block w-full rounded-md border border-gray-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 px-3 py-2 text-sm text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-[color:var(--brand)] transition" />
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone -->
                <div class="mb-4">
                    <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-neutral-300">Phone</label>
                    <input id="phone" name="phone" type="text"
                           value="{{ old('phone', $admin->phone ?? '') }}"
                           class="mt-1 block w-full rounded-md border border-gray-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 px-3 py-2 text-sm text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-[color:var(--brand)] transition" />
                    @error('phone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="border-t border-gray-100 dark:border-neutral-800 my-4"></div>

                <!-- Password -->
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-neutral-300">
                        New Password <span class="text-xs text-gray-400 font-normal">(optional)</span>
                    </label>
                    <input id="password" name="password" type="password"
                           class="mt-1 block w-full rounded-md border border-gray-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 px-3 py-2 text-sm text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-[color:var(--brand)] transition" />
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-neutral-300">Confirm Password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password"
                           class="mt-1 block w-full rounded-md border border-gray-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 px-3 py-2 text-sm text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-[color:var(--brand)] transition" />
                </div>

                <!-- Actions -->
                <div class="mt-6 flex items-center justify-between gap-3">
                    <a href="{{ route('admin.profile.view') }}"
                       class="inline-flex items-center justify-center px-4 py-2 rounded-md border border-gray-200 dark:border-neutral-700 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-neutral-800 transition">
                        Cancel
                    </a>

                    <button type="submit"
                            class="inline-flex items-center justify-center px-4 py-2 rounded-md bg-[color:var(--brand)] text-white text-sm shadow hover:brightness-95 transition">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection