@extends('layouts.admin')

@section('title', 'Edit Profile')

@section('content')
<div class="min-h-screen bg-[#F8F9FA] pb-24 font-sans antialiased">

    {{-- Aesthetic Header Card --}}
    <div class="relative px-6 py-6">        
        <div class="max-w-7xl mx-auto bg-white border border-gray-100 shadow-sm rounded-[2rem] px-10 py-8 flex flex-col md:flex-row items-center justify-between gap-8 relative overflow-hidden">
            {{-- Subtle Background Glow --}}
            <div class="absolute -top-24 -right-24 w-64 h-64 bg-[#800000]/5 rounded-full blur-3xl"></div>

            <div class="relative z-10 flex items-center gap-5">
                <a href="{{ route('admin.profile.view') }}" class="group flex items-center justify-center w-12 h-12 bg-gray-50 rounded-2xl hover:bg-[#800000] hover:text-white transition-all duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <div class="h-10 w-px bg-gray-100 hidden md:block"></div>
                <div>
                    <h1 class="text-3xl font-[900] text-gray-900 tracking-tight leading-none uppercase italic">EDIT <span class="text-[#800000] not-italic">PROFILE</span></h1>
                    <p class="text-[10px] uppercase tracking-[0.3em] text-gray-400 font-bold mt-2">Update Administrative Credentials</p>
                </div>
            </div>

            <div class="relative z-10 hidden md:block">
                <div class="px-5 py-2 bg-gray-50 rounded-xl border border-gray-100 text-[10px] font-black text-gray-400 tracking-widest uppercase">
                    Account Security Mode
                </div>
            </div>
        </div>
    </div>

    {{-- Main Content Container --}}
    <div class="max-w-7xl mx-auto px-6 mt-4 animate-in fade-in slide-in-from-bottom-4 duration-700">
        
        <form action="{{ route('admin.profile.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">

                {{-- Left Column: Identity Details --}}
                <div class="lg:col-span-2 space-y-8">
                    <div class="bg-white rounded-[2.5rem] p-10 md:p-12 border border-gray-100 shadow-sm space-y-10 relative overflow-hidden">
                        <div class="absolute -top-24 -right-24 w-48 h-48 bg-[#800000]/5 rounded-full blur-3xl"></div>

                        <div class="flex items-center gap-4 mb-2 relative z-10">
                            <h3 class="text-[10px] font-black text-[#800000] uppercase tracking-[0.3em]">Personal Identity</h3>
                            <div class="flex-1 h-px bg-gray-50"></div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 relative z-10">
                            {{-- Name --}}
                            <div class="md:col-span-2">
                                <label for="name" class="text-[10px] font-black uppercase tracking-[0.3em] text-gray-400 ml-1">Full Display Name</label>
                                <input id="name" name="name" type="text" required 
                                       value="{{ old('name', $admin->name ?? $admin->Name ?? '') }}"
                                       class="mt-3 w-full rounded-2xl bg-gray-50 border-2 border-transparent p-5 text-lg font-bold text-gray-900 focus:outline-none focus:border-[#800000]/20 focus:bg-white transition-all shadow-sm">
                                @error('name') <p class="mt-2 text-[10px] font-bold text-red-600 uppercase tracking-tighter italic">{{ $message }}</p> @enderror
                            </div>

                            {{-- Email --}}
                            <div>
                                <label for="email" class="text-[10px] font-black uppercase tracking-[0.3em] text-gray-400 ml-1">Secure Email Address</label>
                                <input id="email" name="email" type="email" required
                                       value="{{ old('email', $admin->email ?? $admin->Email ?? '') }}"
                                       class="mt-3 w-full rounded-2xl bg-gray-50 border-2 border-transparent p-4 font-bold text-gray-900 focus:outline-none focus:border-[#800000]/20 focus:bg-white transition-all shadow-sm">
                                @error('email') <p class="mt-2 text-[10px] font-bold text-red-600 uppercase tracking-tighter italic">{{ $message }}</p> @enderror
                            </div>

                            {{-- Phone --}}
                            <div>
                                <label for="phone" class="text-[10px] font-black uppercase tracking-[0.3em] text-gray-400 ml-1">Contact Number</label>
                                <input id="phone" name="phone" type="text"
                                       value="{{ old('phone', $admin->phone ?? '') }}"
                                       class="mt-3 w-full rounded-2xl bg-gray-50 border-2 border-transparent p-4 font-bold text-gray-900 focus:outline-none focus:border-[#800000]/20 focus:bg-white transition-all shadow-sm">
                                @error('phone') <p class="mt-2 text-[10px] font-bold text-red-600 uppercase tracking-tighter italic">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Security Group --}}
                    <div class="bg-white rounded-[2.5rem] p-10 md:p-12 border border-gray-100 shadow-sm space-y-10 relative overflow-hidden">
                        <div class="flex items-center gap-4 mb-2 relative z-10">
                            <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em]">Security Protocol</h3>
                            <div class="flex-1 h-px bg-gray-50"></div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 relative z-10">
                            {{-- Password --}}
                            <div>
                                <label for="password" class="text-[10px] font-black uppercase tracking-[0.3em] text-gray-400 ml-1">New Password <span class="lowercase text-gray-300 font-medium">(Optional)</span></label>
                                <input id="password" name="password" type="password"
                                       placeholder="••••••••"
                                       class="mt-3 w-full rounded-2xl bg-gray-50 border-2 border-transparent p-4 font-bold text-gray-900 focus:outline-none focus:border-[#800000]/20 focus:bg-white transition-all shadow-sm">
                                @error('password') <p class="mt-2 text-[10px] font-bold text-red-600 uppercase tracking-tighter italic">{{ $message }}</p> @enderror
                            </div>

                            {{-- Password Confirmation --}}
                            <div>
                                <label for="password_confirmation" class="text-[10px] font-black uppercase tracking-[0.3em] text-gray-400 ml-1">Confirm New Password</label>
                                <input id="password_confirmation" name="password_confirmation" type="password"
                                       placeholder="••••••••"
                                       class="mt-3 w-full rounded-2xl bg-gray-50 border-2 border-transparent p-4 font-bold text-gray-900 focus:outline-none focus:border-[#800000]/20 focus:bg-white transition-all shadow-sm">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Right Column: Status & Sidebar --}}
                <div class="space-y-8">
                    {{-- Status Card --}}
                    <div class="bg-gray-900 rounded-[2.5rem] p-10 shadow-2xl shadow-gray-200">
                        <label class="text-[10px] font-black uppercase tracking-[0.3em] text-gray-500">Account Health</label>
                        <div class="mt-6 flex items-center gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-white/5 flex items-center justify-center text-green-500">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            </div>
                            <div>
                                <p class="text-[11px] font-black text-white uppercase tracking-widest leading-none">Active Session</p>
                                <p class="text-[9px] font-bold text-gray-500 mt-1 uppercase tracking-tighter">Last synced: Just now</p>
                            </div>
                        </div>
                        <p class="text-[9px] font-bold text-gray-500 mt-10 italic uppercase tracking-tighter leading-relaxed">
                            * Changes to your email will require re-authentication on your next login session.
                        </p>
                    </div>

                    {{-- Form Actions --}}
                    <div class="pt-4 space-y-4">
                        <button type="submit" class="w-full py-5 bg-[#800000] text-white rounded-[1.5rem] font-black uppercase tracking-widest shadow-xl shadow-red-900/20 hover:scale-[1.02] active:scale-[0.98] transition-all flex items-center justify-center gap-3">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            Commit Changes
                        </button>
                        <a href="{{ route('admin.profile.view') }}" class="block w-full py-4 bg-white text-gray-400 text-center rounded-[1.5rem] text-[10px] font-black uppercase tracking-widest border border-gray-100 hover:bg-gray-50 transition-all">
                            Cancel
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap');
    body { font-family: 'Plus Jakarta Sans', sans-serif; letter-spacing: -0.01em; }
</style>
@endsection