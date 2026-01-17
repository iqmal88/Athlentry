@extends('layouts.admin')

@section('title', 'Edit Profile')

@section('content')
<div class="min-h-screen bg-[#F8F9FA] pb-24 font-sans antialiased">

    <div class="relative px-6 py-6">        
        <div class="max-w-7xl mx-auto bg-white border border-gray-100 shadow-sm rounded-[2rem] px-10 py-8 flex flex-col md:flex-row items-center justify-between gap-8 relative overflow-hidden">
            <div class="absolute -top-24 -right-24 w-64 h-64 bg-[#800000]/5 rounded-full blur-3xl"></div>
            <div class="relative z-10 flex items-center gap-5">
                <a href="{{ route('admin.profile.view') }}" class="group flex items-center justify-center w-12 h-12 bg-gray-50 rounded-2xl hover:bg-[#800000] hover:text-white transition-all duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" /></svg>
                </a>
                <div>
                    <h1 class="text-3xl font-[900] text-gray-900 tracking-tight leading-none uppercase italic">EDIT <span class="text-[#800000] not-italic">PROFILE</span></h1>
                    <p class="text-[10px] uppercase tracking-[0.3em] text-gray-400 font-bold mt-2">Update Administrative Credentials</p>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 mt-4">
        <form action="{{ route('admin.profile.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 space-y-8">
                    <div class="bg-white rounded-[2.5rem] p-10 md:p-12 border border-gray-100 shadow-sm space-y-10">
                        <div class="flex items-center gap-4 mb-2">
                            <h3 class="text-[10px] font-black text-[#800000] uppercase tracking-[0.3em]">Personal Identity</h3>
                            <div class="flex-1 h-px bg-gray-50"></div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="md:col-span-2">
                                <label class="text-[10px] font-black uppercase tracking-[0.3em] text-gray-400 ml-1">Full Display Name</label>
                                <input name="name" type="text" value="{{ old('name', $admin->Name) }}" required class="mt-3 w-full rounded-2xl bg-gray-50 border-2 border-transparent p-5 text-lg font-bold text-gray-900 focus:border-[#800000]/20 focus:bg-white transition-all shadow-sm">
                            </div>
                            <div>
                                <label class="text-[10px] font-black uppercase tracking-[0.3em] text-gray-400 ml-1">Email Address</label>
                                <input name="email" type="email" value="{{ old('email', $admin->Email) }}" required class="mt-3 w-full rounded-2xl bg-gray-50 border-2 border-transparent p-4 font-bold text-gray-900 focus:border-[#800000]/20 focus:bg-white transition-all shadow-sm">
                            </div>
                            <div>
                                <label class="text-[10px] font-black uppercase tracking-[0.3em] text-gray-400 ml-1">Contact Number</label>
                                <input name="phone" type="text" value="{{ old('phone', $admin->PhoneNumber) }}" class="mt-3 w-full rounded-2xl bg-gray-50 border-2 border-transparent p-4 font-bold text-gray-900 focus:border-[#800000]/20 focus:bg-white transition-all shadow-sm">
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-[2.5rem] p-10 md:p-12 border border-gray-100 shadow-sm space-y-10">
                        <div class="flex items-center gap-4 mb-2">
                            <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em]">Security Protocol</h3>
                            <div class="flex-1 h-px bg-gray-50"></div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="relative">
                                <label class="text-[10px] font-black uppercase tracking-[0.3em] text-gray-400 ml-1">New Password</label>
                                <input id="password" name="password" type="password" class="mt-3 w-full rounded-2xl bg-gray-50 border-2 border-transparent p-4 font-bold text-gray-900 focus:border-[#800000]/20 focus:bg-white transition-all shadow-sm">
                                <button type="button" onclick="togglePass('password')" class="absolute right-4 bottom-4 text-gray-400 hover:text-[#800000]"><i class="bi bi-eye"></i></button>
                            </div>
                            <div class="relative">
                                <label class="text-[10px] font-black uppercase tracking-[0.3em] text-gray-400 ml-1">Confirm Password</label>
                                <input id="password_confirmation" name="password_confirmation" type="password" class="mt-3 w-full rounded-2xl bg-gray-50 border-2 border-transparent p-4 font-bold text-gray-900 focus:border-[#800000]/20 focus:bg-white transition-all shadow-sm">
                                <button type="button" onclick="togglePass('password_confirmation')" class="absolute right-4 bottom-4 text-gray-400 hover:text-[#800000]"><i class="bi bi-eye"></i></button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-8">
                    <div class="bg-gray-900 rounded-[2.5rem] p-10 shadow-2xl">
                        <label class="text-[10px] font-black uppercase tracking-[0.3em] text-gray-500">Account Health</label>
                        <div class="mt-6 flex items-center gap-4 text-white">
                            <div class="w-12 h-12 rounded-2xl bg-white/5 flex items-center justify-center text-green-500"><i class="bi bi-shield-lock-fill h5 mb-0"></i></div>
                            <div><p class="text-[11px] font-black uppercase tracking-widest leading-none">Status: Secure</p></div>
                        </div>
                    </div>

                    <div class="pt-4 space-y-4">
                        <button type="submit" class="w-full py-5 bg-[#800000] text-white rounded-[1.5rem] font-black uppercase tracking-widest shadow-xl hover:scale-[1.02] transition-all">Commit Changes</button>
                        <a href="{{ route('admin.profile.view') }}" class="block w-full py-4 bg-white text-gray-400 text-center rounded-[1.5rem] text-[10px] font-black uppercase tracking-widest border border-gray-100 hover:bg-gray-50 transition-all">Cancel</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function togglePass(id) {
        const el = document.getElementById(id);
        el.type = el.type === 'password' ? 'text' : 'password';
    }
</script>
@endsection